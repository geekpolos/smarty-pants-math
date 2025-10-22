<?php
/**
 * Reset Quiz Session
 * Use this file to clear your quiz session if you're seeing the wrong operation
 */

session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// Destroy the session
session_destroy();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            text-align: center;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #5b6ef5;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px;
        }
        .button:hover {
            background: #4a5dd4;
        }
    </style>
</head>
<body>
    <div class="success">
        <h1>✅ Session Reset Complete!</h1>
        <p>Your quiz session has been cleared.</p>
    </div>
    
    <h2>Try Again:</h2>
    <a href="/addition/" class="button">Go to Addition Quiz</a>
    <a href="/multiplication/" class="button">Go to Multiplication Quiz</a>
    
    <hr style="margin: 40px 0;">
    
    <p><small>You can delete this file after testing.</small></p>
</body>
</html>
