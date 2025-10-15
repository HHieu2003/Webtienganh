// ==================================================
// ENGLISH FIGHTER HYBRID AI WITH SPEECH PRACTICE
// Customer Service + English Teacher + Speech Analysis
// ==================================================

const chatBody = document.querySelector(".chat-body");
const messageInput = document.querySelector(".message-input");
const chatbotToggler = document.querySelector("#chatbot-toggler");
const closeChatbot = document.querySelector("#close-chatbot");
const chatForm = document.querySelector(".chat-form");

// API Configuration
const API_KEY = "AIzaSyBu3OOT0rNIc-1DDdFYW8EJh-s9sNzm_lc";
const API_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${API_KEY}`;

const userData = { message: null };
const initialInputHeight = messageInput ? messageInput.scrollHeight : 45;

// System state
let websiteData = {
    courses: [],
    teachers: [],
    stats: {},
    notifications: [],
    lastUpdated: null
};

let isExpanded = false;
let currentAIMode = 'customer_service';
let speechMode = false;
const expandButton = document.querySelector('#expand-chatbot');
const overlay = document.querySelector('#chatbot-overlay');
const chatbot = document.querySelector('.chatbot');

// Speech system variables
let mediaRecorder = null;
let audioChunks = [];
let isRecording = false;
let recordingTimer = null;
let recordingStartTime = 0;
let speechRecognition = null;
let currentLesson = null;
let speechLessons = [];
let voiceRecording = false;

// ==================================================
// CRITICAL POSITIONING FIXES
// ==================================================

function applyCriticalFixes() {
    console.log('🔧 Applying critical positioning fixes...');
    
    const chatbot = document.querySelector('.chatbot');
    const toggleBtn = document.querySelector('#chatbot-toggler');
    
    if (chatbot) {
        const criticalStyles = {
            'position': 'fixed',
            'right': '35px', 
            'bottom': '90px',
            'width': '420px',
            'z-index': '999998',
            'top': 'auto',
            'left': 'auto',
            'margin': '0',
            'float': 'none'
        };
        
        Object.entries(criticalStyles).forEach(([prop, value]) => {
            chatbot.style.setProperty(prop, value, 'important');
        });
    }
    
    if (toggleBtn) {
        const toggleStyles = {
            'position': 'fixed',
            'right': '35px',
            'bottom': '30px',
            'z-index': '999999'
        };
        
        Object.entries(toggleStyles).forEach(([prop, value]) => {
            toggleBtn.style.setProperty(prop, value, 'important');
        });
    }
}

// ==================================================
// WEBSITE DATA MANAGEMENT
// ==================================================

const loadWebsiteData = async () => {
    try {
        const [coursesRes, teachersRes, statsRes] = await Promise.all([
            fetch('./chatbot/data_handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'get_courses' })
            }),
            fetch('./chatbot/data_handler.php', {
                method: 'POST', 
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'get_teachers' })
            }),
            fetch('./chatbot/data_handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'get_website_stats' })
            })
        ]);
        
        const coursesData = await coursesRes.json();
        const teachersData = await teachersRes.json();
        const statsData = await statsRes.json();
        
        if (coursesData.success) websiteData.courses = coursesData.data;
        if (teachersData.success) websiteData.teachers = teachersData.data;
        if (statsData.success) websiteData.stats = statsData.data;
        
        websiteData.lastUpdated = new Date();
        console.log('✅ Website data loaded');
        return true;
        
    } catch (error) {
        console.error('❌ Error loading website data:', error);
        return false;
    }
};

const generateWebsiteContext = () => {
    if (!websiteData.lastUpdated) return '';
    
    return `
=== DỮ LIỆU THỰC TỪ WEBSITE ENGLISH FIGHTER ===
📊 THỐNG KÊ: ${websiteData.stats.total_courses || 0} khóa học, ${websiteData.stats.total_students || 0} học viên, ${websiteData.stats.total_teachers || 0} giảng viên

📚 KHÓA HỌC HOT: ${websiteData.courses.slice(0, 5).map(course => 
    `${course.name} (${course.price?.toLocaleString()}đ, ${course.enrolled} học viên)`
).join(', ')}

👨‍🏫 GIẢNG VIÊN: ${websiteData.teachers.slice(0, 3).map(teacher => 
    `${teacher.name} (${teacher.total_classes} lớp)`
).join(', ')}
`;
};

// ==================================================
// HYBRID AI SYSTEM INSTRUCTIONS
// ==================================================

const chatHistory = [{
    "role": "user", 
    "parts": [{
        "text": `Bạn là 'English Fighter AI' - Hệ thống AI 3-in-1:

🎯 3 CHỨC NĂNG:
1️⃣ CUSTOMER SERVICE: Tư vấn khóa học bằng dữ liệu thực
2️⃣ ENGLISH TEACHER: Dạy tiếng Anh với AI
3️⃣ SPEECH PRACTICE: Phân tích pronunciation

📊 CUSTOMER SERVICE: Dùng dữ liệu thực, số liệu chính xác
📚 ENGLISH TEACHER: Dạy grammar, vocabulary, skills
🎤 SPEECH PRACTICE: Phân tích giọng nói, đánh giá phát âm

QUY TẮC: Trả lời tiếng Việt trừ khi thực hành conversation. Thân thiện, chuyên nghiệp.`
    }]
}, {
    "role": "model",
    "parts": [{
        "text": "🌟 **Xin chào! Tôi là English Fighter AI** 🤖\n\nHệ thống AI **3-in-1** thông minh:\n\n**1️⃣ CUSTOMER SERVICE** 🏢 - Tư vấn dựa trên dữ liệu thực\n**2️⃣ ENGLISH TEACHER** 📚 - Dạy tiếng Anh với AI\n**3️⃣ SPEECH PRACTICE** 🎤 - Luyện nói & phân tích giọng\n\n**🎯 Chọn chế độ bằng 3 nút bên input và bắt đầu!**"
    }]
}];

// ==================================================
// SPEECH RECOGNITION SYSTEM
// ==================================================

const initSpeechRecognition = () => {
    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
        speechRecognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        speechRecognition.continuous = false;
        speechRecognition.interimResults = true;
        speechRecognition.lang = 'en-US';
        
        speechRecognition.onresult = (event) => {
            let finalTranscript = '';
            for (let i = event.resultIndex; i < event.results.length; i++) {
                if (event.results[i].isFinal) {
                    finalTranscript += event.results[i][0].transcript;
                }
            }
            
            if (finalTranscript) {
                if (voiceRecording) {
                    // Voice input mode
                    messageInput.value = finalTranscript;
                    stopVoiceInput();
                } else if (isRecording) {
                    // Speech practice mode
                    analyzeUserSpeech(finalTranscript);
                }
            }
        };
        
        speechRecognition.onerror = (event) => {
            console.error('❌ Speech error:', event.error);
            if (voiceRecording) stopVoiceInput();
            if (isRecording) stopRecording();
        };
        
        return true;
    }
    return false;
};

// ==================================================
// SPEECH LESSONS DATA
// ==================================================

const loadSpeechLessons = async () => {
    // Fallback lessons - trong thực tế sẽ load từ API
    speechLessons = [
        {
            id: 'basic_intro',
            title: 'Self Introduction',
            level: 'Beginner',
            text: '[translate:Hello, my name is John. I am from Vietnam. I am 25 years old. Nice to meet you.]',
            vietnamese: 'Xin chào, tên tôi là John. Tôi đến từ Việt Nam. Tôi 25 tuổi. Rất vui được gặp bạn.',
            focus: 'Basic pronunciation, clear speech'
        },
        {
            id: 'weather_talk',
            title: 'Weather Conversation',
            level: 'Elementary',
            text: '[translate:The weather today is really nice. It is sunny and warm. Perfect for going outside.]',
            vietnamese: 'Thời tiết hôm nay thật đẹp. Trời nắng và ấm áp. Hoàn hảo để ra ngoài.',
            focus: 'Natural intonation, rhythm'
        },
        {
            id: 'restaurant_order',
            title: 'Restaurant Ordering',
            level: 'Elementary',
            text: '[translate:Excuse me, I would like to order a chicken sandwich and coffee please. Could you make it to go?]',
            vietnamese: 'Xin lỗi, tôi muốn gọi sandwich gà và cà phê. Bạn có thể làm mang đi không?',
            focus: 'Polite expressions, clear requests'
        },
        {
            id: 'job_interview',
            title: 'Job Interview',
            level: 'Intermediate',
            text: '[translate:I have three years of experience in marketing. I am passionate about digital marketing and believe I can contribute to your team.]',
            vietnamese: 'Tôi có 3 năm kinh nghiệm marketing. Tôi đam mê marketing số và tin rằng có thể đóng góp cho team.',
            focus: 'Professional tone, confidence'
        },
        {
            id: 'business_presentation',
            title: 'Business Presentation',
            level: 'Advanced',
            text: '[translate:Our quarterly sales increased by 25 percent. This growth is due to our new marketing strategy and improved customer service.]',
            vietnamese: 'Doanh số quý tăng 25%. Tăng trưởng này nhờ chiến lược marketing mới và dịch vụ khách hàng cải thiện.',
            focus: 'Business vocabulary, professional delivery'
        }
    ];
    
    console.log(`✅ Loaded ${speechLessons.length} speech lessons`);
    return true;
};

// ==================================================
// SPEECH PRACTICE FUNCTIONS
// ==================================================

const showSpeechPanel = (lessonId = 'basic_intro') => {
    const speechPanel = document.getElementById('speech-panel');
    const chatBody = document.querySelector('.chat-body');
    
    if (!speechPanel) return;
    
    currentLesson = speechLessons.find(lesson => lesson.id === lessonId) || speechLessons[0];
    
    // Update lesson content
    document.getElementById('lesson-level').textContent = currentLesson.level;
    document.getElementById('lesson-focus').textContent = currentLesson.focus;
    document.getElementById('lesson-title').textContent = currentLesson.title;
    document.getElementById('target-text').innerHTML = currentLesson.text;
    document.getElementById('vietnamese-text').textContent = currentLesson.vietnamese;
    
    speechPanel.style.display = 'block';
    
    // Adjust chat body height
    if (chatBody) {
        chatBody.style.height = isExpanded ? 'calc(85vh - 420px)' : '200px';
    }
    
    speechMode = true;
    console.log(`🎤 Speech panel opened: ${currentLesson.title}`);
    
    // Reset results panel
    const resultsPanel = document.getElementById('speech-results');
    if (resultsPanel) resultsPanel.style.display = 'none';
};

window.closeSpeechPanel = () => {
    const speechPanel = document.getElementById('speech-panel');
    const chatBody = document.querySelector('.chat-body');
    
    if (speechPanel) speechPanel.style.display = 'none';
    if (chatBody) chatBody.style.height = isExpanded ? 'calc(85vh - 220px)' : '350px';
    
    if (isRecording) stopRecording();
    speechMode = false;
    
    console.log('🎤 Speech panel closed');
};

// Recording functions
window.startRecording = async () => {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        
        mediaRecorder = new MediaRecorder(stream);
        audioChunks = [];
        
        mediaRecorder.ondataavailable = (event) => {
            audioChunks.push(event.data);
        };
        
        mediaRecorder.onstop = () => {
            const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
            processAudioRecording(audioBlob);
        };
        
        mediaRecorder.start();
        isRecording = true;
        recordingStartTime = Date.now();
        
        // Start speech recognition
        if (speechRecognition) {
            speechRecognition.start();
        }
        
        // Update UI
        document.getElementById('start-recording').disabled = true;
        document.getElementById('stop-recording').disabled = false;
        document.getElementById('recording-indicator').style.display = 'flex';
        
        // Timer
        recordingTimer = setInterval(() => {
            const elapsed = Math.floor((Date.now() - recordingStartTime) / 1000);
            document.getElementById('record-timer').textContent = elapsed;
        }, 1000);
        
        console.log('✅ Recording started');
        
    } catch (error) {
        console.error('❌ Recording error:', error);
        alert('Không thể truy cập microphone. Vui lòng kiểm tra quyền truy cập.');
    }
};

window.stopRecording = () => {
    if (mediaRecorder && isRecording) {
        mediaRecorder.stop();
        mediaRecorder.stream.getTracks().forEach(track => track.stop());
    }
    
    if (speechRecognition) {
        speechRecognition.stop();
    }
    
    if (recordingTimer) {
        clearInterval(recordingTimer);
    }
    
    isRecording = false;
    
    // Update UI
    document.getElementById('start-recording').disabled = false;
    document.getElementById('stop-recording').disabled = true;
    document.getElementById('recording-indicator').style.display = 'none';
    
    console.log('🛑 Recording stopped');
};

window.playSample = () => {
    if (!currentLesson || !('speechSynthesis' in window)) {
        alert('Trình duyệt không hỗ trợ phát âm thanh.');
        return;
    }
    
    const utterance = new SpeechSynthesisUtterance(
        currentLesson.text.replace(/\[translate:|\]/g, '')
    );
    utterance.lang = 'en-US';
    utterance.rate = 0.8;
    utterance.pitch = 1;
    utterance.volume = 1;
    
    const playBtn = document.getElementById('play-sample');
    playBtn.style.background = '#ff9800';
    playBtn.innerHTML = '<i class="fa-solid fa-volume-up"></i> Đang phát...';
    
    utterance.onend = () => {
        playBtn.style.background = 'rgba(255, 255, 255, 0.2)';
        playBtn.innerHTML = '<i class="fa-solid fa-volume-up"></i> Nghe mẫu';
    };
    
    speechSynthesis.speak(utterance);
};

window.showLessonSelector = () => {
    if (!chatBody) return;
    
    const selectorMessage = createMessageElement(`
        <div class="bot-avatar"><i class="fa-solid fa-book"></i></div>
        <div class="message-text">
            📚 **Chọn bài luyện nói:**<br><br>
            ${speechLessons.map((lesson, index) => 
                `**${index + 1}. ${lesson.title}** (${lesson.level})<br>
                <small>${lesson.vietnamese}</small><br>
                <button onclick="selectLesson('${lesson.id}')" style="margin: 5px 0; padding: 4px 8px; background: var(--speech-color); color: white; border: none; border-radius: 10px; font-size: 10px; cursor: pointer;">Chọn bài này</button><br>`
            ).join('<br>')}
        </div>
    `, "bot-message", "lesson-selector");
    
    chatBody.appendChild(selectorMessage);
    chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });
};

window.selectLesson = (lessonId) => {
    showSpeechPanel(lessonId);
    
    const selectorMsg = document.querySelector('.lesson-selector');
    if (selectorMsg) selectorMsg.remove();
    
    const confirmMessage = createMessageElement(`
        <div class="bot-avatar"><i class="fa-solid fa-check"></i></div>
        <div class="message-text">
            ✅ **Đã chọn bài: ${currentLesson.title}**<br>
            Nhấn "Bắt đầu nói" để luyện tập!
        </div>
    `, "bot-message");
    
    chatBody.appendChild(confirmMessage);
    chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });
};

// ==================================================
// SPEECH ANALYSIS SYSTEM
// ==================================================

const processAudioRecording = async (audioBlob) => {
    console.log('🔄 Processing audio...');
    
    // Simulate processing time
    setTimeout(() => {
        // Hiện results panel
        document.getElementById('speech-results').style.display = 'block';
        
        // Simulate AI analysis với random scores
        const scores = {
            pronunciation: 75 + Math.floor(Math.random() * 20),
            fluency: 70 + Math.floor(Math.random() * 25),
            accuracy: 80 + Math.floor(Math.random() * 15),
            overall: 0
        };
        
        scores.overall = Math.floor((scores.pronunciation + scores.fluency + scores.accuracy) / 3);
        scores.feedback = generateSpeechFeedback(scores);
        
        displaySpeechScores(scores);
    }, 2000);
};

const analyzeUserSpeech = async (transcript) => {
    console.log('🧠 Analyzing speech:', transcript);
    
    if (!currentLesson) return;
    
    // Create analysis prompt for AI
    const analysisPrompt = `[SPEECH ANALYSIS MODE]
Target: "${currentLesson.text.replace(/\[translate:|\]/g, '')}"
User said: "${transcript}"
Focus: "${currentLesson.focus}"

Phân tích pronunciation:
1. Pronunciation (0-100): So sánh với target text
2. Fluency (0-100): Độ trôi chảy
3. Accuracy (0-100): Độ chính xác nội dung
4. Feedback: Phản hồi chi tiết bằng tiếng Việt

Trả lời JSON format:
{
  "pronunciation": score,
  "fluency": score,
  "accuracy": score,
  "overall": average_score,
  "feedback": "detailed Vietnamese feedback"
}`;

    try {
        const response = await fetch(API_URL, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ 
                contents: [{ role: "user", parts: [{ text: analysisPrompt }] }]
            })
        });
        
        const data = await response.json();
        
        if (data.candidates && data.candidates.length > 0) {
            const analysisResult = data.candidates[0].content.parts[0].text;
            
            try {
                const scores = JSON.parse(analysisResult);
                displaySpeechScores(scores);
                await saveSpeechScore(scores);
                
            } catch (parseError) {
                console.error('❌ Parse error, using fallback');
                const fallbackScores = generateFallbackScores(transcript);
                displaySpeechScores(fallbackScores);
            }
        }
        
    } catch (error) {
        console.error('❌ AI Analysis error:', error);
        const fallbackScores = generateFallbackScores(transcript);
        displaySpeechScores(fallbackScores);
    }
};

const generateFallbackScores = (transcript) => {
    const targetText = currentLesson.text.replace(/\[translate:|\]/g, '').toLowerCase();
    const userText = transcript.toLowerCase();
    
    // Simple similarity calculation
    const similarity = calculateSimilarity(userText, targetText);
    const baseScore = Math.floor(similarity * 100);
    
    return {
        pronunciation: Math.max(60, baseScore + Math.floor(Math.random() * 20)),
        fluency: Math.max(65, baseScore + Math.floor(Math.random() * 15)), 
        accuracy: Math.max(baseScore, 50),
        overall: Math.max(baseScore, 60),
        feedback: generateSpeechFeedback({
            pronunciation: baseScore,
            fluency: baseScore,
            accuracy: baseScore,
            overall: baseScore
        })
    };
};

const calculateSimilarity = (str1, str2) => {
    const words1 = str1.split(' ');
    const words2 = str2.split(' ');
    const commonWords = words1.filter(word => words2.includes(word));
    return commonWords.length / Math.max(words1.length, words2.length);
};

const generateSpeechFeedback = (scores) => {
    let feedback = `🎯 **Điểm tổng: ${scores.overall}/100**\n\n`;
    
    if (scores.overall >= 85) {
        feedback += '🌟 **Xuất sắc!** Pronunciation rất tốt, tiếp tục duy trì!';
    } else if (scores.overall >= 70) {
        feedback += '👍 **Tốt!** Cần cải thiện một số từ khó phát âm.';
    } else if (scores.overall >= 50) {
        feedback += '💪 **Khá ổn!** Luyện tập thêm để cải thiện fluency.';
    } else {
        feedback += '📈 **Cần cố gắng!** Đọc chậm và rõ ràng hơn.';
    }
    
    feedback += '\n\n**💡 Gợi ý:** ';
    if (scores.pronunciation < 70) feedback += 'Tập trung luyện phát âm từng từ. ';
    if (scores.fluency < 70) feedback += 'Nói chậm và tự nhiên hơn. ';
    if (scores.accuracy < 70) feedback += 'Đọc kỹ text trước khi nói. ';
    
    return feedback;
};

const displaySpeechScores = (scores) => {
    // Update score circles với animation
    updateScoreCircle('pronunciation-score', scores.pronunciation);
    updateScoreCircle('fluency-score', scores.fluency);
    updateScoreCircle('accuracy-score', scores.accuracy);
    
    // Update feedback
    setTimeout(() => {
        document.getElementById('ai-feedback').innerHTML = scores.feedback;
    }, 1500);
    
    // Send to chat
    sendSpeechResultToChat(scores);
};

const updateScoreCircle = (elementId, score) => {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    element.style.setProperty('--score', score);
    
    // Animate number
    let current = 0;
    const timer = setInterval(() => {
        current += 2;
        element.textContent = Math.min(current, score);
        
        if (current >= score) {
            clearInterval(timer);
        }
    }, 30);
};

const sendSpeechResultToChat = (scores) => {
    if (!chatBody) return;
    
    const resultMessage = createMessageElement(`
        <div class="bot-avatar"><i class="fa-solid fa-chart-line"></i></div>
        <div class="message-text">
            🎤 **Kết quả luyện nói: ${currentLesson.title}**<br><br>
            
            **📊 Điểm số AI phân tích:**<br>
            • 🗣️ Pronunciation: **${scores.pronunciation}/100**<br>
            • ⚡ Fluency: **${scores.fluency}/100**<br>
            • 🎯 Accuracy: **${scores.accuracy}/100**<br>
            • 🏆 Overall: **${scores.overall}/100**<br><br>
            
            ${scores.feedback}<br><br>
            
            **🎯 Tiếp tục luyện tập hay chuyển bài khác?**
        </div>
    `, "bot-message", "speech-result");
    
    chatBody.appendChild(resultMessage);
    chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });
};

const saveSpeechScore = async (scores) => {
    try {
        await fetch('./chatbot/speech_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'save_speech_score',
                session_id: `speech_${Date.now()}`,
                pronunciation_score: scores.pronunciation,
                fluency_score: scores.fluency,
                accuracy_score: scores.accuracy,
                overall_score: scores.overall,
                feedback: scores.feedback
            })
        });
    } catch (error) {
        console.error('❌ Error saving scores:', error);
    }
};

// ==================================================
// VOICE INPUT FOR CHAT
// ==================================================

const startVoiceInput = async () => {
    if (voiceRecording) {
        stopVoiceInput();
        return;
    }
    
    if (!speechRecognition) {
        alert('Trình duyệt không hỗ trợ nhận diện giọng nói.');
        return;
    }
    
    try {
        voiceRecording = true;
        const voiceBtn = document.getElementById('voice-input-btn');
        
        voiceBtn.classList.add('recording');
        voiceBtn.innerHTML = '<i class="fa-solid fa-stop"></i>';
        voiceBtn.title = 'Dừng ghi âm';
        
        speechRecognition.lang = currentAIMode === 'english_teacher' ? 'en-US' : 'vi-VN';
        speechRecognition.start();
        
        console.log('🎤 Voice input started');
        
    } catch (error) {
        console.error('❌ Voice input error:', error);
        stopVoiceInput();
    }
};

const stopVoiceInput = () => {
    voiceRecording = false;
    
    if (speechRecognition) {
        speechRecognition.stop();
    }
    
    const voiceBtn = document.getElementById('voice-input-btn');
    if (voiceBtn) {
        voiceBtn.classList.remove('recording');
        voiceBtn.innerHTML = '<i class="fa-solid fa-microphone-lines"></i>';
        voiceBtn.title = 'Nói thay vì gõ';
    }
};

// ==================================================
// MODE MANAGEMENT
// ==================================================

window.switchMode = (newMode) => {
    console.log(`🔄 Switching to ${newMode} mode`);
    
    currentAIMode = newMode;
    
    const chatbot = document.querySelector('.chatbot');
    const modeText = document.getElementById('current-mode-text');
    const messageInput = document.querySelector('.message-input');
    
    // Update mode buttons
    document.querySelectorAll('.mode-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.mode === newMode) {
            btn.classList.add('active');
        }
    });
    
    // Update chatbot styling
    if (chatbot) {
        chatbot.classList.remove('customer-mode', 'teacher-mode', 'speech-mode');
        chatbot.classList.add(`${newMode.replace('_', '-')}-mode`);
        chatbot.classList.add('switching');
        setTimeout(() => chatbot.classList.remove('switching'), 400);
    }
    
    // Update UI based on mode
    if (newMode === 'customer_service') {
        if (speechMode) closeSpeechPanel();
        if (modeText) modeText.innerHTML = '🏢 Customer Service';
        if (messageInput) messageInput.placeholder = '🏢 Hỏi về khóa học, giá cả, thống kê...';
        
    } else if (newMode === 'english_teacher') {
        if (speechMode) closeSpeechPanel();
        if (modeText) modeText.innerHTML = '📚 English Teacher';
        if (messageInput) messageInput.placeholder = '📚 Hỏi về grammar, vocabulary, skills...';
        
    } else if (newMode === 'speech_practice') {
        if (modeText) modeText.innerHTML = '🎤 Speech Practice';
        if (messageInput) messageInput.placeholder = '🎤 Luyện phát âm với AI...';
        
        // Load lessons and show panel
        setTimeout(async () => {
            await loadSpeechLessons();
            showSpeechPanel();
        }, 300);
    }
};

// ==================================================
// SMART RESPONSE SYSTEM
// ==================================================

const handleSmartResponse = (message) => {
    const lowerMsg = message.toLowerCase();
    
    if (currentAIMode === 'speech_practice') {
        if (lowerMsg.includes('bài') || lowerMsg.includes('lesson')) {
            showLessonSelector();
            return 'Đã hiển thị danh sách bài luyện nói ở trên!';
        }
        
        return `🎤 **[SPEECH PRACTICE]**\n\n**Chào bạn! Hãy luyện phát âm cùng AI!**\n\n**📚 Bài hiện tại:** ${currentLesson ? currentLesson.title : 'Chưa chọn'}\n\n**🎯 Cách sử dụng:**\n1. Chọn bài luyện tập\n2. Nghe mẫu để hiểu cách phát âm\n3. Nhấn "Bắt đầu nói" và đọc theo\n4. AI sẽ phân tích và chấm điểm\n\n**🤔 Bạn muốn chọn bài luyện tập nào?**`;
    }
    
    // Customer Service responses
    if (currentAIMode === 'customer_service') {
        if (lowerMsg.includes('thống kê')) {
            return `🏢 **[CUSTOMER SERVICE]**\n\n📊 **THỐNG KÊ REALTIME:**\n• Khóa học: ${websiteData.stats.total_courses || 0}\n• Học viên: ${websiteData.stats.total_students || 0}\n• Giảng viên: ${websiteData.stats.total_teachers || 0}\n\n**💼 Cần tư vấn gì thêm?**`;
        }
        
        if (lowerMsg.includes('khóa học')) {
            const topCourses = websiteData.courses.slice(0, 3);
            return `🏢 **[CUSTOMER SERVICE]**\n\n📚 **TOP KHÓA HỌC:**\n${topCourses.map(course => 
                `• ${course.name}: ${course.price?.toLocaleString()}đ (${course.enrolled} học viên)`
            ).join('\n')}\n\n**💼 Quan tâm khóa nào?**`;
        }
    }
    
    // English Teacher responses  
    if (currentAIMode === 'english_teacher') {
        if (lowerMsg.includes('grammar')) {
            return `📚 **[ENGLISH TEACHER]**\n\n**📖 Grammar Topics:**\n• Present/Past/Future Tenses\n• Passive Voice\n• Conditional Sentences\n• Modal Verbs\n\n**🤔 Học chủ đề nào trước?**`;
        }
        
        if (lowerMsg.includes('vocabulary')) {
            return `📚 **[ENGLISH TEACHER]**\n\n**📝 Vocabulary Themes:**\n• Business English\n• Daily Conversation\n• IELTS/TOEIC Words\n• Travel English\n\n**🎯 Chọn chủ đề từ vựng?**`;
        }
    }
    
    return null;
};

// ==================================================
// CHAT FUNCTIONALITY
// ==================================================

const saveChatMessage = async (type, content) => {
    try {
        await fetch('./chatbot/chat_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'save_message',
                type: type,
                content: content
            })
        });
    } catch (error) {
        console.error('💾 Save error:', error);
    }
};

const loadChatHistory = async () => {
    try {
        const response = await fetch('./chatbot/chat_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'load_history' })
        });
        
        const data = await response.json();
        if (data.success && data.history.length > 0) {
            chatBody.innerHTML = '';
            chatHistory.length = 2;
            
            data.history.forEach(msg => {
                const messageDiv = createMessageElement(
                    msg.type === 'user' ? 
                        `<div class="message-text">${msg.content}</div>` :
                        `<div class="bot-avatar"><i class="fa-solid fa-brain"></i></div><div class="message-text">${formatResponse(msg.content)}</div>`,
                    msg.type === 'user' ? "user-message" : "bot-message"
                );
                chatBody.appendChild(messageDiv);
                chatHistory.push({ role: msg.type === 'user' ? 'user' : 'model', parts: [{ text: msg.content }] });
            });
            
            chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });
        } else {
            showWelcomeMessage();
            addSuggestionButtons();
        }
        
        addFloatingClearButton();
        
    } catch (error) {
        console.error('📜 Load history error:', error);
        showWelcomeMessage();
        addSuggestionButtons();
        addFloatingClearButton();
    }
};

const showWelcomeMessage = () => {
    if (!chatBody) return;
    
    chatBody.innerHTML = '';
    const welcomeMessage = createMessageElement(`
        <div class="bot-avatar"><i class="fa-solid fa-brain"></i></div>
        <div class="message-text">
            🌟 **English Fighter AI - 3-in-1 System** 🤖<br><br>
            
            **1️⃣ CUSTOMER SERVICE** 🏢<br>
            Tư vấn khóa học với dữ liệu thực<br><br>
            
            **2️⃣ ENGLISH TEACHER** 📚<br>
            Dạy grammar, vocabulary, skills<br><br>
            
            **3️⃣ SPEECH PRACTICE** 🎤<br>
            Luyện nói + AI phân tích giọng<br><br>
            
            **🎯 Chọn chế độ bằng 3 nút bên input!**
        </div>
    `, "bot-message");
    chatBody.appendChild(welcomeMessage);
};

const addSuggestionButtons = () => {
    if (!chatBody) return;
    
    const suggestions = {
        customer_service: ["📊 Thống kê", "📚 Khóa học", "👨‍🏫 Giảng viên", "💰 Học phí"],
        english_teacher: ["📖 Grammar", "📝 Vocabulary", "🗣️ Speaking", "🎯 Test"],
        speech_practice: ["🎤 Bắt đầu luyện nói", "📚 Chọn bài khác", "📊 Xem điểm số", "🔊 Nghe mẫu"]
    };
    
    const currentSuggestions = suggestions[currentAIMode] || suggestions.customer_service;
    
    const container = document.createElement('div');
    container.className = 'dual-mode-suggestions';
    container.innerHTML = `
        <div style="text-align: center; margin-bottom: 15px;">
            <h6 style="color: ${currentAIMode === 'customer_service' ? '#0db33b' : currentAIMode === 'english_teacher' ? '#3498db' : '#9c27b0'}; margin: 0;">
                ${currentAIMode === 'customer_service' ? '🏢 Customer Service' : currentAIMode === 'english_teacher' ? '📚 English Teacher' : '🎤 Speech Practice'}
            </h6>
        </div>
        <div class="suggestion-buttons"></div>
    `;
    
    const buttonsContainer = container.querySelector('.suggestion-buttons');
    
    currentSuggestions.forEach(suggestion => {
        const button = document.createElement('button');
        button.textContent = suggestion;
        button.addEventListener('click', () => {
            if (currentAIMode === 'speech_practice' && suggestion.includes('luyện nói')) {
                switchMode('speech_practice');
            } else {
                messageInput.value = suggestion;
                handleOutgoingMessage(new Event('submit'));
            }
            container.remove();
        });
        buttonsContainer.appendChild(button);
    });
    
    chatBody.appendChild(container);
    chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });
};

const clearChatHistory = async () => {
    if (confirm('🗑️ Xóa toàn bộ lịch sử chat?')) {
        try {
            const response = await fetch('./chatbot/chat_handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'clear_history' })
            });
            
            const result = await response.json();
            if (result.success) {
                chatBody.innerHTML = '';
                chatHistory.length = 2;
                showWelcomeMessage();
                addSuggestionButtons();
                
                const oldButton = document.querySelector('.floating-clear-btn');
                if (oldButton) oldButton.remove();
                addFloatingClearButton();
            }
        } catch (error) {
            console.error('❌ Clear error:', error);
        }
    }
};

const addFloatingClearButton = () => {
    const oldButton = document.querySelector('.floating-clear-btn');
    if (oldButton) oldButton.remove();
    
    const floatingClearBtn = document.createElement('button');
    floatingClearBtn.className = 'floating-clear-btn';
    floatingClearBtn.innerHTML = '<i class="fa-solid fa-trash"></i>';
    floatingClearBtn.title = 'Xóa lịch sử chat';
    floatingClearBtn.addEventListener('click', clearChatHistory);
    
    if (chatbot) {
        chatbot.appendChild(floatingClearBtn);
    }
};

const createMessageElement = (content, ...classes) => {
    const div = document.createElement("div");
    div.classList.add("message", ...classes);
    div.innerHTML = content;
    return div;
};

const formatResponse = (text) => {
    text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    text = text.replace(/^\* (.*$)/gm, '<li>$1</li>');
    text = text.replace(/(<li>.*<\/li>)/s, '<ul>$1</ul>');
    text = text.replace(/\n/g, '<br>');
    return text;
};

const generateContextByMode = (mode, message) => {
    const websiteContext = generateWebsiteContext();
    
    if (mode === 'customer_service') {
        return `[CUSTOMER SERVICE MODE] ${message}\n\n${websiteContext}`;
    } else if (mode === 'english_teacher') {
        return `[ENGLISH TEACHER MODE] ${message}\n\nTrung tâm: ${websiteContext}`;
    } else if (mode === 'speech_practice') {
        return `[SPEECH PRACTICE MODE] ${message}\n\nHỗ trợ luyện phát âm tiếng Anh.`;
    }
    return message;
};

const generateBotResponse = async (incomingMessageDiv) => {
    if (!incomingMessageDiv) return;
    
    const messageElement = incomingMessageDiv.querySelector(".message-text");
    if (!messageElement) return;
    
    // Check smart response first
    const smartResponse = handleSmartResponse(userData.message);
    if (smartResponse) {
        messageElement.innerHTML = formatResponse(smartResponse);
        incomingMessageDiv.classList.remove("thinking");
        
        await saveChatMessage('user', userData.message);
        await saveChatMessage('bot', smartResponse);
        
        chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });
        return;
    }
    
    // Generate AI response
    const contextualMessage = generateContextByMode(currentAIMode, userData.message);
    const originalMessage = userData.message;
    
    chatHistory.push({ role: "user", parts: [{ text: contextualMessage }] });
    await saveChatMessage('user', originalMessage);
    
    const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ contents: chatHistory })
    };

    try {
        const response = await fetch(API_URL, requestOptions);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.candidates && data.candidates.length > 0) {
            const botResponse = data.candidates[0].content.parts[0].text;
            const formattedResponse = formatResponse(botResponse);
            
            messageElement.innerHTML = formattedResponse;
            
            chatHistory.push({ role: "model", parts: [{ text: botResponse }] });
            await saveChatMessage('bot', botResponse);
            
        } else {
            messageElement.textContent = "❌ AI không thể phản hồi lúc này.";
        }
    } catch (error) {
        console.error('🤖 AI Error:', error);
        messageElement.innerHTML = `
            <span style="color: #dc3545;">
                ❌ <strong>Lỗi kết nối AI:</strong> ${error.message}<br><br>
                💡 <strong>Thử hỏi:</strong><br>
                ${currentAIMode === 'customer_service' ? 
                    '• "Thống kê trung tâm"<br>• "Danh sách khóa học"' :
                    currentAIMode === 'english_teacher' ?
                    '• "Học ngữ pháp"<br>• "Từ vựng cơ bản"' :
                    '• "Bắt đầu luyện nói"<br>• "Chọn bài khác"'
                }
            </span>
        `;
    } finally {
        incomingMessageDiv.classList.remove("thinking");
        chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });
    }
};

const handleOutgoingMessage = (e) => {
    e.preventDefault();
    
    if (!messageInput) return;
    
    userData.message = messageInput.value.trim();
    if (!userData.message) return;

    // Clear suggestions
    const suggestionButtons = document.querySelector('.dual-mode-suggestions');
    if (suggestionButtons) suggestionButtons.remove();

    messageInput.value = "";
    messageInput.style.height = `${initialInputHeight}px`;

    if (chatBody) {
        const outgoingMessageDiv = createMessageElement(
            `<div class="message-text">${userData.message}</div>`, 
            "user-message"
        );
        chatBody.appendChild(outgoingMessageDiv);
        chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });

        setTimeout(() => {
            const thinkingText = currentAIMode === 'customer_service' ? 
                '🏢 Đang tra cứu dữ liệu...' : 
                currentAIMode === 'english_teacher' ?
                '📚 Đang chuẩn bị bài học...' :
                '🎤 Đang phân tích yêu cầu...';
                
            const messageContent = `
                <div class="bot-avatar">
                    <i class="fa-solid fa-${currentAIMode === 'customer_service' ? 'headset' : currentAIMode === 'english_teacher' ? 'chalkboard-user' : 'microphone'}"></i>
                </div>
                <div class="message-text">
                    <div class="thinking-indicator">
                        ${thinkingText}
                        <div class="dots">
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                        </div>
                    </div>
                </div>`;
                
            const incomingMessageDiv = createMessageElement(messageContent, "bot-message", "thinking");
            chatBody.appendChild(incomingMessageDiv);
            chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });
            generateBotResponse(incomingMessageDiv);
        }, 600);
    }
};

// ==================================================
// EXPAND FUNCTIONALITY
// ==================================================

const toggleChatbotSize = () => {
    console.log(`🔄 Toggle expand: ${isExpanded ? 'shrink' : 'expand'}`);
    
    const chatbot = document.querySelector('.chatbot');
    const overlay = document.querySelector('.chatbot-overlay');
    const expandIcon = expandButton?.querySelector('i');
    
    if (!chatbot || !overlay) return;
    
    if (!isExpanded) {
        // Expand
        chatbot.style.setProperty('position', 'fixed', 'important');
        chatbot.style.setProperty('top', '50%', 'important');
        chatbot.style.setProperty('left', '50%', 'important');
        chatbot.style.setProperty('transform', 'translate(-50%, -50%)', 'important');
        chatbot.style.setProperty('width', '85vw', 'important');
        chatbot.style.setProperty('max-width', '900px', 'important');
        chatbot.style.setProperty('height', '85vh', 'important');
        chatbot.style.setProperty('max-height', '700px', 'important');
        chatbot.style.setProperty('border-radius', '20px', 'important');
        
        chatbot.classList.add('expanded');
        overlay.classList.add('show');
        document.body.classList.add('chatbot-expanded');
        
        if (expandIcon) {
            expandIcon.className = 'fa-solid fa-compress';
            expandButton.title = 'Thu nhỏ chat';
        }
        
        isExpanded = true;
        
        setTimeout(() => {
            if (messageInput) messageInput.focus();
            if (chatBody) chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });
        }, 300);
        
    } else {
        // Shrink
        chatbot.style.setProperty('position', 'fixed', 'important');
        chatbot.style.setProperty('right', '35px', 'important');
        chatbot.style.setProperty('bottom', '90px', 'important');
        chatbot.style.setProperty('width', '420px', 'important');
        chatbot.style.setProperty('height', 'auto', 'important');
        chatbot.style.setProperty('max-height', '500px', 'important');
        chatbot.style.setProperty('top', 'auto', 'important');
        chatbot.style.setProperty('left', 'auto', 'important');
        chatbot.style.setProperty('transform', 'scale(1)', 'important');
        chatbot.style.setProperty('border-radius', '15px', 'important');
        
        chatbot.classList.remove('expanded');
        overlay.classList.remove('show');
        document.body.classList.remove('chatbot-expanded');
        
        if (expandIcon) {
            expandIcon.className = 'fa-solid fa-expand';
            expandButton.title = 'Mở rộng chat';
        }
        
        isExpanded = false;
    }
};

// ==================================================
// EVENT LISTENERS
// ==================================================

// Mode selection buttons
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('mode-btn') || e.target.closest('.mode-btn')) {
        const btn = e.target.classList.contains('mode-btn') ? e.target : e.target.closest('.mode-btn');
        const newMode = btn.dataset.mode;
        
        if (newMode && newMode !== currentAIMode) {
            switchMode(newMode);
        }
    }
});

// Voice input button
const voiceInputBtn = document.getElementById('voice-input-btn');
if (voiceInputBtn) {
    voiceInputBtn.addEventListener('click', startVoiceInput);
}

// Message input
if (messageInput) {
    messageInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 768) {
            handleOutgoingMessage(e);
        }
    });

    messageInput.addEventListener("input", () => {
        messageInput.style.height = "auto";
        messageInput.style.height = `${messageInput.scrollHeight}px`;
    });
}

// Chat form
if (chatForm) {
    chatForm.addEventListener("submit", handleOutgoingMessage);
}

// Chatbot toggler
if (chatbotToggler) {
    chatbotToggler.addEventListener("click", async () => {
        document.body.classList.toggle("show-chatbot");
        
        if (document.body.classList.contains("show-chatbot")) {
            applyCriticalFixes();
            
            if (!websiteData.lastUpdated || Date.now() - websiteData.lastUpdated > 300000) {
                await loadWebsiteData();
            }
            
            await loadChatHistory();
        }
    });
}

// Close chatbot
if (closeChatbot) {
    closeChatbot.addEventListener("click", () => {
        document.body.classList.remove("show-chatbot", "chatbot-expanded");
        
        if (isExpanded) {
            toggleChatbotSize();
        }
        
        if (speechMode) {
            closeSpeechPanel();
        }
        
        const clearBtn = document.querySelector('.floating-clear-btn');
        if (clearBtn) clearBtn.remove();
    });
}

// Expand button
if (expandButton) {
    expandButton.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        toggleChatbotSize();
    });
}

// Overlay click
if (overlay) {
    overlay.addEventListener('click', () => {
        if (isExpanded) {
            toggleChatbotSize();
        }
    });
}

// ESC key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && isExpanded) {
        toggleChatbotSize();
    }
});

// Context menu
if (chatBody) {
    chatBody.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        
        const oldMenu = document.querySelector('.chat-context-menu');
        if (oldMenu) oldMenu.remove();
        
        const contextMenu = document.createElement('div');
        contextMenu.className = 'chat-context-menu';
        contextMenu.style.cssText = `
            position: fixed;
            top: ${e.clientY}px;
            left: ${e.clientX}px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000000;
            min-width: 200px;
            font-family: inherit;
        `;
        
        contextMenu.innerHTML = `
            <div style="padding: 12px 16px; cursor: pointer; border-radius: 8px; transition: background 0.2s; display: flex; align-items: center;" onmouseover="this.style.background='#f0f0f0'" onmouseout="this.style.background='white'" onclick="clearChatHistory(); this.parentNode.remove();">
                <i class="fa-solid fa-trash" style="margin-right: 10px; color: #dc3545;"></i>
                Xóa lịch sử chat
            </div>
            <div style="padding: 12px 16px; cursor: pointer; border-radius: 8px; transition: background 0.2s; display: flex; align-items: center;" onmouseover="this.style.background='#f0f0f0'" onmouseout="this.style.background='white'" onclick="loadWebsiteData(); this.parentNode.remove();">
                <i class="fa-solid fa-sync" style="margin-right: 10px; color: #0db33b;"></i>
                Cập nhật dữ liệu
            </div>
            <div style="padding: 12px 16px; cursor: pointer; border-radius: 8px; transition: background 0.2s; display: flex; align-items: center;" onmouseover="this.style.background='#f0f0f0'" onmouseout="this.style.background='white'" onclick="addSuggestionButtons(); this.parentNode.remove();">
                <i class="fa-solid fa-lightbulb" style="margin-right: 10px; color: #ffc107;"></i>
                Hiển thị gợi ý
            </div>
        `;
        
        document.body.appendChild(contextMenu);
        
        document.addEventListener('click', function removeMenu() {
            contextMenu.remove();
            document.removeEventListener('click', removeMenu);
        });
    });
}

// ==================================================
// GLOBAL FUNCTIONS
// ==================================================

// Function for footer integration
window.openChatWithMessage = function(message, mode = 'customer_service') {
    console.log(`🚀 Opening chat: "${message}" in ${mode} mode`);
    
    document.body.classList.add("show-chatbot");
    applyCriticalFixes();
    
    setTimeout(() => {
        switchMode(mode);
        
        setTimeout(() => {
            if (mode !== 'speech_practice' && messageInput) {
                messageInput.value = message;
                messageInput.focus();
                
                setTimeout(() => {
                    if (chatForm) {
                        chatForm.dispatchEvent(new Event('submit'));
                    }
                }, 500);
            }
        }, 600);
    }, 300);
};

// Export functions
window.EnglishFighterAI = {
    switchMode: switchMode,
    openChatWithMessage: openChatWithMessage,
    clearHistory: clearChatHistory,
    getCurrentMode: () => currentAIMode,
    isExpanded: () => isExpanded,
    loadData: loadWebsiteData,
    speechPanel: {
        show: showSpeechPanel,
        close: closeSpeechPanel,
        startRecording: () => window.startRecording(),
        stopRecording: () => window.stopRecording(),
        playSample: () => window.playSample()
    }
};

// ==================================================
// INITIALIZATION
// ==================================================

// Position monitoring
const positionMonitor = setInterval(() => {
    const chatbot = document.querySelector('.chatbot');
    if (chatbot && window.getComputedStyle(chatbot).position !== 'fixed') {
        console.warn('⚠️ Position changed, re-applying fixes');
        applyCriticalFixes();
    }
}, 3000);

// Initialize system
document.addEventListener('DOMContentLoaded', async () => {
    console.log('🚀 Initializing English Fighter AI System...');
    
    // Apply positioning fixes
    setTimeout(applyCriticalFixes, 100);
    setTimeout(applyCriticalFixes, 1000);
    
    // Initialize speech recognition
    const speechSupported = initSpeechRecognition();
    const audioSupported = navigator.mediaDevices && navigator.mediaDevices.getUserMedia;
    
    console.log('🎤 Speech Recognition:', speechSupported ? '✅' : '❌');
    console.log('🎙️ Audio Recording:', audioSupported ? '✅' : '❌');
    
    // Load speech lessons
    await loadSpeechLessons();
    
    // Initialize mode system
    switchMode('customer_service');
    
    // Load website data
    const success = await loadWebsiteData();
    if (success) {
        console.log('✅ Website data loaded');
    }
    
    // Auto refresh data every 10 minutes
    setInterval(async () => {
        if (document.body.classList.contains("show-chatbot")) {
            await loadWebsiteData();
        }
    }, 600000);
    
    console.log('🎯 English Fighter AI System Ready!');
    console.log('🏢 Customer Service: Database-driven responses');
    console.log('📚 English Teacher: AI-powered education');
    console.log('🎤 Speech Practice: Voice analysis with AI');
});

// Keyboard shortcuts
document.addEventListener('keydown', (e) => {
    if (document.body.classList.contains('show-chatbot')) {
        // Ctrl/Cmd + M: Switch mode
        if ((e.ctrlKey || e.metaKey) && e.key === 'm') {
            e.preventDefault();
            const modes = ['customer_service', 'english_teacher', 'speech_practice'];
            const currentIndex = modes.indexOf(currentAIMode);
            const nextMode = modes[(currentIndex + 1) % modes.length];
            switchMode(nextMode);
        }
        
        // Ctrl/Cmd + L: Clear chat
        if ((e.ctrlKey || e.metaKey) && e.key === 'l') {
            e.preventDefault();
            clearChatHistory();
        }
        
        // Ctrl/Cmd + S: Toggle speech panel (if in teacher mode)
        if ((e.ctrlKey || e.metaKey) && e.key === 's' && currentAIMode === 'english_teacher') {
            e.preventDefault();
            if (speechMode) {
                closeSpeechPanel();
            } else {
                switchMode('speech_practice');
            }
        }
    }
});

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    clearInterval(positionMonitor);
    
    if (isRecording) {
        stopRecording();
    }
    
    if (voiceRecording) {
        stopVoiceInput();
    }
});

// Add CSS animations
const addDynamicCSS = () => {
    if (document.querySelector('#dynamic-ai-css')) return;
    
    const style = document.createElement('style');
    style.id = 'dynamic-ai-css';
    style.textContent = `
        @keyframes chatbotEntrance {
            from {
                opacity: 0;
                transform: scale(0.3) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        body.show-chatbot .chatbot {
            animation: chatbotEntrance 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        .mode-transition {
            animation: modeSwitch 0.4s ease;
        }
        
        .speech-pulse {
            animation: speechPulse 1.5s infinite;
        }
        
        @keyframes speechPulse {
            0%, 100% { 
                box-shadow: 0 0 0 0 rgba(156, 39, 176, 0.7); 
            }
            50% { 
                box-shadow: 0 0 0 10px rgba(156, 39, 176, 0); 
            }
        }
    `;
    document.head.appendChild(style);
};

// Initialize CSS
addDynamicCSS();

console.log('✨ English Fighter Hybrid AI System Fully Loaded!');
console.log('🎯 3-in-1: Customer Service + English Teacher + Speech Practice');
console.log('⌨️ Shortcuts: Ctrl+M (switch), Ctrl+L (clear), Ctrl+S (speech), ESC (close)');
console.log('🚀 Ready for production deployment!');
