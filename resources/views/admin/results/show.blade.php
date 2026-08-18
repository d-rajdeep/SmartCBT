@extends('layouts.admin')

@section('title', 'Result Details: ' . $result->user->name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Result Details</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.results.index') }}" class="text-decoration-none">Results</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">{{ $result->exam->title }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.results.index') }}" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Back to Results
        </a>
    </div>

    <!-- Student & Exam Header Info -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="glass-card border-0 shadow-sm h-100 p-4 d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-4 shadow-sm" style="width: 80px; height: 80px;">
                    <span class="display-5 fw-bold">{{ strtoupper(substr($result->user->name, 0, 1)) }}</span>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-1">{{ $result->user->name }}</h4>
                    <p class="text-muted mb-0"><i class="fas fa-envelope me-2"></i>{{ $result->user->email }}</p>
                    <p class="text-muted small mb-0 mt-1"><i class="fas fa-calendar-alt me-2"></i>Taken: {{ $result->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="glass-card border-0 shadow-sm h-100 p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">{{ $result->exam->title }}</h5>
                        <p class="text-muted small mb-0"><i class="fas fa-clipboard-list me-1"></i> Exam Details</p>
                    </div>
                    @if ($result->is_passed)
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2 fs-6 shadow-sm"><i class="fas fa-check-circle me-1"></i> Passed</span>
                    @else
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-2 fs-6 shadow-sm"><i class="fas fa-times-circle me-1"></i> Failed</span>
                    @endif
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div>
                        <p class="text-muted text-uppercase small fw-bold mb-1">Score</p>
                        <h3 class="fw-bold text-primary mb-0">{{ $result->total_marks_obtained }}<span class="text-muted fs-5 fw-medium">/{{ $result->total_marks }}</span></h3>
                    </div>
                    <div>
                        <p class="text-muted text-uppercase small fw-bold mb-1">Percentage</p>
                        @php
                            $pct = $result->percentage;
                            $pctColor = $pct >= 80 ? 'success' : ($pct >= 60 ? 'primary' : ($pct >= 40 ? 'warning' : 'danger'));
                        @endphp
                        <h3 class="fw-bold text-{{ $pctColor }} mb-0">{{ number_format($pct, 1) }}%</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Stats Breakdown -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="glass-card stat-card border-0 shadow-sm p-4 d-flex justify-content-between align-items-center h-100">
                <div>
                    <p class="text-muted fw-bold text-uppercase small mb-1">Correct Answers</p>
                    <h2 class="display-6 fw-bold text-success mb-0">{{ $result->correct_answers }}</h2>
                </div>
                <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fas fa-check text-success fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card stat-card border-0 shadow-sm p-4 d-flex justify-content-between align-items-center h-100">
                <div>
                    <p class="text-muted fw-bold text-uppercase small mb-1">Incorrect Answers</p>
                    <h2 class="display-6 fw-bold text-danger mb-0">{{ $result->wrong_answers }}</h2>
                </div>
                <div class="bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fas fa-times text-danger fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card stat-card border-0 shadow-sm p-4 d-flex justify-content-between align-items-center h-100">
                <div>
                    <p class="text-muted fw-bold text-uppercase small mb-1">Skipped Questions</p>
                    <h2 class="display-6 fw-bold text-warning mb-0">{{ $result->skipped_answers }}</h2>
                </div>
                <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fas fa-minus text-warning-emphasis fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Answer Review -->
    <div class="glass-card border-0 shadow-sm mb-5">
        <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
            <h5 class="fw-bold text-dark mb-0"><i class="fas fa-list-ul text-primary me-2"></i>Detailed Question Review</h5>
        </div>
        <div class="card-body p-4">
            @forelse($detailedAnswers as $index => $item)
                <div class="glass-card bg-light border-0 p-4 mb-4 shadow-sm rounded-4 position-relative">
                    <div class="d-flex justify-content-between align-items-start mb-3 pb-2 border-bottom border-secondary border-opacity-10">
                        <div class="d-flex align-items-start pe-3">
                            <span class="badge bg-primary rounded-pill me-3 mt-1 shadow-sm">Q {{ $index + 1 }}</span>
                            <h6 class="fw-bold text-dark mb-0" style="line-height: 1.5;">{{ $item['question']->question_text }}</h6>
                        </div>
                        <div class="flex-shrink-0">
                            @if ($item['is_correct'])
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1 shadow-sm"><i class="fas fa-check me-1"></i> Correct</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1 shadow-sm"><i class="fas fa-times me-1"></i> Incorrect</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row g-4 mt-2">
                        <div class="col-md-6">
                            <div class="h-100 bg-white border border-secondary border-opacity-10 rounded-3 p-3 shadow-sm">
                                <p class="text-muted small fw-bold text-uppercase mb-2"><i class="fas fa-user-edit me-1"></i> User's Answer</p>
                                @if(isset($item['user_answer']))
                                    <p class="fw-medium text-dark mb-0">{{ $item['user_answer']->option_text }}</p>
                                @else
                                    <p class="fw-medium text-warning-emphasis mb-0 fst-italic">Not answered (Skipped)</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="h-100 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3 p-3 shadow-sm">
                                <p class="text-success small fw-bold text-uppercase mb-2"><i class="fas fa-check-circle me-1"></i> Correct Answer</p>
                                <p class="fw-bold text-success-emphasis mb-0">{{ $item['correct_answer']->option_text ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if ($item['question']->explanation)
                        <div class="mt-4 bg-info bg-opacity-10 border border-info border-opacity-25 rounded-3 p-3 shadow-sm">
                            <p class="text-info-emphasis small fw-bold text-uppercase mb-2"><i class="fas fa-lightbulb me-1"></i> Explanation</p>
                            <p class="mb-0 text-dark small">{{ $item['question']->explanation }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-5">
                    <div class="text-muted mb-3">
                        <i class="fas fa-question-circle fa-3x text-light"></i>
                    </div>
                    <h6 class="text-muted fw-medium">No detailed answers available</h6>
                </div>
            @endforelse
            
            <div class="d-flex justify-content-center mt-4 pt-3 border-top border-light border-opacity-50">
                <a href="{{ route('admin.results.index') }}" class="btn btn-outline-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
                    Back to Results
                </a>
            </div>
        </div>
    </div>
@endsection
