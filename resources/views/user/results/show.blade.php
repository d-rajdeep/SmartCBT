@extends('layouts.app')

@section('title', 'Result Details')

@section('content')
    <div class="container mt-4">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">{{ $result->exam->title }} - Result Analysis</h4>
            </div>
            <div class="card-body">
                <div class="row text-center mb-4">
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h6>Total Score</h6>
                            <h3 class="text-primary">{{ $result->total_marks_obtained }}/{{ $result->total_marks }}</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h6>Percentage</h6>
                            <h3 class="text-{{ $result->is_passed ? 'success' : 'danger' }}">
                                {{ number_format($result->percentage, 1) }}%
                            </h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h6>Correct Answers</h6>
                            <h3 class="text-success">{{ $result->correct_answers }}</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h6>Wrong Answers</h6>
                            <h3 class="text-danger">{{ $result->wrong_answers }}</h3>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6>Section-wise Performance</h6>
                            </div>
                            <div class="card-body">
                                @foreach ($sectionPerformance as $difficulty => $data)
                                    <div class="mb-3">
                                        <label>{{ ucfirst($difficulty) }}</label>
                                        <div class="progress">
                                            <div class="progress-bar bg-{{ $data['correct'] == $data['total'] ? 'success' : 'warning' }}"
                                                style="width: {{ $data['total'] > 0 ? ($data['correct'] / $data['total']) * 100 : 0 }}%">
                                                {{ $data['correct'] }}/{{ $data['total'] }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6>Time Analysis</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="timeChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h6>Detailed Answers</h6>
                    </div>
                    <div class="card-body">
                        @foreach ($detailedAnswers as $index => $item)
                            <div class="border-bottom mb-3 pb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <strong>Question {{ $index + 1 }}: {{ $item['question']->question_text }}</strong>
                                    @if ($item['is_correct'])
                                        <span class="badge bg-success">Correct</span>
                                    @else
                                        <span class="badge bg-danger">Incorrect</span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">Your Answer:</small>
                                        <div class="border rounded p-2 mb-2">
                                            {{ $item['user_answer']->option_text ?? 'Not answered' }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Correct Answer:</small>
                                        <div class="border rounded p-2 mb-2 bg-success bg-opacity-10">
                                            {{ $item['correct_answer']->option_text ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                                @if ($item['question']->explanation)
                                    <small class="text-muted">Explanation:</small>
                                    <p class="mb-0">{{ $item['question']->explanation }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const timeCtx = document.getElementById('timeChart').getContext('2d');
        new Chart(timeCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(range(1, count($timePerQuestion))) !!},
                datasets: [{
                    label: 'Time Spent (seconds)',
                    data: {!! json_encode($timePerQuestion) !!},
                    backgroundColor: '#667eea'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true
            }
        });
    </script>
@endsection
