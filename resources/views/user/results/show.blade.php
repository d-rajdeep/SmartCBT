@extends('layouts.app')

@section('title', 'Result Details')

@section('content')
    <div class="container mt-4">
        <div class="mb-3">
            <a href="{{ route('user.results.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Results
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">{{ $result->exam->title }} - Result Analysis</h4>
            </div>
            <div class="card-body">
                <!-- Summary Cards -->
                <div class="row text-center mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="border rounded p-3">
                            <h6 class="text-muted">Total Score</h6>
                            <h3 class="text-primary mb-0">{{ $result->total_marks_obtained }}/{{ $result->total_marks }}
                            </h3>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="border rounded p-3">
                            <h6 class="text-muted">Percentage</h6>
                            <h3 class="text-{{ $result->is_passed ? 'success' : 'danger' }} mb-0">
                                {{ number_format($result->percentage, 1) }}%
                            </h3>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="border rounded p-3">
                            <h6 class="text-muted">Correct Answers</h6>
                            <h3 class="text-success mb-0">{{ $result->correct_answers }}</h3>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="border rounded p-3">
                            <h6 class="text-muted">Wrong Answers</h6>
                            <h3 class="text-danger mb-0">{{ $result->wrong_answers }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Result Status Badge -->
                <div class="alert alert-{{ $result->is_passed ? 'success' : 'danger' }} text-center mb-4">
                    <h5 class="mb-0">
                        @if ($result->is_passed)
                            <i class="fas fa-trophy me-2"></i>Congratulations! You have passed this exam.
                        @else
                            <i class="fas fa-frown me-2"></i>Sorry! You did not pass this exam. Keep practicing!
                        @endif
                    </h5>
                </div>

                <!-- Section Performance -->
                @if (isset($sectionPerformance))
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Section-wise Performance</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($sectionPerformance as $difficulty => $data)
                                    @if ($data['total'] > 0)
                                        <div class="col-md-4 mb-3">
                                            <label class="fw-bold">{{ ucfirst($difficulty) }} Questions</label>
                                            <div class="progress" style="height: 30px;">
                                                <div class="progress-bar bg-{{ $data['correct'] == $data['total'] ? 'success' : 'warning' }}"
                                                    style="width: {{ ($data['correct'] / $data['total']) * 100 }}%">
                                                    {{ $data['correct'] }}/{{ $data['total'] }} Correct
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Detailed Answers -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Detailed Answer Analysis</h6>
                    </div>
                    <div class="card-body">
                        @foreach ($detailedAnswers as $index => $item)
                            <div class="border-bottom mb-3 pb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <strong>Question {{ $index + 1 }}:</strong>
                                    @if ($item['is_correct'])
                                        <span class="badge bg-success">Correct</span>
                                    @else
                                        <span class="badge bg-danger">Incorrect</span>
                                    @endif
                                </div>
                                <p class="mb-2">{{ $item['question']->question_text }}</p>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div
                                            class="border rounded p-2 {{ !$item['is_correct'] ? 'bg-danger bg-opacity-10' : 'bg-success bg-opacity-10' }}">
                                            <small class="text-muted">Your Answer:</small>
                                            <div class="mt-1">
                                                @if ($item['user_answer'])
                                                    <span class="fw-bold">{{ $item['user_answer']->option_text }}</span>
                                                @else
                                                    <span class="text-warning">Not answered</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="border rounded p-2 bg-success bg-opacity-10">
                                            <small class="text-muted">Correct Answer:</small>
                                            <div class="mt-1 fw-bold text-success">
                                                {{ $item['correct_answer']->option_text ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($item['question']->explanation)
                                    <div class="mt-2 p-2 bg-info bg-opacity-10 rounded">
                                        <small class="text-muted">Explanation:</small>
                                        <p class="mb-0 mt-1">{{ $item['question']->explanation }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
