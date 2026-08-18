@extends('layouts.admin')

@section('title', 'Edit Question')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Edit Question</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.exams.index') }}" class="text-decoration-none">Exams</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.questions.index', $exam) }}" class="text-decoration-none">{{ $exam->title }}</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">Edit Question</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.questions.index', $exam) }}" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger bg-danger bg-opacity-10 text-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
            <h6 class="fw-bold mb-2"><i class="fas fa-exclamation-triangle me-2"></i>Please check the form for errors:</h6>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="glass-card border-0 shadow-sm">
        <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
            <h5 class="fw-bold text-dark mb-0"><i class="fas fa-edit text-primary me-2"></i>Update Question Details</h5>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.questions.update', [$exam, $question]) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="question_text" class="form-label fw-medium text-dark small ms-1">Question Text <span class="text-danger">*</span></label>
                    <textarea class="form-control bg-light border-0 @error('question_text') is-invalid @enderror" id="question_text" name="question_text"
                        rows="4" required>{{ old('question_text', $question->question_text) }}</textarea>
                    @error('question_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <label for="difficulty" class="form-label fw-medium text-dark small ms-1">Difficulty Level</label>
                        <select class="form-select bg-light border-0" id="difficulty" name="difficulty">
                            <option value="easy" {{ old('difficulty', $question->difficulty) == 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ old('difficulty', $question->difficulty) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="hard" {{ old('difficulty', $question->difficulty) == 'hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="marks" class="form-label fw-medium text-dark small ms-1">Marks</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-success"><i class="fas fa-check"></i></span>
                            <input type="number" class="form-control bg-light border-0" id="marks" name="marks" value="{{ old('marks', $question->marks) }}" min="1">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="negative_marks" class="form-label fw-medium text-dark small ms-1">Negative Marks</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-danger"><i class="fas fa-minus"></i></span>
                            <input type="number" class="form-control bg-light border-0" id="negative_marks" name="negative_marks" value="{{ old('negative_marks', $question->negative_marks) }}" min="0" step="0.01">
                        </div>
                        <div class="form-text small">Enter positive value, e.g. 0.25</div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-medium text-dark small ms-1">Answer Options <span class="text-danger">*</span></label>
                    <div class="glass-card bg-light border-0 p-3 rounded">
                        <p class="small text-muted mb-3"><i class="fas fa-info-circle me-1"></i>Update the options and ensure the correct answer is selected.</p>
                        
                        <div id="options-container">
                            @foreach ($question->options as $index => $option)
                                <div class="input-group mb-3 shadow-sm rounded">
                                    <div class="input-group-text bg-white border-0 border-end">
                                        <input class="form-check-input mt-0" type="radio" name="correct_option" value="{{ $index }}"
                                            {{ old('correct_option', $option->is_correct ? $index : '') == $index ? 'checked' : '' }} required aria-label="Correct Option">
                                    </div>
                                    <span class="input-group-text bg-white border-0 fw-bold text-primary">{{ chr(65 + $index) }}</span>
                                    <input type="text" class="form-control border-0 py-2" name="options[]"
                                        placeholder="Option {{ chr(65 + $index) }}"
                                        value="{{ old('options.' . $index, $option->option_text) }}" required>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <label for="explanation" class="form-label fw-medium text-dark small ms-1">Explanation <span class="text-muted fw-normal">(Optional)</span></label>
                    <textarea class="form-control bg-light border-0" id="explanation" name="explanation" rows="3" placeholder="Provide an explanation for the correct answer, visible after submission.">{{ old('explanation', $question->explanation) }}</textarea>
                </div>

                <div class="d-flex gap-2 border-top border-light border-opacity-50 pt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
                        <i class="fas fa-save me-2"></i> Update Question
                    </button>
                    <a href="{{ route('admin.questions.index', $exam) }}" class="btn btn-light text-dark rounded-pill px-4 py-2 fw-semibold border">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
