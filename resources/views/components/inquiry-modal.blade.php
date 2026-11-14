<div id="inquiry-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-3 sm:p-6 overflow-y-auto">
    <div class="bg-white w-full max-w-xl rounded-3xl shadow-2xl overflow-hidden my-auto border border-sand-200">
        
        <div class="bg-forest text-white p-6 flex justify-between items-center">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-terracotta-light">Direct Island Specialist</span>
                <h3 class="font-serif text-2xl font-bold mt-1">Design Your Ceylon Journey</h3>
            </div>
            <button type="button" onclick="window.closeInquiryModal ? window.closeInquiryModal() : null" class="text-white hover:text-terracotta text-2xl focus:outline-none" aria-label="Close inquiry modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form onsubmit="window.handleInquirySubmit ? window.handleInquirySubmit(event) : null" method="POST" action="{{ route('inquiries.store') }}" class="p-6 space-y-4 text-xs text-stone-800">
            @csrf
            <input type="hidden" id="inquiry-context" name="context" value="General">
            <input type="hidden" id="inquiry-duration" name="duration_days" value="10">
            <input type="hidden" id="inquiry-cost" name="estimated_cost_usd" value="1900">
            <input type="hidden" id="inquiry-tier" name="tier" value="boutique">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="inquiry-name" class="block font-bold text-stone-700 mb-1">Your Full Name *</label>
                    <input type="text" id="inquiry-name" name="name" required placeholder="e.g. Eleanor Vance" class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">
                </div>
                <div>
                    <label for="inquiry-email" class="block font-bold text-stone-700 mb-1">Email Address *</label>
                    <input type="email" id="inquiry-email" name="email" required placeholder="e.g. eleanor@example.com" class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="inquiry-phone" class="block font-bold text-stone-700 mb-1">WhatsApp / Phone Number</label>
                    <input type="tel" id="inquiry-phone" name="phone" placeholder="+44 7700 900077" class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">
                </div>
                <div>
                    <label for="inquiry-season" class="block font-bold text-stone-700 mb-1">Estimated Travel Window</label>
                    <select id="inquiry-season" name="preferred_season" class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm bg-white">
                        <option>November 2025 - January 2026</option>
                        <option>February 2026 - April 2026</option>
                        <option>May 2026 - August 2026</option>
                        <option>Late 2026 / 2027</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="inquiry-guests" class="block font-bold text-stone-700 mb-1">Number of Travelers</label>
                    <select id="inquiry-guests" name="guests" class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm bg-white">
                        <option value="1">1 (Solo traveler)</option>
                        <option value="2" selected>2 (Couple / Pair)</option>
                        <option value="4">3 - 5 (Small family or friends)</option>
                        <option value="6">6+ (Private Group)</option>
                    </select>
                </div>
                <div>
                    <label for="inquiry-style" class="block font-bold text-stone-700 mb-1">Preferred Trip Style</label>
                    <select id="inquiry-style" name="travel_type" class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm bg-white">
                        <option>Small Group Departure</option>
                        <option selected>Tailor-Made Private Chauffeured</option>
                        <option>Ayurveda & Soul Retreat</option>
                        <option>Honeymoon & Luxury Romance</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="inquiry-notes" class="block font-bold text-stone-700 mb-1">Tell us your wishes, pace, or special interests</label>
                <textarea id="inquiry-notes" name="notes" rows="3" placeholder="e.g. We love tea hill walks, boutique hotels, quiet beaches, and want to avoid tourist crowds..." class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm"></textarea>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3.5 bg-terracotta hover:bg-terracotta-dark text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md">
                    Send My Travel Request to Founder
                </button>
                <p class="text-center text-[10px] text-stone-400 mt-2">Zero obligations. You will receive a personalized handcrafted draft within 24 hours.</p>
            </div>

        </form>

    </div>
</div>

