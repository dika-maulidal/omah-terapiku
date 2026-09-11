<!-- =========================================================================
     AI ASISTEN KLINIS & TERAPI (OMAH TERAPI-KU x GOOGLE GEMINI)
     Standar Desain & Nuansa Warna Sesuai DESIGN.md (Royal Blue & Ocean Navy)
     ========================================================================= -->
<style>
/* -------------------------------------------------------------------------
   Backdrop & Drawer Container (Theme: Royal Blue & Ocean Navy)
   ------------------------------------------------------------------------- */
.ai-assistant-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(15, 23, 42, 0.6);
    z-index: 1050;
    display: none;
    opacity: 0;
    transition: opacity 0.25s ease;
}
.ai-assistant-backdrop.show {
    display: block;
    opacity: 1;
}

.ai-assistant-drawer {
    position: fixed;
    top: 0;
    right: -490px;
    width: 470px;
    max-width: 95vw;
    height: 100vh;
    background: #ffffff;
    z-index: 1060;
    box-shadow: -8px 0 32px rgba(45, 75, 122, 0.18);
    display: flex;
    flex-direction: column;
    transition: right 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif !important;
    border-left: 1px solid #E2E8F0;
}
.ai-assistant-drawer.open {
    right: 0;
}

/* -------------------------------------------------------------------------
   Header (Soft Blue Light - Clean & Elegant as per DESIGN.md)
   ------------------------------------------------------------------------- */
.ai-drawer-header {
    background: #edf3fc;
    color: #1e293b;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 8px rgba(45, 75, 122, 0.05);
    border-bottom: 1px solid #cbd5e1;
}
.ai-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.ai-avatar-wrap {
    position: relative;
    width: 40px;
    height: 40px;
    background: #dbeafe;
    border: 1.5px solid #bfdbfe;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
    color: #2563eb;
    box-shadow: 0 1px 4px rgba(37, 99, 235, 0.1);
}
.ai-status-dot {
    position: absolute;
    bottom: -2px;
    right: -2px;
    width: 11px;
    height: 11px;
    background: #10b981;
    border: 2px solid #ffffff;
    border-radius: 50%;
}
.ai-header-title h5 {
    color: #1e40af !important;
    font-size: 15px;
    font-weight: 700;
    margin: 0;
    line-height: 1.25;
    letter-spacing: 0.2px;
}
.ai-header-title span {
    font-size: 11.5px;
    color: #64748b;
    font-weight: 500;
    display: block;
    margin-top: 1px;
}
.ai-header-actions {
    display: flex;
    align-items: center;
    gap: 6px;
}
.ai-header-btn {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 13px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04);
}
.ai-header-btn:hover {
    background: #e2e8f0;
    color: #1e293b;
    border-color: #94a3b8;
    transform: scale(1.05);
}

/* -------------------------------------------------------------------------
   Chat Body & Ambient Surface
   ------------------------------------------------------------------------- */
.ai-drawer-body {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    background: #F1F5F9;
    background-image: radial-gradient(circle at 95% 5%, rgba(56, 165, 219, 0.05) 0%, transparent 45%),
                      radial-gradient(circle at 5% 90%, rgba(45, 75, 122, 0.04) 0%, transparent 45%);
    display: flex;
    flex-direction: column;
    gap: 14px;
    scroll-behavior: smooth;
}

/* -------------------------------------------------------------------------
   Welcome Card & Quick Prompt Chips (DESIGN.md Aligned)
   ------------------------------------------------------------------------- */
.ai-welcome-box {
    background: #ffffff;
    border: 1px solid #E2E8F0;
    border-top: 3.5px solid #2563eb;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 4px 18px rgba(45, 75, 122, 0.05);
}
.ai-welcome-title {
    font-size: 14px;
    font-weight: 700;
    color: #1e40af;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 7px;
}
.ai-welcome-desc {
    font-size: 12.5px;
    color: #475569;
    line-height: 1.5;
    margin-bottom: 12px;
}
.ai-pill-badge {
    display: inline-flex;
    align-items: center;
    padding: 3px 9px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    margin-right: 4px;
    margin-bottom: 5px;
    transition: transform 0.15s ease;
}
.ai-pill-badge.fisio { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
.ai-pill-badge.okupasi { background: #eef2ff; color: #3730a3; border: 1px solid #c7d2fe; }
.ai-pill-badge.wicara { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
.ai-pill-badge.sensori { background: #fefce8; color: #a16207; border: 1px solid #fef08a; }
.ai-pill-badge.home { background: #f0fdfa; color: #0f766e; border: 1px solid #99f6e4; }

.ai-quick-prompts-title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: #64748b;
    margin-top: 6px;
    margin-bottom: 8px;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 5px;
}
.ai-prompt-chip {
    display: flex;
    align-items: center;
    width: 100%;
    text-align: left;
    background: #ffffff;
    border: 1px solid #E2E8F0;
    color: #1e293b;
    padding: 8.5px 12px;
    border-radius: 9px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 6px;
    cursor: pointer;
    transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
    line-height: 1.35;
    box-shadow: 0 1px 3px rgba(45, 75, 122, 0.03);
}
.ai-prompt-chip i {
    flex-shrink: 0;
    font-size: 13px;
}
.ai-prompt-chip:hover {
    background: #eff6ff;
    border-color: #2563eb;
    color: #1e40af;
    transform: translateX(4px);
    box-shadow: 0 3px 10px rgba(37, 99, 235, 0.12);
}

/* -------------------------------------------------------------------------
   Chat Messages & Bubbles
   ------------------------------------------------------------------------- */
.ai-chat-item {
    display: flex;
    gap: 9px;
    max-width: 92%;
    animation: fadeInBubble 0.25s ease forwards;
}
@keyframes fadeInBubble {
    from { opacity: 0; transform: translateY(6px); }
    to { opacity: 1; transform: translateY(0); }
}

.ai-chat-item.user {
    align-self: flex-end;
    flex-direction: row-reverse;
}
.ai-chat-item.assistant {
    align-self: flex-start;
}

.ai-chat-avatar {
    width: 32px;
    height: 32px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13.5px;
    flex-shrink: 0;
}
.ai-chat-item.assistant .ai-chat-avatar {
    background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
    color: #ffffff;
    box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
}
.ai-chat-item.user .ai-chat-avatar {
    background: #e2e8f0;
    color: #1e40af;
}

.ai-chat-content {
    padding: 11px 14px;
    border-radius: 12px;
    font-size: 12.5px;
    line-height: 1.55;
    word-break: break-word;
    position: relative;
}
.ai-chat-item.user .ai-chat-content {
    background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
    color: #ffffff;
    border-bottom-right-radius: 2px;
    box-shadow: 0 3px 10px rgba(37, 99, 235, 0.2);
    font-weight: 500;
}
.ai-chat-item.assistant .ai-chat-content {
    background: #ffffff;
    color: #1e293b;
    border: 1px solid #E2E8F0;
    border-left: 3.5px solid #2563eb;
    border-bottom-left-radius: 2px;
    box-shadow: 0 3px 12px rgba(45, 75, 122, 0.05);
}

/* Markdown Rendering inside Assistant Chat */
.ai-rendered-markdown h1, 
.ai-rendered-markdown h2, 
.ai-rendered-markdown h3, 
.ai-rendered-markdown h4 {
    font-size: 13px;
    font-weight: 700;
    margin-top: 10px;
    margin-bottom: 4px;
    color: #1e40af;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 3px;
}
.ai-rendered-markdown h1:first-child,
.ai-rendered-markdown h2:first-child,
.ai-rendered-markdown h3:first-child {
    margin-top: 0;
}
.ai-rendered-markdown p {
    margin-bottom: 6px;
    color: #334155;
}
.ai-rendered-markdown p:last-child {
    margin-bottom: 0;
}
.ai-rendered-markdown ul, 
.ai-rendered-markdown ol {
    margin-left: 18px;
    margin-bottom: 6px;
    padding-left: 0;
}
.ai-rendered-markdown li {
    margin-bottom: 3.5px;
    color: #334155;
}
.ai-rendered-markdown strong {
    color: #0f172a;
    font-weight: 700;
}
.ai-rendered-markdown hr {
    margin: 8px 0;
    border: 0;
    border-top: 1px solid #e2e8f0;
}
.ai-rendered-markdown blockquote {
    border-left: 3px solid #2563eb;
    background: #eff6ff;
    padding: 6px 10px;
    border-radius: 0 6px 6px 0;
    margin: 6px 0;
    color: #1e40af;
    font-size: 12px;
}

/* Copy Action Button */
.ai-btn-copy {
    position: absolute;
    top: 6px;
    right: 6px;
    background: #f8fafc;
    border: 1px solid #E2E8F0;
    color: #1e40af;
    border-radius: 6px;
    padding: 2px 7px;
    font-size: 10.5px;
    font-weight: 600;
    cursor: pointer;
    opacity: 0;
    transition: all 0.2s ease;
}
.ai-chat-item.assistant:hover .ai-btn-copy {
    opacity: 1;
}
.ai-btn-copy:hover {
    background: #eff6ff;
    border-color: #bfdbfe;
    color: #1d4ed8;
}

/* -------------------------------------------------------------------------
   Typing Indicator Animation
   ------------------------------------------------------------------------- */
.ai-typing-indicator {
    display: none;
    align-self: flex-start;
    gap: 9px;
}
.ai-typing-indicator.active {
    display: flex;
}
.ai-typing-bubble {
    background: #ffffff;
    border: 1px solid #E2E8F0;
    border-left: 3.5px solid #2563eb;
    padding: 10px 14px;
    border-radius: 12px;
    border-bottom-left-radius: 2px;
    display: flex;
    align-items: center;
    gap: 5px;
    box-shadow: 0 2px 8px rgba(45, 75, 122, 0.04);
}
.ai-typing-dot {
    width: 6.5px;
    height: 6.5px;
    background: #2563eb;
    border-radius: 50%;
    animation: typingBounce 1.4s infinite ease-in-out both;
}
.ai-typing-dot:nth-child(1) { animation-delay: -0.32s; }
.ai-typing-dot:nth-child(2) { animation-delay: -0.16s; }
@keyframes typingBounce {
    0%, 80%, 100% { transform: scale(0); opacity: 0.35; }
    40% { transform: scale(1); opacity: 1; }
}

/* -------------------------------------------------------------------------
   Footer & Prompt Input Area (Modern Clean Card Style)
   ------------------------------------------------------------------------- */
.ai-drawer-footer {
    padding: 12px 16px 14px 16px;
    background: #ffffff;
    border-top: 1px solid #E2E8F0;
    box-shadow: 0 -2px 12px rgba(15, 23, 42, 0.04);
}

.ai-prompt-card {
    display: flex;
    flex-direction: column;
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 14px;
    padding: 10px 12px 8px 12px;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
}

.ai-prompt-card:focus-within {
    border-color: #2563eb;
    box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.12), 0 2px 8px rgba(37, 99, 235, 0.06);
    background: #ffffff;
}

.ai-prompt-textarea {
    width: 100%;
    border: none;
    background: transparent;
    resize: none;
    outline: none;
    font-size: 13px;
    font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif !important;
    line-height: 1.5;
    min-height: 38px;
    max-height: 120px;
    color: #1e293b;
    padding: 0;
    margin-bottom: 6px;
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
}

.ai-prompt-textarea::-webkit-scrollbar {
    width: 4px;
}

.ai-prompt-textarea::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.ai-prompt-textarea::placeholder {
    color: #94a3b8;
    font-size: 12.5px;
}

.ai-prompt-action-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    padding-top: 4px;
    border-top: 1px solid #f1f5f9;
}

.ai-prompt-hints {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: #94a3b8;
    user-select: none;
}

.ai-key-hint,
.ai-key-hint-sub {
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

.ai-key-hint kbd,
.ai-key-hint-sub kbd {
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    border-radius: 4px;
    padding: 1px 4px;
    font-size: 9.5px;
    font-family: inherit;
    font-weight: 600;
    color: #475569;
    box-shadow: 0 1px 0 rgba(0, 0, 0, 0.08);
}

.ai-btn-submit {
    background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
    color: #ffffff;
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.18s ease;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(37, 99, 235, 0.28);
    font-size: 12.5px;
}

.ai-btn-submit:hover:not(:disabled) {
    transform: scale(1.08);
    background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%);
    box-shadow: 0 4px 10px rgba(37, 99, 235, 0.38);
}

.ai-btn-submit:disabled {
    opacity: 0.45;
    cursor: not-allowed;
    transform: none;
}

.ai-footer-disclaimer {
    font-size: 11px;
    color: #64748b;
    text-align: center;
    margin-top: 8px;
    margin-bottom: 0;
    line-height: 1.35;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}

@media (max-width: 576px) {
    .ai-prompt-hints .ai-key-hint-sub {
        display: none !important;
    }
    .ai-drawer-footer {
        padding: 10px 12px 12px 12px;
    }
}

/* -------------------------------------------------------------------------
   Navbar Button "Tanya AI" (DESIGN.md Primary Palette)
   ------------------------------------------------------------------------- */
.btn-tanya-ai {
    background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%) !important;
    color: #ffffff !important;
    border: 1px solid rgba(255, 255, 255, 0.28) !important;
    border-radius: 24px !important;
    padding: 7px 15px !important;
    font-size: 12.5px !important;
    font-weight: 700 !important;
    letter-spacing: 0.2px !important;
    box-shadow: 0 3px 10px rgba(37, 99, 235, 0.25) !important;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
    cursor: pointer;
    text-decoration: none !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 7px !important;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
}
.btn-tanya-ai:hover {
    background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%) !important;
    transform: translateY(-1.5px) !important;
    box-shadow: 0 5px 14px rgba(37, 99, 235, 0.38) !important;
    color: #ffffff !important;
}
.ai-agent-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #38bdf8;
    font-size: 14px;
    filter: drop-shadow(0 0 3px rgba(56, 189, 248, 0.6));
    animation: robotGlow 2.8s infinite ease-in-out;
}
@keyframes robotGlow {
    0%, 100% { transform: scale(1); filter: drop-shadow(0 0 3px rgba(56, 189, 248, 0.5)); }
    50% { transform: scale(1.14); filter: drop-shadow(0 0 7px rgba(56, 189, 248, 0.9)); color: #7dd3fc; }
}
@media (max-width: 767.98px) {
    .ai-btn-text,
    .ai-btn-badge {
        display: none !important;
    }
    .btn-tanya-ai {
        width: 38px !important;
        height: 38px !important;
        min-width: 38px !important;
        padding: 0 !important;
        border-radius: 50% !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 0 !important;
    }
    .btn-tanya-ai .ai-agent-icon {
        font-size: 16px !important;
        margin: 0 !important;
    }
}
</style>

<!-- Backdrop Overlay -->
<div class="ai-assistant-backdrop" id="aiAssistantBackdrop"></div>

<!-- Slide-Over Drawer Container -->
<div class="ai-assistant-drawer" id="aiAssistantDrawer">
    
    <!-- Drawer Header -->
    <div class="ai-drawer-header">
        <div class="ai-header-left">
            <div class="ai-avatar-wrap">
                <i class="fa-solid fa-robot"></i>
                <div class="ai-status-dot" title="AI Asisten Aktif"></div>
            </div>
            <div class="ai-header-title">
                <h5>AI Asisten Terapi & Klinis</h5>
                <span>Omah Terapi-KU &bull; Konsultan Medis</span>
            </div>
        </div>
        <div class="ai-header-actions">
            <button type="button" class="ai-header-btn" id="btnClearAiChat" title="Mulai Obrolan Baru">
                <i class="fa-solid fa-rotate-right"></i>
            </button>
            <button type="button" class="ai-header-btn" id="btnCloseAiDrawer" title="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    <!-- Drawer Chat Body -->
    <div class="ai-drawer-body" id="aiChatBody">
        
        <!-- Welcome Card -->
        <div class="ai-welcome-box" id="aiWelcomeBox">
            <div class="ai-welcome-title">
                Halo, Rekan Terapis & Medis!
            </div>
            <div class="ai-welcome-desc">
                Saya adalah asisten klinis cerdas khusus <strong>Omah Terapi-KU</strong>. Saya siap membantu Anda merumuskan rekomendasi intervensi terapi, diagnosa fungsional, dan penyusunan program latihan rumahan.
            </div>

            <div class="ai-quick-prompts-title">
                Rekomendasi Pertanyaan Cepat:
            </div>
            <button type="button" class="ai-prompt-chip" data-prompt="Berikan rekomendasi rencana intervensi fisioterapi untuk anak Cerebral Palsy spastik diplegia usia 4 tahun">
                Rencana fisioterapi anak CP spastik diplegia 4 tahun
            </button>
            <button type="button" class="ai-prompt-chip" data-prompt="Apa saja tahapan dan ide stimulasi untuk anak Speech Delay (terlambat bicara) usia 3 tahun di klinik dan di rumah?">
                Ide stimulasi Speech Delay usia 3 tahun
            </button>
            <button type="button" class="ai-prompt-chip" data-prompt="Berikan 3 ide modul program latihan rumahan (Home Program) untuk melatih kemandirian makan & memegang sendok anak disabilitas">
                3 Ide Home Program melatih memegang sendok
            </button>
            <button type="button" class="ai-prompt-chip" data-prompt="Bagaimana strategi sensori integrasi taktil & vestibular untuk anak ASD yang hiper-reaktif terhadap sentuhan?">
                Strategi Sensori Integrasi untuk anak ASD
            </button>
        </div>

        <!-- Dynamic Chat Messages will be appended here -->

        <!-- Typing Indicator -->
        <div class="ai-typing-indicator" id="aiTypingIndicator">
            <div class="ai-chat-avatar" style="background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%); color: #fff; width: 32px; height: 32px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 13.5px;">
                <i class="fa-solid fa-robot"></i>
            </div>
            <div class="ai-typing-bubble">
                <div class="ai-typing-dot"></div>
                <div class="ai-typing-dot"></div>
                <div class="ai-typing-dot"></div>
                <span class="text-muted ml-1" style="font-size: 11.5px; font-weight: 500;">Menganalisa kasus klinis...</span>
            </div>
        </div>

    </div>

    <!-- Drawer Footer Input -->
    <div class="ai-drawer-footer">
        <form id="aiChatForm" onsubmit="handleSendAiMessage(event)">
            <div class="ai-prompt-card">
                <textarea 
                    id="aiPromptInput" 
                    class="ai-prompt-textarea" 
                    rows="1" 
                    placeholder="Tanyakan rekomendasi terapi, SOAP, atau kasus klinis..."
                    onkeydown="handleAiTextareaKey(event)"
                ></textarea>
                <div class="ai-prompt-action-bar">
                    <div class="ai-prompt-hints">
                        <span class="ai-key-hint"><kbd>Enter</kbd> kirim</span>
                        <span class="ai-key-hint-sub"><kbd>Shift+Enter</kbd> baris baru</span>
                    </div>
                    <button type="submit" class="ai-btn-submit" id="btnSendAi" title="Kirim Pertanyaan">
                        <i class="fa-solid fa-arrow-up"></i>
                    </button>
                </div>
            </div>
            <div class="ai-footer-disclaimer">
                <i class="fa-solid fa-shield-halved text-primary mr-1"></i> Khusus referensi klinis &amp; konsultasi terapi di Omah Terapi-KU Jawa Timur.
            </div>
        </form>
    </div>

</div>

<!-- Interactive JS Logic -->
<script>
var aiChatHistory = [];
var isAiGenerating = false;

function openAiAssistant(initialPrompt = null) {
    var drawer = document.getElementById('aiAssistantDrawer');
    var backdrop = document.getElementById('aiAssistantBackdrop');
    if (drawer && backdrop) {
        backdrop.classList.add('show');
        drawer.classList.add('open');
        var input = document.getElementById('aiPromptInput');
        if (input) {
            setTimeout(function() {
                input.focus();
                if (initialPrompt) {
                    input.value = initialPrompt;
                    handleSendAiMessage();
                }
            }, 300);
        }
    }
}

function closeAiAssistant() {
    var drawer = document.getElementById('aiAssistantDrawer');
    var backdrop = document.getElementById('aiAssistantBackdrop');
    if (drawer && backdrop) {
        drawer.classList.remove('open');
        backdrop.classList.remove('show');
    }
}

function clearAiChat() {
    if (confirm('Mulai obrolan baru dan bersihkan riwayat chat saat ini?')) {
        aiChatHistory = [];
        var chatBody = document.getElementById('aiChatBody');
        var welcomeBox = document.getElementById('aiWelcomeBox');
        var typing = document.getElementById('aiTypingIndicator');
        
        chatBody.innerHTML = '';
        if (welcomeBox) chatBody.appendChild(welcomeBox);
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
    // Fallback format sederhana jika marked belum termuat
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
    div.className = 'ai-chat-item user';
    
    var escapedText = text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\n/g, '<br>');
    
    div.innerHTML = `
        <div class="ai-chat-avatar"><i class="fa-solid fa-user"></i></div>
        <div class="ai-chat-content">${escapedText}</div>
    `;
    
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
    div.className = 'ai-chat-item assistant';
    
    var formattedHtml = renderFormattedMarkdown(rawText);
    
    div.innerHTML = `
        <div class="ai-chat-avatar"><i class="fa-solid fa-robot"></i></div>
        <div class="ai-chat-content">
            <button type="button" class="ai-btn-copy" onclick="copyAiText(this)" title="Salin Jawaban"><i class="fa-regular fa-copy mr-1"></i>Salin</button>
            <div class="ai-rendered-markdown">${formattedHtml}</div>
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
    var contentDiv = btn.closest('.ai-chat-content').querySelector('.ai-rendered-markdown');
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
    var btnOpen = document.getElementById('btnOpenAiAssistant');
    if (btnOpen) {
        btnOpen.addEventListener('click', function(e) {
            e.preventDefault();
            openAiAssistant();
        });
    }

    var btnClose = document.getElementById('btnCloseAiDrawer');
    if (btnClose) {
        btnClose.addEventListener('click', function() {
            closeAiAssistant();
        });
    }

    var backdrop = document.getElementById('aiAssistantBackdrop');
    if (backdrop) {
        backdrop.addEventListener('click', function() {
            closeAiAssistant();
        });
    }

    var btnClear = document.getElementById('btnClearAiChat');
    if (btnClear) {
        btnClear.addEventListener('click', function() {
            clearAiChat();
        });
    }

    var chips = document.querySelectorAll('.ai-prompt-chip');
    chips.forEach(function(chip) {
        chip.addEventListener('click', function() {
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
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });
    }
});
</script>
