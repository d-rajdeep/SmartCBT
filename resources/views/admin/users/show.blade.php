@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">User Details: {{ $user->name }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center">
                        <h6>Total Exams Taken</h6>
                        <h3 class="text-primary">{{ $stats['total_exams'] }}</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center">
                        <h6>Average Score</h6>
                        <h3 class="text-success">{{ $stats['average_score'] }}%</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center">
                        <h6>Passed Exams</h6>
                        <h3 class="text-info">{{ $stats['passed_exams'] }}</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center">
                        <h6>Status</h6>
                        <h3>
                            @if ($user->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </h3>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $user->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>{{ $user->date_of_birth ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Joined Date</th>
                            <td>{{ $user->created_at->format('F d, Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Exam History</h5>
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
                                            <td>{{ number_format($result->percentage, 1) }}%</td>
                                            <td>
                                                @if ($result->is_passed)
                                                    <span class="badge bg-success">Passed</span>
                                                @else
                                                    <span class="badge bg-danger">Failed</span>
                                                @endif
                                            </td>
                                            <td>{{ $result->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <a href="{{ route('admin.results.show', $result) }}"
                                                    class="btn btn-sm btn-info">
                                                    View Result
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $results->links() }}
                    @else
                        <p class="text-center text-muted">No exams taken yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
