<?php
/**
 * API Handler for Hoc Cung AI
 * Centralized Gemini AI API Communication
 */

require_once 'config.php';

class GeminiAPIHandler {
    private $apiKey;
    private $apiUrl;
    private $timeout = 30;

    public function __construct() {
        $this->apiKey = GEMINI_API_KEY;
        $this->apiUrl = GEMINI_API_URL;
    }

    /**
     * Send request to Gemini API
     */
    public function sendRequest($prompt, $temperature = 0.7, $maxTokens = 2048) {
        try {
            // Validate inputs
            if (empty($prompt)) {
                throw new Exception('Prompt cannot be empty');
            }

            // Prepare request data
            $requestData = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => $temperature,
                    'maxOutputTokens' => $maxTokens,
                    'topP' => 0.95,
                    'topK' => 40
                ],
                'safetySettings' => [
                    [
                        'category' => 'HARM_CATEGORY_HARASSMENT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_HATE_SPEECH',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ]
                ]
            ];

            // Initialize cURL
            $ch = curl_init($this->apiUrl . '?key=' . $this->apiKey);
            
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($requestData),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                ],
                CURLOPT_TIMEOUT => $this->timeout,
                CURLOPT_SSL_VERIFYPEER => true
            ]);

            // Execute request
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            // Handle cURL errors
            if ($curlError) {
                throw new Exception('cURL Error: ' . $curlError);
            }

            // Parse response
            $responseData = json_decode($response, true);

            if ($httpCode !== 200) {
                $errorMessage = $responseData['error']['message'] ?? 'Unknown API error';
                throw new Exception('API Error: ' . $errorMessage);
            }

            // Extract generated text
            if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                return [
                    'success' => true,
                    'text' => $responseData['candidates'][0]['content']['parts'][0]['text'],
                    'raw_response' => $responseData
                ];
            } else {
                throw new Exception('Unexpected API response format');
            }

        } catch (Exception $e) {
            Logger::error('Gemini API Error', [
                'error' => $e->getMessage(),
                'prompt_length' => strlen($prompt)
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Generate content with specific instructions
     */
    public function generateContent($systemPrompt, $userInput, $temperature = 0.7) {
        $fullPrompt = $systemPrompt . "\n\nUser Input: " . $userInput;
        return $this->sendRequest($fullPrompt, $temperature);
    }

    /**
     * Analyze text with specific criteria
     */
    public function analyzeText($text, $analysisType, $criteria = []) {
        $prompt = "Analyze the following text for: " . $analysisType . "\n\n";
        
        if (!empty($criteria)) {
            $prompt .= "Criteria: " . json_encode($criteria, JSON_UNESCAPED_UNICODE) . "\n\n";
        }
        
        $prompt .= "Text to analyze: " . $text . "\n\n";
        $prompt .= "Provide a detailed analysis in JSON format.";
        
        return $this->sendRequest($prompt, 0.5);
    }

    /**
     * Generate exercises
     */
    public function generateExercise($skillType, $level, $topic = '', $count = 5) {
        $prompt = "Generate {$count} {$skillType} exercises for {$level} level";
        
        if (!empty($topic)) {
            $prompt .= " on the topic: {$topic}";
        }
        
        $prompt .= "\n\nProvide the exercises in JSON format with questions and answers.";
        
        return $this->sendRequest($prompt, 0.8, 3000);
    }

    /**
     * Provide feedback on user's answer
     */
    public function provideFeedback($question, $userAnswer, $correctAnswer = null, $skillType = '') {
        $prompt = "Provide detailed feedback on the following answer:\n\n";
        $prompt .= "Question: {$question}\n";
        $prompt .= "User's Answer: {$userAnswer}\n";
        
        if ($correctAnswer) {
            $prompt .= "Correct Answer: {$correctAnswer}\n";
        }
        
        $prompt .= "\nSkill Type: {$skillType}\n";
        $prompt .= "\nProvide constructive feedback, identify mistakes, and suggest improvements.";
        $prompt .= "\nRespond in Vietnamese.";
        
        return $this->sendRequest($prompt, 0.6);
    }

    /**
     * Check grammar
     */
    public function checkGrammar($text) {
        $prompt = "Check the following text for grammar errors:\n\n";
        $prompt .= $text . "\n\n";
        $prompt .= "Provide corrections and explanations in JSON format: ";
        $prompt .= '{"errors": [{"type": "error type", "original": "incorrect text", "correction": "corrected text", "explanation": "why"}]}';
        $prompt .= "\nRespond in Vietnamese for explanations.";
        
        return $this->sendRequest($prompt, 0.3);
    }

    /**
     * Translate text
     */
    public function translate($text, $fromLang, $toLang) {
        $prompt = "Translate the following text from {$fromLang} to {$toLang}:\n\n";
        $prompt .= $text;
        
        return $this->sendRequest($prompt, 0.3);
    }

    /**
     * Generate conversation
     */
    public function generateConversation($scenario, $level, $turns = 6) {
        $prompt = "Generate a natural English conversation for {$level} level learners.\n\n";
        $prompt .= "Scenario: {$scenario}\n";
        $prompt .= "Number of dialogue turns: {$turns}\n\n";
        $prompt .= "Format: JSON with array of {speaker, text} objects.";
        
        return $this->sendRequest($prompt, 0.9, 2000);
    }
}

// Singleton instance
class APIService {
    private static $instance = null;
    private $handler;

    private function __construct() {
        $this->handler = new GeminiAPIHandler();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new APIService();
        }
        return self::$instance;
    }

    public function getHandler() {
        return $this->handler;
    }
}
