@extends('layouts.app')

@section('title', 'Instructions - ' . $exam->title)

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Exam Instructions: {{ $exam->title }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <strong>📋 Important Information:</strong>
                            <ul class="mt-2 mb-0">
                                <li>Total Questions: {{ $exam->total_questions }}</li>
                                <li>Duration: {{ $exam->duration }} minutes</li>
                                <li>Passing Percentage: {{ $exam->passing_percentage }}%</li>
                                <li>Maximum Attempts: {{ $exam->max_attempts }}</li>
                            </ul>
                        </div>

                        <h5>📝 General Instructions:</h5>
                        <ul>
                            <li>Read each question carefully before answering.</li>
                            <li>Once you submit, you cannot change your answers.</li>
                            <li>Do not refresh the page during the exam.</li>
                            <li>Your answers will be auto-saved every 30 seconds.</li>
                            <li>Tab switching or opening new windows will be monitored.</li>
                        </ul>

                        <h5>⏱️ Time Management:</h5>
                        <ul>
                            <li>A timer will be displayed at the top of the exam page.</li>
                            <li>Time will start as soon as you begin the exam.</li>
                            <li>The exam will auto-submit when time runs out.</li>
                        </ul>

                        <div class="form-check mt-4">
                            <input type="checkbox" class="form-check-input" id="agreeCheck">
                            <label class="form-check-label" for="agreeCheck">
                                I have read and understood all the instructions. I agree to abide by the rules.
                            </label>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('user.exam.start', $exam) }}" class="btn btn-success btn-lg w-100"
                                id="startBtn" style="display: none;">
                                <i class="fas fa-play me-2"></i> Start Exam
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('agreeCheck').addEventListener('change', function() {
            const startBtn = document.getElementById('startBtn');
            startBtn.style.display = this.checked ? 'block' : 'none';
        });
    </script>
@endsection
