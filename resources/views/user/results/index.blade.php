@extends('layouts.app')

@section('title', 'My Results')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12 text-center text-md-start">
                <h2 class="fw-bold text-dark mb-1">My Results</h2>
                <p class="text-muted">Track your performance and view detailed feedback on past exams.</p>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-sm-6 col-xl-3">
                <div class="glass-card stat-card border-0 shadow-sm h-100 p-4 position-relative overflow-hidden">
                    <div class="position-relative z-1">
                        <p class="text-muted fw-bold text-uppercase small mb-2">Total Exams</p>
                        <h2 class="display-5 fw-bold text-primary mb-0">{{ $statistics['total_exams'] ?? 0 }}</h2>
                    </div>
                    <div class="position-absolute opacity-10" style="bottom: -15px; right: -10px;">
                        <i class="fas fa-file-alt fa-5x text-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="glass-card stat-card border-0 shadow-sm h-100 p-4 position-relative overflow-hidden">
                    <div class="position-relative z-1">
                        <p class="text-muted fw-bold text-uppercase small mb-2">Average Score</p>
                        <h2 class="display-5 fw-bold text-success mb-0">{{ $statistics['average_score'] ?? 0 }}%</h2>
                    </div>
                    <div class="position-absolute opacity-10" style="bottom: -15px; right: -10px;">
                        <i class="fas fa-chart-line fa-5x text-success"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="glass-card stat-card border-0 shadow-sm h-100 p-4 position-relative overflow-hidden">
                    <div class="position-relative z-1">
                        <p class="text-muted fw-bold text-uppercase small mb-2">Passed Exams</p>
                        <h2 class="display-5 fw-bold text-info mb-0">{{ $statistics['passed_exams'] ?? 0 }}</h2>
                    </div>
                    <div class="position-absolute opacity-10" style="bottom: -15px; right: -10px;">
                        <i class="fas fa-check-circle fa-5x text-info"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="glass-card stat-card border-0 shadow-sm h-100 p-4 position-relative overflow-hidden">
                    <div class="position-relative z-1">
                        <p class="text-muted fw-bold text-uppercase small mb-2">Best Score</p>
                        <h2 class="display-5 fw-bold text-warning mb-0">{{ $statistics['best_score'] ?? 0 }}%</h2>
                    </div>
                    <div class="position-absolute opacity-10" style="bottom: -15px; right: -10px;">
                        <i class="fas fa-trophy fa-5x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-history text-primary me-2"></i>Exam History</h5>
            </div>
            <div class="card-body p-4">
                @if ($results->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle custom-table mb-0">
                            <thead class="text-uppercase text-muted small fw-semibold">
                                <tr>
                                    <th class="ps-3 border-0">Exam Name</th>
                                    <th class="border-0 text-center">Score</th>
                                    <th class="border-0 text-center">Performance</th>
                                    <th class="border-0 text-center">Result</th>
                                    <th class="border-0">Date Taken</th>
                                    <th class="border-0 text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach ($results as $result)
                                    <tr>
                                        <td class="ps-3 fw-bold text-dark">{{ $result->exam->title }}</td>
                                        <td class="text-center">
                                            <span class="fw-medium text-dark">{{ $result->total_marks_obtained }}</span>
                                            <span class="text-muted small">/{{ $result->total_marks }}</span>
                                        </td>
                                        <td class="text-center" style="min-width: 150px;">
                                            @php
                                                $pct = $result->percentage;
                                                $colorClass = $pct >= 80 ? 'success' : ($pct >= 60 ? 'primary' : ($pct >= 40 ? 'warning' : 'danger'));
                                            @endphp
                                            <div class="d-flex align-items-center justify-content-center">
                                                <span class="fw-bold text-{{ $colorClass }} me-2" style="width: 40px;">{{ number_format($pct, 1) }}%</span>
                                                <div class="progress flex-grow-1 bg-{{ $colorClass }} bg-opacity-10 shadow-sm" style="height: 8px; max-width: 100px;">
                                                    <div class="progress-bar bg-{{ $colorClass }} rounded-pill" role="progressbar" style="width: {{ $pct }}%" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($result->is_passed)
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1 shadow-sm">Passed</span>
                                            @else
                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1 shadow-sm">Failed</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark small fw-medium">{{ $result->created_at->format('M d, Y') }}</span>
                                                <span class="text-muted small">{{ $result->created_at->format('h:i A') }}</span>
                                            </div>
                                        </td>
                                        <td class="text-end pe-3">
                                            <a href="{{ route('user.results.show', $result) }}" class="btn btn-sm btn-outline-info rounded-pill px-3 shadow-sm">
                                                <i class="fas fa-eye me-1"></i> View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($results->hasPages())
                        <div class="mt-4 d-flex justify-content-end">
                            {{ $results->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow-sm" style="width: 100px; height: 100px;">
                            <i class="fas fa-chart-line fa-3x"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">No Results Yet</h4>
                        <p class="text-muted mb-4">You haven't taken any exams yet. Start taking exams to see your performance analysis here.</p>
                        <a href="{{ route('user.exams.available') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                            <i class="fas fa-compass me-2"></i> Browse Available Exams
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
