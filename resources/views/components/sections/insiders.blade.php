<!-- Why We Exist / Local Insiders & Drivers Section -->
<section id="story" class="py-24 bg-forest text-sand-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-terracotta-light font-bold">Why We Exist</span>
                <h2 class="font-serif text-3xl sm:text-5xl font-bold mt-2 text-white">We Fell Out of Love With Tourist Buses. So We Built Kiyara.</h2>
                
                <div class="space-y-4 text-sand-100 font-light text-base mt-6 leading-relaxed">
                    <p>
                        Too much travel in Sri Lanka has become hurried: checking off sights from a checklist, rushing through crowded temples in huge tour groups, and eating buffet food made for tourists rather than locals.
                    </p>
                    <p>
                        <strong class="text-white font-semibold">Kiyara Holidays was born from a simpler longing:</strong> to introduce our island home with dignity, depth, and unhurried grace. When you travel with us, you are introduced as an honored guest to our personal friends—our favorite boutique lodge owners, generational tea masters, and veteran safari spotters.
                    </p>
                </div>

                <div class="mt-8 flex flex-wrap gap-4">
                    <button type="button" onclick="window.openInsidersModal ? window.openInsidersModal() : null" class="px-6 py-3 bg-white text-forest text-xs font-bold uppercase tracking-wider rounded-full hover:bg-sand-100 transition-all">
                        Meet Our Drivers & Guides &rarr;
                    </button>
                    <button type="button" onclick="window.openGuideModal ? window.openGuideModal() : null" class="px-6 py-3 border border-sand-200 text-sand-100 text-xs font-bold uppercase tracking-wider rounded-full hover:bg-forest-light transition-all">
                        Free Island Guidebook (PDF)
                    </button>
                </div>
            </div>

            <!-- Story Imagery Card -->
            <div class="relative">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-forest-light">
                    <img src="https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=800&q=80" 
                         alt="Kiyara Holidays Slow Travel" 
                         class="w-full h-[450px] object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-forest-900 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 p-6 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20">
                        <span class="text-xs text-sand-200 block italic">"The beauty of Ceylon is revealed not in a rush, but in the quiet gaps between destinations."</span>
                        <span class="text-xs font-bold text-white block mt-2">— Founder, Kiyara Holidays</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Local Insiders Showcase -->
        @if(isset($insiders) && count($insiders) > 0)
            <div class="mt-16 pt-16 border-t border-forest-light/60">
                <div class="text-center max-w-2xl mx-auto mb-10">
                    <span class="text-xs uppercase tracking-[0.25em] text-terracotta-light font-bold">Local Guardians</span>
                    <h3 class="font-serif text-2xl sm:text-4xl font-bold text-white mt-1">Our Insiders & Chauffeur Storytellers</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($insiders as $insider)
                        <div class="bg-forest-900/60 rounded-2xl p-6 border border-forest-light/40 flex items-start gap-4">
                            <img src="{{ $insider->avatar }}" alt="{{ $insider->name }}" class="w-14 h-14 rounded-full object-cover border-2 border-terracotta shrink-0">
                            <div>
                                <h4 class="font-serif text-lg font-bold text-white">{{ $insider->name }}</h4>
                                <span class="text-xs text-terracotta-light block font-medium">{{ $insider->role_title }}</span>
                                <p class="text-xs text-sand-200 mt-2 line-clamp-2">{{ $insider->bio }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>

