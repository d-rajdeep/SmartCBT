<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'question_text' => 'required|string',
            'marks' => 'required|integer|min:1',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_option' => 'required|integer', // index of correct option
        ]);

        $question = Question::create([
            'exam_id' => $validated['exam_id'],
            'question_text' => $validated['question_text'],
            'marks' => $validated['marks']
        ]);

        foreach ($validated['options'] as $idx => $optText) {
            Option::create([
                'question_id' => $question->id,
                'option_text' => $optText,
                'is_correct' => ($idx == $validated['correct_option']),
            ]);
        }

        return back()->with('success', 'Question added.');
    }
}
