<div class="fixed bottom-6 right-6 z-40">
    <div id="wa-chatbox" class="hidden mb-3 w-80 bg-white rounded-3xl shadow-2xl border border-sand-200 overflow-hidden transform transition-all duration-300">
        <div class="bg-forest p-4 text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-terracotta flex items-center justify-center font-bold text-white text-sm">
                        KH
                    </div>
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-400 rounded-full border-2 border-forest"></span>
                </div>
                <div>
                    <h5 class="text-sm font-bold">Kiyara Island Concierge</h5>
                    <p class="text-[10px] text-sand-200">Online &bull; Typically replies in 5m</p>
                </div>
            </div>
            <button type="button" onclick="window.toggleWhatsAppChat ? window.toggleWhatsAppChat() : null" class="text-white hover:text-sand-200" aria-label="Close chat">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="p-4 bg-sand-50 space-y-3 max-h-64 overflow-y-auto text-xs text-stone-700">
            <div class="bg-white p-3 rounded-2xl shadow-sm border border-sand-200/60 max-w-[85%]">
                Ayubowan! &#128591; Welcome to Kiyara Holidays. Need recommendations for best season to visit Sri Lanka or customized route planning?
            </div>
            <div class="bg-white p-3 rounded-2xl shadow-sm border border-sand-200/60 max-w-[85%]">
                Tell us your travel dates and our founder or trip curator will help right away!
            </div>
        </div>

        <div class="p-3 bg-white border-t border-sand-200 flex gap-2">
            <input type="text" id="wa-input" placeholder="Type your trip question..." 
                   onkeydown="if(event.key === 'Enter') { event.preventDefault(); window.sendSimulatedWhatsApp(); }" 
                   class="flex-1 text-xs border border-stone-300 rounded-full px-4 py-2 focus:outline-none focus:border-forest">
            <button type="button" onclick="window.sendSimulatedWhatsApp ? window.sendSimulatedWhatsApp() : null" class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center hover:bg-emerald-700" aria-label="Send WhatsApp message">
                <i class="fa-solid fa-paper-plane text-xs"></i>
            </button>
        </div>
    </div>

    <!-- Main Floating WhatsApp Button -->
    <button type="button" onclick="window.toggleWhatsAppChat ? window.toggleWhatsAppChat() : null" class="w-14 h-14 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full shadow-2xl flex items-center justify-center text-2xl transition-all transform hover:scale-105 active:scale-95" aria-label="Chat on WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </button>
</div>

