<!-- =========================================================================
     AI ASISTEN PENERIMA MANFAAT & KELUARGA (OMAH TERAPI-KU x GOOGLE GEMINI)
     Floating Chatbot Widget — Pojok Kanan Bawah
     ========================================================================= -->
<style>
/* -------------------------------------------------------------------------
   Floating Action Trigger Button (Bottom Right)
   Theme: Solid Ocean Navy (#1e40af) & Royal Blue (#2563eb)
   ------------------------------------------------------------------------- */
.ai-portal-launcher {
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

.ai-portal-launcher-btn {
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

.ai-portal-launcher-btn:hover {
    transform: scale(1.08) translateY(-2px);
    background: #1e3a8a;
    box-shadow: 0 12px 30px rgba(30, 64, 175, 0.5), 0 4px 10px rgba(0, 0, 0, 0.12);
}

.ai-portal-launcher-btn:active {
    transform: scale(0.95);
}

.ai-portal-launcher-pulse {
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

.ai-portal-launcher-badge {
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

.ai-portal-launcher-label {
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

.ai-portal-launcher:hover .ai-portal-launcher-label {
    color: #2563eb;
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.2);
}

/* -------------------------------------------------------------------------
   Floating Chat Window Widget (Card Popup — Solid Theme)
   ------------------------------------------------------------------------- */
.ai-portal-widget {
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

.ai-portal-widget.active {
    transform: scale(1) translateY(0);
    opacity: 1;
    pointer-events: auto;
}

/* -------------------------------------------------------------------------
   Header (Solid Ocean Navy — #1e40af)
   ------------------------------------------------------------------------- */
.ai-portal-widget-header {
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

.ai-portal-head-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.ai-portal-head-avatar {
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

.ai-portal-head-avatar .ai-portal-head-status {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 10px;
    height: 10px;
    background: #10b981;
    border: 2px solid #ffffff;
    border-radius: 50%;
}

.ai-portal-head-info h5 {
    font-size: 15px;
    font-weight: 700;
    color: #ffffff !important;
    margin: 0;
    line-height: 1.2;
    letter-spacing: 0.1px;
}

.ai-portal-head-info span {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.88);
    font-weight: 500;
    display: block;
    margin-top: 1px;
}

.ai-portal-head-actions {
    display: flex;
    align-items: center;
    gap: 5px;
}

.ai-portal-head-btn {
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

.ai-portal-head-btn:hover {
    background: rgba(255, 255, 255, 0.32);
    color: #ffffff;
    transform: scale(1.06);
}

.ai-portal-head-btn.btn-close-widget {
    font-size: 15px;
}

/* -------------------------------------------------------------------------
   Chat Body (Solid Clean Surface)
   ------------------------------------------------------------------------- */
.ai-portal-widget-body {
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

.ai-portal-widget-body::-webkit-scrollbar {
    width: 5px;
}
.ai-portal-widget-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

/* Timestamp Header */
.ai-portal-timestamp-divider {
    text-align: center;
    font-size: 11px;
    color: #64748b;
    font-weight: 600;
    margin: 2px 0 6px 0;
    user-select: none;
}

/* Assistant Message Bubble */
.ai-portal-msg-group {
    display: flex;
    gap: 8px;
    align-items: flex-start;
    animation: aiFadeIn 0.25s ease forwards;
}

@keyframes aiFadeIn {
    from { opacity: 0; transform: translateY(6px); }
    to { opacity: 1; transform: translateY(0); }
}

.ai-portal-msg-mini-avatar {
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

.ai-portal-msg-bubble-assistant {
    background: #ffffff;
    color: #1e293b;
    border: 1px solid #e2e8f0;
    border-radius: 4px 14px 14px 14px;
    padding: 10px 13px;
    font-size: 12.5px;
    line-height: 1.5;
    max-width: 88%;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

/* User Message Bubble */
.ai-portal-msg-group.user {
    justify-content: flex-end;
}

.ai-portal-msg-bubble-user {
    background: #1e40af;
    color: #ffffff;
    border-radius: 14px 14px 4px 14px;
    padding: 10px 13px;
    font-size: 12.5px;
    line-height: 1.5;
    max-width: 84%;
    box-shadow: 0 3px 10px rgba(30, 64, 175, 0.25);
}

/* Dynamic Response Markdown Content */
.ai-portal-msg-bubble-dynamic {
    background: #ffffff;
    color: #1e293b;
    border: 1px solid #cbd5e1;
    border-radius: 4px 14px 14px 14px;
    padding: 11px 14px;
    font-size: 12.5px;
    line-height: 1.55;
    max-width: 88%;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    position: relative;
}

.ai-portal-btn-copy-bubble {
    position: absolute;
    top: 6px;
    right: 8px;
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    color: #475569;
    font-size: 10.5px;
    padding: 2px 7px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.2s ease;
}

.ai-portal-btn-copy-bubble:hover {
    background: #2563eb;
    color: #ffffff;
    border-color: #2563eb;
}

.ai-portal-markdown-content h1, 
.ai-portal-markdown-content h2, 
.ai-portal-markdown-content h3, 
.ai-portal-markdown-content h4 {
    font-size: 13.5px;
    font-weight: 700;
    color: #1e40af;
    margin: 8px 0 4px 0;
}

.ai-portal-markdown-content ul, 
.ai-portal-markdown-content ol {
    margin: 4px 0 6px 18px;
    padding: 0;
}

.ai-portal-markdown-content li {
    margin-bottom: 3px;
}

.ai-portal-markdown-content strong {
    color: #0f172a;
    font-weight: 700;
}

/* Suggestion Chips */
.ai-portal-quick-chips-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 6.5px;
    margin: 4px 0 4px 0;
    animation: aiFadeIn 0.3s ease forwards;
}

.ai-portal-quick-pill {
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
    gap: 7px;
    text-align: left;
    line-height: 1.3;
}

.ai-portal-quick-pill:hover {
    background: #1d4ed8;
    transform: translateY(-1.5px);
    box-shadow: 0 4px 10px rgba(37, 99, 235, 0.32);
    color: #ffffff;
}

.ai-portal-quick-pill:active {
    transform: scale(0.97);
}

.ai-portal-quick-pill i {
    color: #ffffff;
    margin-right: 6px;
    transition: color 0.2s ease;
}

.ai-portal-quick-pill:hover i {
    color: #ffffff;
}

/* Typing Indicator */
.ai-portal-typing-wrap {
    display: none;
    gap: 8px;
    align-items: center;
}

.ai-portal-typing-wrap.active {
    display: flex;
}

.ai-portal-typing-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 8px 12px;
    display: flex;
    align-items: center;
    gap: 4px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
}

.ai-portal-typing-dot {
    width: 6px;
    height: 6px;
    background: #2563eb;
    border-radius: 50%;
    animation: aiDotBlink 1.4s infinite ease-in-out both;
}

.ai-portal-typing-dot:nth-child(1) { animation-delay: -0.32s; }
.ai-portal-typing-dot:nth-child(2) { animation-delay: -0.16s; }

@keyframes aiDotBlink {
    0%, 80%, 100% { transform: scale(0.5); opacity: 0.4; }
    40% { transform: scale(1); opacity: 1; }
}

/* -------------------------------------------------------------------------
   Footer (Input Form Area)
   ------------------------------------------------------------------------- */
.ai-portal-widget-footer {
    padding: 10px 14px 12px 14px;
    background: #ffffff;
    border-top: 1px solid #e2e8f0;
    flex-shrink: 0;
    box-shadow: 0 -2px 10px rgba(45, 75, 122, 0.03);
}

.ai-portal-input-container {
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

.ai-portal-input-container:focus-within {
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.16);
    border-color: #1e40af;
}

.ai-portal-input-field {
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

.ai-portal-input-send-btn {
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

.ai-portal-input-send-btn:hover:not(:disabled) {
    color: #1e40af;
    transform: scale(1.15);
}

.ai-portal-input-send-btn:disabled {
    color: #cbd5e1;
    cursor: not-allowed;
    transform: none;
}

.ai-portal-widget-disclaimer {
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

@media (max-width: 576px) {
    .ai-portal-widget {
        right: 12px;
        left: 12px;
        bottom: 86px;
        width: auto;
        height: calc(100vh - 100px);
        max-height: calc(100vh - 100px);
    }
}
</style>

<!-- Script Marked Parser for Markdown -->
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<!-- Floating Trigger Button (Bottom Right) -->
<div class="ai-portal-launcher" id="aiPortalLauncher" title="Tanya AI Asisten Layanan &amp; Pendaftaran">
    <div class="ai-portal-launcher-label d-none d-md-flex">
        <i class="fa-solid fa-sparkles text-warning mr-1"></i>
        <span>Tanya AI</span>
    </div>
    <button type="button" class="ai-portal-launcher-btn" onclick="toggleAiPortalAssistant()" aria-label="Buka Chat AI Asisten">
        <div class="ai-portal-launcher-pulse"></div>
        <i class="fa-solid fa-robot" id="aiPortalLauncherIcon"></i>
        <div class="ai-portal-launcher-badge"></div>
    </button>
</div>

<!-- Floating Chat Window (Popup Box) -->
<div class="ai-portal-widget" id="aiPortalWidget">
    
    <!-- Widget Header -->
    <div class="ai-portal-widget-header">
        <div class="ai-portal-head-left">
            <div class="ai-portal-head-avatar">
                <i class="fa-solid fa-wand-magic-sparkles" style="color: #38bdf8;"></i>
                <div class="ai-portal-head-status" title="AI Online"></div>
            </div>
            <div class="ai-portal-head-info">
                <h5>AI Asisten Penerima Manfaat</h5>
                <span>Omah Terapi-KU &bull; AI Chat Assistant</span>
            </div>
        </div>
        <div class="ai-portal-head-actions">
            <button type="button" class="ai-portal-head-btn" onclick="clearAiPortalChat()" title="Mulai Obrolan Baru">
                <i class="fa-solid fa-rotate-right"></i>
            </button>
            <button type="button" class="ai-portal-head-btn btn-close-widget" onclick="closeAiPortalAssistant()" title="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    <!-- Widget Body -->
    <div class="ai-portal-widget-body" id="aiPortalChatBody">
        
        <!-- Timestamp Divider -->
        <div class="ai-portal-timestamp-divider" id="aiPortalTimeStamp">
            Hari ini, {{ date('H:i') }} WIB
        </div>

        <!-- Initial Welcome Messages -->
        <div class="ai-portal-msg-group assistant" id="aiPortalWelcome1">
            <div class="ai-portal-msg-mini-avatar">
                <i class="fa-solid fa-robot"></i>
            </div>
            <div class="ai-portal-msg-bubble-assistant">
                Halo! Saya <strong>AI Asisten Layanan &amp; Terapi</strong> dari Omah Terapi-KU Dinas Sosial Provinsi Jawa Timur. Saya siap membantu Anda (Orang Tua, Wali, &amp; Penerima Manfaat Baru) memberikan informasi seputar alur pendaftaran online, layanan terapi gratis, lacak verifikasi, hingga panduan tumbuh kembang anak disabilitas.
            </div>
        </div>

        <div class="ai-portal-msg-group assistant" id="aiPortalWelcome2">
            <div class="ai-portal-msg-mini-avatar">
                <i class="fa-solid fa-robot"></i>
            </div>
            <div class="ai-portal-msg-bubble-assistant">
                Silakan klik pertanyaan singkat di bawah ini atau ketik langsung pertanyaan Anda:
            </div>
        </div>

        <!-- Pertanyaan Singkat Khusus Penerima Manfaat Baru & Keluarga -->
        <div class="ai-portal-quick-chips-wrap" id="aiPortalQuickChips">
            <button type="button" class="ai-portal-quick-pill" onclick="sendAiPortalQuickPrompt(this)" data-prompt="Bagaimana syarat dan langkah alur pendaftaran penerima manfaat baru di Omah Terapi-KU Dinas Sosial Jawa Timur?">
                <i class="fa-solid fa-file-signature mr-2"></i> Syarat &amp; Alur Daftar Baru
            </button>
            <button type="button" class="ai-portal-quick-pill" onclick="sendAiPortalQuickPrompt(this)" data-prompt="Layanan terapi apa saja yang tersedia di Omah Terapi-KU (Fisioterapi, Terapi Okupasi, Terapi Wicara, Sensori Integrasi) dan apakah gratis?">
                <i class="fa-solid fa-hand-holding-medical mr-2"></i> Layanan Terapi Gratis
            </button>
            <button type="button" class="ai-portal-quick-pill" onclick="sendAiPortalQuickPrompt(this)" data-prompt="Apa saja tanda-tanda tumbuh kembang anak yang memerlukan intervensi fisioterapi, terapi okupasi, atau terapi wicara sejak dini?">
                <i class="fa-solid fa-child mr-2"></i> Tanda Anak Butuh Terapi
            </button>
            <button type="button" class="ai-portal-quick-pill" onclick="sendAiPortalQuickPrompt(this)" data-prompt="Bagaimana alur dan cara melakukan booking jadwal sesi terapi online untuk anak saya yang sudah terverifikasi?">
                <i class="fa-solid fa-calendar-check mr-2"></i> Cara Booking Sesi Terapi
            </button>
            <button type="button" class="ai-portal-quick-pill" onclick="sendAiPortalQuickPrompt(this)" data-prompt="Bagaimana cara mengecek atau melacak status verifikasi pendaftaran pendaftaran pasien dan mendapatkan No. Rekam Medis?">
                <i class="fa-solid fa-magnifying-glass-location mr-2"></i> Lacak Status Pendaftaran
            </button>
            <button type="button" class="ai-portal-quick-pill" onclick="sendAiPortalQuickPrompt(this)" data-prompt="Hal apa saja yang perlu disiapkan oleh orang tua sebelum mendampingi anak menjalani sesi terapi pertama kali di Omah Terapi-KU?">
                <i class="fa-solid fa-house-medical mr-2"></i> Persiapan Terapi Pertama
            </button>
        </div>

        <!-- Dynamic Chat Content -->

        <!-- Typing Indicator -->
        <div class="ai-portal-typing-wrap" id="aiPortalTypingIndicator">
            <div class="ai-portal-msg-mini-avatar">
                <i class="fa-solid fa-robot"></i>
            </div>
            <div class="ai-portal-typing-box">
                <div class="ai-portal-typing-dot"></div>
                <div class="ai-portal-typing-dot"></div>
                <div class="ai-portal-typing-dot"></div>
                <span class="text-muted ml-1" style="font-size: 11px; font-weight: 600; color: #1e40af !important;">AI sedang memproses jawaban...</span>
            </div>
        </div>

    </div>

    <!-- Widget Footer Input Form -->
    <div class="ai-portal-widget-footer">
        <form id="aiPortalChatForm" onsubmit="handleSendAiPortalMessage(event)">
            <div class="ai-portal-input-container">
                <textarea 
                    id="aiPortalPromptInput" 
                    class="ai-portal-input-field" 
                    rows="1" 
                    placeholder="Ketik pertanyaan Anda di sini..." 
                    onkeydown="handleAiPortalTextareaKey(event)"
                ></textarea>
                <button type="submit" class="ai-portal-input-send-btn" id="btnSendAiPortal" title="Kirim Pesan">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
            <p class="ai-portal-widget-disclaimer">
                <i class="fa-solid fa-shield-halved text-primary mr-1"></i> Informasi Layanan &amp; Terapi Omah Terapi-KU Dinas Sosial Jatim &bull; Gemini AI
            </p>
        </form>
    </div>

</div>

<!-- Interactive JS Logic -->
<script>
var aiPortalChatHistory = [];
var isAiPortalGenerating = false;

function toggleAiPortalAssistant() {
    var widget = document.getElementById('aiPortalWidget');
    if (!widget) return;

    if (widget.classList.contains('active')) {
        closeAiPortalAssistant();
    } else {
        openAiPortalAssistant();
    }
}

function openAiPortalAssistant(initialPrompt = null) {
    var widget = document.getElementById('aiPortalWidget');
    var icon = document.getElementById('aiPortalLauncherIcon');
    if (widget) {
        widget.classList.add('active');
        if (icon) {
            icon.className = 'fa-solid fa-xmark';
        }
        var input = document.getElementById('aiPortalPromptInput');
        if (input) {
            setTimeout(function() {
                input.focus();
                if (initialPrompt) {
                    input.value = initialPrompt;
                    handleSendAiPortalMessage();
                }
            }, 250);
        }
    }
}

function closeAiPortalAssistant() {
    var widget = document.getElementById('aiPortalWidget');
    var icon = document.getElementById('aiPortalLauncherIcon');
    if (widget) {
        widget.classList.remove('active');
        if (icon) {
            icon.className = 'fa-solid fa-robot';
        }
    }
}

function sendAiPortalQuickPrompt(btn) {
    var prompt = btn.getAttribute('data-prompt');
    if (!prompt) return;
    var input = document.getElementById('aiPortalPromptInput');
    if (input) {
        input.value = prompt;
        handleSendAiPortalMessage();
    }
}

function clearAiPortalChat() {
    if (confirm('Mulai obrolan baru dan bersihkan riwayat chat?')) {
        aiPortalChatHistory = [];
        var chatBody = document.getElementById('aiPortalChatBody');
        var timeStamp = document.getElementById('aiPortalTimeStamp');
        var w1 = document.getElementById('aiPortalWelcome1');
        var w2 = document.getElementById('aiPortalWelcome2');
        var chips = document.getElementById('aiPortalQuickChips');
        var typing = document.getElementById('aiPortalTypingIndicator');

        chatBody.innerHTML = '';
        if (timeStamp) chatBody.appendChild(timeStamp);
        if (w1) chatBody.appendChild(w1);
        if (w2) chatBody.appendChild(w2);
        if (chips) chatBody.appendChild(chips);
        if (typing) chatBody.appendChild(typing);

        var input = document.getElementById('aiPortalPromptInput');
        if (input) {
            input.value = '';
            input.focus();
        }
    }
}

function handleAiPortalTextareaKey(event) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        handleSendAiPortalMessage(event);
    }
}

function renderFormattedPortalMarkdown(text) {
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

function appendUserPortalMessage(text) {
    var chatBody = document.getElementById('aiPortalChatBody');
    var typing = document.getElementById('aiPortalTypingIndicator');
    
    var div = document.createElement('div');
    div.className = 'ai-portal-msg-group user';
    
    var escapedText = text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\n/g, '<br>');
    
    div.innerHTML = `<div class="ai-portal-msg-bubble-user">${escapedText}</div>`;
    
    if (typing) {
        chatBody.insertBefore(div, typing);
    } else {
        chatBody.appendChild(div);
    }
    
    chatBody.scrollTop = chatBody.scrollHeight;
}

function appendAssistantPortalMessage(rawText) {
    var chatBody = document.getElementById('aiPortalChatBody');
    var typing = document.getElementById('aiPortalTypingIndicator');
    
    var div = document.createElement('div');
    div.className = 'ai-portal-msg-group assistant';
    
    var formattedHtml = renderFormattedPortalMarkdown(rawText);
    
    div.innerHTML = `
        <div class="ai-portal-msg-mini-avatar"><i class="fa-solid fa-robot"></i></div>
        <div class="ai-portal-msg-bubble-dynamic">
            <button type="button" class="ai-portal-btn-copy-bubble" onclick="copyAiPortalText(this)" title="Salin Jawaban"><i class="fa-regular fa-copy mr-1"></i>Salin</button>
            <div class="ai-portal-markdown-content">${formattedHtml}</div>
        </div>
    `;
    
    if (typing) {
        chatBody.insertBefore(div, typing);
    } else {
        chatBody.appendChild(div);
    }
    
    chatBody.scrollTop = chatBody.scrollHeight;
}

function copyAiPortalText(btn) {
    var contentDiv = btn.closest('.ai-portal-msg-bubble-dynamic').querySelector('.ai-portal-markdown-content');
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

function handleSendAiPortalMessage(event) {
    if (event) event.preventDefault();
    if (isAiPortalGenerating) return;

    var input = document.getElementById('aiPortalPromptInput');
    var btnSend = document.getElementById('btnSendAiPortal');
    var prompt = input ? input.value.trim() : '';

    if (!prompt) return;

    input.value = '';
    input.style.height = 'auto';

    appendUserPortalMessage(prompt);

    var typing = document.getElementById('aiPortalTypingIndicator');
    if (typing) typing.classList.add('active');
    
    var chatBody = document.getElementById('aiPortalChatBody');
    if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;

    isAiPortalGenerating = true;
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
            history: aiPortalChatHistory
        })
    })
    .then(function(res) {
        return res.json();
    })
    .then(function(data) {
        if (typing) typing.classList.remove('active');
        isAiPortalGenerating = false;
        if (btnSend) btnSend.disabled = false;

        if (data.success && data.reply) {
            appendAssistantPortalMessage(data.reply);
            aiPortalChatHistory.push({ role: 'user', parts: [{ text: prompt }] });
            aiPortalChatHistory.push({ role: 'model', parts: [{ text: data.reply }] });
        } else {
            var errMsg = data.message || 'Maaf, terjadi kendala teknis saat memproses jawaban.';
            appendAssistantPortalMessage('<i class="fa-solid fa-circle-exclamation text-warning mr-1"></i> **Perhatian:** ' + errMsg);
        }
    })
    .catch(function(err) {
        console.error('AI Error:', err);
        if (typing) typing.classList.remove('active');
        isAiPortalGenerating = false;
        if (btnSend) btnSend.disabled = false;
        appendAssistantPortalMessage('<i class="fa-solid fa-circle-xmark text-danger mr-1"></i> **Gagal terhubung ke AI.** Silakan periksa koneksi internet Anda atau coba beberapa saat lagi.');
    });
}
</script>
