@extends('layouts.app')

@section('title', 'My Results')

@section('content')
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h6 class="card-title">Total Exams</h6>
                        <h3 class="mb-0">{{ $statistics['total_exams'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h6 class="card-title">Average Score</h6>
                        <h3 class="mb-0">{{ $statistics['average_score'] ?? 0 }}%</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h6 class="card-title">Passed Exams</h6>
                        <h3 class="mb-0">{{ $statistics['passed_exams'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h6 class="card-title">Best Score</h6>
                        <h3 class="mb-0">{{ $statistics['best_score'] ?? 0 }}%</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">My Exam Results</h5>
            </div>
            <div class="card-body">
                @if ($results->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Exam Name</th>
                                    <th>Score</th>
                                    <th>Percentage</th>
                                    <th>Result</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $result)
                                    <tr>
                                        <td>{{ $result->exam->title }}</td>
                                        <td>{{ $result->total_marks_obtained }}/{{ $result->total_marks }}</td>
                                        <td>
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar bg-{{ $result->percentage >= 60 ? 'success' : 'danger' }}"
                                                    style="width: {{ $result->percentage }}%">
                                                    {{ number_format($result->percentage, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($result->is_passed)
                                                <span class="badge bg-success">Passed</span>
                                            @else
                                                <span class="badge bg-danger">Failed</span>
                                            @endif
                                        </td>
                                        <td>{{ $result->created_at->format('d M Y, h:i A') }}</td>
                                        <td>
                                            <a href="{{ route('user.results.show', $result) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $results->links() }}
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                        <h5>No Results Yet</h5>
                        <p class="text-muted">You haven't taken any exams yet. Start taking exams to see your results here.
                        </p>
                        <a href="{{ route('user.exams.available') }}" class="btn btn-primary">
                            <i class="fas fa-book me-2"></i>Browse Exams
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
