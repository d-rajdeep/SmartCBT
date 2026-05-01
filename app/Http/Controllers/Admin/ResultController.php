<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Exam;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $query = Result::with(['user', 'exam']);

        // Filter by exam
        if ($request->exam_id) {
            $query->where('exam_id', $request->exam_id);
        }

        // Filter by date
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $results = $query->latest()->paginate(20);
        $exams = Exam::all();

        return view('admin.results.index', compact('results', 'exams'));
    }

    public function show(Result $result)
    {
        $result->load(['user', 'exam', 'examAttempt']);

        // Get detailed answers
        $answers = json_decode($result->examAttempt->answers ?? '{}', true) ?? [];
        $questions = $result->exam->questions()->with('options')->get();

        $detailedAnswers = [];
        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $correctAnswer = $question->options->where('is_correct', true)->first();

            $detailedAnswers[] = [
                'question' => $question,
                'user_answer' => $userAnswer ? $question->options->find($userAnswer) : null,
                'correct_answer' => $correctAnswer,
                'is_correct' => $userAnswer && $correctAnswer && $userAnswer == $correctAnswer->id,
            ];
        }

        return view('admin.results.show', compact('result', 'detailedAnswers'));
    }

    public function export(Request $request)
    {
        $query = Result::with(['user', 'exam']);

        if ($request->exam_id) {
            $query->where('exam_id', $request->exam_id);
        }

        $results = $query->get();

        // Export to CSV
        $filename = 'results_' . date('Y-m-d_His') . '.csv';
        $handle = fopen('php://temp', 'w');

        // Add headers
        fputcsv($handle, ['ID', 'User', 'Email', 'Exam', 'Score', 'Percentage', 'Result', 'Date']);

        // Add data
        foreach ($results as $result) {
            fputcsv($handle, [
                $result->id,
                $result->user->name,
                $result->user->email,
                $result->exam->title,
                $result->total_marks_obtained . '/' . $result->total_marks,
                round($result->percentage, 2) . '%',
                $result->is_passed ? 'Passed' : 'Failed',
                $result->created_at->format('Y-m-d H:i:s'),
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
