@extends('layouts.app')

@section('title', 'Take Exam')

{{-- @section('content') --}}
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>{{ $userExam->exam->title }}</h4>
            <div class="alert alert-info mb-0">
                Time Left: <strong id="timer"></strong>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                {{-- Hidden inputs for JavaScript --}}
                <input type="hidden" id="userExamId" value="{{ $userExam->id }}">
                <input type="hidden" id="submitUrl" value="{{ route('user.exams.submit', $userExam->id) }}">
                <input type="hidden" id="saveUrl" value="{{ route('user.exams.answer', $userExam->id) }}">
                <input type="hidden" id="resultUrl" value="{{ route('user.exams.result', $userExam->id) }}">
                <input type="hidden" id="csrfToken" value="{{ csrf_token() }}">
                <input type="hidden" id="remainingSeconds" value="{{ $remainingSeconds }}">

                {{-- Questions --}}
                @foreach($questions as $index => $question)
                    <div class="question-block" id="question-{{ $index }}" style="{{ $index === 0 ? '' : 'display:none;' }}">
                        <h5>Question {{ $index + 1 }} of {{ count($questions) }}</h5>
                        <p class="mt-2">{{ $question->question_text }}</p>

                        <ul class="list-group">
                            @foreach($question->options as $option)
                                <li class="list-group-item">
                                    <label>
                                        <input type="radio" name="question_{{ $question->id }}" value="{{ $option->id }}"
                                            class="option-input" data-question="{{ $question->id }}">
                                        {{ $option->option_text }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-3 d-flex justify-content-between">
                            <button class="btn btn-secondary btn-prev">Previous</button>
                            <div>
                                <button class="btn btn-warning btn-mark" data-question="{{ $question->id }}">Mark for
                                    Review</button>
                                <button class="btn btn-primary btn-next">Next</button>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="text-center mt-4">
                    <button id="submitExam" class="btn btn-success btn-lg">Submit Exam</button>
                </div>

            </div>
        </div>
    </div>

    {{-- JavaScript Section --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const questions = document.querySelectorAll('.question-block');
            let current = 0;
            const userExamId = document.getElementById('userExamId').value;
            const saveUrl = document.getElementById('saveUrl').value;
            const submitUrl = document.getElementById('submitUrl').value;
            const resultUrl = document.getElementById('resultUrl').value;
            const csrf = document.getElementById('csrfToken').value;
            let remaining = parseInt(document.getElementById('remainingSeconds').value);

            // Timer
            const timerEl = document.getElementById('timer');
            function updateTimer() {
                if (remaining <= 0) {
                    submitExam();
                    return;
                }
                const min = Math.floor(remaining / 60);
                const sec = remaining % 60;
                timerEl.textContent = `${min}:${sec.toString().padStart(2, '0')}`;
                remaining--;
            }
            setInterval(updateTimer, 1000);
            updateTimer();

            // Navigation
            document.querySelectorAll('.btn-next').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (current < questions.length - 1) {
                        questions[current].style.display = 'none';
                        current++;
                        questions[current].style.display = 'block';
                    }
                });
            });
            document.querySelectorAll('.btn-prev').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (current > 0) {
                        questions[current].style.display = 'none';
                        current--;
                        questions[current].style.display = 'block';
                    }
                });
            });

            // Auto Save Answer
            document.querySelectorAll('.option-input').forEach(input => {
                input.addEventListener('change', function () {
                    saveAnswer(this.dataset.question, this.value, false);
                });
            });

            // Mark for Review
            document.querySelectorAll('.btn-mark').forEach(btn => {
                btn.addEventListener('click', function () {
                    saveAnswer(this.dataset.question, null, true);
                    alert('Question marked for review.');
                });
            });

            // Submit Button
            document.getElementById('submitExam').addEventListener('click', function () {
                if (confirm('Are you sure you want to submit your exam?')) {
                    submitExam();
                }
            });

            // Save Answer (AJAX)
            function saveAnswer(questionId, optionId = null, marked = false) {
                fetch(saveUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({
                        question_id: questionId,
                        option_id: optionId,
                        marked_for_review: marked
                    })
                })
                    .then(res => res.json())
                    .then(data => console.log('Answer saved:', data))
                    .catch(err => console.error('Error saving answer:', err));
            }

            // Submit Exam (AJAX)
            function submitExam() {
                fetch(submitUrl, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf }
                })
                    .then(() => {
                        alert('Exam submitted successfully!');
                        window.location.href = resultUrl;
                    })
                    .catch(err => console.error('Error submitting exam:', err));
            }

            // Prevent refresh & back navigation
            window.onbeforeunload = function () {
                return "Are you sure you want to leave? Your answers might not be saved.";
            };
        });
    </script>
{{-- @endsection --}}