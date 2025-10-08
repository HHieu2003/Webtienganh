const chatBody = document.querySelector(".chat-body");
const messageInput = document.querySelector(".message-input");
const chatbotToggler = document.querySelector("#chatbot-toggler");
const closeChatbot = document.querySelector("#close-chatbot");
const chatForm = document.querySelector(".chat-form");

// Api setup - NHỚ THAY API KEY CỦA BẠN VÀO ĐÂY
const API_KEY = "AIzaSyBu3OOT0rNIc-1DDdFYW8EJh-s9sNzm_lc";

const API_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${API_KEY}`;
// ====================================================================

// === SỬA LỖI: THÊM LẠI DÒNG NÀY ===
const userData = { message: null }; 
// ===================================

const initialInputHeight = messageInput.scrollHeight;

const chatHistory = [{
    "role": "user",
    "parts": [{
        "text": "Your instructions: You are 'English Fighter Bot', a friendly, encouraging, and helpful AI English practice partner for a student. Your main purpose is to help students practice their English communication skills. You can discuss various topics, answer frequently asked questions about learning English, and gently correct their grammar mistakes when appropriate. Always maintain a positive and supportive tone. Start the conversation by greeting the user and asking how you can help them practice English today."
    }]
}, {
    "role": "model",
    "parts": [{
        "text": "Hello! I'm the English Fighter Bot. How can I help you practice your English today? We can chat about any topic you like, or you can ask me questions about learning English!"
    }]
}];

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
}

const generateBotResponse = async (incomingMessageDiv) => {
    const messageElement = incomingMessageDiv.querySelector(".message-text");
    // Thêm tin nhắn của người dùng vào lịch sử chat
    chatHistory.push({ role: "user", parts: [{ text: userData.message }] });

    const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ contents: chatHistory })
    };

    try {
        const response = await fetch(API_URL, requestOptions);
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.error.message);
        }
        const data = await response.json();
        if (data.candidates && data.candidates.length > 0) {
            const botResponse = data.candidates[0].content.parts[0].text;
            messageElement.innerHTML = formatResponse(botResponse);
            // Thêm phản hồi của bot vào lịch sử chat
            chatHistory.push({ role: "model", parts: [{ text: botResponse }] });
        } else {
            messageElement.textContent = "Sorry, I couldn't generate a response at this moment. Please try again.";
        }
    } catch (error) {
        messageElement.textContent = "Oops! Something went wrong. Please check the API key or try again later. Details: " + error.message;
        messageElement.style.color = "#dc3545";
    } finally {
        incomingMessageDiv.classList.remove("thinking");
        chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });
    }
};

const handleOutgoingMessage = (e) => {
    e.preventDefault();
    userData.message = messageInput.value.trim();
    if (!userData.message) return;

    messageInput.value = "";
    messageInput.style.height = `${initialInputHeight}px`;

    const outgoingMessageDiv = createMessageElement(`<div class="message-text">${userData.message}</div>`, "user-message");
    chatBody.appendChild(outgoingMessageDiv);
    chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });

    setTimeout(() => {
        const messageContent = `
            <div class="bot-avatar"><i class="fa-solid fa-robot"></i></div>
            <div class="message-text">
                <div class="thinking-indicator">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>`;
        const incomingMessageDiv = createMessageElement(messageContent, "bot-message", "thinking");
        chatBody.appendChild(incomingMessageDiv);
        chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });
        generateBotResponse(incomingMessageDiv);
    }, 600);
};

messageInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 768) {
        handleOutgoingMessage(e);
    }
});

messageInput.addEventListener("input", () => {
    messageInput.style.height = "auto";
    messageInput.style.height = `${messageInput.scrollHeight}px`;
});

chatForm.addEventListener("submit", handleOutgoingMessage); 
chatbotToggler.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));
closeChatbot.addEventListener("click", () => document.body.classList.remove("show-chatbot"));