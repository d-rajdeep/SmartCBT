@extends('layouts.app')

@section('title', 'Available Exams')

@section('content')
    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="fw-bold text-dark mb-2">Available Examinations</h2>
                <p class="text-muted">Select an exam below to begin your assessment.</p>
            </div>
        </div>

        @if (isset($exams) && count($exams) > 0)
            <div class="row g-4">
                @foreach ($exams as $exam)
                    <div class="col-md-6 col-lg-4">
                        <div class="glass-card border-0 shadow-sm h-100 d-flex flex-column position-relative overflow-hidden transition-all exam-card">
                            <!-- Decorative accent -->
                            <div class="position-absolute top-0 start-0 w-100 bg-primary" style="height: 4px;"></div>
                            
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;">
                                        <i class="fas fa-file-alt fa-lg"></i>
                                    </div>
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-2 shadow-sm">Ready</span>
                                </div>
                                
                                <h5 class="card-title fw-bold text-dark mb-2">{{ $exam->title }}</h5>
                                <p class="card-text text-muted small mb-4 flex-grow-1">{{ Str::limit($exam->description, 100) }}</p>
                                
                                <div class="bg-light rounded-3 p-3 mb-4 border border-secondary border-opacity-10">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center text-muted small">
                                                <i class="fas fa-clock text-primary me-2"></i>
                                                <span class="fw-medium text-dark">{{ $exam->duration }} mins</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center text-muted small">
                                                <i class="fas fa-list-ol text-primary me-2"></i>
                                                <span class="fw-medium text-dark">{{ $exam->total_questions }} Qs</span>
                                            </div>
                                        </div>
                                        <div class="col-6 mt-3">
                                            <div class="d-flex align-items-center text-muted small">
                                                <i class="fas fa-bullseye text-primary me-2"></i>
                                                <span class="fw-medium text-dark">{{ $exam->passing_percentage }}% Pass</span>
                                            </div>
                                        </div>
                                        <div class="col-6 mt-3">
                                            <div class="d-flex align-items-center text-muted small">
                                                <i class="fas fa-redo text-primary me-2"></i>
                                                <span class="fw-medium text-dark">{{ $exam->max_attempts }} Attempts</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="{{ route('user.exam.instructions', $exam->id) }}" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm stretched-link">
                                    View Details <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="glass-card border-0 shadow-sm p-5 text-center">
                <div class="text-muted mb-4">
                    <i class="fas fa-clipboard-check fa-4x text-light"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">No Exams Available</h4>
                <p class="text-muted mb-0">There are currently no examinations available for you to take.</p>
                <p class="text-muted">Please check back later or contact your administrator.</p>
            </div>
        @endif
    </div>
    
    <style>
        .exam-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }
        .exam-card:hover .stretched-link {
            background-color: var(--color-primary-dark);
        }
    </style>
@endsection
