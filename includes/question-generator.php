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
    public static function generateMultiplication($min_a, $max_a, $min_b, $max_b) {
        // Generate two random numbers within range
        $num1 = rand($min_a, $max_a);
        $num2 = rand($min_b, $max_b);
        
        // Calculate correct answer
        $correct = $num1 * $num2;
        
        // Create question text
        $question_text = "$num1 × $num2 = ?";
        
        // Generate wrong answers
        $options = self::generateOptions($correct, $num1, $num2, 'multiplication');
        
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
     * @return array Shuffled array of 4 options (1 correct, 3 wrong)
     */
    private static function generateOptions($correct, $num1, $num2, $operation = 'multiplication') {
        $wrong_answers = [];
        
        // Strategy: Generate common mistakes and plausible alternatives
        switch($operation) {
            case 'multiplication':
                // Common mistakes for multiplication
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
            return $val != $correct && $val > 0; // Keep positive numbers only
        });
        
        // If we don't have enough options, generate random nearby numbers
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
        
        for ($i = 0; $i < $count; $i++) {
            switch($operation) {
                case 'multiplication':
                    $questions[] = self::generateMultiplication(
                        $config['min_multiplier'],
                        $config['max_multiplier'],
                        $config['min_multiplicand'],
                        $config['max_multiplicand']
                    );
                    break;
                // Future operations can be added here
                default:
                    break;
            }
        }
        
        return $questions;
    }
}
?>
