<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;
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
            'type' => 'required|in:single,multiple',
        ]);

        $question = $exam->questions()->create([
            'question_text' => $validated['question_text'],
            'difficulty' => $validated['difficulty'],
            'marks' => $validated['marks'],
            'negative_marks' => $validated['negative_marks'],
            'explanation' => $validated['explanation'],
            'type' => $validated['type'],
            'order' => $exam->questions()->count() + 1,
        ]);

        // Create options
        foreach ($validated['options'] as $index => $optionText) {
            Option::create([
                'question_id' => $question->id,
                'option_text' => $optionText,
                'is_correct' => $index == $validated['correct_option'],
                'order' => $index + 1,
            ]);
        }

        // Update total questions count in exam
        $exam->update([
            'total_questions' => $exam->questions()->count()
        ]);

        return redirect()->route('admin.exams.questions.index', $exam)
            ->with('success', 'Question added successfully!');
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

        $question->update([
            'question_text' => $validated['question_text'],
            'difficulty' => $validated['difficulty'],
            'marks' => $validated['marks'],
            'negative_marks' => $validated['negative_marks'],
            'explanation' => $validated['explanation'],
        ]);

        // Update options
        foreach ($question->options as $index => $option) {
            $option->update([
                'option_text' => $validated['options'][$index],
                'is_correct' => $index == $validated['correct_option'],
            ]);
        }

        return redirect()->route('admin.exams.questions.index', $exam)
            ->with('success', 'Question updated successfully!');
    }

    public function destroy(Exam $exam, Question $question)
    {
        $question->delete();

        // Update total questions count
        $exam->update([
            'total_questions' => $exam->questions()->count()
        ]);

        return redirect()->route('admin.exams.questions.index', $exam)
            ->with('success', 'Question deleted successfully!');
    }

    public function bulkUpload(Exam $exam)
    {
        return view('admin.questions.bulk-upload', compact('exam'));
    }

    public function processBulkUpload(Request $request, Exam $exam)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:5120',
        ]);

        // Process Excel file
        $data = Excel::toArray([], $request->file('file'));

        foreach ($data[0] as $row) {
            // Create question
            $question = $exam->questions()->create([
                'question_text' => $row[0],
                'difficulty' => $row[5] ?? 'medium',
                'marks' => $row[6] ?? 1,
                'negative_marks' => $row[7] ?? 0,
                'type' => 'single',
                'order' => $exam->questions()->count() + 1,
            ]);

            // Create options (assuming 4 options)
            for ($i = 1; $i <= 4; $i++) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $row[$i],
                    'is_correct' => $i == $row[4], // correct option index
                    'order' => $i,
                ]);
            }
        }

        // Update total questions
        $exam->update([
            'total_questions' => $exam->questions()->count()
        ]);

        return redirect()->route('admin.exams.questions.index', $exam)
            ->with('success', 'Questions uploaded successfully!');
    }
}
