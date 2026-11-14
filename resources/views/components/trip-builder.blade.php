<section id="trip-builder" class="py-24 bg-sand-100 border-y border-sand-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs uppercase tracking-[0.25em] text-terracotta font-bold">Interactive Planner</span>
            <h2 class="font-serif text-3xl sm:text-5xl font-bold text-forest mt-2">Design & Estimate Your Journey</h2>
            <p class="text-stone-600 mt-3 text-sm sm:text-base">Toggle your travel preferences below to calculate an instant estimated budget range for your customized Ceylon expedition.</p>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-lg border border-sand-200">
            
            <!-- Step 1: Traveling Party -->
            <div class="mb-8">
                <label class="block text-xs font-bold uppercase tracking-wider text-forest mb-3">1. Who is traveling with you?</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3" id="builder-party">
                    <button type="button" onclick="window.selectParty ? window.selectParty('solo', 1, this) : null" class="builder-btn active p-4 rounded-2xl border-2 border-terracotta bg-sand-50/50 text-left transition-all">
                        <i class="fa-solid fa-user text-terracotta text-lg mb-2 block"></i>
                        <span class="font-bold text-sm block text-forest">Solo Adventurer</span>
                        <span class="text-xs text-stone-500">1 Traveler</span>
                    </button>
                    <button type="button" onclick="window.selectParty ? window.selectParty('couple', 2, this) : null" class="builder-btn p-4 rounded-2xl border-2 border-stone-200 hover:border-forest text-left transition-all">
                        <i class="fa-solid fa-heart text-stone-600 text-lg mb-2 block"></i>
                        <span class="font-bold text-sm block text-forest">Couple / Pair</span>
                        <span class="text-xs text-stone-500">2 Travelers</span>
                    </button>
                    <button type="button" onclick="window.selectParty ? window.selectParty('family', 4, this) : null" class="builder-btn p-4 rounded-2xl border-2 border-stone-200 hover:border-forest text-left transition-all">
                        <i class="fa-solid fa-people-group text-stone-600 text-lg mb-2 block"></i>
                        <span class="font-bold text-sm block text-forest">Family Tribe</span>
                        <span class="text-xs text-stone-500">3 - 5 Travelers</span>
                    </button>
                    <button type="button" onclick="window.selectParty ? window.selectParty('friends', 6, this) : null" class="builder-btn p-4 rounded-2xl border-2 border-stone-200 hover:border-forest text-left transition-all">
                        <i class="fa-solid fa-users-rays text-stone-600 text-lg mb-2 block"></i>
                        <span class="font-bold text-sm block text-forest">Friends Group</span>
                        <span class="text-xs text-stone-500">6+ Travelers</span>
                    </button>
                </div>
            </div>

            <!-- Step 2: Trip Duration Slider -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-forest">2. How many days would you like to explore?</label>
                    <span class="text-base font-bold text-terracotta" id="duration-val">10 Days</span>
                </div>
                <input type="range" id="builder-days" min="5" max="21" value="10" step="1" 
                       oninput="window.updateDuration ? window.updateDuration(this.value) : null" 
                       class="w-full h-2 bg-sand-200 rounded-lg appearance-none cursor-pointer accent-terracotta">
                <div class="flex justify-between text-[11px] text-stone-400 mt-1">
                    <span>5 Days (Express Focus)</span>
                    <span>10-12 Days (Ideal Island Loop)</span>
                    <span>21 Days (Slow Immersion)</span>
                </div>
            </div>

            <!-- Step 3: Accommodation Style -->
            <div class="mb-8">
                <label class="block text-xs font-bold uppercase tracking-wider text-forest mb-3">3. Preferred Accommodation Tier</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3" id="builder-tier">
                    <button type="button" onclick="window.selectTier ? window.selectTier('boutique', 190, this) : null" class="tier-btn active p-4 rounded-2xl border-2 border-terracotta bg-sand-50/50 text-left transition-all">
                        <div class="font-bold text-sm text-forest mb-1">Eco-Chic & Heritage</div>
                        <p class="text-xs text-stone-500">Characterful boutique stays, colonial bungalows, cozy tree-lodges.</p>
                    </button>
                    <button type="button" onclick="window.selectTier ? window.selectTier('luxury', 310, this) : null" class="tier-btn p-4 rounded-2xl border-2 border-stone-200 hover:border-forest text-left transition-all">
                        <div class="font-bold text-sm text-forest mb-1">High Luxury & Villas</div>
                        <p class="text-xs text-stone-500">5-star tea trails, private pool villas, Aman-tier service & spas.</p>
                    </button>
                    <button type="button" onclick="window.selectTier ? window.selectTier('homestead', 130, this) : null" class="tier-btn p-4 rounded-2xl border-2 border-stone-200 hover:border-forest text-left transition-all">
                        <div class="font-bold text-sm text-forest mb-1">Rustic & Community</div>
                        <p class="text-xs text-stone-500">Warm family guesthouses, safari glamping, tea planter homes.</p>
                    </button>
                </div>
            </div>

            <!-- Live Price Calculation Result Card -->
            <div class="p-6 bg-sand-50 rounded-2xl border border-sand-200 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-stone-500">Estimated Total Investment</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span class="text-3xl sm:text-4xl font-extrabold text-forest" id="builder-calc-total">$1,900</span>
                        <span class="text-xs text-stone-500" id="builder-calc-perperson">approx. $1,900 / person</span>
                    </div>
                    <p class="text-[11px] text-stone-500 mt-1">Includes private vehicle + dedicated driver-guide, all stays, curated breakfasts & key permits.</p>
                </div>
                <button type="button" onclick="window.requestEstimatedTrip ? window.requestEstimatedTrip() : null" class="w-full md:w-auto px-8 py-3.5 bg-terracotta hover:bg-terracotta-dark text-white rounded-full text-xs font-bold uppercase tracking-wider shadow transition-all">
                    Get Complete Custom Itinerary
                </button>
            </div>

        </div>

    </div>
</section>

