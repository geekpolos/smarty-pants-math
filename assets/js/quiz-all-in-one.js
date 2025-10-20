/**
 * All-in-One Quiz Handler
 * Quiz with difficulty buttons always visible
 */

// Global variables
let quizData = null;
let currentQuestionIndex = 0;
let correctCount = 0;
let wrongAnswers = [];
let selectedAnswer = null;
let startTime = null;
let isQuizActive = false;
let timerInterval = null;

/**
 * Initialize quiz on page load
 */
document.addEventListener('DOMContentLoaded', function() {
    loadQuizData();
});

/**
 * Load quiz data from session
 */
function loadQuizData() {
    fetch(`${BASE_URL}get-quiz-data.php`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.questions) {
                quizData = data.questions;
                currentQuestionIndex = 0;
                correctCount = 0;
                wrongAnswers = [];
                startTime = Math.floor(Date.now() / 1000);
                isQuizActive = true;
                
                // Start timer
                startTimer();
                
                // Display first question
                displayQuestion();
            } else {
                console.error('No quiz data available');
            }
        })
        .catch(error => {
            console.error('Error loading quiz:', error);
        });
}

/**
 * Start the quiz timer
 */
function startTimer() {
    const timerDisplay = document.getElementById('timerDisplay');
    if (!timerDisplay) return;
    
    // Update timer every second
    timerInterval = setInterval(() => {
        const currentTime = Math.floor(Date.now() / 1000);
        const elapsedSeconds = currentTime - startTime;
        const minutes = Math.floor(elapsedSeconds / 60);
        const seconds = elapsedSeconds % 60;
        timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }, 1000);
}

/**
 * Stop the timer
 */
function stopTimer() {
    if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
    }
}

/**
 * Update question counter display
 */
function updateQuestionCounter() {
    const counterElement = document.getElementById('currentQuestionNum');
    if (counterElement) {
        counterElement.textContent = currentQuestionIndex + 1;
    }
}

/**
 * Display current question
 */
function displayQuestion() {
    if (!quizData || currentQuestionIndex >= quizData.length) {
        showResults();
        return;
    }

    const question = quizData[currentQuestionIndex];
    
    // Update question counter
    updateQuestionCounter();
    
    // Update question text
    const questionText = document.getElementById('questionText');
    if (questionText) {
        questionText.textContent = question.question;
    }
    
    // Display answer options
    displayAnswerOptions(question.options, question.correct_answer);
    
    // Reset selected answer
    selectedAnswer = null;
}

/**
 * Display answer option buttons
 * @param {Array} options - Array of answer options
 * @param {number} correctAnswer - The correct answer
 */
function displayAnswerOptions(options, correctAnswer) {
    const answerOptions = document.getElementById('answerOptions');
    if (!answerOptions) return;
    
    // Clear existing options
    answerOptions.innerHTML = '';
    
    // Create button for each option
    options.forEach(option => {
        const button = document.createElement('button');
        button.className = 'answer-btn';
        button.textContent = option;
        button.onclick = () => selectAnswer(option, correctAnswer);
        answerOptions.appendChild(button);
    });
}

/**
 * Handle answer selection
 * @param {number} answer - Selected answer
 * @param {number} correctAnswer - The correct answer
 */
function selectAnswer(answer, correctAnswer) {
    if (!isQuizActive) return;
    
    // Prevent multiple clicks - disable all buttons immediately
    const buttons = document.querySelectorAll('.answer-btn');
    buttons.forEach(btn => {
        btn.disabled = true;
        btn.style.cursor = 'not-allowed';
        btn.style.opacity = '0.6';
    });
    
    selectedAnswer = answer;
    const isCorrect = answer === correctAnswer;
    
    // Update buttons to show selection
    buttons.forEach(btn => {
        btn.classList.remove('selected');
        if (parseInt(btn.textContent) === answer) {
            btn.classList.add('selected');
            btn.style.opacity = '1'; // Keep selected button fully visible
        }
    });
    
    // Record answer
    if (isCorrect) {
        correctCount++;
    } else {
        const currentQuestion = quizData[currentQuestionIndex];
        wrongAnswers.push({
            question: currentQuestion.question,
            yourAnswer: answer,
            correctAnswer: correctAnswer
        });
    }
    
    // Auto-advance to next question after short delay
    setTimeout(() => {
        currentQuestionIndex++;
        saveProgress();
        
        if (currentQuestionIndex < quizData.length) {
            displayQuestion();
        } else {
            showResults();
        }
    }, 600);
}

/**
 * Save progress to session
 */
function saveProgress() {
    const formData = new FormData();
    formData.append('action', 'save_progress');
    formData.append('current_question', currentQuestionIndex);
    formData.append('correct_count', correctCount);
    formData.append('wrong_answers', JSON.stringify(wrongAnswers));
    
    fetch(`${BASE_URL}save-progress.php`, {
        method: 'POST',
        body: formData
    }).catch(error => {
        console.error('Error saving progress:', error);
    });
}

/**
 * Show quiz results in modal
 */
function showResults() {
    isQuizActive = false;
    
    // Stop timer
    stopTimer();
    
    // Calculate total time
    const currentTime = Math.floor(Date.now() / 1000);
    const totalSeconds = currentTime - startTime;
    const minutes = Math.floor(totalSeconds / 60);
    const seconds = totalSeconds % 60;
    
    // Update results display
    const finalScore = document.getElementById('finalScore');
    if (finalScore) {
        finalScore.textContent = correctCount;
    }
    
    const totalTime = document.getElementById('totalTime');
    if (totalTime) {
        totalTime.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }
    
    // Display wrong answers if any
    if (wrongAnswers.length > 0) {
        displayWrongAnswers();
    }
    
    // Show modal
    const modal = document.getElementById('resultsModal');
    if (modal) {
        modal.style.display = 'flex';
    }
    
    // Save final results
    saveFinalResults();
}

/**
 * Display wrong answers in results
 */
function displayWrongAnswers() {
    const wrongAnswersSection = document.getElementById('wrongAnswersSection');
    const wrongAnswersList = document.getElementById('wrongAnswersList');
    
    if (!wrongAnswersSection || !wrongAnswersList) return;
    
    wrongAnswersSection.style.display = 'block';
    wrongAnswersList.innerHTML = '';
    
    wrongAnswers.forEach(wrong => {
        const div = document.createElement('div');
        div.innerHTML = `<strong>${wrong.question}</strong><br>Your answer: ${wrong.yourAnswer} | Correct: ${wrong.correctAnswer}`;
        wrongAnswersList.appendChild(div);
    });
}

/**
 * Save final results to session
 */
function saveFinalResults() {
    const formData = new FormData();
    formData.append('action', 'save_final_results');
    formData.append('correct_count', correctCount);
    formData.append('total_questions', QUESTIONS_PER_QUIZ);
    formData.append('wrong_answers', JSON.stringify(wrongAnswers));
    
    fetch(`${BASE_URL}save-progress.php`, {
        method: 'POST',
        body: formData
    }).catch(error => {
        console.error('Error saving results:', error);
    });
}

/**
 * Change difficulty level with loading transition
 * @param {string} level - New difficulty level
 */
function changeDifficulty(level) {
    if (level === currentLevel) return;
    
    // Show loading overlay
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'flex';
    }
    
    // Stop current timer
    stopTimer();
    
    // Small delay for transition effect, then redirect
    setTimeout(() => {
        window.location.href = `${BASE_URL}?level=${level}`;
    }, 300);
}

/**
 * Handle grade dropdown change
 * @param {string} value - Selected grade level
 */
function handleGradeChange(value) {
    if (value === currentLevel) return;
    changeDifficulty(value);
}

/**
 * Start new quiz (after completing one)
 */
function startNewQuiz() {
    // Show loading overlay
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'flex';
    }
    
    setTimeout(() => {
        window.location.href = `${BASE_URL}?level=${currentLevel}`;
    }, 300);
}

/**
 * Close results modal and continue practicing
 */
/**
 * Close results modal and continue practicing
 * Provides instant restart without loading animation
 */
function closeResults() {
    const modal = document.getElementById('resultsModal');
    if (modal) {
        modal.style.display = 'none';
    }
    // Instant reload for faster "keep practicing" experience
    window.location.href = `${BASE_URL}?level=${currentLevel}`;
}



/**
 * Display answer option buttons
 * @param {Array} options - Array of answer options
 * @param {number} correctAnswer - The correct answer
 */
function displayAnswerOptions(options, correctAnswer) {
    const answerOptions = document.getElementById('answerOptions');
    if (!answerOptions) return;
    
    // Clear existing options
    answerOptions.innerHTML = '';
    
    // Create button for each option
    options.forEach(option => {
        const button = document.createElement('button');
        button.className = 'answer-btn';
        button.textContent = option;
        button.onclick = () => selectAnswer(option, correctAnswer);
        answerOptions.appendChild(button);
    });
}

/**
 * Handle answer selection
 * @param {number} answer - Selected answer
 * @param {number} correctAnswer - The correct answer
 */
function selectAnswer(answer, correctAnswer) {
    if (!isQuizActive) return;
    
    // Prevent multiple clicks - disable all buttons immediately
    const buttons = document.querySelectorAll('.answer-btn');
    buttons.forEach(btn => {
        btn.disabled = true;
        btn.style.cursor = 'not-allowed';
        btn.style.opacity = '0.6';
    });
    
    selectedAnswer = answer;
    const isCorrect = answer === correctAnswer;
    
    // Update buttons to show selection
    buttons.forEach(btn => {
        btn.classList.remove('selected');
        if (parseInt(btn.textContent) === answer) {
            btn.classList.add('selected');
            btn.style.opacity = '1'; // Keep selected button fully visible
        }
    });
    
    // Record answer
    if (isCorrect) {
        correctCount++;
    } else {
        const currentQuestion = quizData[currentQuestionIndex];
        wrongAnswers.push({
            question: currentQuestion.question,
            yourAnswer: answer,
            correctAnswer: correctAnswer
        });
    }
    
    // Auto-advance to next question after short delay
    setTimeout(() => {
        currentQuestionIndex++;
        saveProgress();
        
        if (currentQuestionIndex < quizData.length) {
            displayQuestion();
        } else {
            showResults();
        }
    }, 600);
}

/**
 * Save progress to session
 */
function saveProgress() {
    const formData = new FormData();
    formData.append('action', 'save_progress');
    formData.append('current_question', currentQuestionIndex);
    formData.append('correct_count', correctCount);
    formData.append('wrong_answers', JSON.stringify(wrongAnswers));
    
    fetch(`${BASE_URL}save-progress.php`, {
        method: 'POST',
        body: formData
    }).catch(error => {
        console.error('Error saving progress:', error);
    });
}

/**
 * Show quiz results in modal
 */
function showResults() {
    isQuizActive = false;
    
    // Calculate total time
    const currentTime = Math.floor(Date.now() / 1000);
    const totalSeconds = currentTime - startTime;
    const minutes = Math.floor(totalSeconds / 60);
    const seconds = totalSeconds % 60;
    
    // Update results display
    const finalScore = document.getElementById('finalScore');
    if (finalScore) {
        finalScore.textContent = correctCount;
    }
    
    const totalTime = document.getElementById('totalTime');
    if (totalTime) {
        totalTime.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }
    
    // Display wrong answers if any
    if (wrongAnswers.length > 0) {
        displayWrongAnswers();
    }
    
    // Show modal
    const modal = document.getElementById('resultsModal');
    if (modal) {
        modal.style.display = 'flex';
    }
    
    // Save final results
    saveFinalResults();
}

/**
 * Display wrong answers in results
 */
function displayWrongAnswers() {
    const wrongAnswersSection = document.getElementById('wrongAnswersSection');
    const wrongAnswersList = document.getElementById('wrongAnswersList');
    
    if (!wrongAnswersSection || !wrongAnswersList) return;
    
    wrongAnswersSection.style.display = 'block';
    wrongAnswersList.innerHTML = '';
    
    wrongAnswers.forEach(wrong => {
        const div = document.createElement('div');
        div.innerHTML = `<strong>${wrong.question}</strong><br>Your answer: ${wrong.yourAnswer} | Correct: ${wrong.correctAnswer}`;
        wrongAnswersList.appendChild(div);
    });
}

/**
 * Save final results to session
 */
function saveFinalResults() {
    const formData = new FormData();
    formData.append('action', 'save_final_results');
    formData.append('correct_count', correctCount);
    formData.append('total_questions', QUESTIONS_PER_QUIZ);
    formData.append('wrong_answers', JSON.stringify(wrongAnswers));
    
    fetch(`${BASE_URL}save-progress.php`, {
        method: 'POST',
        body: formData
    }).catch(error => {
        console.error('Error saving results:', error);
    });
}

/**
 * Change difficulty level
 * @param {string} level - New difficulty level
 */
function changeDifficulty(level) {
    if (level === currentLevel) return;
    
    // Redirect to new level
    window.location.href = `${BASE_URL}?level=${level}`;
}

/**
 * Handle grade dropdown change
 * @param {string} value - Selected grade level
 */
function handleGradeChange(value) {
    if (value === currentLevel) return;
    changeDifficulty(value);
}

/**
 * Start new quiz (after completing one)
 */
function startNewQuiz() {
    window.location.href = `${BASE_URL}?level=${currentLevel}`;
}

/**
 * Close results modal and continue practicing
 */
