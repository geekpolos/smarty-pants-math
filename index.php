<?php
// Page configuration
$page_title = 'Smarty Pants Math - Fun K-6 Math Quizzes & Worksheets';
$page_description = 'Interactive math quizzes for kindergarten through 6th grade. Common Core aligned with instant feedback. Make math fun and engaging!';
$current_page = 'home';

// Include header
include 'includes/header.php';
?>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <h1>Smarty Pants Math</h1>
            <p>Making math fun and engaging for K-6 students with interactive quizzes and instant feedback!</p>
        </div>
    </header>

    <div class="container">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-image">
                <div class="hero-placeholder">📊 🧮 📚</div>
            </div>
            <div class="hero-content">
                <h2>Start Your Math Adventure!</h2>
                <p>Join thousands of students mastering math with our adaptive, Common Core-aligned quizzes designed to build confidence and skills.</p>
                <a href="#grades" class="cta-button">Choose Your Grade Level</a>
            </div>
        </section>

        <!-- Grades Section -->
        <section class="grades-section" id="grades">
            <h2 class="section-title">Choose Your Grade Level</h2>
            <div class="grades-grid">
                
                <div class="grade-card kindergarten">
                    <div class="grade-header">
                        <span class="grade-icon">🌈</span>
                        <h3 class="grade-title">Kindergarten</h3>
                        <p class="grade-subtitle">Ages 4-6</p>
                    </div>
                    <div class="grade-body">
                        <div class="grade-topics">
                            <strong>What you'll learn:</strong>
                            Counting to 20, number recognition, basic shapes, simple patterns, and comparing sizes
                        </div>
                        <a href="/kindergarten/" class="grade-button">Start Learning</a>
                    </div>
                </div>

                <div class="grade-card first-grade">
                    <div class="grade-header">
                        <span class="grade-icon">🎯</span>
                        <h3 class="grade-title">1st Grade</h3>
                        <p class="grade-subtitle">Ages 6-7</p>
                    </div>
                    <div class="grade-body">
                        <div class="grade-topics">
                            <strong>What you'll learn:</strong>
                            Addition & subtraction to 20, place value, comparing numbers, and telling time
                        </div>
                        <a href="/first-grade/" class="grade-button">Start Learning</a>
                    </div>
                </div>

                <div class="grade-card second-grade">
                    <div class="grade-header">
                        <span class="grade-icon">⭐</span>
                        <h3 class="grade-title">2nd Grade</h3>
                        <p class="grade-subtitle">Ages 7-8</p>
                    </div>
                    <div class="grade-body">
                        <div class="grade-topics">
                            <strong>What you'll learn:</strong>
                            Addition & subtraction to 100, skip counting, money, and measurement
                        </div>
                        <a href="/second-grade/" class="grade-button">Start Learning</a>
                    </div>
                </div>

                <div class="grade-card third-grade">
                    <div class="grade-header">
                        <span class="grade-icon">🎨</span>
                        <h3 class="grade-title">3rd Grade</h3>
                        <p class="grade-subtitle">Ages 8-9</p>
                    </div>
                    <div class="grade-body">
                        <div class="grade-topics">
                            <strong>What you'll learn:</strong>
                            Multiplication tables, division basics, fractions, and area & perimeter
                        </div>
                        <a href="/third-grade/" class="grade-button">Start Learning</a>
                    </div>
                </div>

                <div class="grade-card fourth-grade">
                    <div class="grade-header">
                        <span class="grade-icon">🏆</span>
                        <h3 class="grade-title">4th Grade</h3>
                        <p class="grade-subtitle">Ages 9-10</p>
                    </div>
                    <div class="grade-body">
                        <div class="grade-topics">
                            <strong>What you'll learn:</strong>
                            Multi-digit multiplication, long division, decimals, and angles
                        </div>
                        <a href="/fourth-grade/" class="grade-button">Start Learning</a>
                    </div>
                </div>

                <div class="grade-card fifth-grade">
                    <div class="grade-header">
                        <span class="grade-icon">🎪</span>
                        <h3 class="grade-title">5th Grade</h3>
                        <p class="grade-subtitle">Ages 10-11</p>
                    </div>
                    <div class="grade-body">
                        <div class="grade-topics">
                            <strong>What you'll learn:</strong>
                            Fraction operations, decimal operations, volume, and coordinate planes
                        </div>
                        <a href="/fifth-grade/" class="grade-button">Start Learning</a>
                    </div>
                </div>

                <div class="grade-card sixth-grade">
                    <div class="grade-header">
                        <span class="grade-icon">🎓</span>
                        <h3 class="grade-title">6th Grade</h3>
                        <p class="grade-subtitle">Ages 11-12</p>
                    </div>
                    <div class="grade-body">
                        <div class="grade-topics">
                            <strong>What you'll learn:</strong>
                            Ratios & proportions, percentages, integers, and basic algebra
                        </div>
                        <a href="/sixth-grade/" class="grade-button">Start Learning</a>
                    </div>
                </div>

            </div>
        </section>

        <!-- SEO Content Section -->
        <section class="content-section">
            <div class="content-placeholder">
                <h2 style="color: #2c3e50; font-size: 1.8rem; margin-bottom: 20px; font-weight: 600;">Interactive Math Quizzes for Every Grade Level</h2>
                <p style="margin-bottom: 16px; color: #495057; line-height: 1.7;">Smarty Pants Math provides comprehensive online math practice for students from kindergarten through 6th grade. Our interactive quizzes are carefully designed to align with Common Core standards, ensuring that your child develops strong mathematical foundations at every stage of their elementary education.</p>
                
                <p style="margin-bottom: 16px; color: #495057; line-height: 1.7;">Each math quiz adapts to your student's skill level, providing personalized learning experiences that build confidence and mastery. From basic counting and number recognition in kindergarten to advanced concepts like ratios and basic algebra in 6th grade, our platform covers all essential math topics with engaging, age-appropriate content.</p>
                
                <p style="margin-bottom: 16px; color: #495057; line-height: 1.7;">Parents and teachers love our instant feedback system, which helps students learn from mistakes immediately. Whether you're looking for additional math practice at home, supplemental classroom resources, or targeted skill reinforcement, Smarty Pants Math makes learning mathematics enjoyable and effective for young learners.</p>
            </div>
        </section>

<?php
// Include footer
include 'includes/footer.php';
?>