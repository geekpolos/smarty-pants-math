<?php
/**
 * Get Quiz Data
 * Returns quiz questions stored in session as JSON
 */

session_start();

header('Content-Type: application/json');

// Check if quiz data exists in session
if (isset($_SESSION['questions']) && isset($_SESSION['quiz_active']) && $_SESSION['quiz_active']) {
    echo json_encode([
        'success' => true,
        'questions' => $_SESSION['questions'],
        'current_question' => $_SESSION['current_question'],
        'correct_count' => $_SESSION['correct_count']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => 'No quiz data available'
    ]);
}
?>
