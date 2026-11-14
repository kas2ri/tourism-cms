<div id="itinerary-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-3 sm:p-6 overflow-y-auto">
    <div class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden my-auto max-h-[90vh] flex flex-col border border-sand-200">
        
        <!-- Modal Header -->
        <div class="relative bg-forest text-white p-6 sm:p-8 flex justify-between items-start">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-widest text-terracotta-light" id="modal-tour-tag">Small Group Departure</span>
                <h3 class="font-serif text-2xl sm:text-3xl font-bold mt-1 text-white" id="modal-tour-title">The Heritage & Cloud Highlands Trail</h3>
                <p class="text-xs sm:text-sm text-sand-200 mt-1" id="modal-tour-meta">10 Days / 9 Nights &bull; Max 10 Guests &bull; All-Inclusive Logistics</p>
            </div>
            <button type="button" onclick="window.closeItineraryModal ? window.closeItineraryModal() : null" class="text-white hover:text-terracotta text-2xl p-1 focus:outline-none" aria-label="Close itinerary details">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Body Content -->
        <div class="p-6 sm:p-8 overflow-y-auto space-y-6 flex-1 text-stone-800">
            
            <!-- Day by Day Accordion / Steps -->
            <div>
                <h4 class="font-serif text-xl font-bold text-forest mb-4">Curated Day-by-Day Flow</h4>
                <div class="space-y-4" id="modal-day-flow">
                    <!-- Populated dynamically by JavaScript -->
                </div>
            </div>

            <!-- Inclusions & Exclusions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-5 bg-sand-50 rounded-2xl border border-sand-200">
                <div>
                    <h5 class="text-xs font-bold uppercase tracking-wider text-forest mb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i> What’s Included
                    </h5>
                    <ul class="text-xs text-stone-600 space-y-1.5" id="modal-inclusions">
                        <li>&bull; Handpicked boutique hotels and heritage colonial bungalows</li>
                        <li>&bull; Private AC luxury vehicle & SLTDA certified driver-storyteller</li>
                        <li>&bull; Sigiriya Fortress & cultural monument entry tickets</li>
                        <li>&bull; Scenic 1st class train reservation tickets</li>
                        <li>&bull; Breakfast daily & featured village hearth feasts</li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-xs font-bold uppercase tracking-wider text-forest mb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-xmark text-stone-400"></i> What’s Not Included
                    </h5>
                    <ul class="text-xs text-stone-600 space-y-1.5">
                        <li>&bull; International flight tickets</li>
                        <li>&bull; Sri Lanka ETA travel visa fees</li>
                        <li>&bull; Discretionary driver and porter tips</li>
                        <li>&bull; Alcoholic drinks outside curated tastings</li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- Modal Footer -->
        <div class="bg-sand-100 p-4 sm:p-6 border-t border-sand-200 flex flex-wrap items-center justify-between gap-4">
            <div>
                <span class="text-xs text-stone-500 uppercase tracking-wider block">Starting Rate</span>
                <span class="text-2xl font-bold text-forest" id="modal-price">$2,150</span>
                <span class="text-xs text-stone-500">per person (twin share)</span>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="window.closeItineraryModal ? window.closeItineraryModal() : null" class="px-5 py-2.5 rounded-full border border-stone-300 text-xs font-bold text-stone-700 hover:bg-stone-200 transition-colors">
                    Back
                </button>
                <button type="button" onclick="window.bookThisTourFromModal ? window.bookThisTourFromModal() : null" class="px-6 py-2.5 rounded-full bg-terracotta hover:bg-terracotta-dark text-white text-xs font-bold uppercase tracking-wider shadow transition-colors">
                    Book / Inquire Dates
                </button>
            </div>
        </div>

    </div>
</div>

