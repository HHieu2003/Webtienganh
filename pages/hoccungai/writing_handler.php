<?php
/**
 * WRITING HANDLER - FIXED VERSION
 * Process writing-related API requests
 */

require_once 'config.php';

header('Content-Type: application/json; charset=UTF-8');

try {
    // Check rate limit
    if (!SecurityHelper::checkRateLimit('writing_api', 30, 3600)) {
        throw new Exception('Rate limit exceeded. Please try again later.');
    }

    // Get action from GET or POST
    $action = '';
    
    if (isset($_GET['action'])) {
        $action = SecurityHelper::sanitize($_GET['action']);
    } elseif (isset($_POST['action'])) {
        $action = SecurityHelper::sanitize($_POST['action']);
    } else {
        // Try to get from JSON body
        $input = json_decode(file_get_contents('php://input'), true);
        $action = $input['action'] ?? '';
    }

    // Route to appropriate function
    switch ($action) {
        case 'generate_topic':
            generateWritingTopic();
            break;
            
        case 'check':
            checkWriting();
            break;
            
        case 'suggest':
            suggestWriting();
            break;
            
        case 'paraphrase':
            paraphraseText();
            break;
            
        default:
            throw new Exception('Invalid action: ' . $action);
    }

} catch (Exception $e) {
    Logger::error('Writing handler error', ['error' => $e->getMessage(), 'action' => $action ?? 'unknown']);
    echo json_encode([
        'success' => false, 
        'error' => $e->getMessage(),
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}

/**
 * Tạo đề bài viết ngẫu nhiên
 */
function generateWritingTopic() {
    $level = $_GET['level'] ?? 'intermediate';
    $type = $_GET['type'] ?? 'essay';
    
    $level = SecurityHelper::sanitize($level);
    $type = SecurityHelper::sanitize($type);

    $topics = [
        'beginner' => [
            'My Family',
            'My Best Friend',
            'My Daily Routine',
            'My Favorite Food',
            'My Hometown',
            'A Day in My Life',
            'My Pet',
            'My School'
        ],
        'intermediate' => [
            'The Importance of Learning English',
            'Social Media: Advantages and Disadvantages',
            'How Technology Changed Our Lives',
            'Environmental Protection',
            'Education in the Future',
            'The Benefits of Exercise',
            'Online Shopping vs Traditional Shopping',
            'The Role of Technology in Education'
        ],
        'advanced' => [
            'The Impact of Artificial Intelligence on Employment',
            'Globalization: Pros and Cons',
            'Climate Change: Solutions and Challenges',
            'The Role of Government in Healthcare',
            'Cultural Diversity in Modern Society',
            'Economic Inequality in the 21st Century',
            'The Future of Work in the Digital Age',
            'Ethical Implications of Genetic Engineering'
        ]
    ];

    $levelTopics = $topics[$level] ?? $topics['intermediate'];
    $randomTopic = $levelTopics[array_rand($levelTopics)];
    
    $wordTargets = [
        'beginner' => '100-150 words',
        'intermediate' => '200-250 words',
        'advanced' => '300-400 words'
    ];

    echo json_encode([
        'success' => true,
        'topic' => $randomTopic,
        'level' => $level,
        'type' => $type,
        'wordTarget' => $wordTargets[$level] ?? '200-250 words'
    ], JSON_UNESCAPED_UNICODE);
    
    Logger::info('Topic generated', ['level' => $level, 'type' => $type, 'topic' => $randomTopic]);
}

/**
 * Kiểm tra và sửa lỗi bài viết
 */
function checkWriting() {
    $input = json_decode(file_get_contents('php://input'), true);
    $text = $input['text'] ?? '';
    $type = $input['type'] ?? 'essay';

    if (empty(trim($text))) {
        throw new Exception('No text provided');
    }

    if (!SecurityHelper::validateLength($text, 50, 5000)) {
        throw new Exception('Text must be between 50 and 5000 characters');
    }

    $text = SecurityHelper::sanitize($text);
    $type = SecurityHelper::sanitize($type);

    $prompt = "You are an expert English teacher. Evaluate this student's writing.

📝 STUDENT'S WRITING:
\"\"\"
$text
\"\"\"

📊 TYPE: " . strtoupper($type) . "

🔍 EVALUATION REQUIREMENTS:

1. **Overall Score** (0-100):
   - Grammar: 0-100
   - Vocabulary: 0-100
   - Structure: 0-100
   - Coherence: 0-100

2. **Errors Found**:
   List each error with:
   - original: \"incorrect text\"
   - corrected: \"correct text\"
   - explanation: \"why it's wrong\"

3. **Corrected Version**:
   Rewrite the entire text with all corrections

4. **Improvement Suggestions**:
   Provide 3-5 specific suggestions

Please respond ONLY with valid JSON in this exact format:
{
  \"overallScore\": 85,
  \"scores\": {
    \"grammar\": 85,
    \"vocabulary\": 80,
    \"structure\": 90,
    \"coherence\": 85
  },
  \"errors\": [
    {
      \"original\": \"example error\",
      \"corrected\": \"example correction\",
      \"explanation\": \"why it's wrong\"
    }
  ],
  \"correctedText\": \"The fully corrected text...\",
  \"suggestions\": [\"Suggestion 1\", \"Suggestion 2\", \"Suggestion 3\"]
}";

    $aiResponse = callGeminiAPI($prompt);
    
    if ($aiResponse) {
        $result = parseJSONFromText($aiResponse);
        
        if (!empty($result)) {
            echo json_encode([
                'success' => true,
                'score' => $result['overallScore'] ?? 70,
                'scores' => $result['scores'] ?? [
                    'grammar' => 70,
                    'vocabulary' => 70,
                    'structure' => 70,
                    'coherence' => 70
                ],
                'errors' => $result['errors'] ?? [],
                'correctedText' => $result['correctedText'] ?? $text,
                'suggestions' => $result['suggestions'] ?? [],
                'wordCount' => str_word_count($text)
            ], JSON_UNESCAPED_UNICODE);
            
            Logger::info('Writing checked', ['word_count' => str_word_count($text), 'score' => $result['overallScore'] ?? 70]);
        } else {
            throw new Exception('Invalid AI response format');
        }
    } else {
        throw new Exception('AI service unavailable');
    }
}

/**
 * Gợi ý viết bài
 */
function suggestWriting() {
    $input = json_decode(file_get_contents('php://input'), true);
    $topic = $input['topic'] ?? '';
    $type = $input['type'] ?? 'essay';
    $level = $input['level'] ?? 'intermediate';

    if (empty($topic)) {
        throw new Exception('No topic provided');
    }

    $topic = SecurityHelper::sanitize($topic);
    $type = SecurityHelper::sanitize($type);
    $level = SecurityHelper::sanitize($level);

    $prompt = "You are an English writing tutor. Help a student write about this topic.

📌 TOPIC: $topic
📊 TYPE: " . strtoupper($type) . "
🎯 LEVEL: " . strtoupper($level) . "

Provide writing suggestions in this exact JSON format:
{
  \"outline\": {
    \"introduction\": [\"point 1\", \"point 2\"],
    \"body\": [\"point 1\", \"point 2\", \"point 3\"],
    \"conclusion\": [\"point 1\"]
  },
  \"vocabulary\": [
    {\"word\": \"achievement\", \"meaning\": \"thành tích\", \"example\": \"Winning the award was a great achievement.\"}
  ],
  \"usefulSentences\": [\"sentence 1\", \"sentence 2\"],
  \"tips\": [\"tip 1\", \"tip 2\"]
}";

    $aiResponse = callGeminiAPI($prompt);
    
    if ($aiResponse) {
        $result = parseJSONFromText($aiResponse);
        
        if (!empty($result)) {
            echo json_encode([
                'success' => true,
                'outline' => $result['outline'] ?? [
                    'introduction' => ['Introduce the topic', 'State your thesis'],
                    'body' => ['Main point 1', 'Main point 2', 'Supporting examples'],
                    'conclusion' => ['Summarize key points']
                ],
                'vocabulary' => $result['vocabulary'] ?? [],
                'usefulSentences' => $result['usefulSentences'] ?? [],
                'tips' => $result['tips'] ?? ['Use varied vocabulary', 'Check grammar', 'Read your work aloud']
            ], JSON_UNESCAPED_UNICODE);
            
            Logger::info('Writing suggestions generated', ['topic' => $topic, 'level' => $level]);
        } else {
            throw new Exception('Invalid AI response format');
        }
    } else {
        throw new Exception('AI service unavailable');
    }
}

/**
 * Paraphrase (viết lại câu)
 */
function paraphraseText() {
    $input = json_decode(file_get_contents('php://input'), true);
    $text = $input['text'] ?? '';
    $style = $input['style'] ?? 'formal';

    if (empty(trim($text))) {
        throw new Exception('No text provided');
    }

    if (!SecurityHelper::validateLength($text, 10, 500)) {
        throw new Exception('Text must be between 10 and 500 characters');
    }

    $text = SecurityHelper::sanitize($text);
    $style = SecurityHelper::sanitize($style);

    $prompt = "Paraphrase the following text in 3 different ways. Keep the same meaning but use different words and sentence structures.

ORIGINAL TEXT:
\"$text\"

STYLE: $style

Provide ONLY valid JSON in this format:
{
  \"alternatives\": [
    \"version 1\",
    \"version 2\",
    \"version 3\"
  ]
}";

    $aiResponse = callGeminiAPI($prompt);
    
    if ($aiResponse) {
        $result = parseJSONFromText($aiResponse);
        
        if (!empty($result) && isset($result['alternatives'])) {
            echo json_encode([
                'success' => true,
                'original' => $text,
                'alternatives' => $result['alternatives']
            ], JSON_UNESCAPED_UNICODE);
            
            Logger::info('Text paraphrased', ['original_length' => strlen($text)]);
        } else {
            // Fallback: split by newlines
            $alternatives = array_filter(array_map('trim', explode("\n", $aiResponse)));
            $alternatives = array_slice($alternatives, 0, 3);
            
            if (count($alternatives) > 0) {
                echo json_encode([
                    'success' => true,
                    'original' => $text,
                    'alternatives' => $alternatives
                ], JSON_UNESCAPED_UNICODE);
            } else {
                throw new Exception('Could not generate paraphrases');
            }
        }
    } else {
        throw new Exception('AI service unavailable');
    }
}

/**
 * Call Gemini API
 */
function callGeminiAPI($prompt) {
    $url = GEMINI_API_URL . '?key=' . GEMINI_API_KEY;
    
    $data = [
        'contents' => [
            ['parts' => [['text' => $prompt]]]
        ],
        'generationConfig' => [
            'temperature' => 0.7,
            'topK' => 40,
            'topP' => 0.95,
            'maxOutputTokens' => 2048
        ]
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        Logger::error('cURL error', ['error' => $curlError]);
        return null;
    }

    if ($httpCode !== 200) {
        Logger::error('API HTTP error', ['code' => $httpCode, 'response' => $response]);
        return null;
    }

    $result = json_decode($response, true);
    
    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        return $result['candidates'][0]['content']['parts'][0]['text'];
    }
    
    Logger::error('Invalid API response structure', ['response' => $response]);
    return null;
}

/**
 * Parse JSON from text (handles markdown code blocks)
 */
function parseJSONFromText($text) {
    // Remove markdown code blocks
    $text = preg_replace('/```)/s', '', $text);
    $text = preg_replace('/```\s*/', '', $text);
    $text = trim($text);
    
    // Try to decode directly
    $json = json_decode($text, true);
    if ($json !== null) {
        return $json;
    }
    
    // Try to extract JSON from text
    if (preg_match('/\{[\s\S]*\}/s', $text, $matches)) {
        $json = json_decode($matches[0], true);
        if ($json !== null) {
            return $json;
        }
    }
    
    Logger::error('Failed to parse JSON', ['text' => substr($text, 0, 200)]);
    return [];
}
?>
<?