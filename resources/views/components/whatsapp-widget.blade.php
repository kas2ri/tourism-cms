@if(setting('whatsapp_widget_enabled', true))
    @php
        $rawPhone = setting('whatsapp_number', '+94771234567');
        $cleanPhone = preg_replace('/[^0-9]/', '', (string)$rawPhone);
        if (empty($cleanPhone)) {
            $cleanPhone = '94771234567';
        }
    @endphp

    <div class="fixed bottom-6 right-6 z-40" id="whatsapp-concierge-widget">
        <!-- Chatbox Container -->
        <div id="wa-chatbox" class="hidden mb-3 w-80 sm:w-88 bg-white rounded-3xl shadow-2xl border border-sand-200 overflow-hidden transform transition-all duration-300">
            <!-- Header -->
            <div class="bg-forest p-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-terracotta flex items-center justify-center font-bold text-white text-sm shadow-inner">
                            KH
                        </div>
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-400 rounded-full border-2 border-forest"></span>
                    </div>
                    <div>
                        <h5 class="text-sm font-bold tracking-tight">Kiyara Island Concierge</h5>
                        <p class="text-[10px] text-sand-200 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span>
                            Online &bull; Instant WhatsApp Response
                        </p>
                    </div>
                </div>
                <button type="button" onclick="window.toggleWhatsAppChat ? window.toggleWhatsAppChat() : null" class="text-sand-200 hover:text-white transition-colors p-1" aria-label="Close chat">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Chat Content Body -->
            <div class="p-4 bg-sand-50 space-y-3 max-h-80 overflow-y-auto text-xs text-stone-700">
                <!-- Welcome Bubble -->
                <div class="bg-white p-3 rounded-2xl shadow-xs border border-sand-200/80 max-w-[90%] leading-relaxed">
                    Ayubowan! &#128591; Welcome to Kiyara Holidays. Need personalized recommendations for seasons, boutique tea estates, or slow custom routes?
                </div>

                <!-- Sub-prompt Bubble -->
                <div class="bg-white p-3 rounded-2xl shadow-xs border border-sand-200/80 max-w-[90%] leading-relaxed">
                    Choose a quick topic below or type your inquiry to connect directly on WhatsApp:
                </div>

                <!-- 3 Quick-Prompt Chips -->
                <div class="pt-1 space-y-2">
                    <span class="block text-[10px] uppercase font-bold text-stone-400 tracking-wider">Quick Inquiries:</span>
                    
                    <button type="button" 
                            onclick="window.sendWhatsAppMessage ? window.sendWhatsAppMessage('Plan a custom Sri Lanka route') : null" 
                            class="w-full text-left px-3.5 py-2 bg-white hover:bg-forest hover:text-white rounded-xl text-stone-700 text-xs font-medium transition-all border border-sand-200/80 shadow-xs flex items-center justify-between group">
                        <span>Plan a custom Sri Lanka route</span>
                        <i class="fa-solid fa-arrow-right text-[11px] text-terracotta group-hover:text-white transition-colors"></i>
                    </button>

                    <button type="button" 
                            onclick="window.sendWhatsAppMessage ? window.sendWhatsAppMessage('Small group departure dates') : null" 
                            class="w-full text-left px-3.5 py-2 bg-white hover:bg-forest hover:text-white rounded-xl text-stone-700 text-xs font-medium transition-all border border-sand-200/80 shadow-xs flex items-center justify-between group">
                        <span>Small group departure dates</span>
                        <i class="fa-solid fa-arrow-right text-[11px] text-terracotta group-hover:text-white transition-colors"></i>
                    </button>

                    <button type="button" 
                            onclick="window.sendWhatsAppMessage ? window.sendWhatsAppMessage('Private driver & boutique stays') : null" 
                            class="w-full text-left px-3.5 py-2 bg-white hover:bg-forest hover:text-white rounded-xl text-stone-700 text-xs font-medium transition-all border border-sand-200/80 shadow-xs flex items-center justify-between group">
                        <span>Private driver & boutique stays</span>
                        <i class="fa-solid fa-arrow-right text-[11px] text-terracotta group-hover:text-white transition-colors"></i>
                    </button>
                </div>
            </div>

            <!-- Input Bar -->
            <div class="p-3 bg-white border-t border-sand-200 flex items-center gap-2">
                <label for="wa-input" class="sr-only">Type your trip question</label>
                <input type="text" 
                       id="wa-input" 
                       placeholder="Type your trip question..." 
                       onkeydown="if(event.key === 'Enter') { event.preventDefault(); window.sendWhatsAppMessage ? window.sendWhatsAppMessage() : null; }" 
                       class="flex-1 text-xs border border-stone-300 rounded-full px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-forest focus:border-transparent text-stone-800 placeholder-stone-400">
                <button type="button" 
                        onclick="window.sendWhatsAppMessage ? window.sendWhatsAppMessage() : null" 
                        class="w-9 h-9 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white flex items-center justify-center transition-all shrink-0 shadow-sm" 
                        aria-label="Send WhatsApp message"
                        title="Send via WhatsApp">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </div>
        </div>

        <!-- Main Floating WhatsApp Button -->
        <button type="button" 
                onclick="window.toggleWhatsAppChat ? window.toggleWhatsAppChat() : null" 
                class="w-14 h-14 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full shadow-2xl flex items-center justify-center text-2xl transition-all transform hover:scale-105 active:scale-95" 
                aria-label="Chat on WhatsApp"
                title="Chat with Ceylon Concierge">
            <i class="fa-brands fa-whatsapp"></i>
        </button>
    </div>

    <script>
        window.WHATSAPP_PHONE = '{{ $cleanPhone }}';
    </script>
@endif
