@extends('layouts.admin')

@section('title', 'Bulk Upload Questions')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Bulk Upload Questions</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.exams.index') }}" class="text-decoration-none">Exams</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.questions.index', $exam) }}" class="text-decoration-none">{{ $exam->title }}</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">Bulk Upload</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.questions.index', $exam) }}" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

    @if (session('info'))
        <div class="alert alert-info bg-info bg-opacity-10 text-info-emphasis border-0 shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning bg-warning bg-opacity-10 text-warning-emphasis border-0 shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger bg-danger bg-opacity-10 text-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="glass-card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-file-csv text-primary me-2"></i>Upload File</h5>
                </div>
                <div class="card-body p-4">
                    <!-- IMPORTANT: Added enctype="multipart/form-data" -->
                    <form method="POST" action="{{ route('admin.questions.process-bulk-upload', $exam) }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <div class="glass-card bg-light border-0 p-5 text-center rounded position-relative upload-zone" id="uploadZone">
                                <input type="file" class="form-control position-absolute top-0 start-0 w-100 h-100 opacity-0 @error('file') is-invalid @enderror" id="file" name="file" accept=".csv" required style="cursor: pointer; z-index: 2;">
                                <div class="upload-content position-relative z-1">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                    <h6 class="fw-bold text-dark">Click to select or drag and drop CSV</h6>
                                    <p class="text-muted small mb-0" id="fileName">Maximum file size: 5MB. Only CSV files are accepted.</p>
                                </div>
                            </div>
                            @error('file')
                                <div class="text-danger small mt-2 fw-medium"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                                <i class="fas fa-upload me-2"></i> Upload Questions
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="glass-card border-0 shadow-sm bg-info bg-opacity-10 border-info border-opacity-25">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-info-emphasis mb-3"><i class="fas fa-lightbulb me-2"></i>Instructions</h6>
                    <p class="text-muted small mb-3">Upload a CSV file with the following columns to quickly add multiple questions.</p>
                    
                    <ul class="text-muted small ps-3 mb-4 fw-medium">
                        <li class="mb-1"><strong class="text-dark">question</strong> (Required)</li>
                        <li class="mb-1"><strong class="text-dark">option_a</strong> (Required)</li>
                        <li class="mb-1"><strong class="text-dark">option_b</strong> (Required)</li>
                        <li class="mb-1"><strong class="text-dark">option_c</strong> (Required)</li>
                        <li class="mb-1"><strong class="text-dark">option_d</strong> (Required)</li>
                        <li class="mb-1"><strong class="text-dark">correct_option</strong> (1, 2, 3, or 4)</li>
                        <li class="mb-1"><strong class="text-dark">difficulty</strong> (easy/medium/hard)</li>
                        <li class="mb-1"><strong class="text-dark">marks</strong> (Default: 1)</li>
                        <li class="mb-1"><strong class="text-dark">negative_marks</strong> (Default: 0)</li>
                        <li><strong class="text-dark">explanation</strong> (Optional)</li>
                    </ul>

                    <div class="d-grid">
                        <a href="{{ route('admin.questions.download-template', $exam) }}" class="btn btn-outline-info rounded-pill py-2 shadow-sm fw-semibold">
                            <i class="fas fa-download me-2"></i> Download Template
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('file').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : 'Maximum file size: 5MB. Only CSV files are accepted.';
        document.getElementById('fileName').innerHTML = '<span class="text-primary fw-bold"><i class="fas fa-file-csv me-1"></i> ' + fileName + '</span>';
        
        var uploadZone = document.getElementById('uploadZone');
        if(e.target.files.length > 0) {
            uploadZone.classList.add('bg-primary', 'bg-opacity-10', 'border-primary');
            uploadZone.classList.remove('bg-light');
        } else {
            uploadZone.classList.remove('bg-primary', 'bg-opacity-10', 'border-primary');
            uploadZone.classList.add('bg-light');
        }
    });
</script>
@endpush
