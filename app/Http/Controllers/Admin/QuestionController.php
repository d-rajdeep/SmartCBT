<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Option;
use App\Imports\QuestionsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
{
    public function index(Exam $exam)
    {
        $questions = $exam->questions()->with('options')->paginate(20);
        return view('admin.questions.index', compact('exam', 'questions'));
    }

    public function create(Exam $exam)
    {
        return view('admin.questions.create', compact('exam'));
    }

    public function store(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'marks' => 'required|integer|min:1',
            'negative_marks' => 'required|integer|min:0',
            'explanation' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_option' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            $question = Question::create([
                'exam_id' => $exam->id,
                'question_text' => $validated['question_text'],
                'difficulty' => $validated['difficulty'],
                'marks' => $validated['marks'],
                'negative_marks' => $validated['negative_marks'],
                'explanation' => $validated['explanation'] ?? null,
                'type' => 'single',
                'order' => $exam->questions()->count() + 1,
            ]);

            foreach ($validated['options'] as $index => $optionText) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $optionText,
                    'is_correct' => $index == $validated['correct_option'],
                    'order' => $index + 1,
                ]);
            }

            $exam->update([
                'total_questions' => $exam->questions()->count()
            ]);

            DB::commit();

            return redirect()->route('admin.questions.index', $exam)
                ->with('success', 'Question added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Question store error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to add question: ' . $e->getMessage());
        }
    }

    public function show(Exam $exam, Question $question)
    {
        return redirect()->route('admin.questions.edit', [$exam, $question]);
    }

    public function edit(Exam $exam, Question $question)
    {
        return view('admin.questions.edit', compact('exam', 'question'));
    }

    public function update(Request $request, Exam $exam, Question $question)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'marks' => 'required|integer|min:1',
            'negative_marks' => 'required|integer|min:0',
            'explanation' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_option' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            $question->update([
                'question_text' => $validated['question_text'],
                'difficulty' => $validated['difficulty'],
                'marks' => $validated['marks'],
                'negative_marks' => $validated['negative_marks'],
                'explanation' => $validated['explanation'] ?? null,
            ]);

            foreach ($question->options as $index => $option) {
                $option->update([
                    'option_text' => $validated['options'][$index],
                    'is_correct' => $index == $validated['correct_option'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.questions.index', $exam)
                ->with('success', 'Question updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Question update error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update question: ' . $e->getMessage());
        }
    }

    public function destroy(Exam $exam, Question $question)
    {
        try {
            $question->delete();

            $exam->update([
                'total_questions' => $exam->questions()->count()
            ]);

            return redirect()->route('admin.questions.index', $exam)
                ->with('success', 'Question deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Question delete error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to delete question: ' . $e->getMessage());
        }
    }

    public function bulkUpload(Exam $exam)
    {
        return view('admin.questions.bulk-upload', compact('exam'));
    }

    public function processBulkUpload(Request $request, Exam $exam)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120',
        ]);

        try {
            $import = new QuestionsImport($exam);
            Excel::import($import, $request->file('file'));

            $errors = $import->getErrors();
            $successCount = $import->getSuccessCount();

            $message = "Successfully imported {$successCount} questions.";

            if (!empty($errors) && $successCount > 0) {
                $message .= " However, some rows had errors: " . implode('; ', array_slice($errors, 0, 5));
                if (count($errors) > 5) {
                    $message .= " and " . (count($errors) - 5) . " more errors.";
                }
                return redirect()->route('admin.questions.index', $exam)
                    ->with('warning', $message);
            } elseif (!empty($errors)) {
                return redirect()->back()
                    ->with('error', 'Import failed: ' . implode('; ', array_slice($errors, 0, 5)));
            }

            return redirect()->route('admin.questions.index', $exam)
                ->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Bulk upload error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to process bulk upload: ' . $e->getMessage() . ' Please check your CSV format.');
        }
    }

    public function downloadTemplate(Exam $exam)
    {
        $headers = [
            'question',
            'option_a',
            'option_b',
            'option_c',
            'option_d',
            'correct_option',
            'difficulty',
            'marks',
            'negative_marks',
            'explanation'
        ];

        $example = [
            'What is Laravel?',
            'A JavaScript framework',
            'A PHP framework',
            'A Python framework',
            'A Ruby framework',
            '2',
            'easy',
            '1',
            '0',
            'Laravel is a free, open-source PHP web framework.'
        ];

        $callback = function () use ($headers, $example) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fputcsv($file, $example);
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="questions_template.csv"'
        ]);
    }
}
