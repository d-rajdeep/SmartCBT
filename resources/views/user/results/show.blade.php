@extends('layouts.app')

@section('title', 'Result Details')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-0">Result Details</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.results.index') }}" class="text-decoration-none">My Results</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">{{ Str::limit($result->exam->title, 20) }}</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('user.results.index') }}" class="btn btn-outline-secondary rounded-pill px-3 shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Back to Results
            </a>
        </div>

        <!-- Result Status Badge -->
        <div class="glass-card border-0 shadow-sm mb-4 position-relative overflow-hidden">
            @if ($result->is_passed)
                <div class="position-absolute top-0 start-0 w-100 bg-success" style="height: 4px;"></div>
                <div class="card-body p-4 p-md-5 text-center">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                        <i class="fas fa-trophy fa-3x"></i>
                    </div>
                    <h3 class="fw-bold text-success mb-2">Congratulations!</h3>
                    <p class="text-muted fs-5 mb-0">You have successfully passed the <span class="fw-bold text-dark">{{ $result->exam->title }}</span> exam.</p>
                </div>
            @else
                <div class="position-absolute top-0 start-0 w-100 bg-danger" style="height: 4px;"></div>
                <div class="card-body p-4 p-md-5 text-center">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                        <i class="fas fa-times-circle fa-3x"></i>
                    </div>
                    <h3 class="fw-bold text-danger mb-2">Not Quite There</h3>
                    <p class="text-muted fs-5 mb-0">You did not pass the <span class="fw-bold text-dark">{{ $result->exam->title }}</span> exam. Review your mistakes below and keep practicing!</p>
                </div>
            @endif
        </div>

        <!-- Performance Summary Cards -->
        <div class="row g-4 mb-5">
            <div class="col-6 col-lg-3">
                <div class="glass-card border-0 shadow-sm h-100 p-4 text-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-bullseye fa-2x"></i>
                    </div>
                    <p class="text-muted fw-bold text-uppercase small mb-1">Total Score</p>
                    <h3 class="fw-bold text-primary mb-0">{{ $result->total_marks_obtained }}<span class="fs-5 text-muted fw-medium">/{{ $result->total_marks }}</span></h3>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass-card border-0 shadow-sm h-100 p-4 text-center">
                    @php
                        $pct = $result->percentage;
                        $pctColor = $pct >= 80 ? 'success' : ($pct >= 60 ? 'primary' : ($pct >= 40 ? 'warning' : 'danger'));
                    @endphp
                    <div class="bg-{{ $pctColor }} bg-opacity-10 text-{{ $pctColor }} rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-percentage fa-2x"></i>
                    </div>
                    <p class="text-muted fw-bold text-uppercase small mb-1">Percentage</p>
                    <h3 class="fw-bold text-{{ $pctColor }} mb-0">{{ number_format($pct, 1) }}%</h3>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass-card border-0 shadow-sm h-100 p-4 text-center">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-check fa-2x"></i>
                    </div>
                    <p class="text-muted fw-bold text-uppercase small mb-1">Correct Answers</p>
                    <h3 class="fw-bold text-success mb-0">{{ $result->correct_answers }}</h3>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="glass-card border-0 shadow-sm h-100 p-4 text-center">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-times fa-2x"></i>
                    </div>
                    <p class="text-muted fw-bold text-uppercase small mb-1">Wrong Answers</p>
                    <h3 class="fw-bold text-danger mb-0">{{ $result->wrong_answers }}</h3>
                </div>
            </div>
        </div>

        <!-- Section Performance -->
        @if (isset($sectionPerformance))
            <div class="glass-card border-0 shadow-sm mb-5">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-chart-bar text-primary me-2"></i>Performance by Difficulty</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        @foreach ($sectionPerformance as $difficulty => $data)
                            @if ($data['total'] > 0)
                                @php
                                    $perfPct = ($data['correct'] / $data['total']) * 100;
                                    $perfColor = $perfPct >= 80 ? 'success' : ($perfPct >= 50 ? 'primary' : 'warning');
                                @endphp
                                <div class="col-md-4">
                                    <div class="bg-light rounded-3 p-3 border border-secondary border-opacity-10 shadow-sm">
                                        <div class="d-flex justify-content-between align-items-end mb-2">
                                            <span class="fw-bold text-dark text-capitalize">{{ $difficulty }}</span>
                                            <span class="badge bg-{{ $perfColor }} bg-opacity-10 text-{{ $perfColor }} shadow-sm">{{ number_format($perfPct, 0) }}%</span>
                                        </div>
                                        <div class="progress bg-white shadow-sm" style="height: 10px;">
                                            <div class="progress-bar bg-{{ $perfColor }} rounded-pill" role="progressbar" style="width: {{ $perfPct }}%" aria-valuenow="{{ $perfPct }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="text-end mt-2">
                                            <small class="text-muted fw-medium">{{ $data['correct'] }}/{{ $data['total'] }} Correct</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Detailed Answers -->
        <div class="glass-card border-0 shadow-sm mb-5">
            <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-tasks text-primary me-2"></i>Detailed Question Review</h5>
            </div>
            <div class="card-body p-4">
                @foreach ($detailedAnswers as $index => $item)
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
                                <div class="h-100 bg-white border border-secondary border-opacity-10 rounded-3 p-3 shadow-sm {{ !$item['is_correct'] ? 'border-danger border-opacity-25' : '' }}">
                                    <p class="text-muted small fw-bold text-uppercase mb-2"><i class="fas fa-user-edit me-1"></i> Your Answer</p>
                                    @if ($item['user_answer'])
                                        <p class="fw-medium {{ !$item['is_correct'] ? 'text-danger' : 'text-success' }} mb-0">{{ $item['user_answer']->option_text }}</p>
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
                @endforeach
                
                <div class="d-flex justify-content-center mt-4 pt-3 border-top border-light border-opacity-50">
                    <a href="{{ route('user.results.index') }}" class="btn btn-outline-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
                        Back to All Results
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
