@extends('layouts.app')

@section('title', $package->title . ' - Curated Ceylon Journey - Kiyara Holidays')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($package->overview), 160))

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-forest text-white py-20 sm:py-28 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ $package->hero_image ?? 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=1600&q=80' }}" 
                 alt="{{ $package->title }}" 
                 class="w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-t from-forest via-forest/80 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <nav class="flex text-xs uppercase tracking-widest text-sand-200/80 mb-6" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="mx-2">&bull;</span>
                <a href="{{ route('packages.index') }}" class="hover:text-white transition-colors">Tour Catalog</a>
                <span class="mx-2">&bull;</span>
                <span class="text-terracotta-light">{{ $package->title }}</span>
            </nav>

            <div class="flex flex-wrap gap-2 mb-4">
                @if($package->is_featured)
                    <span class="bg-forest-light text-sand-100 text-xs font-bold uppercase tracking-wider px-3.5 py-1 rounded-full border border-forest-light/60">Featured Route</span>
                @endif
                @if($package->subtitle)
                    <span class="bg-terracotta text-white text-xs font-bold uppercase tracking-wider px-3.5 py-1 rounded-full">{{ $package->subtitle }}</span>
                @endif
                <span class="bg-white/20 backdrop-blur text-sand-100 text-xs font-semibold px-3 py-1 rounded-full">
                    <i class="fa-solid fa-people-group mr-1"></i> Max {{ $package->group_size_max }} Guests
                </span>
                <span class="bg-white/20 backdrop-blur text-sand-100 text-xs font-semibold px-3 py-1 rounded-full">
                    <i class="fa-solid fa-clock mr-1"></i> {{ $package->duration_days }} Days / {{ max(1, $package->duration_days - 1) }} Nights
                </span>
            </div>

            <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-bold text-white max-w-4xl leading-tight">
                {{ $package->title }}
            </h1>

            <p class="text-sand-100 text-base sm:text-lg font-light max-w-2xl mt-4 leading-relaxed">
                {{ $package->difficulty ?? 'Curated Leisure & Culture' }} &bull; Handcrafted boutique slow journey across Ceylon.
            </p>
        </div>
    </section>

    <!-- Main Content & Sticky Booking Card -->
    <section class="py-16 sm:py-24 bg-sand-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Left 8 Columns: Details, Route, Day by Day, Inclusions -->
                <div class="lg:col-span-8 space-y-12">
                    
                    <!-- Overview Section -->
                    <div class="bg-white p-8 sm:p-10 rounded-3xl border border-sand-200 shadow-sm space-y-6">
                        <span class="text-xs uppercase tracking-[0.25em] text-terracotta font-bold">The Journey Narrative</span>
                        <h2 class="font-serif text-2xl sm:text-3xl font-bold text-forest mt-1">Overview & Soul of the Route</h2>
                        <div class="text-stone-700 text-base leading-relaxed space-y-4 font-light">
                            <p>{{ $package->overview }}</p>
                        </div>

                        <!-- Route Highlights Grid -->
                        @if($package->itineraries->isNotEmpty())
                            <div class="pt-6 border-t border-sand-200">
                                <h4 class="text-xs uppercase tracking-wider font-bold text-stone-500 mb-3">Key Stops & Milestones</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($package->itineraries->pluck('location')->filter()->unique() as $loc)
                                        <span class="px-3.5 py-1.5 bg-sand-100 text-forest text-xs font-semibold rounded-full border border-sand-200">
                                            <i class="fa-solid fa-location-dot text-terracotta mr-1.5"></i> {{ $loc }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Day by Day Curated Itinerary -->
                    <div class="space-y-6">
                        <div class="flex items-end justify-between">
                            <div>
                                <span class="text-xs uppercase tracking-[0.25em] text-terracotta font-bold">Chronicle</span>
                                <h3 class="font-serif text-2xl sm:text-4xl font-bold text-forest mt-1">Day-by-Day Experience</h3>
                            </div>
                            <span class="text-xs text-stone-500 font-medium">{{ $package->itineraries->count() }} Chapters</span>
                        </div>

                        <div class="space-y-6">
                            @forelse($package->itineraries as $day)
                                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sand-200 shadow-sm hover:border-terracotta/40 transition-all">
                                    
                                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                                        <div class="flex items-center gap-3">
                                            <span class="w-10 h-10 rounded-2xl bg-forest text-sand-50 font-bold flex items-center justify-center text-sm shadow-sm">
                                                {{ $day->day_number }}
                                            </span>
                                            <div>
                                                <span class="text-[10px] font-bold uppercase tracking-widest text-terracotta">Day {{ $day->day_number }}</span>
                                                <h4 class="font-serif text-xl sm:text-2xl font-bold text-forest leading-snug">{{ $day->title }}</h4>
                                            </div>
                                        </div>

                                        @if($day->location)
                                            <span class="px-3 py-1 bg-sand-100 text-stone-700 text-xs font-semibold rounded-full border border-sand-200">
                                                <i class="fa-solid fa-map-pin text-terracotta mr-1"></i> {{ $day->location }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Day Segments -->
                                    <div class="space-y-3.5 text-sm text-stone-600 leading-relaxed font-light pl-0 sm:pl-13">
                                        @if($day->morning_desc)
                                            <div class="flex items-start gap-2.5">
                                                <span class="w-6 h-6 rounded-full bg-sand-100 text-terracotta flex items-center justify-center text-xs flex-shrink-0 mt-0.5" title="Morning">
                                                    <i class="fa-regular fa-sun"></i>
                                                </span>
                                                <p><strong class="font-semibold text-forest text-xs uppercase tracking-wider block sm:inline sm:mr-1">Morning:</strong> {{ $day->morning_desc }}</p>
                                            </div>
                                        @endif

                                        @if($day->afternoon_desc)
                                            <div class="flex items-start gap-2.5">
                                                <span class="w-6 h-6 rounded-full bg-sand-100 text-amber-600 flex items-center justify-center text-xs flex-shrink-0 mt-0.5" title="Afternoon">
                                                    <i class="fa-solid fa-cloud-sun"></i>
                                                </span>
                                                <p><strong class="font-semibold text-forest text-xs uppercase tracking-wider block sm:inline sm:mr-1">Afternoon:</strong> {{ $day->afternoon_desc }}</p>
                                            </div>
                                        @endif

                                        @if($day->evening_desc)
                                            <div class="flex items-start gap-2.5">
                                                <span class="w-6 h-6 rounded-full bg-sand-100 text-indigo-700 flex items-center justify-center text-xs flex-shrink-0 mt-0.5" title="Evening">
                                                    <i class="fa-solid fa-moon"></i>
                                                </span>
                                                <p><strong class="font-semibold text-forest text-xs uppercase tracking-wider block sm:inline sm:mr-1">Evening:</strong> {{ $day->evening_desc }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    @if($day->stay_notes)
                                        <div class="mt-5 pt-4 border-t border-sand-100 flex items-center gap-2 text-xs text-stone-500 italic pl-0 sm:pl-13">
                                            <i class="fa-solid fa-hotel text-forest"></i>
                                            <span><strong>Lodging:</strong> {{ $day->stay_notes }}</span>
                                        </div>
                                    @endif

                                </div>
                            @empty
                                <div class="bg-white rounded-3xl p-8 text-center text-stone-500 border border-sand-200">
                                    Itinerary schedule details available upon inquiry.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Inclusions & Exclusions Accordion/Cards -->
                    <div class="bg-white p-8 sm:p-10 rounded-3xl border border-sand-200 shadow-sm space-y-6">
                        <span class="text-xs uppercase tracking-[0.25em] text-terracotta font-bold">Transparency</span>
                        <h3 class="font-serif text-2xl sm:text-3xl font-bold text-forest">What’s Included & What’s Not</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                            <!-- Inclusions -->
                            <div class="space-y-3">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-forest flex items-center gap-2">
                                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i> Included in Journey
                                </h4>
                                <ul class="text-xs text-stone-600 space-y-2.5 leading-relaxed">
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-check text-emerald-600 mt-0.5"></i>
                                        <span>Handpicked boutique hotels, eco-lodges & heritage tea estate bungalows</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-check text-emerald-600 mt-0.5"></i>
                                        <span>Private dedicated AC vehicle & certified English-speaking driver-storyteller</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-check text-emerald-600 mt-0.5"></i>
                                        <span>All archaeological sites, temple tickets & national park safari permits</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-check text-emerald-600 mt-0.5"></i>
                                        <span>Reserved 1st-class scenic hill country train tickets</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-check text-emerald-600 mt-0.5"></i>
                                        <span>Daily breakfast + featured culinary masterclasses & village hearth feasts</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-check text-emerald-600 mt-0.5"></i>
                                        <span>24/7 dedicated local concierge on WhatsApp for on-ground assistance</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Exclusions -->
                            <div class="space-y-3">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-stone-500 flex items-center gap-2">
                                    <i class="fa-solid fa-circle-xmark text-stone-400 text-sm"></i> Excluded From Fare
                                </h4>
                                <ul class="text-xs text-stone-500 space-y-2.5 leading-relaxed">
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-xmark text-stone-400 mt-0.5"></i>
                                        <span>International return airfares</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-xmark text-stone-400 mt-0.5"></i>
                                        <span>Sri Lanka ETA visa fees</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-xmark text-stone-400 mt-0.5"></i>
                                        <span>Discretionary driver & porter gratuities</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-xmark text-stone-400 mt-0.5"></i>
                                        <span>Personal medical/travel insurance coverage</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-xmark text-stone-400 mt-0.5"></i>
                                        <span>Alcoholic beverages outside curated wine/tea tastings</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right 4 Columns: Sticky Booking & Inquiry Card -->
                <div class="lg:col-span-4 sticky top-28 space-y-6">
                    
                    <div class="bg-white rounded-3xl p-8 border-2 border-forest shadow-xl space-y-6">
                        
                        <div>
                            <span class="text-xs uppercase tracking-wider text-stone-400 font-semibold block">Starting Investment</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-4xl font-serif font-bold text-forest price-display" data-usd="{{ $package->starting_price_usd }}">${{ number_format($package->starting_price_usd) }}</span>
                                <span class="text-xs text-stone-500">USD / guest</span>
                            </div>
                            <span class="text-[11px] text-stone-400 block mt-1">Based on twin-share occupancy & private chauffeur</span>
                        </div>

                        <div class="space-y-3 pt-4 border-t border-sand-200 text-xs text-stone-600">
                            <div class="flex justify-between py-1 border-b border-sand-100">
                                <span class="text-stone-400">Duration:</span>
                                <span class="font-bold text-forest">{{ $package->duration_days }} Days / {{ max(1, $package->duration_days - 1) }} Nights</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-sand-100">
                                <span class="text-stone-400">Group Intimacy:</span>
                                <span class="font-bold text-forest">Max {{ $package->group_size_max }} Guests or Private</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-sand-100">
                                <span class="text-stone-400">Style:</span>
                                <span class="font-bold text-forest">{{ $package->difficulty ?? 'Bespoke / Group' }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-sand-100">
                                <span class="text-stone-400">Availability:</span>
                                <span class="font-bold text-emerald-600">Open for 2025/2026</span>
                            </div>
                        </div>

                        <div class="space-y-3 pt-2">
                            <button type="button" onclick="window.openInquiryModal ? window.openInquiryModal('Inquiry: {{ addslashes($package->title) }}') : null" class="w-full py-4 bg-terracotta hover:bg-terracotta-dark text-white text-xs uppercase font-bold tracking-wider rounded-2xl shadow-md transition-all text-center block">
                                Inquire / Check Dates
                            </button>
                            <a href="https://wa.me/94771234567?text={{ urlencode('Ayubowan Kiyara! I am interested in: ' . $package->title) }}" target="_blank" rel="noopener noreferrer" class="w-full py-3 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold rounded-2xl transition-all flex items-center justify-center gap-2">
                                <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp Concierge
                            </a>
                        </div>

                        <!-- Trust Guarantees -->
                        <div class="pt-4 border-t border-sand-200 space-y-2 text-[11px] text-stone-500">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-shield-halved text-forest"></i>
                                <span>Zero cancellation penalty up to 30 days prior</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-sliders text-forest"></i>
                                <span>100% customizable route & private stays</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-handshake-angle text-forest"></i>
                                <span>Direct local Ceylon team (no middlemen markups)</span>
                            </div>
                        </div>

                    </div>

                    <!-- Guidebook Download Magnet -->
                    <div class="bg-sand-100 rounded-3xl p-6 border border-sand-200 text-center space-y-3">
                        <i class="fa-solid fa-book-bookmark text-2xl text-terracotta"></i>
                        <h4 class="font-serif text-lg font-bold text-forest">Need Our Island Secrets First?</h4>
                        <p class="text-xs text-stone-600 leading-relaxed font-light">Download our curated 48-page editorial guide featuring 40 hidden gems, train hacks, and boutique stays.</p>
                        <button type="button" onclick="window.openGuideModal ? window.openGuideModal() : null" class="w-full py-2.5 bg-forest hover:bg-forest-light text-white text-xs uppercase font-bold tracking-wider rounded-full transition-all">
                            Free PDF Guide
                        </button>
                    </div>

                </div>

            </div>

            <!-- Related Packages Section -->
            @if($relatedPackages->isNotEmpty())
                <div class="mt-24 pt-16 border-t border-sand-200">
                    <div class="text-center max-w-2xl mx-auto mb-12">
                        <span class="text-xs uppercase tracking-[0.25em] text-terracotta font-bold">Discover More</span>
                        <h3 class="font-serif text-3xl font-bold text-forest mt-1">Other Curated Ceylon Journeys</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($relatedPackages as $rel)
                            <div class="bg-white rounded-3xl overflow-hidden border border-sand-200 shadow-sm hover:shadow-xl transition-all flex flex-col justify-between">
                                <div class="relative h-48 overflow-hidden">
                                    <img src="{{ $rel->hero_image ?? 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $rel->title }}" class="w-full h-full object-cover">
                                    <span class="absolute bottom-3 right-3 bg-forest-900/80 text-sand-100 text-xs px-2.5 py-0.5 rounded-full">
                                        {{ $rel->duration_days }} Days
                                    </span>
                                </div>
                                <div class="p-6 flex-1 flex flex-col justify-between">
                                    <div>
                                        <h4 class="font-serif text-xl font-bold text-forest mb-2">
                                            <a href="{{ route('packages.show', $rel->slug) }}" class="hover:text-terracotta transition-colors">{{ $rel->title }}</a>
                                        </h4>
                                        <p class="text-stone-600 text-xs line-clamp-2 leading-relaxed font-light">{{ $rel->overview }}</p>
                                    </div>
                                    <div class="mt-6 pt-4 border-t border-sand-200 flex items-center justify-between">
                                        <span class="text-sm font-bold text-forest price-display" data-usd="{{ $rel->starting_price_usd }}">${{ number_format($rel->starting_price_usd) }}</span>
                                        <a href="{{ route('packages.show', $rel->slug) }}" class="text-xs font-bold text-terracotta uppercase tracking-wider hover:underline">
                                            View Route &rarr;
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>

@endsection

@push('scripts')
<script>
    window.CURRENCY_RATES = @json($currencyRates);
</script>
@endpush

