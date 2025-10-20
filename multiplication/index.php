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

// Check if starting new quiz or changing level
if (isset($_GET['level']) && $_GET['level'] != $_SESSION['quiz_level'] ?? null) {
    // Generate new questions for new level
    $questions = QuestionGenerator::generateQuestions('multiplication', $level_config, QUESTIONS_PER_QUIZ);
    $_SESSION['questions'] = $questions;
    $_SESSION['current_question'] = 0;
    $_SESSION['correct_count'] = 0;
    $_SESSION['wrong_answers'] = [];
    $_SESSION['quiz_active'] = true;
    $_SESSION['quiz_level'] = $current_level;
    $_SESSION['start_time'] = time();
} elseif (!isset($_SESSION['quiz_active']) || !$_SESSION['quiz_active']) {
    // First time visit - start with default level
    $questions = QuestionGenerator::generateQuestions('multiplication', $level_config, QUESTIONS_PER_QUIZ);
    $_SESSION['questions'] = $questions;
    $_SESSION['current_question'] = 0;
    $_SESSION['correct_count'] = 0;
    $_SESSION['wrong_answers'] = [];
    $_SESSION['quiz_active'] = true;
    $_SESSION['quiz_level'] = $current_level;
    $_SESSION['start_time'] = time();
}

// SEO Configuration
$level_name = ucfirst($current_level);
$page_title = "Multiplication Practice Quiz - {$level_name} Level | Smarty Pants Math";
$page_description = "Practice multiplication with our interactive {$level_name} level quiz! Get instant feedback, track your progress, and master times tables. Perfect for students from kindergarten to 6th grade.";
$current_page = 'multiplication';
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
                <h1 class="quiz-main-title">Multiplication Quiz</h1>
                
                <!-- Quiz Header with Timer and Progress -->
                <div class="quiz-header-info">
                    <div class="question-counter">
                        <span class="counter-label">Question</span>
                        <span class="counter-numbers">
                            <span id="currentQuestionNum">1</span> of <?php echo QUESTIONS_PER_QUIZ; ?>
                        </span>
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

                <!-- Multiplication Tips Section -->
                <section class="info-section tips-section">
                    <h2 class="section-heading">Multiplication Tips & Tricks</h2>
                    
                    <div class="tips-content">
                        <div class="tip-box">
                            <h3>🔢 Start with the Easy Ones</h3>
                            <p>Master multiplying by 1, 2, 5, and 10 first. These have simple patterns:</p>
                            <ul>
                                <li><strong>× 1</strong> = The number stays the same (7 × 1 = 7)</li>
                                <li><strong>× 2</strong> = Just double the number (6 × 2 = 12)</li>
                                <li><strong>× 5</strong> = Always ends in 0 or 5 (4 × 5 = 20)</li>
                                <li><strong>× 10</strong> = Add a zero to the end (8 × 10 = 80)</li>
                            </ul>
                        </div>

                        <div class="tip-box">
                            <h3>🎵 Use Skip Counting</h3>
                            <p>Practice counting by 3s, 4s, 6s, etc. This helps you memorize multiplication facts naturally:</p>
                            <ul>
                                <li><strong>Counting by 3s:</strong> 3, 6, 9, 12, 15, 18, 21, 24, 27, 30</li>
                                <li><strong>Counting by 4s:</strong> 4, 8, 12, 16, 20, 24, 28, 32, 36, 40</li>
                            </ul>
                        </div>

                        <div class="tip-box">
                            <h3>🧮 The Commutative Property</h3>
                            <p>Remember: 3 × 4 is the same as 4 × 3! This cuts your memorization in half. If you know 6 × 7 = 42, then you automatically know 7 × 6 = 42.</p>
                        </div>

                        <div class="tip-box">
                            <h3>✋ Use Your Fingers for 9s</h3>
                            <p>Here's a cool trick for the 9 times table:</p>
                            <ul>
                                <li>Hold both hands in front of you</li>
                                <li>For 9 × 4, put down your 4th finger</li>
                                <li>Count fingers: 3 before, 6 after = 36!</li>
                            </ul>
                        </div>

                        <div class="tip-box">
                            <h3>🎯 Practice Daily</h3>
                            <p>Spend just 5-10 minutes each day practicing. Consistency is more important than long study sessions. Use this quiz to make practice fun and track your progress!</p>
                        </div>

                        <div class="tip-box">
                            <h3>🏆 Build Speed Gradually</h3>
                            <p>Start with accuracy, not speed. Once you can answer correctly every time, work on getting faster. This quiz's auto-advance feature helps you naturally build speed!</p>
                        </div>
                    </div>
                </section>

                <!-- Difficulty Guide -->
                <section class="info-section">
                    <h2 class="section-heading">Which Difficulty Should I Choose?</h2>
                    <div class="difficulty-guide">
                        <div class="guide-card easy-guide">
                            <h3>⭐ Easy (1-5)</h3>
                            <p><strong>Perfect for:</strong> Students just learning multiplication, kindergarten through 2nd grade.</p>
                            <p><strong>You'll practice:</strong> Times tables 1 through 5</p>
                            <p><strong>Example questions:</strong> 2 × 3, 4 × 5, 3 × 1</p>
                        </div>
                        <div class="guide-card medium-guide">
                            <h3>🎯 Medium (1-10)</h3>
                            <p><strong>Perfect for:</strong> Students comfortable with basics, 3rd through 4th grade.</p>
                            <p><strong>You'll practice:</strong> All times tables through 10</p>
                            <p><strong>Example questions:</strong> 7 × 8, 6 × 9, 4 × 10</p>
                        </div>
                        <div class="guide-card hard-guide">
                            <h3>🏆 Hard (1-12)</h3>
                            <p><strong>Perfect for:</strong> Advanced students mastering all facts, 5th through 6th grade.</p>
                            <p><strong>You'll practice:</strong> Complete times tables including 11 and 12</p>
                            <p><strong>Example questions:</strong> 11 × 8, 12 × 7, 9 × 12</p>
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
        const BASE_URL = '/multiplication/';
        let currentLevel = '<?php echo $current_level; ?>';
    </script>
    
    <script src="/assets/js/quiz-all-in-one.js"></script>

<?php
// Include footer
include '../includes/footer.php';
?>

