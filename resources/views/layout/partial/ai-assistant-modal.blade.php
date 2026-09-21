<!-- =========================================================================
     AI ASISTEN KLINIS & TERAPI (OMAH TERAPI-KU x GOOGLE GEMINI)
     Floating Chatbot Widget — Flat Solid Colors (No Gradients) & Clean Medical Theme
     ========================================================================= -->
<style>
/* -------------------------------------------------------------------------
   Floating Action Trigger Button (Bottom Right)
   Theme: Solid Ocean Navy (#1e40af) & Royal Blue (#2563eb)
   ------------------------------------------------------------------------- */
.ai-floating-launcher {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 1040;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    text-decoration: none !important;
    outline: none;
    background: transparent;
    border: none;
    padding: 0;
    font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif !important;
}

.ai-launcher-btn {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: #1e40af;
    color: #ffffff;
    border: 2px solid rgba(255, 255, 255, 0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    box-shadow: 0 8px 24px rgba(30, 64, 175, 0.38), 0 2px 6px rgba(45, 75, 122, 0.1);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    cursor: pointer;
}

.ai-launcher-btn:hover {
    transform: scale(1.08) translateY(-2px);
    background: #1e3a8a;
    box-shadow: 0 12px 30px rgba(30, 64, 175, 0.5), 0 4px 10px rgba(0, 0, 0, 0.12);
}

.ai-launcher-btn:active {
    transform: scale(0.95);
}

.ai-launcher-pulse {
    position: absolute;
    top: -4px;
    left: -4px;
    right: -4px;
    bottom: -4px;
    border-radius: 50%;
    border: 2px solid #2563eb;
    opacity: 0.65;
    animation: aiPulseNavy 2.4s cubic-bezier(0.24, 0, 0.38, 1) infinite;
    pointer-events: none;
}

@keyframes aiPulseNavy {
    0% { transform: scale(0.95); opacity: 0.85; }
    50% { transform: scale(1.22); opacity: 0; }
    100% { transform: scale(1.25); opacity: 0; }
}

.ai-launcher-badge {
    position: absolute;
    top: -1px;
    right: -1px;
    width: 14px;
    height: 14px;
    background: #10b981;
    border: 2.5px solid #ffffff;
    border-radius: 50%;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
}

.ai-launcher-label {
    background: #ffffff;
    color: #1e40af;
    padding: 6px 13px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    box-shadow: 0 4px 16px rgba(45, 75, 122, 0.12), 0 0 0 1px #e2e8f0;
    display: flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
    transition: all 0.25s ease;
    letter-spacing: 0.1px;
}

.ai-floating-launcher:hover .ai-launcher-label {
    color: #2563eb;
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.2);
}

/* -------------------------------------------------------------------------
   Floating Chat Window Widget (Card Popup — Solid Theme)
   ------------------------------------------------------------------------- */
.ai-floating-widget {
    position: fixed;
    bottom: 92px;
    right: 24px;
    width: 395px;
    max-width: calc(100vw - 32px);
    height: 595px;
    max-height: calc(100vh - 110px);
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 16px 48px rgba(45, 75, 122, 0.18), 0 4px 16px rgba(45, 75, 122, 0.08), 0 0 0 1px #e2e8f0;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    z-index: 1050;
    font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif !important;
    transform-origin: bottom right;
    transform: scale(0.92) translateY(20px);
    opacity: 0;
    pointer-events: none;
    transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease;
}

.ai-floating-widget.active {
    transform: scale(1) translateY(0);
    opacity: 1;
    pointer-events: auto;
}

/* -------------------------------------------------------------------------
   Header (Solid Ocean Navy — #1e40af)
   ------------------------------------------------------------------------- */
.ai-widget-header {
    background: #1e40af;
    color: #ffffff;
    padding: 13px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 8px rgba(30, 64, 175, 0.2);
    flex-shrink: 0;
    border-bottom: 1px solid #1e3a8a;
}

.ai-head-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.ai-head-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid rgba(255, 255, 255, 0.85);
    background: rgba(255, 255, 255, 0.18);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    font-size: 19px;
    color: #ffffff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    flex-shrink: 0;
}

.ai-head-avatar .ai-head-status {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 10px;
    height: 10px;
    background: #10b981;
    border: 2px solid #ffffff;
    border-radius: 50%;
}

.ai-head-info h5 {
    font-size: 15px;
    font-weight: 700;
    color: #ffffff !important;
    margin: 0;
    line-height: 1.2;
    letter-spacing: 0.1px;
}

.ai-head-info span {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.88);
    font-weight: 500;
    display: block;
    margin-top: 1px;
}

.ai-head-actions {
    display: flex;
    align-items: center;
    gap: 5px;
}

.ai-head-btn {
    background: rgba(255, 255, 255, 0.18);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #ffffff;
    width: 28px;
    height: 28px;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 12px;
    transition: all 0.2s ease;
    padding: 0;
}

.ai-head-btn:hover {
    background: rgba(255, 255, 255, 0.32);
    color: #ffffff;
    transform: scale(1.06);
}

.ai-head-btn.btn-close-widget {
    font-size: 15px;
}

/* -------------------------------------------------------------------------
   Chat Body (Solid Clean Surface)
   ------------------------------------------------------------------------- */
.ai-widget-body {
    flex: 1;
    overflow-y: auto;
    padding: 14px 15px;
    background: #f8fafc;
    display: flex;
    flex-direction: column;
    gap: 11px;
    scroll-behavior: smooth;
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
}

.ai-widget-body::-webkit-scrollbar {
    width: 5px;
}
.ai-widget-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

/* Date / Time Timestamp Header (Centered) */
.ai-timestamp-divider {
    text-align: center;
    font-size: 11px;
    color: #64748b;
    font-weight: 600;
    margin: 2px 0 6px 0;
    user-select: none;
}

/* Assistant Message Bubble */
.ai-msg-group {
    display: flex;
    gap: 8px;
    align-items: flex-start;
    animation: aiFadeIn 0.25s ease forwards;
}

@keyframes aiFadeIn {
    from { opacity: 0; transform: translateY(6px); }
    to { opacity: 1; transform: translateY(0); }
}

.ai-msg-mini-avatar {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #2563eb;
    color: #ffffff;
    font-size: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
    box-shadow: 0 2px 5px rgba(37, 99, 235, 0.25);
}

.ai-msg-bubble-assistant {
    background: #ffffff;
    color: #1e293b;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 11px 13px;
    font-size: 12.5px;
    line-height: 1.55;
    box-shadow: 0 1px 3px rgba(45, 75, 122, 0.04);
    max-width: 90%;
    word-break: break-word;
    position: relative;
}

.ai-msg-bubble-assistant strong {
    color: #1e40af;
    font-weight: 700;
}

/* Suggestion Chips Container (Solid Royal Blue Rounded Pills) */
.ai-quick-chips-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 6.5px;
    margin: 4px 0 4px 0;
    animation: aiFadeIn 0.3s ease forwards;
}

.ai-quick-pill {
    background: #2563eb;
    color: #ffffff;
    border: 1px solid #1d4ed8;
    border-radius: 20px;
    padding: 6.5px 12.5px;
    font-size: 11.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-align: left;
    line-height: 1.3;
}

.ai-quick-pill:hover {
    background: #1d4ed8;
    transform: translateY(-1.5px);
    box-shadow: 0 4px 10px rgba(37, 99, 235, 0.32);
    color: #ffffff;
}

.ai-quick-pill:active {
    transform: scale(0.97);
}

/* User Message Bubble (Solid Royal Blue) */
.ai-msg-group.user {
    justify-content: flex-end;
}

.ai-msg-bubble-user {
    background: #2563eb;
    color: #ffffff;
    border-radius: 14px;
    border-bottom-right-radius: 3px;
    padding: 10px 14px;
    font-size: 12.5px;
    font-weight: 500;
    line-height: 1.5;
    box-shadow: 0 3px 8px rgba(37, 99, 235, 0.2);
    max-width: 85%;
    word-break: break-word;
}

/* Dynamic Assistant Output with Markdown */
.ai-msg-bubble-dynamic {
    background: #ffffff;
    color: #1e293b;
    border: 1px solid #e2e8f0;
    border-left: 3.5px solid #2563eb;
    border-radius: 12px;
    border-bottom-left-radius: 3px;
    padding: 12px 14px;
    font-size: 12.5px;
    line-height: 1.55;
    max-width: 90%;
    word-break: break-word;
    position: relative;
    box-shadow: 0 2px 8px rgba(45, 75, 122, 0.05);
}

.ai-btn-copy-bubble {
    position: absolute;
    top: 6px;
    right: 6px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    color: #1d4ed8;
    border-radius: 5px;
    padding: 2px 6px;
    font-size: 10px;
    font-weight: 600;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.ai-msg-bubble-dynamic:hover .ai-btn-copy-bubble {
    opacity: 1;
}

.ai-btn-copy-bubble:hover {
    background: #dbeafe;
    border-color: #93c5fd;
}

/* Markdown Rendering inside Bubble */
.ai-markdown-content h1,
.ai-markdown-content h2,
.ai-markdown-content h3,
.ai-markdown-content h4 {
    font-size: 13px;
    font-weight: 700;
    color: #1e40af;
    margin-top: 8px;
    margin-bottom: 4px;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 2px;
}
.ai-markdown-content h1:first-child,
.ai-markdown-content h2:first-child,
.ai-markdown-content h3:first-child {
    margin-top: 0;
}
.ai-markdown-content p {
    margin-bottom: 6px;
    color: #334155;
}
.ai-markdown-content p:last-child {
    margin-bottom: 0;
}
.ai-markdown-content ul,
.ai-markdown-content ol {
    margin-left: 16px;
    margin-bottom: 6px;
    padding-left: 0;
}
.ai-markdown-content li {
    margin-bottom: 3px;
    color: #334155;
}
.ai-markdown-content strong {
    color: #0f172a;
    font-weight: 700;
}
.ai-markdown-content blockquote {
    border-left: 3px solid #2563eb;
    background: #eff6ff;
    padding: 5px 9px;
    border-radius: 0 5px 5px 0;
    margin: 6px 0;
    color: #1e40af;
    font-size: 11.5px;
}

/* Typing Indicator Animation */
.ai-typing-wrap {
    display: none;
    gap: 8px;
    align-items: flex-start;
}
.ai-typing-wrap.active {
    display: flex;
}
.ai-typing-box {
    background: #eff6ff;
    border: 1px solid #dbeafe;
    border-radius: 12px;
    padding: 9px 12px;
    display: flex;
    align-items: center;
    gap: 4.5px;
}
.ai-typing-dot {
    width: 6px;
    height: 6px;
    background: #2563eb;
    border-radius: 50%;
    animation: aiBounceNavy 1.4s infinite ease-in-out both;
}
.ai-typing-dot:nth-child(1) { animation-delay: -0.32s; }
.ai-typing-dot:nth-child(2) { animation-delay: -0.16s; }
@keyframes aiBounceNavy {
    0%, 80%, 100% { transform: scale(0); opacity: 0.35; }
    40% { transform: scale(1); opacity: 1; }
}

/* -------------------------------------------------------------------------
   Footer & Input Box (Solid Clean Borders)
   ------------------------------------------------------------------------- */
.ai-widget-footer {
    padding: 10px 14px 12px 14px;
    background: #ffffff;
    border-top: 1px solid #e2e8f0;
    flex-shrink: 0;
    box-shadow: 0 -2px 10px rgba(45, 75, 122, 0.03);
}

.ai-input-container {
    border: 1.5px solid #2563eb;
    border-radius: 12px;
    padding: 7px 12px;
    display: flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    box-shadow: 0 1px 3px rgba(37, 99, 235, 0.08);
    transition: all 0.2s ease;
}

.ai-input-container:focus-within {
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.16);
    border-color: #1e40af;
}

.ai-input-field {
    border: none;
    outline: none;
    width: 100%;
    font-size: 12.5px;
    color: #1e293b;
    background: transparent;
    resize: none;
    min-height: 22px;
    max-height: 80px;
    font-family: inherit;
    line-height: 1.4;
    padding: 2px 0;
    scrollbar-width: thin;
}

.ai-input-field::placeholder {
    color: #94a3b8;
    font-size: 12.5px;
}

.ai-input-send-btn {
    background: none;
    border: none;
    color: #2563eb;
    font-size: 16px;
    cursor: pointer;
    padding: 3px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.ai-input-send-btn:hover:not(:disabled) {
    color: #1e40af;
    transform: scale(1.15);
}

.ai-input-send-btn:disabled {
    color: #cbd5e1;
    cursor: not-allowed;
    transform: none;
}

.ai-widget-disclaimer {
    font-size: 9.5px;
    color: #64748b;
    text-align: center;
    margin-top: 6px;
    margin-bottom: 0;
    line-height: 1.35;
    user-select: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}

/* -------------------------------------------------------------------------
   Mobile Responsiveness
   ------------------------------------------------------------------------- */
@media (max-width: 576px) {
    .ai-floating-launcher {
        bottom: 16px;
        right: 16px;
    }
    .ai-launcher-label {
        display: none !important;
    }
    .ai-floating-widget {
        bottom: 12px;
        right: 12px;
        left: 12px;
        width: auto;
        height: calc(100vh - 24px);
        max-height: calc(100vh - 24px);
        border-radius: 16px;
    }
}
</style>

<!-- Floating Trigger Button (Bottom Right) -->
<div class="ai-floating-launcher" id="aiFloatingLauncher" title="Tanya AI Asisten Terapi &amp; Klinis">
    <div class="ai-launcher-label d-none d-md-flex">
        <i class="fa-solid fa-sparkles text-warning mr-1"></i>
        <span>Tanya AI</span>
    </div>
    <button type="button" class="ai-launcher-btn" id="btnToggleAiWidget" aria-label="Buka Chat AI">
        <div class="ai-launcher-pulse"></div>
        <i class="fa-solid fa-robot" id="aiLauncherIcon"></i>
        <div class="ai-launcher-badge"></div>
    </button>
</div>

<!-- Floating Chat Window (Popup Box) -->
<div class="ai-floating-widget" id="aiFloatingWidget">
    
    <!-- Widget Header -->
    <div class="ai-widget-header">
        <div class="ai-head-left">
            <div class="ai-head-avatar">
                <i class="fa-solid fa-wand-magic-sparkles" style="color: #38bdf8;"></i>
                <div class="ai-head-status" title="AI Online"></div>
            </div>
            <div class="ai-head-info">
                <h5>AI Asisten Klinis</h5>
                <span>Omah Terapi-KU &bull; AI Chat Assistant</span>
            </div>
        </div>
        <div class="ai-head-actions">
            <button type="button" class="ai-head-btn" id="btnClearAiChat" title="Mulai Obrolan Baru">
                <i class="fa-solid fa-rotate-right"></i>
            </button>
            <button type="button" class="ai-head-btn btn-close-widget" id="btnCloseAiWidget" title="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    <!-- Widget Body -->
    <div class="ai-widget-body" id="aiChatBody">
        
        <!-- Timestamp Divider -->
        <div class="ai-timestamp-divider" id="aiTimeStamp">
            Hari ini, {{ date('H:i') }} WIB
        </div>

        <!-- Initial Welcome Messages (Avatar + Bubble) -->
        <div class="ai-msg-group assistant" id="aiWelcomeBubble1">
            <div class="ai-msg-mini-avatar">
                <i class="fa-solid fa-robot"></i>
            </div>
            <div class="ai-msg-bubble-assistant">
                Halo! Saya <strong>AI Asisten</strong> dari Omah Terapi-KU Dinas Sosial Provinsi Jawa Timur. Saya siap membantu Anda menganalisa kasus klinis, rekomendasi intervensi fisioterapi, terapi okupasi, wicara, sensori integrasi, hingga penyusunan Home Program untuk anak disabilitas.
            </div>
        </div>

        <div class="ai-msg-group assistant" id="aiWelcomeBubble2">
            <div class="ai-msg-mini-avatar">
                <i class="fa-solid fa-robot"></i>
            </div>
            <div class="ai-msg-bubble-assistant">
                Silakan pilih topik rekomendasi cepat di bawah ini atau ketik langsung pertanyaan klinis Anda:
            </div>
        </div>

        <!-- Suggestion Chips (Solid Royal Blue Pills) -->
        <div class="ai-quick-chips-wrap" id="aiQuickChipsWrap">
            <button type="button" class="ai-quick-pill" data-prompt="Berikan rekomendasi rencana intervensi fisioterapi untuk anak Cerebral Palsy spastik diplegia usia 4 tahun">
                <i class="fa-solid fa-person-walking mr-1"></i> Fisioterapi CP Spastik
            </button>
            <button type="button" class="ai-quick-pill" data-prompt="Apa saja tahapan dan ide stimulasi untuk anak Speech Delay (terlambat bicara) usia 3 tahun di klinik dan di rumah?">
                <i class="fa-solid fa-comments mr-1"></i> Stimulasi Speech Delay
            </button>
            <button type="button" class="ai-quick-pill" data-prompt="Berikan 3 ide modul program latihan rumahan (Home Program) untuk melatih kemandirian makan & memegang sendok anak disabilitas">
                <i class="fa-solid fa-house-chimney-medical mr-1"></i> Ide Home Program ADL
            </button>
            <button type="button" class="ai-quick-pill" data-prompt="Bagaimana strategi sensori integrasi taktil & vestibular untuk anak ASD yang hiper-reaktif terhadap sentuhan?">
                <i class="fa-solid fa-brain mr-1"></i> Sensori Integrasi ASD
            </button>
            <button type="button" class="ai-quick-pill" data-prompt="Bagaimana cara menentukan diagnosa fungsional dan target SOAP terapi okupasi untuk anak GDD?">
                <i class="fa-solid fa-file-medical mr-1"></i> Diagnosa Fungsional SOAP
            </button>
        </div>

        <!-- Dynamic Chat Content will be inserted here -->

        <!-- Typing Indicator -->
        <div class="ai-typing-wrap" id="aiTypingIndicator">
            <div class="ai-msg-mini-avatar">
                <i class="fa-solid fa-robot"></i>
            </div>
            <div class="ai-typing-box">
                <div class="ai-typing-dot"></div>
                <div class="ai-typing-dot"></div>
                <div class="ai-typing-dot"></div>
                <span class="text-muted ml-1" style="font-size: 11px; font-weight: 600; color: #1e40af !important;">Menganalisis kasus klinis...</span>
            </div>
        </div>

    </div>

    <!-- Widget Footer Input Form -->
    <div class="ai-widget-footer">
        <form id="aiChatForm" onsubmit="handleSendAiMessage(event)">
            <div class="ai-input-container">
                <textarea 
                    id="aiPromptInput" 
                    class="ai-input-field" 
                    rows="1" 
                    placeholder="Enter a message..." 
                    onkeydown="handleAiTextareaKey(event)"
                ></textarea>
                <button type="submit" class="ai-input-send-btn" id="btnSendAi" title="Kirim Pesan">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
            <p class="ai-widget-disclaimer">
                <i class="fa-solid fa-shield-halved text-primary mr-1"></i> Referensi klinis &amp; terapi Omah Terapi-KU Dinas Sosial Jatim &bull; Gemini AI
            </p>
        </form>
    </div>

</div>

<!-- Interactive JS Logic -->
<script>
var aiChatHistory = [];
var isAiGenerating = false;

function toggleAiAssistant() {
    var widget = document.getElementById('aiFloatingWidget');
    var icon = document.getElementById('aiLauncherIcon');
    if (!widget) return;

    if (widget.classList.contains('active')) {
        closeAiAssistant();
    } else {
        openAiAssistant();
    }
}

function openAiAssistant(initialPrompt = null) {
    var widget = document.getElementById('aiFloatingWidget');
    var icon = document.getElementById('aiLauncherIcon');
    if (widget) {
        widget.classList.add('active');
        if (icon) {
            icon.className = 'fa-solid fa-xmark';
        }
        var input = document.getElementById('aiPromptInput');
        if (input) {
            setTimeout(function() {
                input.focus();
                if (initialPrompt) {
                    input.value = initialPrompt;
                    handleSendAiMessage();
                }
            }, 250);
        }
    }
}

function closeAiAssistant() {
    var widget = document.getElementById('aiFloatingWidget');
    var icon = document.getElementById('aiLauncherIcon');
    if (widget) {
        widget.classList.remove('active');
        if (icon) {
            icon.className = 'fa-solid fa-robot';
        }
    }
}

function clearAiChat() {
    if (confirm('Mulai obrolan baru dan bersihkan riwayat chat saat ini?')) {
        aiChatHistory = [];
        var chatBody = document.getElementById('aiChatBody');
        var timeStamp = document.getElementById('aiTimeStamp');
        var b1 = document.getElementById('aiWelcomeBubble1');
        var b2 = document.getElementById('aiWelcomeBubble2');
        var chips = document.getElementById('aiQuickChipsWrap');
        var typing = document.getElementById('aiTypingIndicator');

        chatBody.innerHTML = '';
        if (timeStamp) chatBody.appendChild(timeStamp);
        if (b1) chatBody.appendChild(b1);
        if (b2) chatBody.appendChild(b2);
        if (chips) chatBody.appendChild(chips);
        if (typing) chatBody.appendChild(typing);

        var input = document.getElementById('aiPromptInput');
        if (input) {
            input.value = '';
            input.focus();
        }
    }
}

function handleAiTextareaKey(event) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        handleSendAiMessage(event);
    }
}

function renderFormattedMarkdown(text) {
    if (typeof marked !== 'undefined') {
        try {
            return marked.parse(text);
        } catch (e) {
            console.error(e);
        }
    }
    var escaped = text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
    
    escaped = escaped.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    return escaped.replace(/\n/g, '<br>');
}

function appendUserMessage(text) {
    var chatBody = document.getElementById('aiChatBody');
    var typing = document.getElementById('aiTypingIndicator');
    
    var div = document.createElement('div');
    div.className = 'ai-msg-group user';
    
    var escapedText = text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\n/g, '<br>');
    
    div.innerHTML = `<div class="ai-msg-bubble-user">${escapedText}</div>`;
    
    if (typing) {
        chatBody.insertBefore(div, typing);
    } else {
        chatBody.appendChild(div);
    }
    
    chatBody.scrollTop = chatBody.scrollHeight;
}

function appendAssistantMessage(rawText) {
    var chatBody = document.getElementById('aiChatBody');
    var typing = document.getElementById('aiTypingIndicator');
    
    var div = document.createElement('div');
    div.className = 'ai-msg-group assistant';
    
    var formattedHtml = renderFormattedMarkdown(rawText);
    
    div.innerHTML = `
        <div class="ai-msg-mini-avatar"><i class="fa-solid fa-robot"></i></div>
        <div class="ai-msg-bubble-dynamic">
            <button type="button" class="ai-btn-copy-bubble" onclick="copyAiText(this)" title="Salin Jawaban"><i class="fa-regular fa-copy mr-1"></i>Salin</button>
            <div class="ai-markdown-content">${formattedHtml}</div>
        </div>
    `;
    
    if (typing) {
        chatBody.insertBefore(div, typing);
    } else {
        chatBody.appendChild(div);
    }
    
    chatBody.scrollTop = chatBody.scrollHeight;
}

function copyAiText(btn) {
    var contentDiv = btn.closest('.ai-msg-bubble-dynamic').querySelector('.ai-markdown-content');
    if (contentDiv) {
        var text = contentDiv.innerText || contentDiv.textContent;
        navigator.clipboard.writeText(text).then(function() {
            btn.innerHTML = '<i class="fa-solid fa-check text-success mr-1"></i>Tersalin';
            setTimeout(function() {
                btn.innerHTML = '<i class="fa-regular fa-copy mr-1"></i>Salin';
            }, 2000);
        });
    }
}

function handleSendAiMessage(event) {
    if (event) event.preventDefault();
    if (isAiGenerating) return;

    var input = document.getElementById('aiPromptInput');
    var btnSend = document.getElementById('btnSendAi');
    var prompt = input ? input.value.trim() : '';

    if (!prompt) return;

    input.value = '';
    input.style.height = 'auto';

    appendUserMessage(prompt);

    var typing = document.getElementById('aiTypingIndicator');
    if (typing) typing.classList.add('active');
    
    var chatBody = document.getElementById('aiChatBody');
    if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;

    isAiGenerating = true;
    if (btnSend) btnSend.disabled = true;

    var csrfToken = document.querySelector('meta[name="csrf-token"]') 
        ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
        : '{{ csrf_token() }}';

    fetch('{{ route("ai.chat") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            prompt: prompt,
            history: aiChatHistory
        })
    })
    .then(function(res) {
        return res.json();
    })
    .then(function(data) {
        if (typing) typing.classList.remove('active');
        isAiGenerating = false;
        if (btnSend) btnSend.disabled = false;

        if (data.success && data.reply) {
            appendAssistantMessage(data.reply);
            aiChatHistory.push({ role: 'user', parts: [{ text: prompt }] });
            aiChatHistory.push({ role: 'model', parts: [{ text: data.reply }] });
        } else {
            var errMsg = data.message || 'Maaf, terjadi kendala teknis saat memproses jawaban.';
            appendAssistantMessage('<i class="fa-solid fa-circle-exclamation text-warning mr-1"></i> **Perhatian:** ' + errMsg);
        }
    })
    .catch(function(err) {
        console.error('AI Error:', err);
        if (typing) typing.classList.remove('active');
        isAiGenerating = false;
        if (btnSend) btnSend.disabled = false;
        appendAssistantMessage('<i class="fa-solid fa-circle-xmark text-danger mr-1"></i> **Gagal terhubung ke AI.** Silakan periksa koneksi internet Anda atau coba beberapa saat lagi.');
    });
}

document.addEventListener("DOMContentLoaded", function() {
    var launcher = document.getElementById('aiFloatingLauncher');
    if (launcher) {
        launcher.addEventListener('click', function(e) {
            e.preventDefault();
            toggleAiAssistant();
        });
    }

    var btnClose = document.getElementById('btnCloseAiWidget');
    if (btnClose) {
        btnClose.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeAiAssistant();
        });
    }

    var btnClear = document.getElementById('btnClearAiChat');
    if (btnClear) {
        btnClear.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            clearAiChat();
        });
    }

    var chips = document.querySelectorAll('.ai-quick-pill');
    chips.forEach(function(chip) {
        chip.addEventListener('click', function(e) {
            e.preventDefault();
            var prompt = this.getAttribute('data-prompt');
            if (prompt) {
                var input = document.getElementById('aiPromptInput');
                if (input) input.value = prompt;
                handleSendAiMessage();
            }
        });
    });

    var textarea = document.getElementById('aiPromptInput');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 80) + 'px';
        });
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAiAssistant();
        }
    });
});
</script>
