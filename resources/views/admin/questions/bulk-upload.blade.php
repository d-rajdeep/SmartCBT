@extends('layouts.admin')

@section('title', 'Bulk Upload Questions')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Bulk Upload Questions for: {{ $exam->title }}</h4>
        </div>
        <div class="card-body">
            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="alert alert-info">
                <h5><i class="fas fa-info-circle me-2"></i>Instructions:</h5>
                <ul class="mb-3">
                    <li>Download the template CSV file below to see the correct format</li>
                    <li>Upload a CSV file with the following columns:</li>
                    <li><strong>question</strong> - The question text (required)</li>
                    <li><strong>option_a</strong> - First option (required)</li>
                    <li><strong>option_b</strong> - Second option (required)</li>
                    <li><strong>option_c</strong> - Third option (required)</li>
                    <li><strong>option_d</strong> - Fourth option (required)</li>
                    <li><strong>correct_option</strong> - Correct option number (1, 2, 3, or 4) (required)</li>
                    <li><strong>difficulty</strong> - Difficulty level (easy/medium/hard) - Default: medium</li>
                    <li><strong>marks</strong> - Marks for this question - Default: 1</li>
                    <li><strong>negative_marks</strong> - Negative marks if wrong - Default: 0</li>
                    <li><strong>explanation</strong> - Explanation for the answer (optional)</li>
                </ul>
                <a href="{{ route('admin.questions.download-template', $exam) }}" class="btn btn-success">
                    <i class="fas fa-download me-2"></i>Download Template CSV
                </a>
            </div>

            <!-- IMPORTANT: Added enctype="multipart/form-data" -->
            <form method="POST" action="{{ route('admin.questions.process-bulk-upload', $exam) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Select CSV File *</label>
                    <input type="file" class="form-control @error('file') is-invalid @enderror" id="file"
                        name="file" accept=".csv" required>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Maximum file size: 5MB. Only CSV files are accepted.</small>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>Upload Questions
                    </button>
                    <a href="{{ route('admin.questions.index', $exam) }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
