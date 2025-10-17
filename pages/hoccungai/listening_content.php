<?php
// Nội dung bài nghe theo chủ đề
// File này cung cấp dữ liệu cho phần Listening

header('Content-Type: application/json');

$listeningContent = [
    'daily_conversation' => [
        [
            'id' => 'dc1',
            'title' => 'At the Restaurant',
            'level' => 'beginner',
            'duration' => '2:30',
            'audio_url' => 'uploads/audio/listening/restaurant.mp3',
            'transcript' => "Waiter: Good evening! Welcome to our restaurant. How many people are in your party?\nCustomer: Good evening. There are four of us.\nWaiter: Wonderful! Please follow me to your table. Here are your menus. Can I get you something to drink?\nCustomer: Yes, please. Can we have four glasses of water?\nWaiter: Of course. I'll be right back with your water.",
            'questions' => [
                [
                    'question' => 'How many people are in the customer\'s party?',
                    'options' => ['Two', 'Three', 'Four', 'Five'],
                    'correct' => 2
                ],
                [
                    'question' => 'What does the customer order to drink?',
                    'options' => ['Coffee', 'Tea', 'Water', 'Juice'],
                    'correct' => 2
                ],
                [
                    'question' => 'Where does this conversation take place?',
                    'options' => ['Hotel', 'Restaurant', 'Coffee shop', 'Bar'],
                    'correct' => 1
                ]
            ]
        ],
        [
            'id' => 'dc2',
            'title' => 'Shopping for Clothes',
            'level' => 'beginner',
            'duration' => '3:00',
            'transcript' => "Shop Assistant: Hello! Can I help you find something today?\nCustomer: Yes, I'm looking for a jacket.\nShop Assistant: What size are you?\nCustomer: I usually wear a medium.\nShop Assistant: Great! We have several jackets in medium. What color would you prefer?\nCustomer: Do you have anything in blue?\nShop Assistant: Yes, we do. Let me show you.",
            'questions' => [
                [
                    'question' => 'What is the customer looking for?',
                    'options' => ['A shirt', 'A jacket', 'Shoes', 'A hat'],
                    'correct' => 1
                ],
                [
                    'question' => 'What size does the customer wear?',
                    'options' => ['Small', 'Medium', 'Large', 'Extra Large'],
                    'correct' => 1
                ],
                [
                    'question' => 'What color does the customer prefer?',
                    'options' => ['Red', 'Green', 'Blue', 'Black'],
                    'correct' => 2
                ]
            ]
        ]
    ],
    
    'toeic' => [
        [
            'id' => 'toeic1',
            'title' => 'Office Meeting',
            'level' => 'intermediate',
            'duration' => '3:30',
            'transcript' => "Manager: Good morning, everyone. Thank you for joining today's meeting. I'd like to discuss our quarterly sales report. As you can see from the presentation, our sales increased by 15% compared to last quarter. This is excellent progress.\nEmployee 1: That's great news! What factors contributed to this increase?\nManager: Well, our new marketing campaign was very successful, and we also launched three new products that performed well in the market.\nEmployee 2: Will we continue with the same strategy next quarter?\nManager: Yes, but we'll also focus on expanding our online presence.",
            'questions' => [
                [
                    'question' => 'What is the main topic of the meeting?',
                    'options' => ['Marketing strategy', 'Quarterly sales report', 'New products', 'Online expansion'],
                    'correct' => 1
                ],
                [
                    'question' => 'By how much did sales increase?',
                    'options' => ['10%', '12%', '15%', '20%'],
                    'correct' => 2
                ],
                [
                    'question' => 'What will be the focus next quarter?',
                    'options' => ['New products', 'Marketing campaign', 'Online presence', 'Sales training'],
                    'correct' => 2
                ]
            ]
        ],
        [
            'id' => 'toeic2',
            'title' => 'Phone Conversation - Customer Service',
            'level' => 'intermediate',
            'duration' => '4:00',
            'transcript' => "Agent: Good afternoon, Tech Support. This is Sarah speaking. How can I help you today?\nCustomer: Hi Sarah, I'm having trouble with my internet connection. It's been very slow for the past two days.\nAgent: I'm sorry to hear that. Let me check your account. Can you please provide your account number?\nCustomer: Sure, it's 789456123.\nAgent: Thank you. I can see that there's maintenance work in your area. This should be completed by tomorrow evening. Your internet speed will return to normal after that.\nCustomer: Oh, I see. Thank you for the information.",
            'questions' => [
                [
                    'question' => 'What is the customer\'s problem?',
                    'options' => ['Broken computer', 'Slow internet', 'No connection', 'High bill'],
                    'correct' => 1
                ],
                [
                    'question' => 'How long has the problem existed?',
                    'options' => ['One day', 'Two days', 'Three days', 'One week'],
                    'correct' => 1
                ],
                [
                    'question' => 'What is causing the problem?',
                    'options' => ['Router issue', 'Maintenance work', 'Payment due', 'Weather'],
                    'correct' => 1
                ]
            ]
        ]
    ],
    
    'ielts' => [
        [
            'id' => 'ielts1',
            'title' => 'University Lecture - Climate Change',
            'level' => 'advanced',
            'duration' => '5:00',
            'transcript' => "Professor: Good morning, class. Today we're going to discuss the impact of climate change on global ecosystems. Climate change is one of the most pressing issues of our time, affecting not only the environment but also human societies and economies worldwide.\n\nThe primary cause of current climate change is the increase in greenhouse gases, particularly carbon dioxide, in our atmosphere. These gases trap heat from the sun, causing global temperatures to rise. Over the past century, we've seen an average temperature increase of approximately 1 degree Celsius, which might not sound significant, but it has profound effects.\n\nOne major consequence is the melting of polar ice caps. This leads to rising sea levels, which threatens coastal communities around the world. Additionally, we're seeing more frequent extreme weather events, such as hurricanes, droughts, and floods. These changes disrupt ecosystems, causing some species to migrate or face extinction.\n\nThe impact on human societies is also substantial. Agricultural patterns are shifting, which affects food security. Some regions are experiencing water shortages, while others face increased flooding. The economic costs of climate change are estimated to reach trillions of dollars in the coming decades if we don't take action.",
            'questions' => [
                [
                    'question' => 'What is the main topic of the lecture?',
                    'options' => ['Global warming causes', 'Ecosystem diversity', 'Climate change impacts', 'Environmental protection'],
                    'correct' => 2
                ],
                [
                    'question' => 'By how much have temperatures increased in the past century?',
                    'options' => ['0.5 degrees', '1 degree', '1.5 degrees', '2 degrees'],
                    'correct' => 1
                ],
                [
                    'question' => 'What is mentioned as a consequence of melting ice caps?',
                    'options' => ['Lower temperatures', 'Rising sea levels', 'More rainfall', 'Better fishing'],
                    'correct' => 1
                ],
                [
                    'question' => 'According to the lecture, climate change affects:',
                    'options' => ['Only the environment', 'Only human societies', 'Only economies', 'All of the above'],
                    'correct' => 3
                ]
            ]
        ]
    ],
    
    'news' => [
        [
            'id' => 'news1',
            'title' => 'Technology News - AI in Healthcare',
            'level' => 'advanced',
            'duration' => '4:30',
            'transcript' => "Anchor: Welcome to Tech Today. Our top story: Artificial Intelligence is revolutionizing healthcare in ways we never imagined. Reporter Jane Smith has more on this developing story.\n\nReporter: Thank you, Michael. A new AI system developed by researchers at Stanford University can now diagnose certain diseases with accuracy matching that of experienced doctors. The system uses deep learning algorithms to analyze medical images, patient history, and symptoms.\n\nDr. Chen, the lead researcher, explains: 'Our AI can process thousands of cases in minutes, identifying patterns that humans might miss. This doesn't replace doctors but enhances their capabilities, leading to faster and more accurate diagnoses.'\n\nThe system has been tested in several hospitals and has shown promising results, particularly in detecting early-stage cancers and rare diseases. However, experts caution that while AI is a powerful tool, it should be used in conjunction with human expertise, not as a replacement.\n\nThe technology is expected to be widely available in medical facilities within the next two years, potentially saving countless lives through early detection.",
            'questions' => [
                [
                    'question' => 'What can the new AI system do?',
                    'options' => ['Perform surgery', 'Diagnose diseases', 'Create medicines', 'Train doctors'],
                    'correct' => 1
                ],
                [
                    'question' => 'Where was the AI system developed?',
                    'options' => ['Harvard', 'MIT', 'Stanford', 'Oxford'],
                    'correct' => 2
                ],
                [
                    'question' => 'What does the AI analyze?',
                    'options' => ['Only images', 'Only symptoms', 'Only history', 'Images, history, and symptoms'],
                    'correct' => 3
                ],
                [
                    'question' => 'When will the technology be widely available?',
                    'options' => ['Within one year', 'Within two years', 'Within five years', 'Next month'],
                    'correct' => 1
                ]
            ]
        ]
    ]
];

// Xử lý request
$action = $_GET['action'] ?? 'get_all';
$category = $_GET['category'] ?? 'all';
$id = $_GET['id'] ?? null;

$response = ['success' => false];

switch($action) {
    case 'get_all':
        if ($category === 'all') {
            $response['success'] = true;
            $response['data'] = $listeningContent;
        } elseif (isset($listeningContent[$category])) {
            $response['success'] = true;
            $response['data'] = $listeningContent[$category];
        }
        break;
        
    case 'get_by_id':
        if ($id) {
            foreach ($listeningContent as $cat => $items) {
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
        $lessonId = $_POST['lessonId'] ?? null;
        
        if ($lessonId) {
            foreach ($listeningContent as $cat => $items) {
                foreach ($items as $item) {
                    if ($item['id'] === $lessonId) {
                        if (isset($item['questions'][$questionIndex])) {
                            $correct = $item['questions'][$questionIndex]['correct'];
                            $response['success'] = true;
                            $response['correct'] = ($userAnswer === $correct);
                            $response['correctAnswer'] = $correct;
                        }
                        break 2;
                    }
                }
            }
        }
        break;
}

echo json_encode($response);
?>
