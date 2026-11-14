@php
    $heroBg = setting('hero_background_image', 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=2000&q=80');
    $heroBgUrl = (str_starts_with($heroBg, 'http://') || str_starts_with($heroBg, 'https://'))
        ? $heroBg
        : \Illuminate\Support\Facades\Storage::url($heroBg);
@endphp
<section class="relative min-h-[85vh] flex items-center justify-center overflow-hidden bg-forest-900 text-white">
    <!-- Ambient Background with High Quality Tropical Landscape -->
    <div class="absolute inset-0 z-0">
        <img src="{{ $heroBgUrl }}" 
             alt="Sri Lanka Misty Tea Hills & Train" 
             class="w-full h-full object-cover opacity-40 scale-105 transition-transform duration-1000 ease-out"
             onerror="this.src='https://placehold.co/1920x1080/1a3b32/f4efe6?text=Kiyara+Holidays+Ceylon'">
        <div class="absolute inset-0 bg-gradient-to-t from-forest-900 via-forest-900/60 to-forest-900/30"></div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        
        <!-- Badges -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full badge-blur border border-white/20 text-sand-100 text-xs font-medium mb-6">
            <span class="w-1.5 h-1.5 rounded-full bg-terracotta"></span>
            Authentic, Unhurried Sri Lanka & Tropical Sanctuaries
        </div>

        <!-- Main Headline -->
        <h1 class="font-serif text-4xl sm:text-6xl md:text-7xl font-bold tracking-tight text-sand-50 leading-[1.1] mb-6">
            {!! format_hero_headline(setting('hero_headline', 'Not just a holiday, but a journey that [lingers in your soul.]')) !!}
        </h1>

        <p class="max-w-2xl mx-auto text-base sm:text-lg text-sand-100 font-light leading-relaxed mb-10">
            {{ setting('hero_subheadline', 'We move away from crowded tourist coaches. Join intimate, thoughtfully guided journeys, stay in colonial heritage bungalows and eco-villas, and connect directly with local islanders.') }}
        </p>

        <!-- Interactive Quick Journey Filter Bar -->
        <div class="bg-white/95 backdrop-blur-md p-3 sm:p-4 rounded-3xl shadow-2xl text-stone-800 max-w-4xl mx-auto border border-white/30 text-left">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                
                <!-- Filter 1: Destination / Region -->
                <div class="p-2 sm:p-3 rounded-2xl hover:bg-sand-50 transition-colors">
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-forest/70">1. Island Region</span>
                    <select id="hero-region" class="w-full mt-1 bg-transparent font-semibold text-stone-900 text-sm focus:outline-none cursor-pointer">
                        <option value="all">All Enchanting Regions</option>
                        <option value="cultural">Sigiriya & Cultural Triangle</option>
                        <option value="hills">Ella & Central High Hills</option>
                        <option value="safari">Yala & Wilpattu Wildlife</option>
                        <option value="coast">Galle Fort & Southern Coast</option>
                    </select>
                </div>

                <!-- Filter 2: Travel Style -->
                <div class="p-2 sm:p-3 rounded-2xl hover:bg-sand-50 transition-colors border-t sm:border-t-0 sm:border-l border-stone-200">
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-forest/70">2. Travel Style</span>
                    <select id="hero-style" class="w-full mt-1 bg-transparent font-semibold text-stone-900 text-sm focus:outline-none cursor-pointer">
                        <option value="all">Any Journey Format</option>
                        <option value="group">Curated Small Group (Max 12)</option>
                        <option value="bespoke">Private Chauffeur-Guide</option>
                        <option value="wellness">Ayurveda & Soul Retreat</option>
                        <option value="slow">Slow Train & Eco Hiking</option>
                    </select>
                </div>

                <!-- Filter 3: Timing / Month -->
                <div class="p-2 sm:p-3 rounded-2xl hover:bg-sand-50 transition-colors border-t lg:border-t-0 lg:border-l border-stone-200">
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-forest/70">3. When to Travel</span>
                    <select id="hero-season" class="w-full mt-1 bg-transparent font-semibold text-stone-900 text-sm focus:outline-none cursor-pointer">
                        <option value="upcoming">Next 3 Months</option>
                        <option value="winter">Dec - Mar (High Sun & Whales)</option>
                        <option value="spring">Apr - Jun (Green Season / Festive)</option>
                        <option value="summer">Jul - Sep (East Coast Surf)</option>
                    </select>
                </div>

                <!-- Search CTA Button -->
                <div class="flex items-center">
                    <button type="button" onclick="window.handleHeroSearch ? window.handleHeroSearch() : null" class="w-full h-full min-h-[50px] bg-forest hover:bg-forest-light text-white rounded-2xl font-semibold text-sm flex items-center justify-center gap-2 transition-all shadow-md">
                        <i class="fa-solid fa-compass text-terracotta"></i> Explore Routes
                    </button>
                </div>

            </div>
        </div>

        <!-- Trust Metrics -->
        <div class="mt-8 flex flex-wrap items-center justify-center gap-6 sm:gap-12 text-xs sm:text-sm text-sand-200 font-light">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-leaf text-emerald-400"></i>
                <span>{{ setting('hero_badge_1', 'Carbon-Balanced Trips') }}</span>
            </span>
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-users text-terracotta-light"></i>
                <span>{{ setting('hero_badge_2', 'Max 12 Travelers on Groups') }}</span>
            </span>
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-certificate text-gold"></i>
                <span>{{ setting('hero_badge_3', 'SLTDA Certified Insider Drivers') }}</span>
            </span>
        </div>

    </div>
</section>
