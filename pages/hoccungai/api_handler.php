<?php
/**
 * GEMINI API HANDLER
 * Centralized API communication
 */

class GeminiAPI {
    private $apiKey;
    private $apiUrl;
    private $timeout;
    private $maxRetries;

    public function __construct() {
        $this->apiKey = GEMINI_API_KEY;
        $this->apiUrl = GEMINI_API_URL;
        $this->timeout = GEMINI_TIMEOUT;
        $this->maxRetries = GEMINI_MAX_RETRIES;
    }

    /**
     * Generate content from Gemini API
     */
    public function generateContent($prompt, $systemPrompt = '') {
        $fullPrompt = !empty($systemPrompt) 
            ? $systemPrompt . "\n\n" . $prompt 
            : $prompt;

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $fullPrompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 2048,
            ]
        ];

        $attempt = 0;
        $lastError = null;

        while ($attempt < $this->maxRetries) {
            try {
                $response = $this->makeRequest($payload);
                
                if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
                    Logger::info('Gemini API success', ['attempt' => $attempt + 1]);
                    return [
                        'success' => true,
                        'text' => $response['candidates'][0]['content']['parts'][0]['text']
                    ];
                }
                
                throw new Exception('Invalid API response structure');

            } catch (Exception $e) {
                $lastError = $e->getMessage();
                $attempt++;
                
                Logger::error('Gemini API attempt failed', [
                    'attempt' => $attempt,
                    'error' => $lastError
                ]);

                if ($attempt < $this->maxRetries) {
                    sleep(pow(2, $attempt)); // Exponential backoff
                }
            }
        }

        return [
            'success' => false,
            'error' => $lastError ?? 'Unknown error'
        ];
    }

    /**
     * Make HTTP request to Gemini API
     */
    private function makeRequest($payload) {
        $url = $this->apiUrl . '?key=' . $this->apiKey;

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_SSL_VERIFYPEER => true
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception('cURL Error: ' . $error);
        }

        if ($httpCode !== 200) {
            throw new Exception('API returned HTTP ' . $httpCode . ': ' . $response);
        }

        $decoded = json_decode($response, true);
        if (!$decoded) {
            throw new Exception('Failed to decode API response');
        }

        return $decoded;
    }
}

// Handle direct API requests
if (basename($_SERVER['PHP_SELF']) === 'api_handler.php') {
    header('Content-Type: application/json');
    
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        $action = $input['action'] ?? '';

        if ($action === 'save_progress') {
            // Save user progress to database
            $skill = $input['skill'] ?? '';
            $data = $input['data'] ?? [];
            
            // Implement database save logic here
            
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
