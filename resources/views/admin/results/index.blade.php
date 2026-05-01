@extends('layouts.admin')

@section('title', 'Results Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Exam Results</h2>
        <a href="{{ route('admin.results.export') }}" class="btn btn-success">
            <i class="fas fa-download me-2"></i>Export Results
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.results.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="exam_id" class="form-label">Filter by Exam</label>
                    <select name="exam_id" id="exam_id" class="form-select">
                        <option value="">All Exams</option>
                        @foreach ($exams as $exam)
                            <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                                {{ $exam->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date_from" class="form-label">Date From</label>
                    <input type="date" name="date_from" id="date_from" class="form-control"
                        value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label">Date To</label>
                    <input type="date" name="date_to" id="date_to" class="form-control"
                        value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Exam</th>
                            <th>Score</th>
                            <th>Percentage</th>
                            <th>Result</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $result)
                            <tr>
                                <td>{{ $result->id }}</td>
                                <td>{{ $result->user->name }}</td>
                                <td>{{ $result->exam->title }}</td>
                                <td>{{ $result->total_marks_obtained }}/{{ $result->total_marks }}</td>
                                <td>
                                    <div class="progress" style="height: 20px;">
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
                                <td>{{ $result->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.results.show', $result) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No results found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $results->links() }}
        </div>
    </div>
@endsection
