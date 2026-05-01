<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('category')->latest()->paginate(10);
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.exams.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'duration' => 'required|integer|min:1',
            'total_questions' => 'required|integer|min:1',
            'passing_percentage' => 'required|integer|min:0|max:100',
            'max_attempts' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        $validated['is_published'] = $request->has('is_published');
        $validated['randomize_questions'] = $request->has('randomize_questions');
        $validated['show_result_immediately'] = $request->has('show_result_immediately');

        Exam::create($validated);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam created successfully!');
    }

    public function edit(Exam $exam)
    {
        $categories = Category::all();
        return view('admin.exams.edit', compact('exam', 'categories'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'duration' => 'required|integer|min:1',
            'total_questions' => 'required|integer|min:1',
            'passing_percentage' => 'required|integer|min:0|max:100',
            'max_attempts' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['randomize_questions'] = $request->has('randomize_questions');
        $validated['show_result_immediately'] = $request->has('show_result_immediately');

        $exam->update($validated);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam updated successfully!');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam deleted successfully!');
    }

    public function toggleStatus(Exam $exam)
    {
        $exam->is_published = !$exam->is_published;
        $exam->save();

        return response()->json(['success' => true]);
    }
}
