<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $results = Result::where('user_id', auth()->id())
            ->with('exam')
            ->latest()
            ->paginate(10);

        $statistics = [
            'total_exams' => $results->total(),
            'average_score' => round($results->avg('percentage') ?? 0, 1),
            'passed_exams' => $results->where('is_passed', true)->count(),
            'best_score' => round($results->max('percentage') ?? 0, 1),
        ];

        return view('user.results.index', compact('results', 'statistics'));
    }

    public function show(Result $result)
    {
        // Security check
        if ($result->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $result->load(['exam', 'examAttempt']);

        // Get detailed answers with analysis
        $answers = json_decode($result->examAttempt->answers ?? '{}', true) ?? [];
        $questions = $result->exam->questions()->with('options')->get();

        $detailedAnswers = [];
        $sectionPerformance = [
            'easy' => ['correct' => 0, 'total' => 0],
            'medium' => ['correct' => 0, 'total' => 0],
            'hard' => ['correct' => 0, 'total' => 0],
        ];

        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $correctAnswer = $question->options->where('is_correct', true)->first();
            $isCorrect = $userAnswer && $correctAnswer && $userAnswer == $correctAnswer->id;

            // Update section performance
            $difficulty = $question->difficulty;
            $sectionPerformance[$difficulty]['total']++;
            if ($isCorrect) {
                $sectionPerformance[$difficulty]['correct']++;
            }

            $detailedAnswers[] = [
                'question' => $question,
                'user_answer' => $userAnswer ? $question->options->find($userAnswer) : null,
                'correct_answer' => $correctAnswer,
                'is_correct' => $isCorrect,
            ];
        }

        return view('user.results.show', compact('result', 'detailedAnswers', 'sectionPerformance'));
    }

    public function downloadCertificate(Result $result)
    {
        if ($result->user_id !== auth()->id() || !$result->is_passed) {
            abort(403);
        }

        // Certificate download feature
        return back()->with('info', 'Certificate download feature coming soon!');
    }
}
