<!-- COMMUNICATION SECTION -->
<section id="communication-section" class="skill-content-section">
    <div class="ai-card">
        <div class="ai-card-header">
            <h2 class="ai-card-title">
                <i class="fas fa-comments"></i>
                Luyện Giao Tiếp (Communication)
            </h2>
        </div>
        <div class="ai-card-body">
            <p class="mb-3">Thực hành giao tiếp tiếng Anh qua các tình huống thực tế với AI chatbot.</p>
            
            <div class="form-group">
                <label class="form-label">Chọn tình huống:</label>
                <select id="communication-scenario" class="form-control">
                    <option value="shopping">Shopping (Mua sắm)</option>
                    <option value="restaurant">At Restaurant (Nhà hàng)</option>
                    <option value="hotel">Hotel Check-in (Khách sạn)</option>
                    <option value="airport">At Airport (Sân bay)</option>
                    <option value="interview">Job Interview (Phỏng vấn)</option>
                    <option value="phone">Phone Call (Điện thoại)</option>
                    <option value="meeting">Business Meeting (Họp)</option>
                </select>
            </div>

            <div class="text-center mb-4">
                <button class="btn btn-primary btn-lg" id="communication-start-btn">
                    <i class="fas fa-play"></i> Bắt đầu hội thoại
                </button>
            </div>

            <div id="communication-chat-container" style="display: none;">
                <div class="ai-card" style="background: var(--bg-secondary); min-height: 400px; max-height: 500px; overflow-y: auto; margin-bottom: 1rem;" id="communication-messages">
                    <div class="text-center" style="padding: 2rem; color: var(--text-secondary);">
                        <i class="fas fa-comments" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                        <p>Cuộc hội thoại sẽ bắt đầu ở đây...</p>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <input type="text" id="communication-input" class="form-control" placeholder="Nhập tin nhắn của bạn..." style="flex: 1;">
                    <button class="btn btn-primary" id="communication-send-btn">
                        <i class="fas fa-paper-plane"></i> Gửi
                    </button>
                </div>

                <div class="text-center mt-3">
                    <button class="btn btn-success" id="communication-feedback-btn">
                        <i class="fas fa-chart-line"></i> Xem đánh giá
                    </button>
                    <button class="btn btn-outline" id="communication-reset-btn">
                        <i class="fas fa-redo"></i> Bắt đầu lại
                    </button>
                </div>

                <div id="communication-results" class="mt-4" style="display: none;"></div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('skillSectionInit', (e) => {
    if (e.detail.skill === 'communication') {
        initCommunicationSection();
    }
});

function initCommunicationSection() {
    const startBtn = document.getElementById('communication-start-btn');
    const sendBtn = document.getElementById('communication-send-btn');
    const input = document.getElementById('communication-input');
    const feedbackBtn = document.getElementById('communication-feedback-btn');
    const resetBtn = document.getElementById('communication-reset-btn');
    
    let conversationHistory = [];

    startBtn?.addEventListener('click', async () => {
        const scenario = document.getElementById('communication-scenario').value;
        Utils.showLoading('Đang khởi tạo cuộc hội thoại...');

        try {
            const result = await Utils.apiRequest('communication_api.php', {
                action: 'start',
                scenario: scenario
            });

            if (result.success) {
                document.getElementById('communication-chat-container').style.display = 'block';
                conversationHistory = [];
                addMessage('AI', result.data.greeting);
                Utils.showToast('Cuộc hội thoại đã bắt đầu!', 'success');
            } else {
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            Utils.showToast('Không thể bắt đầu', 'error');
        } finally {
            Utils.hideLoading();
        }
    });

    sendBtn?.addEventListener('click', sendMessage);
    input?.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });

    async function sendMessage() {
        const message = input.value.trim();
        if (!message) return;

        addMessage('You', message);
        input.value = '';
        conversationHistory.push({role: 'user', text: message});

        Utils.showLoading('AI đang trả lời...');

        try {
            const result = await Utils.apiRequest('communication_api.php', {
                action: 'reply',
                message: message,
                history: JSON.stringify(conversationHistory)
            });

            if (result.success) {
                addMessage('AI', result.data.reply);
                conversationHistory.push({role: 'ai', text: result.data.reply});
            } else {
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            Utils.showToast('Không thể nhận phản hồi', 'error');
        } finally {
            Utils.hideLoading();
        }
    }

    feedbackBtn?.addEventListener('click', async () => {
        if (conversationHistory.length === 0) {
            Utils.showToast('Chưa có cuộc hội thoại nào', 'warning');
            return;
        }

        Utils.showLoading('Đang phân tích cuộc hội thoại...');

        try {
            const result = await Utils.apiRequest('communication_api.php', {
                action: 'feedback',
                history: JSON.stringify(conversationHistory)
            });

            if (result.success) {
                displayCommunicationFeedback(result.data);
                Utils.showToast('Đã tạo đánh giá!', 'success');
            } else {
                Utils.showToast('Lỗi: ' + result.message, 'error');
            }
        } catch (error) {
            Utils.showToast('Không thể tạo đánh giá', 'error');
        } finally {
            Utils.hideLoading();
        }
    });

    resetBtn?.addEventListener('click', () => {
        conversationHistory = [];
        document.getElementById('communication-messages').innerHTML = '<div class="text-center" style="padding: 2rem;"><p>Cuộc hội thoại đã được đặt lại.</p></div>';
        document.getElementById('communication-results').style.display = 'none';
    });

    function addMessage(sender, text) {
        const messagesDiv = document.getElementById('communication-messages');
        if (messagesDiv.querySelector('.text-center')) {
            messagesDiv.innerHTML = '';
        }

        const msgDiv = document.createElement('div');
        msgDiv.style.marginBottom = '1rem';
        msgDiv.style.padding = '1rem';
        msgDiv.style.borderRadius = 'var(--border-radius-sm)';
        msgDiv.style.background = sender === 'You' ? '#e0e7ff' : 'white';
        msgDiv.style.marginLeft = sender === 'You' ? '20%' : '0';
        msgDiv.style.marginRight = sender === 'You' ? '0' : '20%';
        
        msgDiv.innerHTML = `<strong style="color: var(--primary-color);">${sender}:</strong><div style="margin-top: 0.5rem;">${text}</div>`;
        messagesDiv.appendChild(msgDiv);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    function displayCommunicationFeedback(data) {
        const resultsDiv = document.getElementById('communication-results');
        resultsDiv.style.display = 'block';
        
        resultsDiv.innerHTML = `
            <div class="ai-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h3><i class="fas fa-trophy"></i> Đánh giá cuộc hội thoại</h3>
                <div style="font-size: 1.5rem; margin-top: 1rem;">Điểm: ${data.score || 7}/10</div>
            </div>
            <div class="ai-card mt-3">
                <h4><i class="fas fa-comments"></i> Nhận xét</h4>
                <div style="line-height: 1.8;">${(data.feedback || 'Bạn giao tiếp tốt!').replace(/\n/g, '<br>')}</div>
            </div>
        `;
    }
}
</script>
