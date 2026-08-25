<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    public function instructions(Exam $exam)
    {
        // Check if user can attempt
        if (!$exam->canUserAttempt(auth()->id())) {
            return redirect()->route('user.dashboard')
                ->with('error', 'You cannot attempt this exam.');
        }

        return view('user.exams.instructions', compact('exam'));
    }

    public function start(Exam $exam)
    {
        // Check if there's an in-progress attempt
        $existingAttempt = ExamAttempt::where('user_id', auth()->id())
            ->where('exam_id', $exam->id)
            ->where('status', 'in-progress')
            ->first();

        if ($existingAttempt) {
            return redirect()->route('user.exam.take', $existingAttempt);
        }

        // Create new attempt
        $attempt = ExamAttempt::create([
            'user_id' => auth()->id(),
            'exam_id' => $exam->id,
            'started_at' => now(),
            'status' => 'in-progress',
            'answers' => json_encode([]),
            'marked_questions' => json_encode([]),
            'tab_switch_count' => 0,
        ]);

        return redirect()->route('user.exam.take', $attempt);
    }

    public function take(ExamAttempt $attempt)
    {
        // Security checks
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }

        if ($attempt->status !== 'in-progress') {
            return redirect()->route('user.dashboard')
                ->with('error', 'This exam has already been submitted.');
        }

        $exam = $attempt->exam;

        // Get questions with randomization if enabled
        $questions = $exam->questions;
        if ($exam->randomize_questions) {
            $questions = $questions->shuffle();
        }

        // Load options for each question
        foreach ($questions as $question) {
            $question->options = $question->options->shuffle();
        }

        $savedAnswers = json_decode($attempt->answers, true) ?? [];
        $markedQuestions = json_decode($attempt->marked_questions, true) ?? [];
        $attemptNumber = ExamAttempt::where('user_id', $attempt->user_id)
            ->where('exam_id', $attempt->exam_id)
            ->where('created_at', '<=', $attempt->created_at)
            ->count();
        $elapsedSeconds = max(0, now()->timestamp - $attempt->started_at->timestamp);
        $timeLeft = max(0, ($exam->duration * 60) - $elapsedSeconds);

        return view('user.exams.take', compact(
            'exam',
            'questions',
            'attempt',
            'savedAnswers',
            'markedQuestions',
            'attemptNumber',
            'timeLeft'
        ));
    }

    public function autoSave(Request $request, ExamAttempt $attempt)
    {
        if ($attempt->user_id !== auth()->id() || $attempt->status !== 'in-progress') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $attempt->update([
            'answers' => json_encode($request->answers),
            'marked_questions' => json_encode($request->marked),
        ]);

        return response()->json(['success' => true]);
    }

    public function submit(Request $request, ExamAttempt $attempt)
    {
        if ($attempt->user_id !== auth()->id() || $attempt->status !== 'in-progress') {
            abort(403);
        }

        DB::beginTransaction();

        try {
            $exam = $attempt->exam;
            $answers = json_decode($request->answers_input, true) ?? [];

            // Calculate results
            $questions = $exam->questions()->with('options')->get();
            $correctAnswers = 0;
            $wrongAnswers = 0;
            $totalMarks = 0;
            $obtainedMarks = 0;
            $sectionPerformance = [];

            foreach ($questions as $question) {
                $totalMarks += $question->marks;
                $userAnswer = $answers[$question->id] ?? null;

                if (!$userAnswer) {
                    continue;
                }

                $correctOption = $question->options->where('is_correct', true)->first();

                if ($correctOption && $correctOption->id == $userAnswer) {
                    $correctAnswers++;
                    $obtainedMarks += $question->marks;
                } else {
                    $wrongAnswers++;
                    $obtainedMarks -= $question->negative_marks;
                }
            }

            $skippedAnswers = $questions->count() - ($correctAnswers + $wrongAnswers);
            $percentage = max(0, ($obtainedMarks / $totalMarks) * 100);
            $isPassed = $percentage >= $exam->passing_percentage;

            // Create result
            $result = Result::create([
                'exam_attempt_id' => $attempt->id,
                'user_id' => auth()->id(),
                'exam_id' => $exam->id,
                'total_questions' => $questions->count(),
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'skipped_answers' => $skippedAnswers,
                'total_marks_obtained' => $obtainedMarks,
                'total_marks' => $totalMarks,
                'percentage' => $percentage,
                'is_passed' => $isPassed,
                'section_wise_performance' => json_encode($sectionPerformance),
            ]);

            // Update attempt
            $attempt->update([
                'completed_at' => now(),
                'status' => 'completed',
                'score' => $obtainedMarks,
                'percentage' => $percentage,
            ]);

            DB::commit();

            if ($exam->show_result_immediately) {
                return redirect()->route('user.results.show', $result)
                    ->with('success', 'Exam submitted successfully!');
            }

            return redirect()->route('user.dashboard')
                ->with('success', 'Exam submitted successfully! Results will be announced soon.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function available()
    {
        $exams = Exam::where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->get();

        return view('user.exams.available', compact('exams'));
    }
}
