<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\Option;
use App\Models\UserExam;
use Illuminate\Http\Request;

class ExamController extends Controller
{

    public function index()
    {
        $exams = Exam::latest()->get();
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        return view('admin.exams.create');
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required', 'duration' => 'required|integer']);
        Exam::create($request->only('title', 'description', 'duration') + ['published' => false]);
        return redirect()->route('admin.exams.index')->with('success', 'Exam created.');
    }

    public function edit(Exam $exam)
    {
        return view('admin.exams.edit', compact('exam'));
    }

    public function update(Request $request, Exam $exam)
    {
        $exam->update($request->all());
        return redirect()->route('admin.exams.index')->with('success', 'Updated.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return back()->with('success', 'Deleted.');
    }

    public function start(Request $request, Exam $exam)
    {
        $user = $request->user();

        // prevent re-attempt unless you want multiple attempts
        $exists = UserExam::where('user_id', $user->id)->where('exam_id', $exam->id)->first();
        if ($exists && $exists->submitted) {
            return redirect()->route('user.exams.index')->with('error', 'You already submitted this exam.');
        }
        if (!$exists) {
            // build a question order (shuffle)
            $qIds = $exam->questions()->pluck('id')->toArray();
            shuffle($qIds);
            $userExam = UserExam::create([
                'user_id' => $user->id,
                'exam_id' => $exam->id,
                'started_at' => now(),
                'question_order' => $qIds
            ]);
        } else {
            $userExam = $exists;
            if (!$userExam->started_at) {
                $userExam->update(['started_at' => now()]);
            }
        }

        return redirect()->route('user.exams.take', $userExam->id);
    }

    public function saveAnswer(Request $request, $userExamId)
    {
        $data = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'option_id' => 'nullable|exists:options,id',
            'marked_for_review' => 'nullable|boolean',
        ]);

        $userExam = UserExam::findOrFail($userExamId);
        // ensure it belongs to current user and not submitted
        if ($userExam->user_id !== $request->user()->id || $userExam->submitted) {
            abort(403);
        }

        $answer = Answer::updateOrCreate(
            ['user_exam_id' => $userExam->id, 'question_id' => $data['question_id']],
            [
                'option_id' => $data['option_id'] ?? null,
                'marked_for_review' => $data['marked_for_review'] ?? false,
                'is_correct' => optional(Option::find($data['option_id']))->is_correct ? true : false
            ]
        );

        return response()->json(['status' => 'ok']);
    }

    public function submit(Request $request, $userExamId)
    {
        $userExam = UserExam::with('exam')->findOrFail($userExamId);
        if ($userExam->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }


        if ($userExam->submitted) {
            return redirect()->route('user.exams.result', $userExam->id);
        }

        // compute score
        $score = 0;
        foreach ($userExam->exam->questions as $q) {
            $ans = Answer::where('user_exam_id', $userExam->id)->where('question_id', $q->id)->first();
            if ($ans && $ans->option && $ans->option->is_correct) {
                $score += $q->marks;
                $ans->update(['is_correct' => true]);
            } else {
                $ans?->update(['is_correct' => false]);
            }
        }

        $userExam->update([
            'score' => $score,
            'submitted' => true,
            'submitted_at' => now()
        ]);

        return redirect()->route('user.exams.result', $userExam->id);
    }
}
