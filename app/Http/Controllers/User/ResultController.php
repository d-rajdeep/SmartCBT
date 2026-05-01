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
            abort(403);
        }

        $result->load(['exam', 'examAttempt']);

        // Get detailed answers with analysis
        $answers = json_decode($result->examAttempt->answers, true) ?? [];
        $questions = $result->exam->questions()->with('options')->get();

        $detailedAnswers = [];
        $correctCount = 0;

        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $correctAnswer = $question->options->where('is_correct', true)->first();
            $isCorrect = $userAnswer && $correctAnswer && $userAnswer == $correctAnswer->id;

            if ($isCorrect) $correctCount++;

            $detailedAnswers[] = [
                'question' => $question,
                'user_answer' => $userAnswer ? $question->options->find($userAnswer) : null,
                'correct_answer' => $correctAnswer,
                'is_correct' => $isCorrect,
            ];
        }

        // Calculate time per question (mock data)
        $timePerQuestion = [];
        for ($i = 0; $i < $questions->count(); $i++) {
            $timePerQuestion[] = rand(30, 180); // Simulated seconds per question
        }

        // Section-wise performance
        $sectionPerformance = [
            'easy' => ['correct' => 0, 'total' => 0],
            'medium' => ['correct' => 0, 'total' => 0],
            'hard' => ['correct' => 0, 'total' => 0],
        ];

        foreach ($detailedAnswers as $item) {
            $difficulty = $item['question']->difficulty;
            $sectionPerformance[$difficulty]['total']++;
            if ($item['is_correct']) {
                $sectionPerformance[$difficulty]['correct']++;
            }
        }

        return view('user.results.show', compact('result', 'detailedAnswers', 'sectionPerformance', 'timePerQuestion'));
    }

    public function downloadCertificate(Result $result)
    {
        if ($result->user_id !== auth()->id() || !$result->is_passed) {
            abort(403);
        }

        // Generate PDF certificate
        // This would require barryvdh/laravel-dompdf package
        // For now, redirect back with message
        return back()->with('info', 'Certificate download feature coming soon!');
    }
}
