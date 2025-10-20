<?php
/**
 * Question Generator
 * Generates math questions for different operations and difficulty levels
 */

class QuestionGenerator {
    
    /**
     * Generate a multiplication question
     * @param int $min_a Minimum value for first number
     * @param int $max_a Maximum value for first number
     * @param int $min_b Minimum value for second number
     * @param int $max_b Maximum value for second number
     * @return array Question data with text, correct answer, and options
     */
    public static function generateMultiplication($min_a, $max_a, $min_b, $max_b, $difficulty = 'medium') {
        // Generate two random numbers within range
        $num1 = rand($min_a, $max_a);
        $num2 = rand($min_b, $max_b);
        
        // Calculate correct answer
        $correct = $num1 * $num2;
        
        // Create question text
        $question_text = "$num1 × $num2 = ?";
        
        // Generate wrong answers (pass difficulty level)
        $options = self::generateOptions($correct, $num1, $num2, 'multiplication', $difficulty);
        
        return [
            'question' => $question_text,
            'correct_answer' => $correct,
            'options' => $options,
            'num1' => $num1,
            'num2' => $num2
        ];
    }
    
    /**
     * Generate plausible wrong answers along with the correct answer
     * @param int $correct The correct answer
     * @param int $num1 First number in equation
     * @param int $num2 Second number in equation
     * @param string $operation Type of operation
     * @param string $difficulty Difficulty level (easy, medium, hard)
     * @return array Shuffled array of 4 options (1 correct, 3 wrong)
     */
    private static function generateOptions($correct, $num1, $num2, $operation = 'multiplication', $difficulty = 'medium') {
        $wrong_answers = [];
        
        // Use different strategies based on difficulty
        if ($difficulty === 'hard') {
            // HARD MODE: Very close numbers - much harder!
            switch($operation) {
                case 'multiplication':
                    // Generate answers that are very close to correct answer
                    $potential_wrongs = [
                        $correct - 1,    // Just one less
                        $correct + 1,    // Just one more
                        $correct - 2,    // Two less
                        $correct + 2,    // Two more
                        $correct - 3,    // Three less
                        $correct + 3,    // Three more
                        $correct - 4,    // Four less
                        $correct + 4,    // Four more
                    ];
                    
                    // Also add some answers from adjacent multiplication facts
                    if ($num2 > 1) {
                        $potential_wrongs[] = $num1 * ($num2 - 1);  // Previous multiple
                    }
                    if ($num2 < 12) {
                        $potential_wrongs[] = $num1 * ($num2 + 1);  // Next multiple
                    }
                    if ($num1 > 1) {
                        $potential_wrongs[] = ($num1 - 1) * $num2;  // Previous multiple
                    }
                    if ($num1 < 12) {
                        $potential_wrongs[] = ($num1 + 1) * $num2;  // Next multiple
                    }
                    break;
                default:
                    $potential_wrongs = [];
            }
            
            // Remove duplicates and the correct answer
            $potential_wrongs = array_unique($potential_wrongs);
            $potential_wrongs = array_filter($potential_wrongs, function($val) use ($correct) {
                return $val != $correct && $val > 0;
            });
            
            // If we don't have enough options, generate more close numbers
            while (count($potential_wrongs) < 3) {
                $offset = rand(1, 6);
                $random = rand(0, 1) ? $correct + $offset : $correct - $offset;
                
                if ($random > 0 && $random != $correct && !in_array($random, $potential_wrongs)) {
                    $potential_wrongs[] = $random;
                }
            }
        } else {
            // EASY & MEDIUM MODE: More spread out, easier to eliminate
            switch($operation) {
                case 'multiplication':
                    // Common mistakes for multiplication (easier)
                    $potential_wrongs = [
                        $correct + $num1,           // Off by one multiplicand
                        $correct - $num2,           // Off by one multiplicand
                        $correct + $num2,           // Close but not quite
                        $num1 + $num2,              // Addition instead of multiplication
                        ($num1 - 1) * $num2,        // Off by one on first number
                        $num1 * ($num2 - 1),        // Off by one on second number
                        ($num1 + 1) * $num2,        // Off by one on first number
                        $num1 * ($num2 + 1),        // Off by one on second number
                    ];
                    break;
                default:
                    $potential_wrongs = [];
            }
            
            // Remove duplicates and the correct answer
            $potential_wrongs = array_unique($potential_wrongs);
            $potential_wrongs = array_filter($potential_wrongs, function($val) use ($correct) {
                return $val != $correct && $val > 0;
            });
            
            // If we don't have enough options, generate random nearby numbers (more spread)
            while (count($potential_wrongs) < 3) {
                if ($correct < 10) {
                    $random = $correct + rand(-3, 3);
                } elseif ($correct < 50) {
                    $random = $correct + rand(-8, 8);
                } else {
                    $random = $correct + rand(-15, 15);
                }
                
                if ($random > 0 && $random != $correct && !in_array($random, $potential_wrongs)) {
                    $potential_wrongs[] = $random;
                }
            }
        }
        
        // Take 3 random wrong answers
        $potential_wrongs = array_values($potential_wrongs);
        shuffle($potential_wrongs);
        $wrong_answers = array_slice($potential_wrongs, 0, 3);
        
        // Combine with correct answer and shuffle
        $all_options = array_merge([$correct], $wrong_answers);
        shuffle($all_options);
        
        return $all_options;
    }
    
    /**
     * Generate multiple questions
     * @param string $operation Type of operation (multiplication, addition, etc.)
     * @param array $config Configuration for question generation
     * @param int $count Number of questions to generate
     * @return array Array of question data
     */
    public static function generateQuestions($operation, $config, $count = 10) {
        $questions = [];
        $used_pairs = []; // Track used number combinations
        $max_attempts = $count * 10; // Prevent infinite loops
        $attempts = 0;
        
        while (count($questions) < $count && $attempts < $max_attempts) {
            $attempts++;
            
            switch($operation) {
                case 'multiplication':
                    $difficulty = isset($config['difficulty']) ? $config['difficulty'] : 'medium';
                    $question = self::generateMultiplication(
                        $config['min_multiplier'],
                        $config['max_multiplier'],
                        $config['min_multiplicand'],
                        $config['max_multiplicand'],
                        $difficulty
                    );
                    
                    // Create a unique key for this question (handles commutative property)
                    // Both 3×4 and 4×3 are considered the same question
                    $num1 = $question['num1'];
                    $num2 = $question['num2'];
                    $pair_key = min($num1, $num2) . 'x' . max($num1, $num2);
                    
                    // Only add if this combination hasn't been used
                    if (!in_array($pair_key, $used_pairs)) {
                        $questions[] = $question;
                        $used_pairs[] = $pair_key;
                    }
                    break;
                    
                // Future operations can be added here
                default:
                    break;
            }
        }
        
        // If we couldn't generate enough unique questions (very small range),
        // allow some duplicates but shuffle to make them less obvious
        if (count($questions) < $count) {
            // Generate more questions without the duplicate check
            while (count($questions) < $count) {
                switch($operation) {
                    case 'multiplication':
                        $questions[] = self::generateMultiplication(
                            $config['min_multiplier'],
                            $config['max_multiplier'],
                            $config['min_multiplicand'],
                            $config['max_multiplicand']
                        );
                        break;
                    default:
                        break;
                }
            }
        }
        
        // Shuffle to randomize order
        shuffle($questions);
        
        return $questions;
    }
}
?>
