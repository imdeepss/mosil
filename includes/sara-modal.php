<!-- Sarah Modal HTML & CSS & JS -->
<style>
    #evaModal {
        z-index: 999999 !important;
    }

    /* #evaModalContent {
        height: 75vh !important;
        min-height: 480px !important;
        max-height: 720px !important;
    } */

    #evaModal,
    #evaModal input,
    #evaModal button,
    #evaModal textarea,
    #evaModal select {
        font-family: 'Helvetica', Arial, sans-serif !important;
    }

    #evaModal code,
    #evaModal pre,
    #evaModal .font-mono {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace !important;
    }
</style>

<div id="evaModal" style="font-family: 'Helvetica', Arial, sans-serif;"
    class="fixed inset-0 z-[100] hidden flex-col items-center pt-[8vh] pb-4 px-4 bg-slate-900/60 backdrop-blur-md opacity-0 transition-opacity duration-500">
    <div class="relative w-full max-w-4xl bg-white/95 backdrop-blur-3xl rounded-[32px] shadow-[0_30px_60px_rgba(0,0,0,0.25),0_0_0_1px_rgba(255,255,255,0.8)] overflow-hidden flex flex-col transform scale-95 transition-all duration-500"
        id="evaModalContent">

        <!-- Modal Header -->
        <div
            class="bg-white/95 backdrop-blur-2xl p-6 flex items-center justify-between relative z-20 shadow-[0_4px_30px_rgba(0,0,0,0.03)] border-b border-white/40">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 relative overflow-hidden shadow-[0_8px_20px_rgba(244,195,0,0.25)] bg-gradient-to-tr from-primary to-primary-mid">
                    <img src="<?php echo SITE_URL; ?>/assets/icons/png/Sarah-ai-v3.png" alt="Sarah AI"
                        class="w-full h-full object-cover relative z-10">
                </div>
                <div class="flex flex-col shrink-0">
                    <span
                        class="text-[11px] font-black text-primary tracking-[0.25em] leading-none uppercase mb-1.5 opacity-90">Ask</span>
                    <span class="text-[22px] font-black text-main-green leading-none tracking-tight">Sarah</span>
                </div>
            </div>
            <!-- Close button inside header -->
            <button onclick="closeEvaModal()"
                class="w-11 h-11 bg-slate-50 border border-slate-200 rounded-full flex items-center justify-center text-slate-400 hover:text-main-green hover:bg-white hover:border-gray-300 hover:shadow-sm transition-all duration-300 group">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 group-hover:rotate-90 transition-transform duration-300" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body Area -->
        <div class="flex-1 relative bg-slate-50/90 overflow-hidden min-h-[450px]">
            <!-- Body / Trending Searches -->
            <div id="trendingSearches" class="absolute inset-0 md:p-10 p-5 transition-all duration-500 overflow-y-auto">
                <div
                    class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-primary-low/40 via-transparent to-transparent pointer-events-none">
                </div>

                <div class="flex items-center gap-3 mb-8 relative z-10">
                    <div class="w-8 h-8 rounded-full bg-primary-high flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary animate-pulse"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-main-green font-bold text-[17px] tracking-tight">Trending searches</h3>
                </div>

                <div class="flex flex-wrap gap-3 relative z-10 pb-4">
                    <?php
                    $trending = [
                        "High Temperature Grease",
                        "Food Grade Lubricants",
                        "Silicone Grease",
                        "Gear Oils",
                        "Chain Lubricants",
                        "Anti-Seize Compounds",
                        "Compressor Oils",
                        "Moly Paste",
                        "Synthetic Oils",
                        "Aerosol Sprays",
                        "Corrosion Preventives",
                        "Find MSDS",
                        "Product Selector Tool",
                        "Distributor Login",
                        "Request a Sample",
                        "O-Ring Compatibility",
                        "Bearing Lubrication Guide"
                    ];
                    foreach ($trending as $tag):
                        ?>
                        <button onclick="triggerChatbase('<?= htmlspecialchars($tag, ENT_QUOTES) ?>')"
                            class="px-5 py-2.5 bg-white border border-gray-100 rounded-2xl text-[13.5px] text-slate-600 font-medium hover:bg-main-green hover:text-primary hover:border-main-green shadow-sm hover:shadow-md transition-colors duration-300">
                            <?= $tag ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Body / Chat Interface -->
            <div id="chatInterface"
                class="hidden flex-col absolute inset-0 transition-all duration-500 bg-slate-50/90 z-20">
                <!-- Hidden element to force Tailwind CDN to generate dynamic classes -->
                <div
                    class="hidden bg-gradient-to-tr from-secondary to-main-green text-slate-800 animate-[slideInRight_0.4s_ease-out_forwards] animate-[slideInLeft_0.4s_ease-out_forwards] text-white">
                </div>

                <!-- Decorative ambient glows -->
                <div
                    class="absolute top-0 left-[-20%] w-96 h-96 bg-primary rounded-full mix-blend-multiply filter blur-[100px] opacity-[0.15] pointer-events-none">
                </div>
                <div
                    class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-main-green rounded-full mix-blend-multiply filter blur-[100px] opacity-[0.15] pointer-events-none">
                </div>

                <div class="flex-1 overflow-y-auto p-5 md:p-8 pb-12 flex flex-col scroll-smooth relative z-10 gap-6"
                    id="chatMessages">
                    <!-- Initial Welcome Message -->
                    <div class="flex justify-start chat-bubble-enter w-full">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-[#FFFCF2] to-[#FFF6D6] flex items-center justify-center shrink-0 mr-3 mt-1 shadow-[0_4px_12px_rgba(250,204,21,0.15)] border border-white relative overflow-hidden group">
                            <img src="<?php echo SITE_URL; ?>/assets/icons/png/Sarah-ai-v3.png" alt="Sarah AI"
                                class="w-full h-full object-cover relative z-20">
                        </div>
                        <div
                            class="bg-white/95 backdrop-blur-xl border border-slate-100 text-slate-700 rounded-[28px] rounded-tl-[8px] px-7 py-5 max-w-[90%] shadow-[0_12px_40px_rgba(0,0,0,0.06)] text-[16px] leading-[160%] font-normal">
                            Hello! I am Sarah, your intelligent assistant. How can I help you discover the perfect
                            lubrication solution today?
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer / Search Input -->
        <div
            class="bg-white/95 backdrop-blur-2xl p-5 px-6 flex items-center gap-3 relative z-30 border-t border-gray-100 shadow-[0_-10px_40px_rgba(0,0,0,0.03)]">
            <input type="text" placeholder="What can I help you find today?"
                class="flex-1 bg-slate-50 border border-slate-200 rounded-2xl h-[56px] outline-none text-main-green text-[17px] font-light placeholder:text-gray-400 px-5 w-full tracking-wide focus:bg-white focus:border-primary/50 transition-colors shadow-inner"
                autofocus id="evaSearchInput" oninput="toggleSendButton()"
                onkeydown="if(event.key === 'Enter') { event.preventDefault(); triggerChatbase(this.value); }">
            <button id="evaSendBtn" disabled onclick="triggerChatbase(document.getElementById('evaSearchInput').value)"
                class="w-[56px] h-[56px] flex items-center justify-center text-slate-400 bg-slate-50 border border-slate-200 hover:text-white hover:bg-gradient-to-r hover:from-primary hover:to-primary-mid hover:border-transparent hover:shadow-[0_8px_20px_rgba(244,195,0,0.3)] rounded-2xl transition-all duration-300 shrink-0 transform hover:scale-105 group disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:hover:bg-slate-50 disabled:hover:text-slate-400 disabled:hover:border-slate-200 disabled:hover:shadow-none">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 transform rotate-45 group-hover:rotate-0 transition-transform duration-300"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </div>
    </div>
</div>



<script>
    var sarahAutoTimer = null;

    function openEvaModal() {
        if (sarahAutoTimer) {
            clearTimeout(sarahAutoTimer);
            sarahAutoTimer = null;
        }
        try {
            sessionStorage.setItem('sarah_modal_handled', 'true');
        } catch (e) { }

        const modal = document.getElementById('evaModal');
        const content = document.getElementById('evaModalContent');
        const input = document.getElementById('evaSearchInput');

        // Prevent background scrolling
        document.body.style.overflow = 'hidden';

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
            input.focus();
        }, 10);
    }

    function closeEvaModal() {
        if (sarahAutoTimer) {
            clearTimeout(sarahAutoTimer);
            sarahAutoTimer = null;
        }
        try {
            sessionStorage.setItem('sarah_modal_handled', 'true');
        } catch (e) { }

        const modal = document.getElementById('evaModal');
        const content = document.getElementById('evaModalContent');

        // Restore background scrolling
        document.body.style.overflow = '';

        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 500);
    }

    // Auto-open Sarah AI popup after 1 minute for new tab/session
    document.addEventListener('DOMContentLoaded', function () {
        try {
            if (!sessionStorage.getItem('sarah_modal_handled')) {
                var sessionStart = sessionStorage.getItem('sarah_session_start');

                if (!sessionStart) {
                    sessionStart = Date.now();
                    sessionStorage.setItem('sarah_session_start', sessionStart);
                }

                var elapsed = Date.now() - parseInt(sessionStart, 10);
                var remaining = 5000 - elapsed; // 5 seconds

                if (remaining <= 0) {
                    openEvaModal();
                } else {
                    sarahAutoTimer = setTimeout(function () {
                        if (!sessionStorage.getItem('sarah_modal_handled')) {
                            openEvaModal();
                        }
                    }, remaining);
                }
            }
        } catch (e) { }
    });

    document.getElementById('evaModal').addEventListener('click', function (e) {
        if (e.target === this) closeEvaModal();
    });

    document.addEventListener('keydown', function (e) {
        const modal = document.getElementById('evaModal');
        if (modal.classList.contains('hidden')) return;

        if (e.key === 'Escape') {
            closeEvaModal();
            return;
        }

        if (e.key === 'Tab') {
            const focusableElements = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (focusableElements.length === 0) return;

            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];

            if (e.shiftKey) {
                if (document.activeElement === firstElement) {
                    lastElement.focus();
                    e.preventDefault();
                }
            } else {
                if (document.activeElement === lastElement) {
                    firstElement.focus();
                    e.preventDefault();
                }
            }
        }
    });

    let chatHistory = [];
    let isSending = false;

    async function triggerChatbase(query) {
        if (!query || !query.trim() || isSending) return;
        isSending = true;
        toggleSendButton();

        // Transition from Empty State to Chat View
        const emptyState = document.getElementById('trendingSearches');
        const chatBubbles = document.getElementById('chatMessages');

        if (!emptyState.classList.contains('hidden')) {
            emptyState.classList.add('opacity-0');
            setTimeout(() => {
                emptyState.classList.add('hidden');
                const chatInterface = document.getElementById('chatInterface');
                chatInterface.classList.remove('hidden');
                chatInterface.classList.add('flex');
            }, 300);
        } else {
            const chatInterface = document.getElementById('chatInterface');
            chatInterface.classList.remove('hidden');
            chatInterface.classList.add('flex');
        }

        const inputEl = document.getElementById('evaSearchInput');
        inputEl.value = '';
        toggleSendButton();

        // Add User Bubble (Refined Matte Green)
        const safeQuery = query.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        setTimeout(() => {
            chatBubbles.insertAdjacentHTML('beforeend', `
                <div class="flex justify-end chat-bubble-enter opacity-0 w-full">
                    <div class="bg-main-green text-white rounded-[28px] rounded-tr-[8px] px-7 py-4 max-w-[85%] sm:max-w-[75%] shadow-md border border-[#1A3B1B]">
                        <p class="text-[16px] font-medium leading-[150%] tracking-[0.2px]">${safeQuery}</p>
                    </div>
                </div>
            `);
            scrollToBottom(true);
        }, emptyState.classList.contains('hidden') ? 0 : 350);

        // Add Loading Bubble (Bento Style)
        const loaderId = 'loader_' + Date.now();
        setTimeout(() => {
            chatBubbles.insertAdjacentHTML('beforeend', `
                <div id="${loaderId}" class="flex justify-start chat-bubble-enter opacity-0 w-full">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#FFFCF2] to-[#FFF6D6] flex items-center justify-center shrink-0 mr-3 mt-1 shadow-[0_4px_12px_rgba(250,204,21,0.15)] border border-white relative overflow-hidden group">
                        <img src="<?php echo SITE_URL; ?>/assets/icons/png/Sarah-ai-v3.png" alt="Sarah AI" class="w-full h-full object-cover relative z-20">
                    </div>
                    <div class="bg-white/95 backdrop-blur-xl border border-slate-100 rounded-[28px] rounded-tl-[8px] px-7 py-5 max-w-[85%] flex items-center gap-2 shadow-[0_12px_40px_rgba(0,0,0,0.06)]">
                        <div class="w-2.5 h-2.5 rounded-full bg-primary animate-[dotBounce_1s_infinite]"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-primary animate-[dotBounce_1s_infinite_0.15s]"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-primary animate-[dotBounce_1s_infinite_0.3s]"></div>
                    </div>
                </div>
            `);
            scrollToBottom();
        }, emptyState.classList.contains('hidden') ? 250 : 600);

        chatHistory.push({ role: 'user', content: query });

        let currentConvId = null;
        try {
            currentConvId = sessionStorage.getItem('sarah_conversation_id');
        } catch (e) { }

        const requestPayload = { messages: chatHistory };
        if (currentConvId) {
            requestPayload.conversationId = currentConvId;
        }

        try {
            const response = await fetch(`<?php echo SITE_URL; ?>/ajax/chatbase.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(requestPayload)
            });

            const data = await response.json();
            const loaderEl = document.getElementById(loaderId);
            if (loaderEl) loaderEl.remove();

            if (data.error) {
                appendSarahResponse("Oops, I encountered an error: " + data.error);
            } else {
                if (data.conversationId) {
                    try {
                        sessionStorage.setItem('sarah_conversation_id', data.conversationId);
                    } catch (e) { }
                }
                appendSarahResponse(data.text);
                chatHistory.push({ role: 'assistant', content: data.text });
            }
        } catch (e) {
            const loaderEl = document.getElementById(loaderId);
            if (loaderEl) loaderEl.remove();
            appendSarahResponse("I am having trouble connecting to the server right now. Please check your network.");
        } finally {
            isSending = false;
            toggleSendButton();
            document.getElementById('evaSearchInput').focus();
        }
    }

    function appendSarahResponse(text) {
        let formattedText = text
            // Parse Markdown Links first
            .replace(/\[([^\]]+)\]\((https?:\/\/[^\s]+)\)/g, '%%LINK_START%%$2%%LINK_MID%%$1%%LINK_END%%')
            // Parse Bare URLs (ignoring already parsed ones)
            .replace(/(^|\s)(https?:\/\/[^\s<]+)/g, function (match, space, url) {
                // Remove trailing punctuation from URL if any
                let punctuation = '';
                if (url.match(/[.,;:!?)\]]$/)) {
                    punctuation = url.slice(-1);
                    url = url.slice(0, -1);
                }
                return space + '%%LINK_START%%' + url + '%%LINK_MID%%' + url + '%%LINK_END%%' + punctuation;
            })
            // Convert placeholders to styled HTML anchor tags
            .replace(/%%LINK_START%%(.*?)%%LINK_MID%%(.*?)%%LINK_END%%/g, '<a href="$1" target="_blank" class="inline-flex items-center gap-1.5 text-main-green font-bold hover:text-primary transition-colors underline underline-offset-4 decoration-primary/40 hover:decoration-primary break-all"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>$2</a>')
            // Standard markdown
            .replace(/### (.*?)(?:\n|$)/g, '<h3 class="text-lg font-bold text-slate-800 mt-4 mb-2">$1</h3>')
            .replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-slate-900">$1</strong>')
            .replace(/\*(.*?)\*/g, '<em class="italic text-slate-800">$1</em>')
            .replace(/```([\s\S]*?)```/g, '<pre class="bg-slate-800 text-slate-100 p-3 rounded-lg my-3 overflow-x-auto text-sm font-mono leading-relaxed"><code>$1</code></pre>')
            .replace(/`(.*?)`/g, '<code class="bg-slate-100/80 text-slate-800 px-1.5 py-0.5 rounded text-[13.5px] font-mono border border-slate-200/60">$1</code>')
            .replace(/\n/g, '<br>');

        const chatBubbles = document.getElementById('chatMessages');
        chatBubbles.insertAdjacentHTML('beforeend', `
            <div class="flex justify-start chat-bubble-enter opacity-0 w-full">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#FFFCF2] to-[#FFF6D6] flex items-center justify-center shrink-0 mr-3 mt-1 shadow-[0_4px_12px_rgba(250,204,21,0.15)] border border-white relative overflow-hidden group">
                    <img src="<?php echo SITE_URL; ?>/assets/icons/png/Sarah-ai-v3.png" alt="Sarah AI" class="w-full h-full object-cover relative z-20">
                </div>
                <div class="bg-white/95 backdrop-blur-xl border border-slate-100 text-slate-700 rounded-[28px] rounded-tl-[8px] px-7 py-5 max-w-[90%] shadow-[0_12px_40px_rgba(0,0,0,0.06)] text-[16px] leading-[160%] font-normal">
                    ${formattedText}
                </div>
            </div>
        `);
        scrollToBottom();
    }

    function toggleSendButton() {
        const inputEl = document.getElementById('evaSearchInput');
        const btn = document.getElementById('evaSendBtn');
        if (inputEl.value.trim() !== '' && !isSending) {
            btn.removeAttribute('disabled');
        } else {
            btn.setAttribute('disabled', 'true');
        }
    }

    function scrollToBottom(force = false) {
        const container = document.getElementById('chatMessages');

        const isNearBottom = container.scrollHeight - container.scrollTop <= container.clientHeight + 200;

        if (force || isNearBottom) {
            setTimeout(() => {
                container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
            }, 50);
        }
    }
</script>