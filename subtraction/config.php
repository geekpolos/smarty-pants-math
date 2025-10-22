<?php
/**
 * Subtraction Quiz Configuration
 * Define settings for different difficulty levels
 */

// Quiz settings
define('QUESTIONS_PER_QUIZ', 10);
define('TIME_LIMIT', 300); // 5 minutes in seconds (optional, can be removed for no limit)

// Difficulty level configurations
$subtraction_levels = [
    'easy' => [
        'name' => 'Easy',
        'description' => 'Numbers 1-10',
        'difficulty' => 'easy',
        'min_number_1' => 1,
        'max_number_1' => 10,
        'min_number_2' => 1,
        'max_number_2' => 10,
        'icon' => '🌟',
        'color' => 'kindergarten' // CSS class
    ],
    'medium' => [
        'name' => 'Medium',
        'description' => 'Numbers 1-50',
        'difficulty' => 'medium',
        'min_number_1' => 1,
        'max_number_1' => 50,
        'min_number_2' => 1,
        'max_number_2' => 50,
        'icon' => '🎯',
        'color' => 'third-grade' // CSS class
    ],
    'hard' => [
        'name' => 'Hard',
        'description' => 'Numbers 1-100',
        'difficulty' => 'hard',
        'min_number_1' => 1,
        'max_number_1' => 100,
        'min_number_2' => 1,
        'max_number_2' => 100,
        'icon' => '🏆',
        'color' => 'sixth-grade' // CSS class
    ]
];

/**
 * Get level configuration
 * @param string $level The difficulty level (easy, medium, hard)
 * @return array|null Level configuration or null if not found
 */
function get_level_config($level) {
    global $subtraction_levels;
    return isset($subtraction_levels[$level]) ? $subtraction_levels[$level] : null;
}

/**
 * Validate level parameter
 * @param string $level The difficulty level to validate
 * @return bool True if valid, false otherwise
 */
function is_valid_level($level) {
    global $subtraction_levels;
    return isset($subtraction_levels[$level]);
}
?>
