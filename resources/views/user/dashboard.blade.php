@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-0">Welcome back, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-muted mb-0">Here's a summary of your performance and available exams.</p>
            </div>
            <div>
                <a href="{{ route('user.exams.available') ?? '#' }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                    <i class="fas fa-search me-2"></i> Browse Exams
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-5 g-4">
            <!-- Total Exams Taken -->
            <div class="col-xl-3 col-sm-6">
                <div class="stats-card-premium primary p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-white text-opacity-75 mb-2 fw-medium">Exams Completed</h6>
                            <h2 class="text-white mb-0 fw-bold">{{ $totalExamsTaken ?? 0 }}</h2>
                        </div>
                        <div class="icon-wrapper bg-white bg-opacity-25 rounded-circle p-3 text-white">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Average Score -->
            <div class="col-xl-3 col-sm-6">
                <div class="stats-card-premium success p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-white text-opacity-75 mb-2 fw-medium">Average Score</h6>
                            <h2 class="text-white mb-0 fw-bold">{{ number_format($averageScore ?? 0, 1) }}%</h2>
                        </div>
                        <div class="icon-wrapper bg-white bg-opacity-25 rounded-circle p-3 text-white">
                            <i class="fas fa-star fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Total Hours Spent -->
            <div class="col-xl-3 col-sm-6">
                <div class="stats-card-premium info p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-white text-opacity-75 mb-2 fw-medium">Hours Spent</h6>
                            <h2 class="text-white mb-0 fw-bold">{{ $totalHoursSpent ?? 0 }}</h2>
                        </div>
                        <div class="icon-wrapper bg-white bg-opacity-25 rounded-circle p-3 text-white">
                            <i class="fas fa-clock fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Global Rank -->
            <div class="col-xl-3 col-sm-6">
                <div class="stats-card-premium warning p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-white text-opacity-75 mb-2 fw-medium">Global Rank</h6>
                            <h2 class="text-white mb-0 fw-bold">#{{ $globalRank ?? 'N/A' }}</h2>
                        </div>
                        <div class="icon-wrapper bg-white bg-opacity-25 rounded-circle p-3 text-white">
                            <i class="fas fa-trophy fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <!-- Performance Chart -->
            <div class="col-lg-8">
                <div class="glass-card h-100 border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-chart-line text-primary me-2"></i>Performance Trend</h5>
                    </div>
                    <div class="card-body p-4">
                        @if (isset($chartLabels) && count($chartLabels) > 0)
                            <canvas id="performanceChart" height="100"></canvas>
                        @else
                            <div class="text-center py-5">
                                <div class="text-muted mb-3">
                                    <i class="fas fa-chart-bar fa-3x text-light"></i>
                                </div>
                                <h6 class="text-muted fw-medium">Take some exams to see your performance chart here.</h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Recent Activities -->
            <div class="col-lg-4">
                <div class="glass-card h-100 border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-history text-primary me-2"></i>Recent Activity</h5>
                    </div>
                    <div class="card-body p-4">
                        @if (isset($recentActivities) && count($recentActivities) > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($recentActivities as $activity)
                                    <div class="list-group-item bg-transparent px-0 py-3 border-light border-opacity-50">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3 text-primary">
                                                    <i class="fas fa-clipboard-check"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold text-dark">{{ $activity->exam_name }}</h6>
                                                    <small class="text-muted"><i class="fas fa-clock me-1"></i>{{ $activity->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-1">
                                                {{ $activity->score }}%
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <p class="text-muted fw-medium mb-0">No recent activities.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Exams -->
        <div class="glass-card mb-4 border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-clipboard-list text-primary me-2"></i>Available Examinations</h5>
                <a href="{{ route('user.exams.available') ?? '#' }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
            </div>
            <div class="card-body p-4">
                @if (isset($availableExams) && count($availableExams) > 0)
                    <div class="row g-4">
                        @foreach ($availableExams as $exam)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 border-light border-opacity-50 shadow-sm hover-shadow transition-all rounded-4">
                                    <div class="card-body p-4">
                                        <h5 class="card-title fw-bold text-dark mb-2">{{ $exam->title }}</h5>
                                        <p class="card-text text-muted small mb-3">{{ Str::limit($exam->description, 80) }}</p>
                                        
                                        <div class="d-flex flex-wrap gap-2 mb-3">
                                            <span class="badge bg-light text-dark border px-2 py-1 rounded-pill small">
                                                <i class="fas fa-clock text-primary me-1"></i> {{ $exam->duration }} mins
                                            </span>
                                            <span class="badge bg-light text-dark border px-2 py-1 rounded-pill small">
                                                <i class="fas fa-question-circle text-primary me-1"></i> {{ $exam->total_questions }} Qs
                                            </span>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <small class="text-muted fw-medium">Attempts: {{ $exam->attempts_taken }}/{{ $exam->max_attempts }}</small>
                                            </div>
                                            <div class="progress" style="height: 6px; border-radius: 3px;">
                                                <div class="progress-bar bg-primary rounded-pill" role="progressbar" 
                                                    style="width: {{ ($exam->attempts_taken / max($exam->max_attempts, 1)) * 100 }}%">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-auto pt-3 border-top border-light border-opacity-50">
                                            @if ($exam->can_attempt)
                                                <a href="{{ route('user.exam.instructions', $exam->id) }}" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                                                    Start Exam <i class="fas fa-arrow-right ms-1"></i>
                                                </a>
                                            @else
                                                <button class="btn btn-secondary w-100 rounded-pill py-2 fw-semibold" disabled>
                                                    Attempts Exhausted
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="text-muted mb-3">
                            <i class="fas fa-inbox fa-3x text-light"></i>
                        </div>
                        <p class="text-muted fw-medium mb-0">No exams available at the moment.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recommended Exams -->
        @if (isset($recommendedExams) && count($recommendedExams) > 0)
            <div class="glass-card mb-4 border-0 shadow-sm" style="background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(240,248,255,0.9) 100%);">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-bullseye text-info me-2"></i>Recommended for You</h5>
                    <p class="text-muted small mb-0 mt-1">Based on your recent performance</p>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        @foreach ($recommendedExams as $exam)
                            <div class="col-md-4">
                                <div class="card h-100 border-info border-opacity-25 shadow-sm rounded-4">
                                    <div class="card-body p-4 d-flex flex-column">
                                        <h6 class="fw-bold text-dark mb-2">{{ $exam->title }}</h6>
                                        <p class="text-muted small mb-4 flex-grow-1">{{ $exam->based_on_exam }}</p>
                                        <a href="{{ route('user.exam.instructions', $exam->id) }}" class="btn btn-outline-info w-100 rounded-pill py-2 fw-semibold">
                                            Practice Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    @if (isset($chartLabels) && count($chartLabels) > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('performanceChart').getContext('2d');
            
            // Create gradient
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(99, 102, 241, 0.3)');   
            gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Your Score (%)',
                        data: {!! json_encode($chartData) !!},
                        borderColor: '#6366f1',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#6366f1',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#1e293b',
                            bodyColor: '#475569',
                            borderColor: 'rgba(0,0,0,0.05)',
                            borderWidth: 1,
                            padding: 10,
                            boxPadding: 4,
                            usePointStyle: true,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.04)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    family: "'Outfit', sans-serif",
                                    size: 11
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    family: "'Outfit', sans-serif",
                                    size: 11
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            });
        </script>
    @endif
@endpush
