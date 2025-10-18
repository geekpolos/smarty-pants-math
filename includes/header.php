<?php
// Define page variables with defaults
$page_title = isset($page_title) ? $page_title : 'Smarty Pants Math - Fun K-6 Math Quizzes & Worksheets';
$page_description = isset($page_description) ? $page_description : 'Interactive math quizzes for kindergarten through 6th grade. Common Core aligned with instant feedback. Make math fun and engaging!';
$current_page = isset($current_page) ? $current_page : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <?php if (isset($extra_css)): ?>
        <?php foreach ($extra_css as $css_file): ?>
            <link rel="stylesheet" href="<?php echo htmlspecialchars($css_file); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="nav-container">
            <a href="/" class="logo">🧠 Smarty Pants Math</a>
            <ul class="nav-menu" id="navMenu">
                <li><a href="/" class="nav-link <?php echo $current_page === 'home' ? 'active' : ''; ?>">Home</a></li>
                <li class="grades-dropdown">
                    <a href="#" class="nav-link <?php echo in_array($current_page, ['kindergarten', 'first-grade', 'second-grade', 'third-grade', 'fourth-grade', 'fifth-grade', 'sixth-grade']) ? 'active' : ''; ?>">Grades ▼</a>
                    <div class="dropdown-content">
                        <a href="/kindergarten/" class="dropdown-link">Kindergarten</a>
                        <a href="/first-grade/" class="dropdown-link">1st Grade</a>
                        <a href="/second-grade/" class="dropdown-link">2nd Grade</a>
                        <a href="/third-grade/" class="dropdown-link">3rd Grade</a>
                        <a href="/fourth-grade/" class="dropdown-link">4th Grade</a>
                        <a href="/fifth-grade/" class="dropdown-link">5th Grade</a>
                        <a href="/sixth-grade/" class="dropdown-link">6th Grade</a>
                    </div>
                </li>
                <li class="grades-dropdown">
                    <a href="#" class="nav-link <?php echo in_array($current_page, ['addition', 'subtraction', 'multiplication', 'division']) ? 'active' : ''; ?>">Operations ▼</a>
                    <div class="dropdown-content">
                        <a href="/addition/" class="dropdown-link">Addition</a>
                        <a href="/subtraction/" class="dropdown-link">Subtraction</a>
                        <a href="/multiplication/" class="dropdown-link">Multiplication</a>
                        <a href="/division/" class="dropdown-link">Division</a>
                    </div>
                </li>
                <li><a href="/worksheets/" class="nav-link <?php echo $current_page === 'worksheets' ? 'active' : ''; ?>">Worksheets</a></li>
                <li><a href="/blog/" class="nav-link <?php echo $current_page === 'blog' ? 'active' : ''; ?>">Blog</a></li>
                <li><a href="/about/" class="nav-link <?php echo $current_page === 'about' ? 'active' : ''; ?>">About</a></li>
                <li><a href="/contact/" class="nav-link <?php echo $current_page === 'contact' ? 'active' : ''; ?>">Contact</a></li>
            </ul>
            <button class="mobile-menu-toggle" id="mobileToggle">☰</button>
        </div>
    </nav>