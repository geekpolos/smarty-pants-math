<?php
// Page configuration
$page_title = '1st Grade Math - Interactive Quizzes & Activities | Smarty Pants Math';
$page_description = 'Fun 1st grade math quizzes covering addition & subtraction to 20, place value, comparing numbers, and telling time. Perfect for ages 6-7!';
$current_page = 'first-grade';

// Include header
include '../includes/header.php';
?>

    <!-- Page Header -->
    <header class="header">
        <div class="container">
            <h1>🎯 1st Grade Math</h1>
            <p>Building strong math foundations with fun activities and quizzes!</p>
        </div>
    </header>

    <div class="container">
        <!-- Main Content -->
        <section class="content-section">
            <div class="content-placeholder">
                <h2 style="color: #2c3e50; font-size: 2rem; margin-bottom: 20px; font-weight: 600;">Welcome to 1st Grade Math!</h2>
                <p style="margin-bottom: 16px; color: #495057; line-height: 1.7;">Our 1st grade math program builds upon kindergarten skills, introducing addition and subtraction concepts, place value understanding, and time-telling skills. Perfect for children ages 6-7 who are ready to tackle more challenging mathematical concepts.</p>
            </div>
        </section>

        <!-- Topics Grid -->
        <section class="grades-section">
            <h2 class="section-title">What You'll Learn</h2>
            <div class="grades-grid">
                
                <div class="grade-card first-grade">
                    <div class="grade-header">
                        <span class="grade-icon">➕</span>
                        <h3 class="grade-title">Addition & Subtraction</h3>
                        <p class="grade-subtitle">Numbers to 20</p>
                    </div>
                    <div class="grade-body">
                        <div class="grade-topics">
                            <strong>Skills covered:</strong>
                            Add and subtract within 20, use counting strategies, and solve word problems
                        </div>
                        <a href="/first-grade/addition-subtraction/" class="grade-button">Start Adding</a>
                    </div>
                </div>

                <div class="grade-card first-grade">
                    <div class="grade-header">
                        <span class="grade-icon">📍</span>
                        <h3 class="grade-title">Place Value</h3>
                        <p class="grade-subtitle">Tens & ones</p>
                    </div>
                    <div class="grade-body">
                        <div class="grade-topics">
                            <strong>Skills covered:</strong>
                            Understand tens and ones, count by 10s, and compare two-digit numbers
                        </div>
                        <a href="/first-grade/place-value/" class="grade-button">Learn Place Value</a>
                    </div>
                </div>

                <div class="grade-card first-grade">
                    <div class="grade-header">
                        <span class="grade-icon">🕐</span>
                        <h3 class="grade-title">Time & Measurement</h3>
                        <p class="grade-subtitle">Clocks & length</p>
                    </div>
                    <div class="grade-body">
                        <div class="grade-topics">
                            <strong>Skills covered:</strong>
                            Tell time to the hour and half-hour, measure length, and compare measurements
                        </div>
                        <a href="/first-grade/time-measurement/" class="grade-button">Explore Time</a>
                    </div>
                </div>

            </div>
        </section>

<?php
// Include footer
include '../includes/footer.php';
?>