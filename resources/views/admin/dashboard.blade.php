@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Users</h6>
                        <h2 class="mb-0">{{ $totalUsers ?? 0 }}</h2>
                    </div>
                    <div class="bg-primary rounded-circle p-3">
                        <i class="fas fa-users text-white fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Exams</h6>
                        <h2 class="mb-0">{{ $totalExams ?? 0 }}</h2>
                    </div>
                    <div class="bg-success rounded-circle p-3">
                        <i class="fas fa-book text-white fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Attempts</h6>
                        <h2 class="mb-0">{{ $totalAttempts ?? 0 }}</h2>
                    </div>
                    <div class="bg-info rounded-circle p-3">
                        <i class="fas fa-chart-line text-white fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Average Score</h6>
                        <h2 class="mb-0">{{ number_format($averageScore ?? 0, 1) }}%</h2>
                    </div>
                    <div class="bg-warning rounded-circle p-3">
                        <i class="fas fa-percent text-white fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Recent Exams</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Questions</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentExams ?? [] as $exam)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $exam->title }}</td>
                                <td>{{ $exam->category->name ?? 'N/A' }}</td>
                                <td>{{ $exam->total_questions }}</td>
                                <td>
                                    @if ($exam->is_published)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>{{ $exam->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No exams found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
