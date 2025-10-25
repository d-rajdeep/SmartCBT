@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
    <div class="container py-4">
        <h3 class="mb-4">Welcome, {{ auth()->user()->name }} 👋</h3>

        {{-- Stats Section --}}
        <div class="row mb-4">
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <h5 class="fw-bold mb-1">{{ $completedCount }}</h5>
                        <p class="text-muted mb-0">Exams Completed</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <h5 class="fw-bold mb-1">{{ $totalScore }}</h5>
                        <p class="text-muted mb-0">Total Score</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Exams List --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Available Exams</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Exam Title</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exams as $exam)
                            @php
                                $userExam = $userExams->get($exam->id);
                            @endphp
                            <tr>
                                <td>{{ $exam->title }}</td>
                                <td>{{ $exam->duration }} mins</td>
                                <td>
                                    @if(!$userExam)
                                        <span class="badge bg-secondary">Not Started</span>
                                    @elseif(!$userExam->submitted)
                                        <span class="badge bg-warning text-dark">In Progress</span>
                                    @else
                                        <span class="badge bg-success">Submitted</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$userExam)
                                        <form action="{{ route('user.exams.start', $exam->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">Start Exam</button>
                                        </form>
                                    @elseif(!$userExam->submitted)
                                        <a href="{{ route('user.exams.take', $userExam->id) }}"
                                            class="btn btn-sm btn-warning">Resume</a>
                                    @else
                                        <a href="{{ route('user.exams.result', $userExam->id) }}"
                                            class="btn btn-sm btn-success">View Result</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted p-3">
                                    No exams available right now.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection