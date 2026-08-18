@extends('layouts.app')

@section('title', 'Instructions - ' . $exam->title)

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center mb-4">
                    <a href="{{ route('user.exams.available') }}" class="btn btn-outline-secondary rounded-circle p-2 me-3 shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="fw-bold text-dark mb-0">Exam Instructions</h2>
                </div>

                <div class="glass-card border-0 shadow-sm overflow-hidden mb-4">
                    <div class="bg-primary bg-gradient p-4 text-white">
                        <h4 class="fw-bold mb-1">{{ $exam->title }}</h4>
                        <p class="text-white-50 mb-0">Please read the instructions carefully before starting.</p>
                    </div>
                    
                    <div class="card-body p-4 p-md-5">
                        <!-- Key Information Highlights -->
                        <div class="row g-3 mb-5">
                            <div class="col-6 col-md-3">
                                <div class="bg-light rounded-3 p-3 text-center h-100 border border-secondary border-opacity-10 shadow-sm">
                                    <i class="fas fa-list-ol text-primary fs-3 mb-2"></i>
                                    <h5 class="fw-bold text-dark mb-0">{{ $exam->total_questions }}</h5>
                                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem;">Questions</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="bg-light rounded-3 p-3 text-center h-100 border border-secondary border-opacity-10 shadow-sm">
                                    <i class="fas fa-stopwatch text-info fs-3 mb-2"></i>
                                    <h5 class="fw-bold text-dark mb-0">{{ $exam->duration }}</h5>
                                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem;">Minutes</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="bg-light rounded-3 p-3 text-center h-100 border border-secondary border-opacity-10 shadow-sm">
                                    <i class="fas fa-bullseye text-success fs-3 mb-2"></i>
                                    <h5 class="fw-bold text-dark mb-0">{{ $exam->passing_percentage }}%</h5>
                                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem;">To Pass</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="bg-light rounded-3 p-3 text-center h-100 border border-secondary border-opacity-10 shadow-sm">
                                    <i class="fas fa-redo text-warning fs-3 mb-2"></i>
                                    <h5 class="fw-bold text-dark mb-0">{{ $exam->max_attempts }}</h5>
                                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem;">Attempts</small>
                                </div>
                            </div>
                        </div>

                        <!-- General Instructions -->
                        <div class="mb-4">
                            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-2">
                                    <i class="fas fa-clipboard-list fa-fw"></i>
                                </div>
                                General Instructions
                            </h5>
                            <div class="bg-light rounded-3 p-4 border border-secondary border-opacity-10">
                                <ul class="list-unstyled mb-0 text-muted">
                                    <li class="mb-3 d-flex align-items-start">
                                        <i class="fas fa-check-circle text-primary mt-1 me-3"></i>
                                        <span>Read each question carefully before selecting an answer.</span>
                                    </li>
                                    <li class="mb-3 d-flex align-items-start">
                                        <i class="fas fa-check-circle text-primary mt-1 me-3"></i>
                                        <span>Once you submit the exam, you cannot change your answers.</span>
                                    </li>
                                    <li class="mb-3 d-flex align-items-start">
                                        <i class="fas fa-exclamation-triangle text-warning mt-1 me-3"></i>
                                        <span><strong>Do not refresh the page</strong> during the exam, as this may submit your exam prematurely.</span>
                                    </li>
                                    <li class="mb-3 d-flex align-items-start">
                                        <i class="fas fa-save text-success mt-1 me-3"></i>
                                        <span>Your answers are automatically saved every 30 seconds.</span>
                                    </li>
                                    <li class="d-flex align-items-start">
                                        <i class="fas fa-desktop text-info mt-1 me-3"></i>
                                        <span>Tab switching or opening new windows may be monitored.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Time Management -->
                        <div class="mb-5">
                            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-2">
                                    <i class="fas fa-hourglass-half fa-fw"></i>
                                </div>
                                Time Management
                            </h5>
                            <div class="bg-light rounded-3 p-4 border border-secondary border-opacity-10">
                                <ul class="list-unstyled mb-0 text-muted">
                                    <li class="mb-2 d-flex align-items-center">
                                        <i class="fas fa-dot-circle text-primary me-3 small"></i>
                                        <span>A countdown timer will be displayed prominently at the top of the exam screen.</span>
                                    </li>
                                    <li class="mb-2 d-flex align-items-center">
                                        <i class="fas fa-dot-circle text-primary me-3 small"></i>
                                        <span>The timer starts immediately as soon as you click 'Start Exam'.</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-dot-circle text-danger me-3 small"></i>
                                        <span>The exam will <strong>automatically submit</strong> when the time runs out.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Agreement and Action -->
                        <div class="bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-3 p-4 text-center">
                            <div class="form-check d-flex justify-content-center align-items-center gap-2 mb-4 custom-checkbox">
                                <input class="form-check-input mt-0 fs-5" type="checkbox" id="agreeCheck">
                                <label class="form-check-label fw-medium text-dark text-start user-select-none cursor-pointer" for="agreeCheck">
                                    I have read and understood all instructions. I agree to abide by the exam rules.
                                </label>
                            </div>
                            
                            <a href="{{ route('user.exam.start', $exam) }}" class="btn btn-success btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg text-white w-100 disabled" id="startBtn" style="transition: all 0.3s; opacity: 0.5;">
                                <i class="fas fa-play-circle me-2"></i> Start Exam Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('agreeCheck').addEventListener('change', function() {
            const startBtn = document.getElementById('startBtn');
            if (this.checked) {
                startBtn.classList.remove('disabled');
                startBtn.style.opacity = '1';
                // Remove pointer-events none from disabled class
                startBtn.style.pointerEvents = 'auto'; 
            } else {
                startBtn.classList.add('disabled');
                startBtn.style.opacity = '0.5';
                startBtn.style.pointerEvents = 'none';
            }
        });
    </script>
    
    <style>
        .cursor-pointer { cursor: pointer; }
    </style>
@endsection
