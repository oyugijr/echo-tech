<!-- Live Chat Widget -->
<div id="chatWidget" class="chat-widget">
    <button class="chat-toggle" onclick="toggleChat()" aria-label="Toggle chat">
        <span class="chat-icon">💬</span>
        <span class="chat-close">✕</span>
    </button>
    
    <div class="chat-window">
        <div class="chat-header">
            <div class="chat-title">
                <span class="status-dot"></span>
                <div>
                    <h4>EcoTech Support</h4>
                    <span class="status-text">Online</span>
                </div>
            </div>
            <button class="chat-minimize" onclick="toggleChat()">−</button>
        </div>
        
        <div class="chat-messages" id="chatMessages">
            <div class="chat-welcome">
                <p>👋 Hi there! Welcome to EcoTech Solutions.</p>
                <p>How can we help you today?</p>
            </div>
            <div class="quick-responses">
                <button onclick="sendQuickResponse('I want to learn about your services')">Our Services</button>
                <button onclick="sendQuickResponse('I need a quote for a project')">Get a Quote</button>
                <button onclick="sendQuickResponse('I have a technical question')">Technical Support</button>
                <button onclick="sendQuickResponse('I want to speak with a representative')">Contact Sales</button>
            </div>
        </div>
        
        <form class="chat-input" onsubmit="sendMessage(event)">
            <input type="text" id="chatInput" placeholder="Type your message..." autocomplete="off">
            <button type="submit" aria-label="Send message">→</button>
        </form>
    </div>
</div>

<style>
.chat-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    font-family: 'Segoe UI', system-ui, sans-serif;
}

.chat-toggle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(46, 204, 113, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.chat-toggle:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(46, 204, 113, 0.5);
}

.chat-icon,
.chat-close {
    font-size: 1.5rem;
    color: white;
    position: absolute;
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.chat-close {
    opacity: 0;
    transform: rotate(-90deg);
}

.chat-widget.open .chat-icon {
    opacity: 0;
    transform: rotate(90deg);
}

.chat-widget.open .chat-close {
    opacity: 1;
    transform: rotate(0);
}

.chat-window {
    position: absolute;
    bottom: 75px;
    right: 0;
    width: 350px;
    height: 450px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    opacity: 0;
    visibility: hidden;
    transform: translateY(20px) scale(0.95);
    transition: all 0.3s ease;
}

.chat-widget.open .chat-window {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

.chat-header {
    background: linear-gradient(135deg, #2c3e50, #34495e);
    color: white;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.chat-title h4 {
    margin: 0;
    font-size: 1rem;
}

.status-dot {
    width: 10px;
    height: 10px;
    background: #2ecc71;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.status-text {
    font-size: 0.75rem;
    opacity: 0.8;
}

.chat-minimize {
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.chat-minimize:hover {
    opacity: 1;
}

.chat-messages {
    flex: 1;
    padding: 1rem;
    overflow-y: auto;
    background: #f8fafc;
}

.chat-welcome {
    background: white;
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.chat-welcome p {
    margin: 0 0 0.5rem;
    color: #2c3e50;
}

.chat-welcome p:last-child {
    margin: 0;
}

.quick-responses {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.quick-responses button {
    padding: 0.5rem 0.75rem;
    background: white;
    border: 1px solid #e3e9ed;
    border-radius: 20px;
    cursor: pointer;
    font-size: 0.8rem;
    color: #2c3e50;
    transition: all 0.3s ease;
}

.quick-responses button:hover {
    border-color: #2ecc71;
    color: #2ecc71;
}

.message {
    margin-bottom: 0.75rem;
    display: flex;
    flex-direction: column;
}

.message.user {
    align-items: flex-end;
}

.message.bot {
    align-items: flex-start;
}

.message-content {
    max-width: 80%;
    padding: 0.75rem 1rem;
    border-radius: 16px;
    font-size: 0.9rem;
    line-height: 1.4;
}

.message.user .message-content {
    background: #2ecc71;
    color: white;
    border-bottom-right-radius: 4px;
}

.message.bot .message-content {
    background: white;
    color: #2c3e50;
    border-bottom-left-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.chat-input {
    display: flex;
    padding: 1rem;
    background: white;
    border-top: 1px solid #e3e9ed;
}

.chat-input input {
    flex: 1;
    padding: 0.75rem 1rem;
    border: 1px solid #e3e9ed;
    border-radius: 25px;
    font-size: 0.9rem;
    outline: none;
    transition: border-color 0.3s ease;
}

.chat-input input:focus {
    border-color: #2ecc71;
}

.chat-input button {
    width: 40px;
    height: 40px;
    margin-left: 0.5rem;
    background: #2ecc71;
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.1rem;
    transition: background 0.3s ease;
}

.chat-input button:hover {
    background: #27ae60;
}

@media (max-width: 480px) {
    .chat-window {
        width: calc(100vw - 40px);
        height: calc(100vh - 100px);
        bottom: 70px;
    }
}
</style>

<script>
function toggleChat() {
    document.getElementById('chatWidget').classList.toggle('open');
}

function sendMessage(e) {
    e.preventDefault();
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    
    if (message) {
        addMessage(message, 'user');
        input.value = '';
        
        // Simulate bot response
        setTimeout(() => {
            const response = getBotResponse(message);
            addMessage(response, 'bot');
        }, 1000);
    }
}

function sendQuickResponse(message) {
    addMessage(message, 'user');
    
    // Hide quick responses after first use
    const quickResponses = document.querySelector('.quick-responses');
    if (quickResponses) {
        quickResponses.style.display = 'none';
    }
    
    setTimeout(() => {
        const response = getBotResponse(message);
        addMessage(response, 'bot');
    }, 1000);
}

function addMessage(text, type) {
    const messagesContainer = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${type}`;
    messageDiv.innerHTML = `<div class="message-content">${escapeHtml(text)}</div>`;
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function getBotResponse(message) {
    const lowerMessage = message.toLowerCase();
    
    if (lowerMessage.includes('service')) {
        return "We offer sustainable technology solutions including energy management, water conservation, waste reduction, and smart building systems. Visit our Services page for details, or I can connect you with our team!";
    } else if (lowerMessage.includes('quote') || lowerMessage.includes('price') || lowerMessage.includes('cost')) {
        return "I'd be happy to help you get a quote! Please visit our Contact page and fill out the form with your project details, or call us at +1 (555) 123-4567.";
    } else if (lowerMessage.includes('technical') || lowerMessage.includes('support')) {
        return "For technical support, please email support@ecotechsolutions.com or call our support line at +1 (555) 987-6543. Our team is available Monday-Friday, 8 AM - 6 PM.";
    } else if (lowerMessage.includes('contact') || lowerMessage.includes('representative') || lowerMessage.includes('sales')) {
        return "You can reach our sales team at sales@ecotechsolutions.com or +1 (555) 123-4567. Alternatively, visit our Contact page to schedule a consultation.";
    } else if (lowerMessage.includes('hello') || lowerMessage.includes('hi') || lowerMessage.includes('hey')) {
        return "Hello! 👋 How can I assist you today? Feel free to ask about our services, request a quote, or get technical support.";
    } else if (lowerMessage.includes('thank')) {
        return "You're welcome! Is there anything else I can help you with?";
    } else {
        return "Thanks for your message! For the fastest response, please contact our team directly at info@ecotechsolutions.com or call +1 (555) 123-4567. Is there anything specific I can help you with?";
    }
}
</script>
