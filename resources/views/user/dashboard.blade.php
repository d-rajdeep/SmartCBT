@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mt-4">
        <div class="header glass-card">
            <div class="logo">
                <h1>📚 SmartCBT</h1>
                <p style="color: rgba(255,255,255,0.8); font-size: 12px;">Computer Based Test System</p>
            </div>
            <div class="user-info">
                <span>Welcome, {{ Auth::user()->name }}</span>
                <div class="avatar">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline; margin: 0;">
                    @csrf
                    <button type="submit"
                        style="background: none; border: none; color: white; cursor: pointer; font-size: 20px;">
                        🚪
                    </button>
                </form>
            </div>
        </div>
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Exams</h5>
                        <h2 class="mb-0">{{ $totalExamsTaken ?? 0 }}</h2>
                        <small>Exams Completed</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Average Score</h5>
                        <h2 class="mb-0">{{ number_format($averageScore ?? 0, 1) }}%</h2>
                        <small>Overall Performance</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Hours Spent</h5>
                        <h2 class="mb-0">{{ $totalHoursSpent ?? 0 }}</h2>
                        <small>Total Study Time</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Global Rank</h5>
                        <h2 class="mb-0">#{{ $globalRank ?? 'N/A' }}</h2>
                        <small>Among All Users</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Exams -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Available Examinations</h5>
            </div>
            <div class="card-body">
                @if (isset($availableExams) && count($availableExams) > 0)
                    <div class="row">
                        @foreach ($availableExams as $exam)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $exam->title }}</h5>
                                        <p class="card-text">{{ Str::limit($exam->description, 100) }}</p>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <small class="text-muted">⏱️ Duration: {{ $exam->duration }} mins</small>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">📊 Questions:
                                                    {{ $exam->total_questions }}</small>
                                            </div>
                                        </div>
                                        <div class="progress mb-2" style="height: 5px;">
                                            <div class="progress-bar"
                                                style="width: {{ ($exam->attempts_taken / max($exam->max_attempts, 1)) * 100 }}%">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small>Attempts: {{ $exam->attempts_taken }}/{{ $exam->max_attempts }}</small>
                                            @if ($exam->can_attempt)
                                                <a href="{{ route('user.exam.instructions', $exam->id) }}"
                                                    class="btn btn-success btn-sm">
                                                    Start Exam 🚀
                                                </a>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled>Attempts
                                                    Exhausted</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-muted">No exams available at the moment.</p>
                @endif
            </div>
        </div>

        <!-- Performance Chart -->
        @if (isset($chartLabels) && count($chartLabels) > 0)
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Performance Trend</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="performanceChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Recent Activities</h5>
                        </div>
                        <div class="card-body">
                            @if (isset($recentActivities) && count($recentActivities) > 0)
                                <div class="list-group">
                                    @foreach ($recentActivities as $activity)
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $activity->exam_name }}</strong>
                                                    <br>
                                                    <small
                                                        class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                                </div>
                                                <span class="badge bg-primary">Score: {{ $activity->score }}%</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No recent activities.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="text-muted">Take some exams to see your performance chart here.</p>
                            @if (isset($availableExams) && count($availableExams) > 0)
                                <a href="{{ route('user.exam.instructions', $availableExams[0]->id) }}"
                                    class="btn btn-primary">
                                    Start Your First Exam
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recommended Exams -->
        @if (isset($recommendedExams) && count($recommendedExams) > 0)
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">🎯 Recommended for You</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($recommendedExams as $exam)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>{{ $exam->title }}</h6>
                                        <p class="text-muted small">{{ $exam->based_on_exam }}</p>
                                        <a href="{{ route('user.exam.instructions', $exam->id) }}"
                                            class="btn btn-sm btn-outline-primary">
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @if (isset($chartLabels) && count($chartLabels) > 0)
        <script>
            const ctx = document.getElementById('performanceChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Your Score (%)',
                        data: {!! json_encode($chartData) !!},
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        </script>
    @endif
@endsection
