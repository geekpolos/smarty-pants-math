<?php
/**
 * Multiplication Quiz Configuration
 * Define settings for different difficulty levels
 */

// Quiz settings
define('QUESTIONS_PER_QUIZ', 10);
define('TIME_LIMIT', 300); // 5 minutes in seconds (optional, can be removed for no limit)

// Difficulty level configurations
$multiplication_levels = [
    'easy' => [
        'name' => 'Easy',
        'description' => 'Times Tables 1-5',
        'difficulty' => 'easy',
        'min_multiplier' => 1,
        'max_multiplier' => 5,
        'min_multiplicand' => 1,
        'max_multiplicand' => 5,
        'icon' => '🌟',
        'color' => 'kindergarten' // CSS class
    ],
    'medium' => [
        'name' => 'Medium',
        'description' => 'Times Tables 1-10',
        'difficulty' => 'medium',
        'min_multiplier' => 1,
        'max_multiplier' => 10,
        'min_multiplicand' => 1,
        'max_multiplicand' => 10,
        'icon' => '🎯',
        'color' => 'third-grade' // CSS class
    ],
    'hard' => [
        'name' => 'Hard',
        'description' => 'Times Tables 1-12',
        'difficulty' => 'hard',
        'min_multiplier' => 1,
        'max_multiplier' => 12,
        'min_multiplicand' => 1,
        'max_multiplicand' => 12,
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
    global $multiplication_levels;
    return isset($multiplication_levels[$level]) ? $multiplication_levels[$level] : null;
}

/**
 * Validate level parameter
 * @param string $level The difficulty level to validate
 * @return bool True if valid, false otherwise
 */
function is_valid_level($level) {
    global $multiplication_levels;
    return isset($multiplication_levels[$level]);
}
?>
