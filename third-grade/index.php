<?php
// Page configuration
$page_title = 'Kindergarten Math - Fun Interactive Quizzes | Smarty Pants Math';
$page_description = 'Engaging kindergarten math quizzes covering counting to 20, number recognition, shapes, and patterns. Perfect for ages 4-6!';
$current_page = 'kindergarten';

// Include header
include '../includes/header.php';
?>

    <!-- Page Header -->
    <header class="header">
        <div class="container">
            <h1>🌈 Kindergarten Math</h1>
            <p>Fun and interactive math adventures for our youngest learners!</p>
        </div>
    </header>

    <div class="container">
        <!-- Main Content -->
        <section class="content-section">
            <div class="content-placeholder">
                <h2 style="color: #2c3e50; font-size: 2rem; margin-bottom: 20px; font-weight: 600;">Welcome to Kindergarten Math!</h2>
                <p style="margin-bottom: 16px; color: #495057; line-height: 1.7;">Our kindergarten math program is designed specifically for children ages 4-6, introducing fundamental mathematical concepts through play and exploration. Each activity builds confidence while developing essential number sense and problem-solving skills.</p>
            </div>
        </section>

        <!-- Topics Grid -->
        <section class="grades-section">
            <h2 class="section-title">What You'll Learn</h2>
            <div class="grades-grid">
                
                <div class="grade-card kindergarten">
                    <div class="grade-header">
                        <span class="grade-icon">🔢</span>
                        <h3 class="grade-title">Counting & Numbers</h3>
                        <p class="grade-subtitle">1-20</p>
                    </div>
                    <div class="grade-body">
                        <div class="grade-topics">
                            <strong>Skills covered:</strong>
                            Count objects, recognize numbers 1-20, write numbers, and understand number order
                        </div>
                        <a href="/kindergarten/counting/" class="grade-button">Start Counting</a>
                    </div>
                </div>

                <div class="grade-card kindergarten">
                    <div class="grade-header">
                        <span class="grade-icon">🔺</span>
                        <h3 class="grade-title">Shapes & Patterns</h3>
                        <p class="grade-subtitle">Basic geometry</p>
                    </div>
                    <div class="grade-body">
                        <div class="grade-topics">
                            <strong>Skills covered:</strong>
                            Identify circles, squares, triangles, rectangles, and create simple patterns
                        </div>
                        <a href="/kindergarten/shapes/" class="grade-button">Explore Shapes</a>
                    </div>
                </div>

                <div class="grade-card kindergarten">
                    <div class="grade-header">
                        <span class="grade-icon">⚖️</span>
                        <h3 class="grade-title">Comparing & Sorting</h3>
                        <p class="grade-subtitle">More & less</p>
                    </div>
                    <div class="grade-body">
                        <div class="grade-topics">
                            <strong>Skills covered:</strong>
                            Compare sizes, sort objects by attributes, and understand more, less, and equal
                        </div>
                        <a href="/kindergarten/comparing/" class="grade-button">Start Comparing</a>
                    </div>
                </div>

            </div>
        </section>

<?php
// Include footer
include '../includes/footer.php';
?>