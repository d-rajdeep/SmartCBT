@extends('layouts.admin')

@section('title', 'Edit Exam')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Exam: {{ $exam->title }}</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.exams.update', $exam) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Exam Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title', $exam->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                            name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $exam->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="3" required>{{ old('description', $exam->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="duration" class="form-label">Duration (minutes)</label>
                        <input type="number" class="form-control @error('duration') is-invalid @enderror" id="duration"
                            name="duration" value="{{ old('duration', $exam->duration) }}" required>
                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="total_questions" class="form-label">Total Questions</label>
                        <input type="number" class="form-control @error('total_questions') is-invalid @enderror"
                            id="total_questions" name="total_questions"
                            value="{{ old('total_questions', $exam->total_questions) }}" required>
                        @error('total_questions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="passing_percentage" class="form-label">Passing Percentage</label>
                        <input type="number" class="form-control @error('passing_percentage') is-invalid @enderror"
                            id="passing_percentage" name="passing_percentage"
                            value="{{ old('passing_percentage', $exam->passing_percentage) }}" required>
                        @error('passing_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="max_attempts" class="form-label">Max Attempts</label>
                        <input type="number" class="form-control @error('max_attempts') is-invalid @enderror"
                            id="max_attempts" name="max_attempts" value="{{ old('max_attempts', $exam->max_attempts) }}"
                            required>
                        @error('max_attempts')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Start Date (Optional)</label>
                        <input type="datetime-local" class="form-control" id="start_date" name="start_date"
                            value="{{ old('start_date', $exam->start_date ? $exam->start_date->format('Y-m-d\TH:i') : '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Date (Optional)</label>
                        <input type="datetime-local" class="form-control" id="end_date" name="end_date"
                            value="{{ old('end_date', $exam->end_date ? $exam->end_date->format('Y-m-d\TH:i') : '') }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_published" name="is_published"
                                value="1" {{ $exam->is_published ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_published">Publish Exam</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="randomize_questions"
                                name="randomize_questions" value="1"
                                {{ $exam->randomize_questions ? 'checked' : '' }}>
                            <label class="form-check-label" for="randomize_questions">Randomize Questions</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="show_result_immediately"
                                name="show_result_immediately" value="1"
                                {{ $exam->show_result_immediately ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_result_immediately">Show Result Immediately</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Exam</button>
                <a href="{{ route('admin.exams.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
