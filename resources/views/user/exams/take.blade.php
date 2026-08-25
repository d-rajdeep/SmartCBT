<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Taking Exam: {{ $exam->title }} | SmartCBT</title>
    <link rel="icon" type="image/svg+xml" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/svgs/solid/graduation-cap.svg">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap and Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Premium UI CSS -->
    <link rel="stylesheet" href="{{ asset('css/premium-ui.css') }}">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        :root {
            --color-background: var(--bg-body);
            --color-surface: #ffffff;
            --color-text: var(--text-primary);
            --color-text-muted: var(--text-secondary);
            --color-border: var(--border-color);
            --color-primary: var(--primary-color);
            --color-primary-dark: #4f46e5;
            --color-primary-light: #eef2ff;
            --color-primary-rgb: 99, 102, 241;
            --color-success: var(--success-color);
            --color-warning: var(--warning-color);
            --radius-md: var(--border-radius-md);
            --radius-lg: var(--border-radius-lg);
        }

        body {
            background-color: var(--color-background);
            color: var(--color-text);
            min-height: 100vh;
        }

        /* Top Bar */
        .top-bar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            box-shadow: var(--shadow-sm);
        }

        .exam-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--color-text);
        }

        .attempt-badge {
            background: #eef2ff;
            color: #4338ca;
            border: 1px solid #c7d2fe;
            border-radius: 50px;
            padding: 7px 14px;
            font-size: 0.85rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .timer {
            background: var(--color-primary-light);
            padding: 8px 24px;
            border-radius: 50px;
            font-family: monospace;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-primary-dark);
            border: 1px solid rgba(var(--color-primary-rgb), 0.2);
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        }

        .timer.warning {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border-color: rgba(239, 68, 68, 0.2);
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .question-palette-btn {
            background: var(--color-surface);
            padding: 10px 20px;
            border-radius: 50px;
            cursor: pointer;
            transition: all var(--transition-fast);
            border: 1px solid var(--color-border);
            font-weight: 600;
            color: var(--color-text);
            box-shadow: var(--shadow-sm);
        }

        .question-palette-btn:hover {
            background: var(--color-primary-light);
            color: var(--color-primary);
            border-color: rgba(var(--color-primary-rgb), 0.2);
        }

        /* Main Container */
        .exam-container {
            display: flex;
            margin-top: 74px; /* Height of top bar */
            min-height: calc(100vh - 74px);
        }

        /* Question Area */
        .question-area {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            background: transparent;
        }

        .question-card {
            background: var(--color-surface);
            border-radius: var(--radius-lg);
            padding: 40px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(255, 255, 255, 0.5);
            max-width: 900px;
            margin: 0 auto 30px auto;
        }

        .question-number {
            color: var(--color-primary);
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
            display: inline-block;
            background: var(--color-primary-light);
            padding: 6px 16px;
            border-radius: 50px;
        }

        .question-text {
            font-size: 1.35rem;
            font-weight: 600;
            line-height: 1.6;
            margin-bottom: 40px;
            color: var(--color-text);
        }

        .options {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .option {
            display: flex;
            align-items: center;
            padding: 18px 24px;
            background: var(--color-background);
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all var(--transition-fast);
            border: 2px solid transparent;
        }

        .option:hover {
            background: white;
            border-color: rgba(var(--color-primary-rgb), 0.2);
            transform: translateX(5px);
            box-shadow: var(--shadow-sm);
        }

        .option.selected {
            background: var(--color-primary-light);
            border-color: var(--color-primary);
        }

        .option input {
            margin-right: 20px;
            cursor: pointer;
            width: 20px;
            height: 20px;
            accent-color: var(--color-primary);
        }

        .option-label {
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Navigation Buttons */
        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid var(--color-border);
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        .nav-btn {
            background: white;
            color: var(--color-text);
            border: 1px solid var(--color-border);
            padding: 12px 28px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all var(--transition-fast);
            box-shadow: var(--shadow-sm);
        }

        .nav-btn:hover:not(:disabled) {
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .nav-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: #f1f5f9;
        }

        .mark-btn {
            background: #fffbeb;
            color: #d97706;
            border-color: #fde68a;
        }
        
        .mark-btn:hover:not(:disabled) {
            background: #f59e0b;
            color: white;
            border-color: #f59e0b;
        }

        .submit-btn-container {
            text-align: center;
            margin-top: 40px;
            padding-bottom: 60px;
        }

        /* Question Palette Sidebar */
        .palette-sidebar {
            width: 320px;
            background: white;
            padding: 30px 20px;
            border-left: 1px solid var(--color-border);
            overflow-y: auto;
            box-shadow: -5px 0 15px rgba(0,0,0,0.03);
            z-index: 90;
        }

        .palette-title {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--color-primary-light);
            font-weight: 700;
            color: var(--color-text);
            font-size: 1.2rem;
            display: flex;
            align-items: center;
        }

        .palette-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin-bottom: 30px;
        }

        .palette-item {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.2s;
            font-size: 0.9rem;
            box-shadow: var(--shadow-sm);
        }

        .palette-item.answered {
            background: var(--color-success);
            color: white;
            border: 2px solid var(--color-success);
        }

        .palette-item.marked {
            background: var(--color-warning);
            color: white;
            border: 2px solid var(--color-warning);
        }

        .palette-item.current {
            border: 3px solid var(--color-primary);
            transform: scale(1.1);
            box-shadow: 0 0 0 3px rgba(var(--color-primary-rgb), 0.2);
            z-index: 2;
        }

        .palette-item.not-visited {
            background: white;
            color: var(--color-text-muted);
            border: 1px solid var(--color-border);
        }

        .legend {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid var(--color-border);
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--color-text-muted);
        }

        .legend-color {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            box-shadow: var(--shadow-sm);
        }

        /* Submit Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-card {
            background: white;
            padding: 40px;
            border-radius: var(--radius-lg);
            max-width: 500px;
            width: 90%;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modal-title {
            font-weight: 800;
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--color-text);
        }

        .modal-desc {
            color: var(--color-text-muted);
            margin-bottom: 30px;
        }

        .modal-stats {
            background: var(--color-background);
            border-radius: var(--radius-md);
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
        }

        .stat-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .stat-row:last-child {
            margin-bottom: 0;
        }

        .modal-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .modal-btn {
            padding: 12px 30px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 700;
            transition: all var(--transition-fast);
        }

        .confirm-btn {
            background: var(--color-primary);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(var(--color-primary-rgb), 0.2);
        }
        
        .confirm-btn:hover {
            background: var(--color-primary-dark);
            transform: translateY(-2px);
        }

        .confirm-btn:disabled {
            opacity: 0.7;
            cursor: wait;
        }

        .cancel-btn {
            background: white;
            color: var(--color-text);
            border: 1px solid var(--color-border);
        }
        
        .cancel-btn:hover {
            background: #f8fafc;
        }

        @media (max-width: 992px) {
            .palette-sidebar {
                position: fixed;
                right: -320px;
                top: 74px;
                bottom: 0;
                transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: -10px 0 25px rgba(0,0,0,0.1);
            }

            .palette-sidebar.open {
                right: 0;
            }
        }
    </style>
</head>

<body>
    <div class="top-bar">
        <div class="exam-title d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3 d-none d-md-block">
                <i class="fas fa-laptop-code"></i>
            </div>
            {{ $exam->title }}
            <span class="attempt-badge ms-3">
                Attempt {{ $attemptNumber }} of {{ $exam->max_attempts }}
            </span>
        </div>
        <div class="timer" id="timer">00:00:00</div>
        <div class="question-palette-btn" onclick="togglePalette()">
            <i class="fas fa-th me-2"></i> Palette
        </div>
    </div>

    <div class="exam-container">
        <div class="question-area">
            <form id="examForm" method="POST" action="{{ route('user.exam.submit', $attempt) }}">
                @csrf
                <input type="hidden" name="answers_input" id="answersInput">

                @foreach ($questions as $index => $question)
                    <div class="question-card" id="question-{{ $index }}"
                        style="display: {{ $index == 0 ? 'block' : 'none' }}">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="question-number">Question {{ $index + 1 }} of {{ count($questions) }}</div>
                            <span class="badge bg-light text-muted border">ID: {{ $question->id }}</span>
                        </div>
                        
                        <div class="question-text">{{ $question->question_text }}</div>
                        
                        <div class="options">
                            @foreach ($question->options as $optIndex => $option)
                                <label class="option {{ isset($savedAnswers[$question->id]) && $savedAnswers[$question->id] == $option->id ? 'selected' : '' }}" id="label-{{ $question->id }}-{{ $option->id }}">
                                    <input type="radio" name="answers[{{ $question->id }}]"
                                        value="{{ $option->id }}" onchange="markAnswered({{ $index }}, {{ $question->id }}, {{ $option->id }})"
                                        {{ isset($savedAnswers[$question->id]) && $savedAnswers[$question->id] == $option->id ? 'checked' : '' }}>
                                    <span class="option-label">
                                        <span class="fw-bold me-2">{{ chr(65 + $optIndex) }}.</span>
                                        {{ $option->option_text }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        
                        <div class="nav-buttons">
                            <button type="button" class="nav-btn" onclick="previousQuestion()" id="prevBtn"
                                disabled><i class="fas fa-arrow-left me-2"></i> Previous</button>
                            <button type="button" class="nav-btn mark-btn"
                                onclick="markForReview({{ $index }})">
                                <i class="fas fa-bookmark me-2"></i> Mark for Review
                            </button>
                            <button type="button" class="nav-btn bg-primary text-white border-primary" onclick="nextQuestion()" id="nextBtn">
                                Next <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                @endforeach

                <div class="submit-btn-container">
                    <button type="button" class="btn btn-success btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg" onclick="showSubmitModal()">
                        <i class="fas fa-paper-plane me-2"></i> Finish & Submit Exam
                    </button>
                </div>
            </form>
        </div>

        <div class="palette-sidebar" id="palette">
            <div class="palette-title">
                <i class="fas fa-th-large text-primary me-2"></i> Question Navigator
            </div>
            <div class="palette-grid" id="paletteGrid">
                @foreach ($questions as $index => $question)
                    <div class="palette-item not-visited" id="palette-{{ $index }}"
                        onclick="goToQuestion({{ $index }})" title="Go to Question {{ $index + 1 }}">
                        {{ $index + 1 }}
                    </div>
                @endforeach
            </div>
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-color bg-success"></div>
                    <span>Answered</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color bg-warning"></div>
                    <span>Marked for Review</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color border border-3 border-primary bg-white"></div>
                    <span>Current Question</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color bg-white border border-secondary"></div>
                    <span>Not Visited</span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="submitModal">
        <div class="modal-card">
            <div class="mb-4">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fas fa-paper-plane fa-3x"></i>
                </div>
                <h3 class="modal-title">Ready to Submit?</h3>
                <p class="modal-desc">Review your progress before final submission. You cannot change your answers after submitting.</p>
            </div>
            
            <div class="modal-stats">
                <div class="stat-row text-success">
                    <span><i class="fas fa-check-circle me-2"></i>Answered:</span>
                    <span><span id="answeredCount">0</span> of {{ count($questions) }}</span>
                </div>
                <div class="stat-row text-warning">
                    <span><i class="fas fa-bookmark me-2"></i>Marked for Review:</span>
                    <span id="markedCount">0</span>
                </div>
                <div class="stat-row text-danger">
                    <span><i class="fas fa-exclamation-circle me-2"></i>Unanswered:</span>
                    <span id="notAnsweredCount">{{ count($questions) }}</span>
                </div>
            </div>
            
            <div class="modal-buttons">
                <button type="button" class="modal-btn cancel-btn" onclick="closeModal()">Return to Exam</button>
                <button type="button" class="modal-btn confirm-btn" onclick="submitExam()">Confirm Submission</button>
            </div>
        </div>
    </div>

    <script>
        let currentQuestion = 0;
        const totalQuestions = {{ count($questions) }};
        let answered = new Array(totalQuestions).fill(false);
        let markedForReview = new Array(totalQuestions).fill(false);
        const examEndsAt = Date.now() + ({{ $timeLeft }} * 1000);
        let examSubmitted = false;
        let timerInterval = null;

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

            const timeLeft = Math.max(0, Math.ceil((examEndsAt - Date.now()) / 1000));
            const hours = Math.floor(timeLeft / 3600);
            const minutes = Math.floor((timeLeft % 3600) / 60);
            const seconds = timeLeft % 60;
            
            const timerElement = document.getElementById('timer');
            timerElement.textContent =
                `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            // Warning style when less than 5 minutes remain
            if (timeLeft <= 300 && timeLeft > 0) {
                timerElement.classList.add('warning');
            }

            if (timeLeft <= 0) {
                submitExam(true);
            }
        }

        updateTimer();
        if (!examSubmitted) {
            timerInterval = setInterval(updateTimer, 1000);
        }

        // Browsers may restore this page from their back/forward cache.
        // Recalculate from the deadline immediately whenever it becomes active.
        window.addEventListener('pageshow', updateTimer);
        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) updateTimer();
        });

        // Navigation
        function goToQuestion(index) {
            // Fade out current
            const currentCard = document.getElementById(`question-${currentQuestion}`);
            currentCard.style.opacity = '0';
            
            setTimeout(() => {
                currentCard.style.display = 'none';
                
                // Show new
                currentQuestion = index;
                const newCard = document.getElementById(`question-${currentQuestion}`);
                newCard.style.display = 'block';
                
                // Trigger reflow
                void newCard.offsetWidth;
                
                newCard.style.opacity = '1';
                
                updatePaletteHighlight();
                updateNavButtons();
                
                // Scroll to top of question area on mobile
                if (window.innerWidth <= 992) {
                    document.querySelector('.question-area').scrollTop = 0;
                    // Auto-close palette on mobile when selecting a question
                    document.getElementById('palette').classList.remove('open');
                }
            }, 150);
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

        function markAnswered(questionIndex, questionId, optionId) {
            answered[questionIndex] = true;
            
            // Remove selected class from all options in this question
            const inputs = document.querySelectorAll(`input[name="answers[${questionId}]"]`);
            inputs.forEach(input => {
                const label = input.closest('.option');
                if (label) label.classList.remove('selected');
            });
            
            // Add selected class to the clicked option
            const selectedLabel = document.getElementById(`label-${questionId}-${optionId}`);
            if (selectedLabel) selectedLabel.classList.add('selected');
            
            updatePaletteItem(questionIndex);
            updateSubmitModalStats();
            autoSave();
        }

        function markForReview(questionIndex) {
            markedForReview[questionIndex] = !markedForReview[questionIndex];
            updatePaletteItem(questionIndex);
            autoSave();
            
            const btn = document.querySelector(`#question-${questionIndex} .mark-btn`);
            if (markedForReview[questionIndex]) {
                btn.innerHTML = '<i class="fas fa-bookmark me-2"></i> Marked for Review';
                btn.classList.add('active');
            } else {
                btn.innerHTML = '<i class="far fa-bookmark me-2"></i> Mark for Review';
                btn.classList.remove('active');
            }
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
            
            const btn = document.querySelector(`#question-${currentQuestion} .mark-btn`);
            if (markedForReview[currentQuestion]) {
                btn.innerHTML = '<i class="fas fa-bookmark me-2"></i> Marked for Review';
            } else {
                btn.innerHTML = '<i class="far fa-bookmark me-2"></i> Mark for Review';
            }
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

        function submitExam(timeExpired = false) {
            if (examSubmitted) return;
            examSubmitted = true;
            if (timerInterval) clearInterval(timerInterval);

            if (timeExpired) {
                const modal = document.getElementById('submitModal');
                modal.style.display = 'flex';
                modal.querySelector('.modal-title').textContent = 'Time is up!';
                modal.querySelector('.modal-desc').textContent = 'Your saved answers are being submitted automatically.';
                modal.querySelector('.modal-stats').style.display = 'none';
                modal.querySelector('.cancel-btn').style.display = 'none';
            }
            
            // Show loading state
            const confirmBtn = document.querySelector('.confirm-btn');
            if (confirmBtn) {
                confirmBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin me-2"></i> Submitting...';
                confirmBtn.disabled = true;
            }

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

        // Protect an active attempt from accidental refresh or navigation.
        window.addEventListener('beforeunload', function (event) {
            if (!examSubmitted) {
                event.preventDefault();
                event.returnValue = '';
            }
        });

        document.addEventListener('keydown', function (event) {
            const refreshShortcut = event.key === 'F5'
                || ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'r');

            if (refreshShortcut && !examSubmitted) {
                event.preventDefault();
            }
        });
        
        // Setup transition effects
        document.querySelectorAll('.question-card').forEach(card => {
            card.style.transition = 'opacity 0.15s ease-in-out';
        });
    </script>
</body>

</html>
