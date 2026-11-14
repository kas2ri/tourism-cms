@extends('layouts.app')

@section('title', 'Kiyara Holidays - Boutique Ceylon Journeys & Slow Luxury Travel')

@section('content')

    <!-- Hero Section -->
    <x-hero />

    <!-- Brand Philosophy / Signature Pillars -->
    <section class="py-20 bg-sand-100 border-b border-sand-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs uppercase tracking-[0.25em] text-terracotta font-bold">The Kiyara Signature</span>
                <h2 class="font-serif text-3xl sm:text-5xl font-bold text-forest mt-2">How We Travel Differently</h2>
                <p class="text-stone-600 mt-4 text-base">Inspired by soulful, slow-paced exploration. We champion human warmth, wild landscapes, and respectful tourism.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <!-- Pillar 1 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-xl transition-all border border-sand-200/80 group">
                    <div class="w-14 h-14 bg-sand-100 text-terracotta rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-terracotta group-hover:text-white transition-colors">
                        <i class="fa-solid fa-people-roof"></i>
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-forest mb-2">Small Intimate Circles</h3>
                    <p class="text-stone-600 text-sm leading-relaxed">
                        Never travel in anonymity. Our curated group journeys never exceed 12 guests, unlocking access to boutique tea estates and secret dinners.
                    </p>
                    <a href="#expeditions" class="mt-6 text-xs font-bold text-terracotta uppercase tracking-wider flex items-center gap-1 group-hover:gap-2 transition-all">
                        See Group Departures <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <!-- Pillar 2 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-xl transition-all border border-sand-200/80 group">
                    <div class="w-14 h-14 bg-sand-100 text-forest rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-forest group-hover:text-sand-100 transition-colors">
                        <i class="fa-solid fa-car-side"></i>
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-forest mb-2">Private Chauffeured Slow Pace</h3>
                    <p class="text-stone-600 text-sm leading-relaxed">
                        Your personal Sri Lankan storyteller & licensed chauffeur who knows every roadside king coconut stand, ancient water tank, and secret scenic viewpoint.
                    </p>
                    <a href="#expeditions" class="mt-6 text-xs font-bold text-forest uppercase tracking-wider flex items-center gap-1 group-hover:gap-2 transition-all">
                        Explore Bespoke <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <!-- Pillar 3 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-xl transition-all border border-sand-200/80 group">
                    <div class="w-14 h-14 bg-sand-100 text-emerald-700 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-emerald-700 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-spa"></i>
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-forest mb-2">Soulful Ayurveda & Retreats</h3>
                    <p class="text-stone-600 text-sm leading-relaxed">
                        Authentic herbal medicine treatments, morning yoga overlooking misty knuckles peaks, and plant-based feasts harvested right from organic soil.
                    </p>
                    <a href="#expeditions" class="mt-6 text-xs font-bold text-emerald-700 uppercase tracking-wider flex items-center gap-1 group-hover:gap-2 transition-all">
                        View Retreats <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <!-- Pillar 4 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-xl transition-all border border-sand-200/80 group">
                    <div class="w-14 h-14 bg-sand-100 text-stone-700 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-stone-800 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-hand-holding-heart"></i>
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-forest mb-2">Community Direct Impact</h3>
                    <p class="text-stone-600 text-sm leading-relaxed">
                        We partner directly with home cooks, grassroots wildlife conservation naturalists, and local craftsmen. Your journey sustains real families.
                    </p>
                    <a href="#story" class="mt-6 text-xs font-bold text-stone-700 uppercase tracking-wider flex items-center gap-1 group-hover:gap-2 transition-all">
                        Our Ethics <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

            </div>

        </div>
    </section>

    <!-- Expeditions / Tour Packages Section -->
    <section id="expeditions" class="py-24 bg-sand-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <span class="text-xs uppercase tracking-[0.25em] text-terracotta font-bold">Handcrafted Itineraries</span>
                    <h2 class="font-serif text-3xl sm:text-5xl font-bold text-forest mt-2">Curated Journeys For 2025/2026</h2>
                    <p class="text-stone-600 mt-3 text-base max-w-xl">Every itinerary is tested and vetted by our local team. Choose to join a small group or travel this exact route privately.</p>
                </div>

                <!-- Category Filter Tabs -->
                <div class="mt-6 md:mt-0 flex flex-wrap gap-2" id="catalog-filters">
                    <button type="button" onclick="window.filterTours ? window.filterTours('all', this) : null" class="filter-btn active px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full bg-forest text-white transition-all">All Expeditions</button>
                    <button type="button" onclick="window.filterTours ? window.filterTours('group', this) : null" class="filter-btn px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full bg-white text-stone-700 border border-sand-200 hover:border-forest transition-all">Small Group</button>
                    <button type="button" onclick="window.filterTours ? window.filterTours('bespoke', this) : null" class="filter-btn px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full bg-white text-stone-700 border border-sand-200 hover:border-forest transition-all">Bespoke Private</button>
                    <button type="button" onclick="window.filterTours ? window.filterTours('wellness', this) : null" class="filter-btn px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full bg-white text-stone-700 border border-sand-200 hover:border-forest transition-all">Wellness & Nature</button>
                </div>
            </div>

            <!-- Tours Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="tours-container">
                @forelse($packages as $package)
                    <x-package-card :package="$package" :index="$loop->index" />
                @empty
                    <div class="col-span-3 text-center py-12 text-stone-500">
                        No tour packages available at this time.
                    </div>
                @endforelse
            </div>

            <!-- Custom Request Banner -->
            <div class="mt-12 bg-forest text-white p-8 rounded-3xl flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
                <div class="space-y-1 text-center md:text-left">
                    <h4 class="font-serif text-2xl font-bold">Have your own dates or unique island dream?</h4>
                    <p class="text-sand-200 text-sm">We can remodel any of these routes or craft one from scratch specifically around your group.</p>
                </div>
                <button type="button" onclick="window.openInquiryModal ? window.openInquiryModal('Customized Itinerary') : null" class="whitespace-nowrap px-6 py-3 bg-terracotta hover:bg-terracotta-dark text-white text-xs uppercase font-bold tracking-wider rounded-full transition-all">
                    Request Bespoke Proposal
                </button>
            </div>

        </div>
    </section>

    <!-- Trip Builder & Interactive Planner -->
    <x-trip-builder />

    <!-- Curated Moments / Micro-Experiences -->
    <section id="experiences" class="py-24 bg-sand-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs uppercase tracking-[0.25em] text-terracotta font-bold">Unscripted Magic</span>
                <h2 class="font-serif text-3xl sm:text-5xl font-bold text-forest mt-2">Moments That Can’t Be Googled</h2>
                <p class="text-stone-600 mt-3 text-base">We weave small, intimate island micro-experiences into every journey you take with us.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Experience 1 -->
                <div class="group relative rounded-3xl overflow-hidden shadow-sm h-96">
                    <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=600&q=80" 
                         alt="Cooking with Amma" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-forest-900 via-forest-900/40 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-white">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-terracotta-light">Culinary Heritage</span>
                        <h3 class="font-serif text-xl font-bold mt-1">Village Claypot Feast with Amma Lakshmi</h3>
                        <p class="text-xs text-sand-100 opacity-90 mt-2 line-clamp-3">
                            Grind coconut on ancient granite stones, pluck organic spices from the backyard forest, and cook clay-pot jackfruit curry over wood embers.
                        </p>
                    </div>
                </div>

                <!-- Experience 2 -->
                <div class="group relative rounded-3xl overflow-hidden shadow-sm h-96">
                    <img src="https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?auto=format&fit=crop&w=600&q=80" 
                         alt="Wild Leopard Trackers" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-forest-900 via-forest-900/40 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-white">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-terracotta-light">Ethical Wildlife</span>
                        <h3 class="font-serif text-xl font-bold mt-1">Twilight Tracking with Wildlife Biologists</h3>
                        <p class="text-xs text-sand-100 opacity-90 mt-2 line-clamp-3">
                            Avoid high-speed jeep queues. Learn paw-print identification, bird call deciphering, and ethical leopard monitoring in buffer zones.
                        </p>
                    </div>
                </div>

                <!-- Experience 3 -->
                <div class="group relative rounded-3xl overflow-hidden shadow-sm h-96">
                    <img src="https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=600&q=80" 
                         alt="Tea Pluckers Ceylon" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-forest-900 via-forest-900/40 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-white">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-terracotta-light">Highlands Life</span>
                        <h3 class="font-serif text-xl font-bold mt-1">Secret Tea Tasting with Master Planters</h3>
                        <p class="text-xs text-sand-100 opacity-90 mt-2 line-clamp-3">
                            Walk the private misty ridges of Bogawantalawa, pluck 'two leaves and a bud' and sample rare golden tips teas in an 1890s factory salon.
                        </p>
                    </div>
                </div>

                <!-- Experience 4 -->
                <div class="group relative rounded-3xl overflow-hidden shadow-sm h-96">
                    <img src="https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=600&q=80" 
                         alt="Galle Fort Sunset" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-forest-900 via-forest-900/40 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-white">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-terracotta-light">Coastal Living</span>
                        <h3 class="font-serif text-xl font-bold mt-1">Galle Fort Ramparts & Carrom Match</h3>
                        <p class="text-xs text-sand-100 opacity-90 mt-2 line-clamp-3">
                            Watch cliff divers as golden hour breaks over the Indian Ocean, followed by a friendly game of carrom board and fresh coconut arrack cocktails.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Why We Exist / Brand Manifesto -->
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

        </div>
    </section>

    <!-- Reviews Slider / Guest Testimonials -->
    <x-reviews-slider :reviews="$reviews" />

    <!-- Guidebook Call To Action Banner -->
    <section class="py-20 bg-forest-900 text-sand-50 relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="inline-block px-3 py-1 bg-terracotta text-white text-[11px] font-bold uppercase tracking-widest rounded-full mb-4">
                Free 2025 Edition
            </span>
            <h2 class="font-serif text-3xl sm:text-5xl font-bold text-white mb-4">
                The Insider’s Guide to Ceylon: 40 Hidden Corners
            </h2>
            <p class="text-sand-200 text-base max-w-2xl mx-auto mb-8 font-light">
                Download our free 48-page editorial guidebook. Packed with vetted boutique stays, tipping etiquette, train ticket secrets, and street food safety tips.
            </p>

            <form onsubmit="window.handleInlineGuide ? window.handleInlineGuide(event) : null" class="max-w-md mx-auto flex flex-col sm:flex-row gap-2">
                @csrf
                <label for="inline-guide-email" class="sr-only">Email address</label>
                <input type="email" id="inline-guide-email" name="email" required placeholder="Enter your email address..." 
                       class="px-5 py-3 rounded-full bg-white/10 text-white placeholder-stone-400 border border-white/20 focus:outline-none focus:ring-2 focus:ring-terracotta flex-1 text-sm">
                <button type="submit" class="px-6 py-3 bg-terracotta hover:bg-terracotta-dark text-white rounded-full text-xs uppercase font-bold tracking-wider transition-all">
                    Download PDF
                </button>
            </form>
        </div>
    </section>

    <!-- Insiders Modal Component -->
    <x-insiders-grid :insiders="$insiders" />

@endsection

@push('scripts')
<script>
    // Injected Dynamic Database Data for Client-Side Interactivity
    window.TOURS_DATA = @json($toursData);
    window.CURRENCY_RATES = @json($currencyRates);
</script>
@endpush
