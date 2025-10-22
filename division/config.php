<?php
/**
 * Division Quiz Configuration
 * Define settings for different difficulty levels
 */

// Quiz settings
define('QUESTIONS_PER_QUIZ', 10);
define('TIME_LIMIT', 300); // 5 minutes in seconds (optional, can be removed for no limit)

// Difficulty level configurations
$division_levels = [
    'easy' => [
        'name' => 'Easy',
        'description' => 'Division Tables 1-5',
        'difficulty' => 'easy',
        'min_divisor' => 1,
        'max_divisor' => 5,
        'min_quotient' => 1,
        'max_quotient' => 5,
        'icon' => '🌟',
        'color' => 'kindergarten' // CSS class
    ],
    'medium' => [
        'name' => 'Medium',
        'description' => 'Division Tables 1-10',
        'difficulty' => 'medium',
        'min_divisor' => 1,
        'max_divisor' => 10,
        'min_quotient' => 1,
        'max_quotient' => 10,
        'icon' => '🎯',
        'color' => 'third-grade' // CSS class
    ],
    'hard' => [
        'name' => 'Hard',
        'description' => 'Division Tables 1-12',
        'difficulty' => 'hard',
        'min_divisor' => 1,
        'max_divisor' => 12,
        'min_quotient' => 1,
        'max_quotient' => 12,
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
    global $division_levels;
    return isset($division_levels[$level]) ? $division_levels[$level] : null;
}

/**
 * Validate level parameter
 * @param string $level The difficulty level to validate
 * @return bool True if valid, false otherwise
 */
function is_valid_level($level) {
    global $division_levels;
    return isset($division_levels[$level]);
}
?>
