@extends('layouts.admin')

@section('title', 'Result Details')

@section('content')
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Result Details - {{ $result->exam->title }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center">
                        <h6>Student Name</h6>
                        <h5>{{ $result->user->name }}</h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center">
                        <h6>Email</h6>
                        <h5>{{ $result->user->email }}</h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center">
                        <h6>Total Score</h6>
                        <h5 class="text-primary">{{ $result->total_marks_obtained }}/{{ $result->total_marks }}</h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center">
                        <h6>Percentage</h6>
                        <h5 class="text-{{ $result->is_passed ? 'success' : 'danger' }}">
                            {{ number_format($result->percentage, 1) }}%
                        </h5>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="border rounded p-3 text-center">
                        <h6>Correct Answers</h6>
                        <h3 class="text-success">{{ $result->correct_answers }}</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 text-center">
                        <h6>Wrong Answers</h6>
                        <h3 class="text-danger">{{ $result->wrong_answers }}</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 text-center">
                        <h6>Skipped Answers</h6>
                        <h3 class="text-warning">{{ $result->skipped_answers }}</h3>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6>Detailed Answers</h6>
                </div>
                <div class="card-body">
                    @forelse($detailedAnswers as $index => $item)
                        <div class="border-bottom mb-3 pb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Q{{ $index + 1 }}: {{ $item['question']->question_text }}</strong>
                                @if ($item['is_correct'])
                                    <span class="badge bg-success">Correct</span>
                                @else
                                    <span class="badge bg-danger">Incorrect</span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">User Answer:</small>
                                    <div class="border rounded p-2 bg-light">
                                        {{ $item['user_answer']->option_text ?? 'Not answered' }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Correct Answer:</small>
                                    <div class="border rounded p-2 bg-success bg-opacity-10">
                                        {{ $item['correct_answer']->option_text ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            @if ($item['question']->explanation)
                                <small class="text-muted">Explanation:</small>
                                <p class="mb-0 mt-1">{{ $item['question']->explanation }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-muted">No detailed answers available</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.results.index') }}" class="btn btn-secondary">Back to Results</a>
            </div>
        </div>
    </div>
@endsection
