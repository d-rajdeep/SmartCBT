@extends('layouts.admin')

@section('title', 'Create Exam')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Create Exam</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.exams.index') }}" class="text-decoration-none">Exams</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">Create New</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.exams.index') }}" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

    <form method="POST" action="{{ route('admin.exams.store') }}">
        @csrf
        
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="glass-card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Basic Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label for="title" class="form-label fw-medium text-dark small ms-1">Exam Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg bg-light border-0 @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}" placeholder="e.g. Midterm Mathematics Exam" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="category_id" class="form-label fw-medium text-dark small ms-1">Category <span class="text-danger">*</span></label>
                            <select class="form-select bg-light border-0 @error('category_id') is-invalid @enderror" id="category_id"
                                name="category_id" required>
                                <option value="" disabled selected>Select a Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-2">
                            <label for="description" class="form-label fw-medium text-dark small ms-1">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control bg-light border-0 @error('description') is-invalid @enderror" id="description" name="description"
                                rows="4" placeholder="Briefly describe the purpose and instructions for this exam..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Exam Configuration -->
                <div class="glass-card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-cog text-primary me-2"></i>Exam Configuration</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="duration" class="form-label fw-medium text-dark small ms-1">Duration (minutes) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-clock"></i></span>
                                    <input type="number" class="form-control bg-light border-0 @error('duration') is-invalid @enderror" id="duration"
                                        name="duration" value="{{ old('duration', 60) }}" min="1" required>
                                </div>
                                @error('duration')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="total_questions" class="form-label fw-medium text-dark small ms-1">Total Questions <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-list-ol"></i></span>
                                    <input type="number" class="form-control bg-light border-0 @error('total_questions') is-invalid @enderror"
                                        id="total_questions" name="total_questions" value="{{ old('total_questions', 10) }}" min="1" required>
                                </div>
                                @error('total_questions')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="passing_percentage" class="form-label fw-medium text-dark small ms-1">Passing Percentage (%) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-percent"></i></span>
                                    <input type="number" class="form-control bg-light border-0 @error('passing_percentage') is-invalid @enderror"
                                        id="passing_percentage" name="passing_percentage" value="{{ old('passing_percentage', 40) }}" min="1" max="100" required>
                                </div>
                                @error('passing_percentage')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="max_attempts" class="form-label fw-medium text-dark small ms-1">Max Attempts <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-redo"></i></span>
                                    <input type="number" class="form-control bg-light border-0 @error('max_attempts') is-invalid @enderror"
                                        id="max_attempts" name="max_attempts" value="{{ old('max_attempts', 3) }}" min="1" required>
                                </div>
                                @error('max_attempts')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Scheduling -->
                <div class="glass-card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-calendar-alt text-primary me-2"></i>Scheduling</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label for="start_date" class="form-label fw-medium text-dark small ms-1">Start Date & Time <span class="text-muted fw-normal">(Optional)</span></label>
                            <input type="datetime-local" class="form-control bg-light border-0" id="start_date" name="start_date" value="{{ old('start_date') }}">
                            <div class="form-text small">Leave blank to make it available immediately (if published).</div>
                        </div>
                        
                        <div class="mb-2">
                            <label for="end_date" class="form-label fw-medium text-dark small ms-1">End Date & Time <span class="text-muted fw-normal">(Optional)</span></label>
                            <input type="datetime-local" class="form-control bg-light border-0" id="end_date" name="end_date" value="{{ old('end_date') }}">
                            <div class="form-text small">Leave blank to make it available indefinitely.</div>
                        </div>
                    </div>
                </div>

                <!-- Settings -->
                <div class="glass-card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-sliders-h text-primary me-2"></i>Settings</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-check form-switch mb-3 custom-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium ms-2" for="is_published">Publish Exam</label>
                            <div class="form-text ms-2 mt-0">Visible to users if published.</div>
                        </div>
                        
                        <div class="form-check form-switch mb-3 custom-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="randomize_questions" name="randomize_questions" value="1" {{ old('randomize_questions') ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium ms-2" for="randomize_questions">Randomize Questions</label>
                            <div class="form-text ms-2 mt-0">Shuffle question order for each attempt.</div>
                        </div>
                        
                        <div class="form-check form-switch mb-2 custom-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="show_result_immediately" name="show_result_immediately" value="1" {{ old('show_result_immediately', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium ms-2" for="show_result_immediately">Show Result Immediately</label>
                            <div class="form-text ms-2 mt-0">Users see their score right after submission.</div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill py-3 fw-bold shadow-sm">
                        <i class="fas fa-save me-2"></i> Create Exam
                    </button>
                    <a href="{{ route('admin.exams.index') }}" class="btn btn-light text-dark rounded-pill py-2 fw-semibold border">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection
