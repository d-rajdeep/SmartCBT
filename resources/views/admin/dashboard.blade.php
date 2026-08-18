@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Dashboard Overview</h2>
            <p class="text-muted mb-0">Welcome back, here's what's happening today.</p>
        </div>
        <div>
            <a href="{{ route('admin.exams.create') ?? '#' }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                <i class="fas fa-plus me-2"></i> Create Exam
            </a>
        </div>
    </div>

    <div class="row mb-5 g-4">
        <!-- Total Users -->
        <div class="col-xl-3 col-sm-6">
            <div class="stats-card-premium primary p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-white text-opacity-75 mb-2 fw-medium">Total Users</h6>
                        <h2 class="text-white mb-0 fw-bold">{{ $totalUsers ?? 0 }}</h2>
                    </div>
                    <div class="icon-wrapper bg-white bg-opacity-25 rounded-circle p-3 text-white">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-2 py-1 small">
                        <i class="fas fa-arrow-up me-1"></i> 12% increase
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Total Exams -->
        <div class="col-xl-3 col-sm-6">
            <div class="stats-card-premium success p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-white text-opacity-75 mb-2 fw-medium">Total Exams</h6>
                        <h2 class="text-white mb-0 fw-bold">{{ $totalExams ?? 0 }}</h2>
                    </div>
                    <div class="icon-wrapper bg-white bg-opacity-25 rounded-circle p-3 text-white">
                        <i class="fas fa-book-open fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-2 py-1 small">
                        <i class="fas fa-plus me-1"></i> 3 new this week
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Total Attempts -->
        <div class="col-xl-3 col-sm-6">
            <div class="stats-card-premium info p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-white text-opacity-75 mb-2 fw-medium">Total Attempts</h6>
                        <h2 class="text-white mb-0 fw-bold">{{ $totalAttempts ?? 0 }}</h2>
                    </div>
                    <div class="icon-wrapper bg-white bg-opacity-25 rounded-circle p-3 text-white">
                        <i class="fas fa-chart-line fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-2 py-1 small">
                        <i class="fas fa-arrow-up me-1"></i> 8% this month
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Average Score -->
        <div class="col-xl-3 col-sm-6">
            <div class="stats-card-premium warning p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-white text-opacity-75 mb-2 fw-medium">Average Score</h6>
                        <h2 class="text-white mb-0 fw-bold">{{ number_format($averageScore ?? 0, 1) }}%</h2>
                    </div>
                    <div class="icon-wrapper bg-white bg-opacity-25 rounded-circle p-3 text-white">
                        <i class="fas fa-bullseye fa-lg"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-2 py-1 small">
                        Consistent performance
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="glass-card mb-4 border-0 shadow-sm">
        <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-clock text-primary me-2"></i>Recent Exams</h5>
            <a href="{{ route('admin.exams.index') ?? '#' }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle custom-table mb-0">
                    <thead class="text-uppercase text-muted small fw-semibold">
                        <tr>
                            <th class="ps-3 border-0">Exam Details</th>
                            <th class="border-0">Category</th>
                            <th class="border-0 text-center">Questions</th>
                            <th class="border-0">Status</th>
                            <th class="border-0 text-end pe-3">Created</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($recentExams ?? [] as $exam)
                            <tr>
                                <td class="ps-3 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle p-2 me-3 text-primary">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $exam->title }}</h6>
                                            <small class="text-muted">ID: #{{ $exam->id ?? $loop->index + 1 }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1 rounded-pill">
                                        {{ $exam->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-medium text-dark">{{ $exam->total_questions }}</span>
                                </td>
                                <td>
                                    @if ($exam->is_published)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill">
                                            <i class="fas fa-check-circle me-1 small"></i> Published
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1 rounded-pill">
                                            <i class="fas fa-pen me-1 small"></i> Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-3 text-muted small fw-medium">
                                    {{ $exam->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        <i class="fas fa-inbox fa-3x text-light"></i>
                                    </div>
                                    <h6 class="text-muted fw-medium">No recent exams found</h6>
                                    <a href="{{ route('admin.exams.create') ?? '#' }}" class="btn btn-sm btn-primary mt-2 rounded-pill px-3">Create First Exam</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
