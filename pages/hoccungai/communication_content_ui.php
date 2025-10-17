<!-- ============================================ -->
<!-- COMMUNICATION CONTENT -->
<!-- ============================================ -->
<div id="communication-content" class="skill-content">
    <div class="skill-header">
        <h2><i class="fas fa-comments"></i> Giao Tiếp (Communication)</h2>
        <p>Rèn luyện kỹ năng giao tiếp thực tế với AI</p>
    </div>

    <!-- Communication Scenarios -->
    <div class="scenario-selector">
        <h3><i class="fas fa-sitemap"></i> Chọn tình huống giao tiếp</h3>
        
        <div class="scenario-grid">
            <div class="scenario-card" data-scenario="introduction">
                <i class="fas fa-handshake"></i>
                <h4>Giới thiệu bản thân</h4>
                <p>Tự giới thiệu trong các tình huống khác nhau</p>
                <button class="btn-primary">Bắt đầu</button>
            </div>

            <div class="scenario-card" data-scenario="small-talk">
                <i class="fas fa-coffee"></i>
                <h4>Small Talk</h4>
                <p>Trò chuyện phím về thời tiết, công việc...</p>
                <button class="btn-primary">Bắt đầu</button>
            </div>

            <div class="scenario-card" data-scenario="shopping">
                <i class="fas fa-shopping-cart"></i>
                <h4>Mua sắm</h4>
                <p>Giao tiếp tại cửa hàng, siêu thị</p>
                <button class="btn-primary">Bắt đầu</button>
            </div>

            <div class="scenario-card" data-scenario="restaurant">
                <i class="fas fa-utensils"></i>
                <h4>Nhà hàng</h4>
                <p>Đặt món, thanh toán tại nhà hàng</p>
                <button class="btn-primary">Bắt đầu</button>
            </div>

            <div class="scenario-card" data-scenario="hotel">
                <i class="fas fa-hotel"></i>
                <h4>Khách sạn</h4>
                <p>Check-in, yêu cầu dịch vụ</p>
                <button class="btn-primary">Bắt đầu</button>
            </div>

            <div class="scenario-card" data-scenario="airport">
                <i class="fas fa-plane"></i>
                <h4>Sân bay</h4>
                <p>Làm thủ tục, hỏi thông tin</p>
                <button class="btn-primary">Bắt đầu</button>
            </div>

            <div class="scenario-card" data-scenario="doctor">
                <i class="fas fa-stethoscope"></i>
                <h4>Bác sĩ</h4>
                <p>Mô tả triệu chứng, khám bệnh</p>
                <button class="btn-primary">Bắt đầu</button>
            </div>

            <div class="scenario-card" data-scenario="job-interview">
                <i class="fas fa-briefcase"></i>
                <h4>Phỏng vấn việc làm</h4>
                <p>Trả lời câu hỏi phỏng vấn</p>
                <button class="btn-primary">Bắt đầu</button>
            </div>

            <div class="scenario-card" data-scenario="phone-call">
                <i class="fas fa-phone"></i>
                <h4>Điện thoại</h4>
                <p>Gọi điện chuyên nghiệp</p>
                <button class="btn-primary">Bắt đầu</button>
            </div>

            <div class="scenario-card" data-scenario="complaint">
                <i class="fas fa-exclamation-triangle"></i>
                <h4>Khiếu nại</h4>
                <p>Phàn nàn, yêu cầu giải quyết</p>
                <button class="btn-primary">Bắt đầu</button>
            </div>
        </div>
    </div>

    <!-- Role Play Area -->
    <div id="roleplay-area" class="roleplay-area" style="display: none;">
        <button id="back-to-scenarios" class="btn-back">
            <i class="fas fa-arrow-left"></i> Chọn tình huống khác
        </button>

        <div class="roleplay-container">
            <div class="roleplay-header">
                <h3 id="roleplay-title">Scenario: At the Restaurant</h3>
                <div class="roleplay-info">
                    <span class="your-role">Vai của bạn: <strong id="user-role">Customer</strong></span>
                    <span class="ai-role">AI đóng vai: <strong id="ai-role">Waiter</strong></span>
                </div>
            </div>

            <div class="scenario-description">
                <i class="fas fa-info-circle"></i>
                <p id="scenario-description">
                    Bạn đang ở nhà hàng và muốn gọi món. Hãy tương tác với nhân viên phục vụ.
                </p>
            </div>

            <div class="useful-phrases">
                <h4><i class="fas fa-lightbulb"></i> Cụm từ hữu ích</h4>
                <div id="phrases-list" class="phrases-list">
                    <span class="phrase-chip">"Can I see the menu?"</span>
                    <span class="phrase-chip">"I'd like to order..."</span>
                    <span class="phrase-chip">"Could you recommend something?"</span>
                    <span class="phrase-chip">"Can I have the bill, please?"</span>
                </div>
            </div>

            <div class="conversation-display">
                <div id="conversation-thread" class="conversation-thread">
                    <div class="message ai-message">
                        <div class="message-avatar">
                            <i class="fas fa-robot"></i>
                        </div>
                        <div class="message-bubble">
                            <strong>Waiter:</strong>
                            <p>Good evening! Welcome to our restaurant. How many people?</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="response-options">
                <button id="speak-response-comm" class="response-btn voice-btn">
                    <i class="fas fa-microphone"></i> Nói
                </button>
                <button id="type-response-comm" class="response-btn type-btn">
                    <i class="fas fa-keyboard"></i> Gõ
                </button>
                <button id="hint-btn" class="response-btn hint-btn">
                    <i class="fas fa-question-circle"></i> Gợi ý
                </button>
            </div>

            <div id="text-input-area" class="text-input-area" style="display: none;">
                <textarea 
                    id="user-response-text" 
                    placeholder="Type your response here..."
                    rows="3"
                ></textarea>
                <button id="send-text-response" class="btn-primary">
                    <i class="fas fa-paper-plane"></i> Gửi
                </button>
            </div>

            <div id="hint-display" class="hint-display" style="display: none;">
                <i class="fas fa-lightbulb"></i>
                <p id="hint-content"></p>
            </div>

            <div class="conversation-controls">
                <button id="restart-conversation" class="btn-secondary">
                    <i class="fas fa-redo"></i> Bắt đầu lại
                </button>
                <button id="end-conversation" class="btn-danger">
                    <i class="fas fa-times"></i> Kết thúc
                </button>
            </div>
        </div>

        <!-- Conversation Summary -->
        <div id="conversation-summary" class="conversation-summary" style="display: none;">
            <h3><i class="fas fa-chart-bar"></i> Đánh giá cuộc hội thoại</h3>
            <div id="summary-content">
                <!-- AI will provide feedback here -->
            </div>
        </div>
    </div>

    <!-- Quick Chat with AI -->
    <div class="quick-chat-section">
        <h3><i class="fas fa-robot"></i> Chat nhanh với AI</h3>
        <p>Trò chuyện tự do bằng tiếng Anh với trợ lý AI</p>

        <div class="quick-chat-box">
            <div id="quick-chat-messages" class="chat-messages">
                <div class="chat-message ai">
                    <i class="fas fa-robot"></i>
                    <div class="message-text">
                        Hello! I'm your English learning assistant. Feel free to chat with me in English. I'm here to help you practice!
                    </div>
                </div>
            </div>

            <div class="chat-input-area">
                <input 
                    type="text" 
                    id="quick-chat-input" 
                    placeholder="Type your message in English..."
                    class="chat-input"
                >
                <button id="send-quick-chat" class="send-btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
                <button id="voice-quick-chat" class="voice-btn">
                    <i class="fas fa-microphone"></i>
                </button>
            </div>
        </div>
    </div>
</div>
