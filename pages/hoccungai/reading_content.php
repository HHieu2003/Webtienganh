<?php
// Nội dung bài đọc theo chủ đề
// File này cung cấp dữ liệu cho phần Reading

header('Content-Type: application/json');

$readingContent = [
    'short' => [
        [
            'id' => 'r1',
            'title' => 'The Benefits of Reading',
            'level' => 'beginner',
            'category' => 'Lifestyle',
            'reading_time' => '3 min',
            'content' => "Reading is one of the most beneficial activities you can do for your mind. When you read, you exercise your brain, improve your vocabulary, and expand your knowledge.\n\nStudies show that reading regularly can reduce stress levels by up to 68%. It's more effective than listening to music or taking a walk. Reading before bed can help you sleep better because it relaxes your mind.\n\nReading also improves your focus and concentration. In our digital age, where we're constantly distracted by notifications and social media, reading a book requires sustained attention. This trains your brain to focus better.\n\nMoreover, reading fiction can improve your empathy. When you read about characters and their experiences, you learn to understand different perspectives and emotions. This makes you more compassionate in real life.\n\nWhether you prefer fiction or non-fiction, reading for just 30 minutes a day can make a significant difference in your mental health and cognitive abilities.",
            'vocabulary' => [
                ['word' => 'beneficial', 'meaning' => 'có lợi, có ích', 'example' => 'Exercise is beneficial for health.'],
                ['word' => 'expand', 'meaning' => 'mở rộng, phát triển', 'example' => 'Travel expands your horizons.'],
                ['word' => 'sustained', 'meaning' => 'liên tục, kéo dài', 'example' => 'Sustained effort leads to success.'],
                ['word' => 'empathy', 'meaning' => 'sự đồng cảm', 'example' => 'Teachers need empathy to understand students.'],
                ['word' => 'cognitive', 'meaning' => 'nhận thức', 'example' => 'Cognitive development is important for children.']
            ],
            'questions' => [
                [
                    'question' => 'According to the passage, reading can reduce stress by:',
                    'options' => ['50%', '60%', '68%', '75%'],
                    'correct' => 2,
                    'explanation' => 'The passage states "reading regularly can reduce stress levels by up to 68%"'
                ],
                [
                    'question' => 'What does reading fiction improve?',
                    'options' => ['Memory', 'Empathy', 'Speed', 'Strength'],
                    'correct' => 1,
                    'explanation' => 'The text mentions "reading fiction can improve your empathy"'
                ],
                [
                    'question' => 'How long should you read daily to see benefits?',
                    'options' => ['15 minutes', '20 minutes', '30 minutes', '1 hour'],
                    'correct' => 2,
                    'explanation' => 'The passage recommends "reading for just 30 minutes a day"'
                ],
                [
                    'question' => 'Reading before bed helps you:',
                    'options' => ['Wake up early', 'Sleep better', 'Dream more', 'Feel hungry'],
                    'correct' => 1,
                    'explanation' => 'The text states "Reading before bed can help you sleep better"'
                ]
            ]
        ],
        [
            'id' => 'r2',
            'title' => 'Coffee Culture Around the World',
            'level' => 'beginner',
            'category' => 'Culture',
            'reading_time' => '4 min',
            'content' => "Coffee is more than just a drink – it's a global phenomenon that brings people together. Different countries have their own unique coffee cultures and traditions.\n\nIn Italy, coffee is an art form. Italians typically drink espresso while standing at a bar, and it's usually consumed quickly. The tradition of 'la pausa' (the break) is sacred, with many people taking a coffee break around 10 AM and 3 PM.\n\nTurkey has one of the oldest coffee traditions in the world. Turkish coffee is prepared in a special pot called a 'cezve' and is served unfiltered. After drinking, some people read fortunes in the coffee grounds left in the cup.\n\nIn Vietnam, coffee is often mixed with sweetened condensed milk, creating a rich and sweet beverage called 'cà phê sữa đá'. It's typically served over ice, perfect for the hot climate.\n\nSweden has a tradition called 'fika' – a coffee break that's considered essential for social bonding. Swedes take fika seriously, often twice a day, accompanied by pastries.\n\nNo matter where you go, coffee serves as a social connector, bringing people together for conversation and community.",
            'vocabulary' => [
                ['word' => 'phenomenon', 'meaning' => 'hiện tượng', 'example' => 'Social media is a modern phenomenon.'],
                ['word' => 'sacred', 'meaning' => 'thiêng liêng, quan trọng', 'example' => 'Family time is sacred to her.'],
                ['word' => 'unfiltered', 'meaning' => 'không lọc', 'example' => 'He speaks in an unfiltered way.'],
                ['word' => 'beverage', 'meaning' => 'đồ uống', 'example' => 'What beverage would you like?'],
                ['word' => 'bonding', 'meaning' => 'gắn kết', 'example' => 'Team activities promote bonding.']
            ],
            'questions' => [
                [
                    'question' => 'How do Italians typically drink espresso?',
                    'options' => ['Sitting down', 'Standing at a bar', 'Walking', 'At home only'],
                    'correct' => 1,
                    'explanation' => 'The passage mentions "Italians typically drink espresso while standing at a bar"'
                ],
                [
                    'question' => 'What is used to prepare Turkish coffee?',
                    'options' => ['French press', 'Cezve', 'Espresso machine', 'Filter'],
                    'correct' => 1,
                    'explanation' => 'Turkish coffee is prepared in a "cezve"'
                ],
                [
                    'question' => 'What is "fika"?',
                    'options' => ['A type of coffee', 'A coffee break tradition', 'A pastry', 'A coffee shop'],
                    'correct' => 1,
                    'explanation' => 'Fika is described as "a coffee break that\'s considered essential for social bonding"'
                ]
            ]
        ]
    ],
    
    'medium' => [
        [
            'id' => 'r3',
            'title' => 'The Psychology of Color in Marketing',
            'level' => 'intermediate',
            'category' => 'Business',
            'reading_time' => '6 min',
            'content' => "Colors play a crucial role in marketing and branding, influencing consumer behavior in ways many people don't realize. Understanding color psychology can give businesses a significant advantage in connecting with their target audience.\n\nRed is perhaps the most powerful color in marketing. It evokes strong emotions – passion, excitement, urgency, and even hunger. This is why many fast-food chains use red in their logos. Red also creates a sense of urgency, which is why it's commonly used in sale signs and clearance promotions.\n\nBlue conveys trust, security, and professionalism. It's the most popular color in corporate branding, used by tech giants like Facebook, Twitter, and IBM. Studies show that blue can actually lower heart rate and reduce appetite, making it ideal for businesses that want to project stability and reliability.\n\nGreen is associated with nature, health, and growth. It's commonly used by organic food brands, environmental organizations, and financial institutions (suggesting financial growth). Green also has a calming effect, making it suitable for healthcare and wellness brands.\n\nYellow captures attention and conveys optimism and warmth. It's the most visible color in daylight, which is why it's used for warning signs. However, too much yellow can cause anxiety, so it's typically used as an accent color.\n\nBlack represents sophistication, luxury, and power. Premium brands often use black in their packaging and logos to convey exclusivity and elegance. Think of luxury car brands, high-end fashion, and premium technology products.\n\nThe key to effective color marketing is understanding your target audience and the emotions you want to evoke. Cultural differences also play a role – colors can have different meanings in different cultures. For example, while white represents purity in Western cultures, it's associated with mourning in many Asian cultures.\n\nSuccessful brands don't choose colors randomly. They carefully select colors that align with their brand values and resonate with their target market. This strategic use of color can increase brand recognition by up to 80%.",
            'vocabulary' => [
                ['word' => 'crucial', 'meaning' => 'quan trọng, thiết yếu', 'example' => 'Timing is crucial for success.'],
                ['word' => 'evoke', 'meaning' => 'gợi lên, khơi dậy', 'example' => 'Music evokes memories.'],
                ['word' => 'convey', 'meaning' => 'truyền đạt, thể hiện', 'example' => 'His smile conveys happiness.'],
                ['word' => 'sophistication', 'meaning' => 'sự tinh tế, sang trọng', 'example' => 'The design shows sophistication.'],
                ['word' => 'resonate', 'meaning' => 'gây tiếng vang, phù hợp', 'example' => 'The message resonates with young people.']
            ],
            'questions' => [
                [
                    'question' => 'Why do fast-food chains often use red?',
                    'options' => ['It\'s cheap', 'It evokes hunger and urgency', 'It\'s traditional', 'It\'s easy to see'],
                    'correct' => 1,
                    'explanation' => 'Red evokes emotions including hunger and creates urgency'
                ],
                [
                    'question' => 'What does blue color convey in marketing?',
                    'options' => ['Excitement', 'Trust and security', 'Luxury', 'Nature'],
                    'correct' => 1,
                    'explanation' => 'Blue conveys trust, security, and professionalism'
                ],
                [
                    'question' => 'By how much can strategic color use increase brand recognition?',
                    'options' => ['50%', '60%', '70%', '80%'],
                    'correct' => 3,
                    'explanation' => 'The text states color can increase recognition by up to 80%'
                ],
                [
                    'question' => 'Which color is mentioned as representing luxury?',
                    'options' => ['Red', 'Blue', 'Black', 'Yellow'],
                    'correct' => 2,
                    'explanation' => 'Black represents sophistication, luxury, and power'
                ]
            ]
        ]
    ],
    
    'advanced' => [
        [
            'id' => 'r4',
            'title' => 'The Future of Artificial Intelligence',
            'level' => 'advanced',
            'category' => 'Technology',
            'reading_time' => '8 min',
            'content' => "Artificial Intelligence (AI) has evolved from a concept in science fiction to a transformative force reshaping virtually every aspect of modern life. As we stand on the cusp of what many experts call the 'AI revolution,' it's crucial to understand both the potential benefits and the challenges that lie ahead.\n\nThe current state of AI is dominated by machine learning, particularly deep learning neural networks. These systems have achieved remarkable success in specific tasks – from playing complex games like Go and chess to diagnosing diseases with accuracy rivaling expert physicians. However, these are examples of 'narrow AI' – systems designed for specific tasks. The holy grail of AI research remains 'Artificial General Intelligence' (AGI), machines that can match or exceed human intelligence across a broad range of cognitive tasks.\n\nThe impact of AI on the economy is already profound. According to McKinsey Global Institute, AI could contribute an additional $13 trillion to global economic output by 2030. Industries from healthcare to finance, manufacturing to transportation are being revolutionized. AI-powered diagnostic tools can detect diseases earlier and more accurately than traditional methods. In finance, algorithmic trading systems process vast amounts of data in milliseconds, making trading decisions faster than any human could.\n\nHowever, this technological progress comes with significant challenges. The most pressing concern is employment displacement. While AI will create new jobs, it will also make many existing jobs obsolete. Estimates suggest that by 2030, up to 800 million workers worldwide could be displaced by automation. This necessitates massive investment in education and retraining programs to help workers transition to new roles.\n\nEthical considerations are equally important. AI systems can perpetuate and amplify human biases present in their training data. Facial recognition systems have shown higher error rates for certain demographic groups. Credit scoring algorithms may discriminate based on protected characteristics. Ensuring AI fairness and accountability is crucial as these systems make increasingly important decisions affecting people's lives.\n\nPrivacy concerns loom large as AI systems require vast amounts of data to function effectively. The same technologies that enable personalized recommendations and improved services also enable unprecedented surveillance capabilities. Striking a balance between innovation and privacy protection is one of the key challenges facing policymakers.\n\nAnother critical concern is the potential for AI to be weaponized. Autonomous weapons systems, sophisticated disinformation campaigns, and AI-powered cyberattacks represent new frontiers in warfare and conflict. International cooperation and regulation will be essential to prevent an AI arms race.\n\nDespite these challenges, the potential benefits of AI are enormous. In healthcare, AI could help develop personalized medicine, with treatments tailored to individual genetic profiles. Climate change could be better understood and potentially mitigated through AI-powered climate modeling. Education could become more personalized and accessible through intelligent tutoring systems.\n\nThe key to realizing AI's potential while minimizing its risks lies in thoughtful governance and regulation. This includes developing robust ethical frameworks, investing in AI safety research, ensuring transparency and accountability in AI systems, and fostering international cooperation on AI governance.\n\nAs we move forward, it's essential to remember that AI is a tool created by humans and should serve human values and interests. The future of AI will be shaped not just by technological capabilities, but by the choices we make as a society about how to develop and deploy these powerful technologies.",
            'vocabulary' => [
                ['word' => 'transformative', 'meaning' => 'mang tính chuyển đổi, biến đổi', 'example' => 'The internet was a transformative technology.'],
                ['word' => 'cusp', 'meaning' => 'bờ vực, ngưỡng cửa', 'example' => 'We are on the cusp of a breakthrough.'],
                ['word' => 'profound', 'meaning' => 'sâu sắc, to lớn', 'example' => 'AI has a profound impact on society.'],
                ['word' => 'perpetuate', 'meaning' => 'duy trì, làm tồn tại mãi', 'example' => 'We must not perpetuate stereotypes.'],
                ['word' => 'loom', 'meaning' => 'hiện ra đe dọa', 'example' => 'Dark clouds loom on the horizon.'],
                ['word' => 'unprecedented', 'meaning' => 'chưa từng có', 'example' => 'This is an unprecedented situation.'],
                ['word' => 'mitigated', 'meaning' => 'giảm thiểu', 'example' => 'Risks can be mitigated with planning.'],
                ['word' => 'robust', 'meaning' => 'mạnh mẽ, vững chắc', 'example' => 'We need robust security measures.']
            ],
            'questions' => [
                [
                    'question' => 'What is the main difference between narrow AI and AGI?',
                    'options' => [
                        'Speed of processing',
                        'Specific tasks vs. broad cognitive abilities',
                        'Cost of development',
                        'Energy consumption'
                    ],
                    'correct' => 1,
                    'explanation' => 'Narrow AI is designed for specific tasks, while AGI would match human intelligence across a broad range of cognitive tasks'
                ],
                [
                    'question' => 'According to McKinsey, how much could AI contribute to global economic output by 2030?',
                    'options' => ['$10 trillion', '$13 trillion', '$15 trillion', '$20 trillion'],
                    'correct' => 1,
                    'explanation' => 'The passage states AI could contribute an additional $13 trillion'
                ],
                [
                    'question' => 'How many workers could be displaced by automation by 2030?',
                    'options' => ['500 million', '600 million', '700 million', '800 million'],
                    'correct' => 3,
                    'explanation' => 'Up to 800 million workers worldwide could be displaced'
                ],
                [
                    'question' => 'What does the author suggest is key to realizing AI\'s potential?',
                    'options' => [
                        'Faster computing power',
                        'More data collection',
                        'Thoughtful governance and regulation',
                        'Increased investment'
                    ],
                    'correct' => 2,
                    'explanation' => 'The author emphasizes thoughtful governance and regulation as key'
                ],
                [
                    'question' => 'Which ethical concern is NOT mentioned in the passage?',
                    'options' => [
                        'Employment displacement',
                        'Bias in AI systems',
                        'Privacy concerns',
                        'Environmental impact'
                    ],
                    'correct' => 3,
                    'explanation' => 'Environmental impact is not discussed as an ethical concern in this passage'
                ]
            ]
        ]
    ]
];

// Xử lý request
$action = $_GET['action'] ?? 'get_all';
$level = $_GET['level'] ?? 'all';
$id = $_GET['id'] ?? null;

$response = ['success' => false];

switch($action) {
    case 'get_all':
        if ($level === 'all') {
            $response['success'] = true;
            $response['data'] = $readingContent;
        } elseif (isset($readingContent[$level])) {
            $response['success'] = true;
            $response['data'] = $readingContent[$level];
        }
        break;
        
    case 'get_by_id':
        if ($id) {
            foreach ($readingContent as $lvl => $items) {
                foreach ($items as $item) {
                    if ($item['id'] === $id) {
                        $response['success'] = true;
                        $response['data'] = $item;
                        break 2;
                    }
                }
            }
        }
        break;
        
    case 'check_answer':
        $questionIndex = intval($_POST['questionIndex'] ?? 0);
        $userAnswer = intval($_POST['answer'] ?? -1);
        $articleId = $_POST['articleId'] ?? null;
        
        if ($articleId) {
            foreach ($readingContent as $lvl => $items) {
                foreach ($items as $item) {
                    if ($item['id'] === $articleId) {
                        if (isset($item['questions'][$questionIndex])) {
                            $correct = $item['questions'][$questionIndex]['correct'];
                            $response['success'] = true;
                            $response['correct'] = ($userAnswer === $correct);
                            $response['correctAnswer'] = $correct;
                            $response['explanation'] = $item['questions'][$questionIndex]['explanation'];
                        }
                        break 2;
                    }
                }
            }
        }
        break;
        
    case 'save_favorite':
        // Lưu bài đọc yêu thích vào database
        if (!isset($_SESSION)) session_start();
        
        if (isset($_SESSION['id_hocvien']) && $id) {
            require_once '../../config/config.php';
            
            $userId = $_SESSION['id_hocvien'];
            $sql = "INSERT INTO reading_favorites (user_id, article_id, created_at) 
                    VALUES (?, ?, NOW()) 
                    ON DUPLICATE KEY UPDATE created_at = NOW()";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $userId, $id);
            
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Đã lưu bài đọc yêu thích!';
            }
        }
        break;
}

echo json_encode($response);
?>
