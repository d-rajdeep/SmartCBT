@extends('layouts.admin')

@section('title', 'Add Question')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New Question for: {{ $exam->title }}</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.questions.store', $exam) }}">
                @csrf
                <div class="mb-3">
                    <label for="question_text" class="form-label">Question Text *</label>
                    <textarea class="form-control @error('question_text') is-invalid @enderror" id="question_text" name="question_text"
                        rows="3" required>{{ old('question_text') }}</textarea>
                    @error('question_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="difficulty" class="form-label">Difficulty Level</label>
                        <select class="form-select" id="difficulty" name="difficulty">
                            <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ old('difficulty') == 'medium' ? 'selected' : '' }} selected>Medium
                            </option>
                            <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="marks" class="form-label">Marks</label>
                        <input type="number" class="form-control" id="marks" name="marks"
                            value="{{ old('marks', 1) }}" min="1">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="negative_marks" class="form-label">Negative Marks (0 for none)</label>
                        <input type="number" class="form-control" id="negative_marks" name="negative_marks"
                            value="{{ old('negative_marks', 0) }}" min="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Options *</label>
                    <div id="options-container">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="input-group mb-2">
                                <span class="input-group-text">
                                    <input type="radio" name="correct_option" value="{{ $i }}"
                                        {{ old('correct_option') == $i ? 'checked' : '' }} required>
                                </span>
                                <input type="text" class="form-control" name="options[]"
                                    placeholder="Option {{ chr(65 + $i) }}" value="{{ old('options.' . $i) }}" required>
                            </div>
                        @endfor
                    </div>
                    <small class="text-muted">Select the radio button for the correct answer</small>
                </div>

                <div class="mb-3">
                    <label for="explanation" class="form-label">Explanation (Optional)</label>
                    <textarea class="form-control" id="explanation" name="explanation" rows="2">{{ old('explanation') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Add Question</button>
                <a href="{{ route('admin.questions.index', $exam) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
