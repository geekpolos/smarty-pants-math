<?php
// Start session
session_start();

// Include configuration and helpers
require_once '../includes/question-generator.php';
require_once 'config.php';

// Get current level from URL or session
$current_level = isset($_GET['level']) ? strtolower(trim($_GET['level'])) : 
                (isset($_SESSION['quiz_level']) ? $_SESSION['quiz_level'] : 'easy');

// Validate level
if (!is_valid_level($current_level)) {
    $current_level = 'easy';
}

// Get level configuration
$level_config = get_level_config($current_level);

// Check if we need to generate new questions
$needs_new_questions = false;

// Case 1: Changing difficulty level
if (isset($_GET['level']) && $_GET['level'] != $_SESSION['quiz_level'] ?? null) {
    $needs_new_questions = true;
}
// Case 2: First time visit or quiz not active
elseif (!isset($_SESSION['quiz_active']) || !$_SESSION['quiz_active']) {
    $needs_new_questions = true;
}
// Case 3: Different operation (switching from multiplication to addition, etc.)
elseif (!isset($_SESSION['quiz_operation']) || $_SESSION['quiz_operation'] != 'addition') {
    $needs_new_questions = true;
}

// Generate new questions if needed
if ($needs_new_questions) {
    $questions = QuestionGenerator::generateQuestions('addition', $level_config, QUESTIONS_PER_QUIZ);
    $_SESSION['questions'] = $questions;
    $_SESSION['current_question'] = 0;
    $_SESSION['correct_count'] = 0;
    $_SESSION['wrong_answers'] = [];
    $_SESSION['quiz_active'] = true;
    $_SESSION['quiz_level'] = $current_level;
    $_SESSION['quiz_operation'] = 'addition'; // Track which operation this is
    $_SESSION['start_time'] = time();
}

// SEO Configuration
$level_name = ucfirst($current_level);
$page_title = "Addition Practice Quiz - {$level_name} Level | Smarty Pants Math";
$page_description = "Practice addition with our interactive {$level_name} level quiz! Get instant feedback, track your progress, and master addition facts. Perfect for students from kindergarten to 6th grade.";
$current_page = 'addition';
$extra_css = ['/assets/css/quiz.css'];

// Include header
include '../includes/header.php';
?>

    <!-- Single Page All-in-One Quiz -->
    <div class="quiz-page-container">
        <!-- Loading overlay for transitions -->
        <div class="loading-overlay" id="loadingOverlay" style="display: none;">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading quiz...</p>
        </div>

        <div class="quiz-all-in-one">
            <div class="quiz-main-container">
                
                <!-- Main H1 Title for SEO -->
                <h1 class="quiz-main-title">Addition Quiz</h1>
                
                <!-- Progress Bar -->
                <div class="progress-bar-container">
                    <div class="progress-bar" id="progressBar"></div>
                    <div class="progress-text" id="progressText">0%</div>
                </div>
                
                <!-- Quiz Header with Timer and Progress -->
                <div class="quiz-header-info">
                    <div class="question-counter">
                        <span class="counter-label">Question</span>
                        <span class="counter-numbers">
                            <span id="currentQuestionNum">1</span> of <?php echo QUESTIONS_PER_QUIZ; ?>
                        </span>
                    </div>
                    <div class="streak-counter" id="streakCounter" style="display: none;">
                        <span class="streak-icon">🔥</span>
                        <span class="streak-text"><span id="streakNumber">0</span> correct!</span>
                    </div>
                    <div class="quiz-timer">
                        <span class="timer-icon">⏱️</span>
                        <span id="timerDisplay">0:00</span>
                    </div>
                </div>

                <!-- Quiz Question Area -->
                <div class="quiz-question-card" id="quizCard">
                    <h2 class="question-display" id="questionText">Loading...</h2>
                    
                    <div class="answer-options" id="answerOptions">
                        <!-- Answer buttons populated by JavaScript -->
                    </div>
                </div>

                <!-- Difficulty Selector Buttons -->
                <div class="difficulty-buttons">
                    <button class="diff-btn easy-btn <?php echo $current_level == 'easy' ? 'active' : ''; ?>" 
                            onclick="changeDifficulty('easy')"
                            aria-label="Switch to Easy difficulty">Easy</button>
                    <button class="diff-btn medium-btn <?php echo $current_level == 'medium' ? 'active' : ''; ?>" 
                            onclick="changeDifficulty('medium')"
                            aria-label="Switch to Medium difficulty">Medium</button>
                    <button class="diff-btn hard-btn <?php echo $current_level == 'hard' ? 'active' : ''; ?>" 
                            onclick="changeDifficulty('hard')"
                            aria-label="Switch to Hard difficulty">Hard</button>
                </div>

                <!-- Grade Level Indicator -->
                <div class="grade-indicator">
                    <label for="gradeDisplay">Currently set to</label>
                    <select id="gradeDisplay" onchange="handleGradeChange(this.value)" aria-label="Select grade level">
                        <option value="easy" <?php echo $current_level == 'easy' ? 'selected' : ''; ?>>Kindergarten - 2nd grade</option>
                        <option value="medium" <?php echo $current_level == 'medium' ? 'selected' : ''; ?>>3rd - 4th grade</option>
                        <option value="hard" <?php echo $current_level == 'hard' ? 'selected' : ''; ?>>5th - 6th grade</option>
                    </select>
                </div>

            </div>
        </div>

        <!-- Content Section Below Quiz -->
        <div class="content-below-quiz">
            <div class="content-wrapper">
                
                <!-- How to Use Section -->
                <section class="info-section">
                    <h2 class="section-heading">How to Use This Quiz</h2>
                    <div class="info-grid">
                        <div class="info-card">
                            <div class="info-icon">🎯</div>
                            <h3>Choose Your Level</h3>
                            <p>Click Easy, Medium, or Hard to match your skill level. You can change difficulty anytime during the quiz!</p>
                        </div>
                        <div class="info-card">
                            <div class="info-icon">✨</div>
                            <h3>Answer Questions</h3>
                            <p>Click on any answer button. The quiz automatically advances to the next question—no "next" button needed!</p>
                        </div>
                        <div class="info-card">
                            <div class="info-icon">📊</div>
                            <h3>See Your Results</h3>
                            <p>After 10 questions, you'll see your score, time, and which questions you missed so you can learn from mistakes.</p>
                        </div>
                    </div>
                </section>

                <!-- Addition Tips Section -->
                <section class="info-section tips-section">
                    <h2 class="section-heading">Addition Tips & Tricks</h2>
                    
                    <div class="tips-content">
                        <div class="tip-box">
                            <h3>🔢 Start with Doubles</h3>
                            <p>Master adding a number to itself first. These are the easiest patterns:</p>
                            <ul>
                                <li><strong>1 + 1</strong> = 2</li>
                                <li><strong>2 + 2</strong> = 4</li>
                                <li><strong>5 + 5</strong> = 10</li>
                                <li><strong>10 + 10</strong> = 20</li>
                            </ul>
                        </div>

                        <div class="tip-box">
                            <h3>🎵 Count On Strategy</h3>
                            <p>Start with the bigger number and count up by the smaller number:</p>
                            <ul>
                                <li><strong>7 + 3:</strong> Start at 7, count up: 8, 9, 10!</li>
                                <li><strong>12 + 5:</strong> Start at 12, count up: 13, 14, 15, 16, 17!</li>
                            </ul>
                        </div>

                        <div class="tip-box">
                            <h3>🧮 Making Ten</h3>
                            <p>Break numbers to make 10 first, then add the rest. This makes larger numbers easier:</p>
                            <ul>
                                <li><strong>8 + 5:</strong> Think "8 + 2 = 10, then 10 + 3 = 13"</li>
                                <li><strong>7 + 6:</strong> Think "7 + 3 = 10, then 10 + 3 = 13"</li>
                            </ul>
                        </div>

                        <div class="tip-box">
                            <h3>✋ Use Your Fingers</h3>
                            <p>For smaller numbers, fingers are a great tool:</p>
                            <ul>
                                <li>Put up fingers for the first number</li>
                                <li>Add more fingers for the second number</li>
                                <li>Count all your fingers for the answer!</li>
                            </ul>
                        </div>

                        <div class="tip-box">
                            <h3>🎯 Near Doubles</h3>
                            <p>If you know your doubles, use them for numbers that are close:</p>
                            <ul>
                                <li><strong>6 + 7:</strong> Think "6 + 6 = 12, plus 1 more = 13"</li>
                                <li><strong>8 + 9:</strong> Think "8 + 8 = 16, plus 1 more = 17"</li>
                            </ul>
                        </div>

                        <div class="tip-box">
                            <h3>🏆 Practice Daily</h3>
                            <p>Spend just 5-10 minutes each day practicing. Consistency is more important than long study sessions. Use this quiz to make practice fun and track your progress!</p>
                        </div>
                    </div>
                </section>

                <!-- Difficulty Guide -->
                <section class="info-section">
                    <h2 class="section-heading">Which Difficulty Should I Choose?</h2>
                    <div class="difficulty-guide">
                        <div class="guide-card easy-guide">
                            <h3>⭐ Easy (1-10)</h3>
                            <p><strong>Perfect for:</strong> Students just learning addition, kindergarten through 2nd grade.</p>
                            <p><strong>You'll practice:</strong> Adding numbers from 1 to 10</p>
                            <p><strong>Example questions:</strong> 2 + 3, 4 + 5, 7 + 1</p>
                        </div>
                        <div class="guide-card medium-guide">
                            <h3>🎯 Medium (1-50)</h3>
                            <p><strong>Perfect for:</strong> Students comfortable with basics, 3rd through 4th grade.</p>
                            <p><strong>You'll practice:</strong> Adding numbers up to 50</p>
                            <p><strong>Example questions:</strong> 17 + 28, 36 + 19, 24 + 31</p>
                        </div>
                        <div class="guide-card hard-guide">
                            <h3>🏆 Hard (1-100)</h3>
                            <p><strong>Perfect for:</strong> Advanced students mastering larger numbers, 5th through 6th grade.</p>
                            <p><strong>You'll practice:</strong> Adding numbers up to 100</p>
                            <p><strong>Example questions:</strong> 67 + 84, 59 + 73, 88 + 96</p>
                        </div>
                    </div>
                </section>

            </div>
        </div>

        <!-- Results Modal (Better approach - smaller, dismissible) -->
        <div class="results-modal" id="resultsModal" style="display: none;">
            <div class="modal-overlay" onclick="closeResults()"></div>
            <div class="results-content">
                <button class="close-modal" onclick="closeResults()" aria-label="Close results">×</button>
                
                <h2 class="results-title">Quiz Complete! 🎉</h2>
                <div class="score-display">
                    <div class="score-number" id="finalScore">0</div>
                    <div class="score-label">out of <?php echo QUESTIONS_PER_QUIZ; ?> correct!</div>
                </div>
                <div class="time-display">
                    Total time: <span id="totalTime">0:00</span>
                </div>
                
                <div class="wrong-answers-section" id="wrongAnswersSection" style="display: none;">
                    <h3>Questions you missed:</h3>
                    <div id="wrongAnswersList"></div>
                </div>
                
                <div class="results-actions">
                    <button class="btn-continue" onclick="startNewQuiz()">Take Quiz Again</button>
                    <button class="btn-secondary" onclick="closeResults()">Keep Practicing</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pass data to JavaScript -->
    <script>
        const QUESTIONS_PER_QUIZ = <?php echo QUESTIONS_PER_QUIZ; ?>;
        const BASE_URL = '/addition/';
        let currentLevel = '<?php echo $current_level; ?>';
    </script>
    
    <script src="/assets/js/quiz-all-in-one.js?v=2"></script>

<?php
// Include footer
include '../includes/footer.php';
?>