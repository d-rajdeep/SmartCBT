<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Taking Exam: {{ $exam->title }} | SmartCBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #1a1a2e;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #eee;
        }

        /* Top Bar */
        .top-bar {
            background: #16213e;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #0f3460;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        .exam-title {
            font-size: 18px;
            font-weight: bold;
        }

        .timer {
            background: #0f3460;
            padding: 8px 20px;
            border-radius: 50px;
            font-family: monospace;
            font-size: 24px;
            font-weight: bold;
            color: #e94560;
        }

        .question-palette-btn {
            background: #0f3460;
            padding: 8px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .question-palette-btn:hover {
            background: #1a5490;
        }

        /* Main Container */
        .exam-container {
            display: flex;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
        }

        /* Question Area */
        .question-area {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .question-card {
            background: #0f3460;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 20px;
        }

        .question-number {
            color: #e94560;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .question-text {
            font-size: 20px;
            line-height: 1.5;
            margin-bottom: 30px;
        }

        .options {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .option {
            display: flex;
            align-items: center;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            border: 1px solid transparent;
        }

        .option:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .option.selected {
            background: #e94560;
            border-color: #ff6b6b;
        }

        .option input {
            margin-right: 15px;
            cursor: pointer;
        }

        .option-label {
            font-size: 16px;
        }

        /* Navigation Buttons */
        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .nav-btn {
            background: #16213e;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }

        .nav-btn:hover:not(:disabled) {
            background: #e94560;
            transform: translateY(-2px);
        }

        .nav-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .mark-btn {
            background: #ffd700;
            color: #1a1a2e;
        }

        /* Question Palette Sidebar */
        .palette-sidebar {
            width: 300px;
            background: #16213e;
            padding: 20px;
            border-left: 2px solid #0f3460;
            overflow-y: auto;
        }

        .palette-title {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e94560;
        }

        .palette-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .palette-item {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f3460;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
        }

        .palette-item.answered {
            background: #00b894;
        }

        .palette-item.marked {
            background: #f39c12;
        }

        .palette-item.current {
            border: 3px solid #e94560;
            transform: scale(1.05);
        }

        .palette-item.not-visited {
            background: #2c3e50;
        }

        .legend {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #0f3460;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 12px;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
        }

        /* Submit Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #16213e;
            padding: 30px;
            border-radius: 12px;
            max-width: 500px;
            text-align: center;
        }

        .modal-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            justify-content: center;
        }

        .modal-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .confirm-btn {
            background: #e94560;
            color: white;
        }

        .cancel-btn {
            background: #2c3e50;
            color: white;
        }

        @media (max-width: 768px) {
            .palette-sidebar {
                position: fixed;
                right: -300px;
                top: 70px;
                bottom: 0;
                transition: right 0.3s;
                z-index: 200;
            }

            .palette-sidebar.open {
                right: 0;
            }
        }
    </style>
</head>

<body>
    <div class="top-bar">
        <div class="exam-title">{{ $exam->title }}</div>
        <div class="timer" id="timer">00:00:00</div>
        <div class="question-palette-btn" onclick="togglePalette()">📊 Question Palette</div>
    </div>

    <div class="exam-container">
        <div class="question-area">
            <form id="examForm" method="POST" action="{{ route('user.exam.submit', $attempt) }}">
                @csrf
                <input type="hidden" name="answers_input" id="answersInput">

                @foreach ($questions as $index => $question)
                    <div class="question-card" id="question-{{ $index }}"
                        style="display: {{ $index == 0 ? 'block' : 'none' }}">
                        <div class="question-number">Question {{ $index + 1 }} of {{ count($questions) }}</div>
                        <div class="question-text">{{ $question->question_text }}</div>
                        <div class="options">
                            @foreach ($question->options as $optIndex => $option)
                                <label class="option">
                                    <input type="radio" name="answers[{{ $question->id }}]"
                                        value="{{ $option->id }}" onchange="markAnswered({{ $index }})"
                                        {{ isset($savedAnswers[$question->id]) && $savedAnswers[$question->id] == $option->id ? 'checked' : '' }}>
                                    <span class="option-label">{{ chr(65 + $optIndex) }}.
                                        {{ $option->option_text }}</span>
                                </label>
                            @endforeach
                        </div>
                        <div class="nav-buttons">
                            <button type="button" class="nav-btn" onclick="previousQuestion()" id="prevBtn"
                                disabled>← Previous</button>
                            <button type="button" class="nav-btn mark-btn"
                                onclick="markForReview({{ $index }})">🔖 Mark for Review</button>
                            <button type="button" class="nav-btn" onclick="nextQuestion()" id="nextBtn">Next
                                →</button>
                        </div>
                    </div>
                @endforeach

                <div style="text-align: center; margin-top: 30px;">
                    <button type="button" class="nav-btn" onclick="showSubmitModal()"
                        style="background: #00b894;">Submit Exam</button>
                </div>
            </form>
        </div>

        <div class="palette-sidebar" id="palette">
            <div class="palette-title">Question Palette</div>
            <div class="palette-grid" id="paletteGrid">
                @foreach ($questions as $index => $question)
                    <div class="palette-item not-visited" id="palette-{{ $index }}"
                        onclick="goToQuestion({{ $index }})">
                        {{ $index + 1 }}
                    </div>
                @endforeach
            </div>
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-color" style="background: #00b894;"></div>
                    <span>Answered</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #f39c12;"></div>
                    <span>Marked for Review</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #e94560;"></div>
                    <span>Current Question</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #2c3e50;"></div>
                    <span>Not Visited</span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="submitModal">
        <div class="modal-content">
            <h3>Confirm Submission</h3>
            <p>Are you sure you want to submit the exam?</p>
            <div class="stats" style="margin: 20px 0;">
                <p>Answered: <span id="answeredCount">0</span>/{{ count($questions) }}</p>
                <p>Marked for Review: <span id="markedCount">0</span></p>
                <p>Not Answered: <span id="notAnsweredCount">{{ count($questions) }}</span></p>
            </div>
            <div class="modal-buttons">
                <button class="modal-btn cancel-btn" onclick="closeModal()">Cancel</button>
                <button class="modal-btn confirm-btn" onclick="submitExam()">Confirm Submit</button>
            </div>
        </div>
    </div>

    <script>
        let currentQuestion = 0;
        const totalQuestions = {{ count($questions) }};
        let answered = new Array(totalQuestions).fill(false);
        let markedForReview = new Array(totalQuestions).fill(false);
        let timeLeft = {{ $exam->duration * 60 }}; // in seconds
        let examSubmitted = false;

        // Initialize from saved data
        @foreach ($savedAnswers as $qId => $answer)
            answered[{{ $loop->index }}] = true;
        @endforeach

        @foreach ($markedQuestions as $index)
            markedForReview[{{ $index }}] = true;
        @endforeach

        // Timer
        function updateTimer() {
            if (examSubmitted) return;

            const hours = Math.floor(timeLeft / 3600);
            const minutes = Math.floor((timeLeft % 3600) / 60);
            const seconds = timeLeft % 60;

            document.getElementById('timer').textContent =
                `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            if (timeLeft <= 0) {
                submitExam();
            } else {
                timeLeft--;
                setTimeout(updateTimer, 1000);
            }
        }

        updateTimer();

        // Navigation
        function goToQuestion(index) {
            document.getElementById(`question-${currentQuestion}`).style.display = 'none';
            currentQuestion = index;
            document.getElementById(`question-${currentQuestion}`).style.display = 'block';

            updatePaletteHighlight();
            updateNavButtons();
        }

        function nextQuestion() {
            if (currentQuestion < totalQuestions - 1) {
                goToQuestion(currentQuestion + 1);
            }
        }

        function previousQuestion() {
            if (currentQuestion > 0) {
                goToQuestion(currentQuestion - 1);
            }
        }

        function markAnswered(questionIndex) {
            answered[questionIndex] = true;
            updatePaletteItem(questionIndex);
            updateSubmitModalStats();
            autoSave();
        }

        function markForReview(questionIndex) {
            markedForReview[questionIndex] = !markedForReview[questionIndex];
            updatePaletteItem(questionIndex);
            autoSave();

            // Show alert
            const message = markedForReview[questionIndex] ? 'Marked for Review' : 'Review Removed';
            alert(message);
        }

        function updatePaletteItem(index) {
            const element = document.getElementById(`palette-${index}`);
            element.classList.remove('answered', 'marked', 'not-visited');

            if (markedForReview[index]) {
                element.classList.add('marked');
            } else if (answered[index]) {
                element.classList.add('answered');
            } else {
                element.classList.add('not-visited');
            }
        }

        function updatePaletteHighlight() {
            for (let i = 0; i < totalQuestions; i++) {
                document.getElementById(`palette-${i}`).classList.remove('current');
            }
            document.getElementById(`palette-${currentQuestion}`).classList.add('current');
        }

        function updateNavButtons() {
            document.getElementById('prevBtn').disabled = currentQuestion === 0;
            document.getElementById('nextBtn').disabled = currentQuestion === totalQuestions - 1;
        }

        // Submit Modal
        function showSubmitModal() {
            updateSubmitModalStats();
            document.getElementById('submitModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('submitModal').style.display = 'none';
        }

        function updateSubmitModalStats() {
            const answeredCount = answered.filter(a => a === true).length;
            const markedCount = markedForReview.filter(m => m === true).length;
            document.getElementById('answeredCount').textContent = answeredCount;
            document.getElementById('markedCount').textContent = markedCount;
            document.getElementById('notAnsweredCount').textContent = totalQuestions - answeredCount;
        }

        function collectAnswers() {
            const form = document.getElementById('examForm');
            const formData = new FormData(form);
            const answers = {};
            for (let [key, value] of formData.entries()) {
                if (key.startsWith('answers[')) {
                    const questionId = key.match(/\d+/)[0];
                    answers[questionId] = value;
                }
            }
            return answers;
        }

        function autoSave() {
            const answers = collectAnswers();
            fetch('{{ route('user.exam.auto-save', $attempt) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    answers: answers,
                    marked: markedForReview
                })
            });
        }

        function submitExam() {
            if (examSubmitted) return;
            examSubmitted = true;

            const answers = collectAnswers();
            document.getElementById('answersInput').value = JSON.stringify(answers);
            document.getElementById('examForm').submit();
        }

        function togglePalette() {
            document.getElementById('palette').classList.toggle('open');
        }

        // Initialize
        for (let i = 0; i < totalQuestions; i++) {
            updatePaletteItem(i);
        }
        updatePaletteHighlight();
        updateNavButtons();
        updateSubmitModalStats();

        // Auto-save every 30 seconds
        setInterval(autoSave, 30000);
    </script>
</body>

</html>
