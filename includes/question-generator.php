<?php
/**
 * Question Generator
 * Generates math questions for different operations and difficulty levels
 */

class QuestionGenerator {
    
    /**
     * Generate a division question (no remainders)
     * @param int $min_divisor Minimum divisor
     * @param int $max_divisor Maximum divisor
     * @param int $min_quotient Minimum quotient
     * @param int $max_quotient Maximum quotient
     * @param string $difficulty Difficulty level
     * @return array Question data with text, correct answer, and options
     */
    public static function generateDivision($min_divisor, $max_divisor, $min_quotient, $max_quotient, $difficulty = 'medium') {
        // Generate divisor and quotient, then calculate dividend
        $divisor = rand($min_divisor, $max_divisor);
        $quotient = rand($min_quotient, $max_quotient);
        $dividend = $divisor * $quotient;  // Ensures no remainder
        
        // Create question text
        $question_text = "$dividend ÷ $divisor = ?";
        
        // Generate wrong answers (pass difficulty level)
        // Note: num1 = dividend, num2 = divisor, correct = quotient
        $options = self::generateOptions($quotient, $dividend, $divisor, 'division', $difficulty);
        
        return [
            'question' => $question_text,
            'correct_answer' => $quotient,
            'options' => $options,
            'num1' => $dividend,
            'num2' => $divisor
        ];
    }
    
    /**
     * Generate a subtraction question
     * @param int $min_a Minimum value for first number
     * @param int $max_a Maximum value for first number
     * @param int $min_b Minimum value for second number
     * @param int $max_b Maximum value for second number
     * @param string $difficulty Difficulty level
     * @return array Question data with text, correct answer, and options
     */
    public static function generateSubtraction($min_a, $max_a, $min_b, $max_b, $difficulty = 'medium') {
        // Generate two random numbers within range
        // Ensure num1 >= num2 for positive results
        $num1 = rand($min_a, $max_a);
        $num2 = rand($min_b, min($max_b, $num1)); // num2 can't be larger than num1
        
        // Calculate correct answer
        $correct = $num1 - $num2;
        
        // Create question text
        $question_text = "$num1 - $num2 = ?";
        
        // Generate wrong answers (pass difficulty level)
        $options = self::generateOptions($correct, $num1, $num2, 'subtraction', $difficulty);
        
        return [
            'question' => $question_text,
            'correct_answer' => $correct,
            'options' => $options,
            'num1' => $num1,
            'num2' => $num2
        ];
    }
    
    /**
     * Generate an addition question
     * @param int $min_a Minimum value for first number
     * @param int $max_a Maximum value for first number
     * @param int $min_b Minimum value for second number
     * @param int $max_b Maximum value for second number
     * @param string $difficulty Difficulty level
     * @return array Question data with text, correct answer, and options
     */
    public static function generateAddition($min_a, $max_a, $min_b, $max_b, $difficulty = 'medium') {
        // Generate two random numbers within range
        $num1 = rand($min_a, $max_a);
        $num2 = rand($min_b, $max_b);
        
        // Calculate correct answer
        $correct = $num1 + $num2;
        
        // Create question text
        $question_text = "$num1 + $num2 = ?";
        
        // Generate wrong answers (pass difficulty level)
        $options = self::generateOptions($correct, $num1, $num2, 'addition', $difficulty);
        
        return [
            'question' => $question_text,
            'correct_answer' => $correct,
            'options' => $options,
            'num1' => $num1,
            'num2' => $num2
        ];
    }
    
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
     * Generate hard mode options - very close to correct answer
     * @param int $correct The correct answer
     * @param int $num1 First number in equation
     * @param int $num2 Second number in equation
     * @param string $operation Type of operation
     * @return array Array of potential wrong answers
     */
    private static function generateHardOptions($correct, $num1, $num2, $operation) {
        $potential_wrongs = [];
        
        switch($operation) {
            case 'multiplication':
                // Very close numbers (±1 to ±4)
                $potential_wrongs = [
                    $correct - 1, $correct + 1,
                    $correct - 2, $correct + 2,
                    $correct - 3, $correct + 3,
                    $correct - 4, $correct + 4,
                ];
                
                // Adjacent multiplication facts
                if ($num2 > 1) {
                    $potential_wrongs[] = $num1 * ($num2 - 1);
                }
                if ($num2 < 12) {
                    $potential_wrongs[] = $num1 * ($num2 + 1);
                }
                if ($num1 > 1) {
                    $potential_wrongs[] = ($num1 - 1) * $num2;
                }
                if ($num1 < 12) {
                    $potential_wrongs[] = ($num1 + 1) * $num2;
                }
                break;
                
            case 'addition':
                // Close numbers for addition
                $potential_wrongs = [
                    $correct - 1, $correct + 1,
                    $correct - 2, $correct + 2,
                    $correct - 3, $correct + 3,
                    $correct - 4, $correct + 4,
                ];
                
                // Off-by-one errors
                $potential_wrongs[] = ($num1 + 1) + $num2;
                $potential_wrongs[] = $num1 + ($num2 + 1);
                $potential_wrongs[] = ($num1 - 1) + $num2;
                $potential_wrongs[] = $num1 + ($num2 - 1);
                break;
                
            case 'subtraction':
                // Close numbers for subtraction
                $potential_wrongs = [
                    $correct - 1, $correct + 1,
                    $correct - 2, $correct + 2,
                    $correct - 3, $correct + 3,
                    $correct - 4, $correct + 4,
                ];
                
                // Off-by-one errors
                $potential_wrongs[] = ($num1 + 1) - $num2;
                $potential_wrongs[] = $num1 - ($num2 + 1);
                $potential_wrongs[] = ($num1 - 1) - $num2;
                $potential_wrongs[] = $num1 - ($num2 - 1);
                break;
                
            case 'division':
                // Close quotients for division
                $potential_wrongs = [
                    $correct - 1, $correct + 1,
                    $correct - 2, $correct + 2,
                    $correct - 3, $correct + 3,
                ];
                
                // Related division facts
                if ($num2 > 2) {
                    $potential_wrongs[] = ($num1 * $num2) / ($num2 - 1);
                }
                if ($num2 < 12) {
                    $potential_wrongs[] = ($num1 * $num2) / ($num2 + 1);
                }
                break;
        }
        
        return $potential_wrongs;
    }
    
    /**
     * Generate easy/medium mode options - more spread out
     * @param int $correct The correct answer
     * @param int $num1 First number in equation
     * @param int $num2 Second number in equation
     * @param string $operation Type of operation
     * @return array Array of potential wrong answers
     */
    private static function generateEasyOptions($correct, $num1, $num2, $operation) {
        $potential_wrongs = [];
        
        switch($operation) {
            case 'multiplication':
                // Common mistakes - more spread out
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
                
            case 'addition':
                // Common addition mistakes
                $potential_wrongs = [
                    $correct - 5, $correct + 5,
                    $correct - 10, $correct + 10,
                    $num1 * $num2,              // Multiplication instead
                    $num1 - $num2,              // Subtraction instead
                    ($num1 + 5) + $num2,        // Off by 5
                    $num1 + ($num2 + 5),        // Off by 5
                    ($num1 + 1) + ($num2 + 1),  // Both off by 1
                ];
                break;
                
            case 'subtraction':
                // Common subtraction mistakes
                $potential_wrongs = [
                    $correct - 5, $correct + 5,
                    $correct - 10, $correct + 10,
                    $num1 + $num2,              // Addition instead
                    abs($num2 - $num1),         // Reversed subtraction
                    $num1 * $num2,              // Multiplication instead
                    ($num1 + 5) - $num2,        // Off by 5
                    $num1 - ($num2 + 5),        // Off by 5
                ];
                break;
                
            case 'division':
                // Common division mistakes
                $potential_wrongs = [
                    $correct - 2, $correct + 2,
                    $correct - 3, $correct + 3,
                    $correct - 5, $correct + 5,
                    $num1 - $num2,              // Subtraction instead
                    $num1 * $num2,              // Multiplication instead (dividend * divisor)
                    ($correct + 1),             // Off by one
                    ($correct - 1),             // Off by one
                ];
                break;
        }
        
        return $potential_wrongs;
    }
    
    /**
     * Fill in missing options with random nearby numbers
     * @param int $correct The correct answer
     * @param array $potential_wrongs Current wrong answers
     * @param string $difficulty Difficulty level
     * @return array Complete array of wrong answers
     */
    private static function fillMissingOptions($correct, $potential_wrongs, $difficulty) {
        while (count($potential_wrongs) < 3) {
            if ($difficulty === 'hard') {
                // Keep generating numbers very close to the answer
                $offset = rand(1, 6);
                $random = rand(0, 1) ? $correct + $offset : $correct - $offset;
            } else {
                // More spread out for easy/medium
                if ($correct < 10) {
                    $random = $correct + rand(-3, 3);
                } elseif ($correct < 50) {
                    $random = $correct + rand(-8, 8);
                } else {
                    $random = $correct + rand(-15, 15);
                }
            }
            
            if ($random > 0 && $random != $correct && !in_array($random, $potential_wrongs)) {
                $potential_wrongs[] = $random;
            }
        }
        
        return $potential_wrongs;
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
        // Generate wrong answers based on difficulty
        if ($difficulty === 'hard') {
            $potential_wrongs = self::generateHardOptions($correct, $num1, $num2, $operation);
        } else {
            $potential_wrongs = self::generateEasyOptions($correct, $num1, $num2, $operation);
        }
        
        // Remove duplicates and the correct answer
        $potential_wrongs = array_unique($potential_wrongs);
        $potential_wrongs = array_filter($potential_wrongs, function($val) use ($correct) {
            return $val != $correct && $val > 0;
        });
        
        // Fill in any missing options with random numbers
        $potential_wrongs = self::fillMissingOptions($correct, $potential_wrongs, $difficulty);
        
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
                case 'division':
                    $difficulty = isset($config['difficulty']) ? $config['difficulty'] : 'medium';
                    $question = self::generateDivision(
                        $config['min_divisor'],
                        $config['max_divisor'],
                        $config['min_quotient'],
                        $config['max_quotient'],
                        $difficulty
                    );
                    
                    // Create a unique key for this question
                    $dividend = $question['num1'];
                    $divisor = $question['num2'];
                    $pair_key = $dividend . '÷' . $divisor;
                    
                    if (!in_array($pair_key, $used_pairs)) {
                        $questions[] = $question;
                        $used_pairs[] = $pair_key;
                    }
                    break;
                    
                case 'subtraction':
                    $difficulty = isset($config['difficulty']) ? $config['difficulty'] : 'medium';
                    $question = self::generateSubtraction(
                        $config['min_number_1'],
                        $config['max_number_1'],
                        $config['min_number_2'],
                        $config['max_number_2'],
                        $difficulty
                    );
                    
                    // Create a unique key for this question
                    $num1 = $question['num1'];
                    $num2 = $question['num2'];
                    $pair_key = $num1 . '-' . $num2;  // Order matters for subtraction
                    
                    if (!in_array($pair_key, $used_pairs)) {
                        $questions[] = $question;
                        $used_pairs[] = $pair_key;
                    }
                    break;
                    
                case 'addition':
                    $difficulty = isset($config['difficulty']) ? $config['difficulty'] : 'medium';
                    $question = self::generateAddition(
                        $config['min_number_1'],
                        $config['max_number_1'],
                        $config['min_number_2'],
                        $config['max_number_2'],
                        $difficulty
                    );
                    
                    // Create a unique key for this question
                    $num1 = $question['num1'];
                    $num2 = $question['num2'];
                    $pair_key = min($num1, $num2) . '+' . max($num1, $num2);
                    
                    if (!in_array($pair_key, $used_pairs)) {
                        $questions[] = $question;
                        $used_pairs[] = $pair_key;
                    }
                    break;
                    
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
