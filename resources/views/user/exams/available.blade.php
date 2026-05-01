@extends('layouts.app')

@section('title', 'Available Exams')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Available Examinations</h5>
            </div>
            <div class="card-body">
                @if (isset($exams) && count($exams) > 0)
                    <div class="row">
                        @foreach ($exams as $exam)
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
                                                <small class="text-muted">📊 Questions: {{ $exam->total_questions }}</small>
                                            </div>
                                        </div>
                                        <a href="{{ route('user.exam.instructions', $exam->id) }}"
                                            class="btn btn-primary btn-sm">
                                            View Details
                                        </a>
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
    </div>
@endsection
