<?php
/**
 * Save Quiz Progress
 * Handles AJAX requests to save quiz progress to session
 */

session_start();

// Set header for JSON response
header('Content-Type: application/json');

// Check if action is set
if (!isset($_POST['action'])) {
    echo json_encode(['success' => false, 'error' => 'No action specified']);
    exit;
}

$action = $_POST['action'];

switch ($action) {
    case 'save_progress':
        // Save current progress
        if (isset($_POST['current_question'])) {
            $_SESSION['current_question'] = (int)$_POST['current_question'];
        }
        
        if (isset($_POST['correct_count'])) {
            $_SESSION['correct_count'] = (int)$_POST['correct_count'];
        }
        
        if (isset($_POST['wrong_answers'])) {
            $_SESSION['wrong_answers'] = json_decode($_POST['wrong_answers'], true);
        }
        
        echo json_encode(['success' => true, 'message' => 'Progress saved']);
        break;
        
    case 'save_final_results':
        // Save final results and end quiz
        if (isset($_POST['correct_count'])) {
            $_SESSION['correct_count'] = (int)$_POST['correct_count'];
        }
        
        if (isset($_POST['wrong_answers'])) {
            $_SESSION['wrong_answers'] = json_decode($_POST['wrong_answers'], true);
        }
        
        // Mark quiz as inactive
        $_SESSION['quiz_active'] = false;
        
        echo json_encode(['success' => true, 'message' => 'Final results saved']);
        break;
        
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
        break;
}
?>
