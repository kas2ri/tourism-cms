@extends('layouts.app')

@section('title', 'Curated Tour Packages & Expeditions - Kiyara Holidays')
@section('meta_description', 'Discover handpicked boutique journeys across Sri Lanka. Small group departures strictly capped at 12 guests and bespoke chauffeured itineraries.')

@section('content')

    <!-- Catalog Hero Header -->
    <section class="bg-forest text-sand-50 py-16 sm:py-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <nav class="flex text-xs uppercase tracking-widest text-sand-200/80 mb-4" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="mx-2">&bull;</span>
                <span class="text-terracotta-light">Tour Catalog</span>
            </nav>
            <div class="max-w-3xl">
                <span class="text-xs uppercase tracking-[0.25em] text-terracotta-light font-bold">Boutique Expeditions</span>
                <h1 class="font-serif text-3xl sm:text-5xl font-bold mt-2 text-white">Curated Ceylon Journeys</h1>
                <p class="text-sand-100 mt-4 text-base font-light leading-relaxed">
                    Handcrafted routes tested and vetted by our local storytellers. Join an intimate circle capped at 12 guests, or embark on a bespoke chauffeured expedition designed around your personal pace.
                </p>
            </div>
        </div>
        <div class="absolute -right-20 -bottom-20 w-96 h-96 rounded-full bg-forest-light/20 blur-3xl"></div>
    </section>

    <!-- Filters & Search Section -->
    <section class="py-8 bg-sand-100 border-b border-sand-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('packages.index') }}" class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-center justify-between">
                
                <!-- Search Input -->
                <div class="relative flex-1 max-w-md">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by route, region, or highlight..." 
                           class="w-full pl-11 pr-4 py-2.5 rounded-full bg-white border border-sand-300 text-xs sm:text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-forest focus:border-transparent shadow-sm">
                </div>

                <!-- Filters Group -->
                <div class="flex flex-wrap items-center gap-3">
                    
                    <!-- Style Filter -->
                    <div class="relative">
                        <select name="style" onchange="this.form.submit()" class="px-4 py-2.5 pr-8 rounded-full bg-white border border-sand-300 text-xs font-semibold text-stone-700 focus:outline-none focus:ring-2 focus:ring-forest cursor-pointer shadow-sm">
                            <option value="all" {{ request('style') == 'all' ? 'selected' : '' }}>All Travel Styles</option>
                            <option value="group" {{ request('style') == 'group' ? 'selected' : '' }}>Small Group (Max 12)</option>
                            <option value="bespoke" {{ request('style') == 'bespoke' ? 'selected' : '' }}>Bespoke Private</option>
                            <option value="wellness" {{ request('style') == 'wellness' ? 'selected' : '' }}>Wellness & Nature</option>
                        </select>
                    </div>

                    <!-- Duration Filter -->
                    <div class="relative">
                        <select name="duration" onchange="this.form.submit()" class="px-4 py-2.5 pr-8 rounded-full bg-white border border-sand-300 text-xs font-semibold text-stone-700 focus:outline-none focus:ring-2 focus:ring-forest cursor-pointer shadow-sm">
                            <option value="" {{ !request('duration') ? 'selected' : '' }}>Any Duration</option>
                            <option value="short" {{ request('duration') == 'short' ? 'selected' : '' }}>1 - 7 Days (Short Focus)</option>
                            <option value="medium" {{ request('duration') == 'medium' ? 'selected' : '' }}>8 - 14 Days (Island Loop)</option>
                            <option value="long" {{ request('duration') == 'long' ? 'selected' : '' }}>15+ Days (Slow Immersion)</option>
                        </select>
                    </div>

                    <!-- Sort -->
                    <div class="relative">
                        <select name="sort" onchange="this.form.submit()" class="px-4 py-2.5 pr-8 rounded-full bg-white border border-sand-300 text-xs font-semibold text-stone-700 focus:outline-none focus:ring-2 focus:ring-forest cursor-pointer shadow-sm">
                            <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Sort: Featured</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="duration_asc" {{ request('sort') == 'duration_asc' ? 'selected' : '' }}>Duration: Shortest</option>
                            <option value="duration_desc" {{ request('sort') == 'duration_desc' ? 'selected' : '' }}>Duration: Longest</option>
                        </select>
                    </div>

                    <!-- Filter Actions -->
                    <button type="submit" class="px-5 py-2.5 bg-forest hover:bg-forest-light text-white text-xs font-bold uppercase tracking-wider rounded-full shadow transition-all">
                        Apply
                    </button>
                    @if(request()->anyFilled(['search', 'style', 'duration', 'sort']))
                        <a href="{{ route('packages.index') }}" class="px-4 py-2.5 bg-sand-200 hover:bg-sand-300 text-stone-700 text-xs font-bold rounded-full transition-colors">
                            Reset
                        </a>
                    @endif

                </div>

            </form>
        </div>
    </section>

    <!-- Packages Grid Catalog -->
    <section class="py-16 sm:py-24 bg-sand-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between mb-8 text-xs text-stone-500 uppercase tracking-wider font-semibold">
                <span>Showing {{ $packages->firstItem() ?? 0 }} - {{ $packages->lastItem() ?? 0 }} of {{ $packages->total() }} Expeditions</span>
            </div>

            @if($packages->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($packages as $package)
                        <div class="tour-card group bg-white rounded-3xl overflow-hidden border border-sand-200/90 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                            <div class="relative h-64 overflow-hidden">
                                <img src="{{ $package->hero_image ?? 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=800&q=80' }}" 
                                     alt="{{ $package->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                
                                <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                                    @if($package->is_featured)
                                        <span class="bg-forest text-white text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow">Featured</span>
                                    @endif
                                    @if($package->subtitle)
                                        <span class="bg-terracotta text-white text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow">{{ $package->subtitle }}</span>
                                    @endif
                                    <span class="bg-white/90 backdrop-blur text-forest text-[11px] font-semibold px-2.5 py-1 rounded-full">Max {{ $package->group_size_max }} Guests</span>
                                </div>

                                <div class="absolute bottom-4 right-4 bg-forest-900/80 backdrop-blur text-sand-100 text-xs px-3 py-1 rounded-full">
                                    <i class="fa-regular fa-clock mr-1"></i> {{ $package->duration_days }} Days / {{ max(1, $package->duration_days - 1) }} Nights
                                </div>
                            </div>
                            
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center text-xs text-stone-500 mb-2 gap-2">
                                        <i class="fa-solid fa-map-pin text-terracotta"></i>
                                        <span>{{ $package->difficulty ?? 'Curated Ceylon' }} &bull; {{ $package->itineraries->pluck('location')->filter()->unique()->take(3)->implode(' &bull; ') }}</span>
                                    </div>
                                    
                                    <h3 class="font-serif text-2xl font-bold text-forest mb-2 group-hover:text-terracotta transition-colors">
                                        <a href="{{ route('packages.show', $package->slug) }}">{{ $package->title }}</a>
                                    </h3>
                                    
                                    <p class="text-stone-600 text-sm leading-relaxed mb-4 line-clamp-3">
                                        {{ $package->overview }}
                                    </p>
                                    
                                    @if($package->itineraries->isNotEmpty())
                                        <div class="grid grid-cols-2 gap-2 text-xs text-stone-600 mb-6 bg-sand-50 p-3 rounded-2xl">
                                            @foreach($package->itineraries->take(4) as $it)
                                                <span class="truncate" title="{{ $it->title }}">
                                                    <i class="fa-solid fa-check text-emerald-600 mr-1"></i> {{ \Illuminate\Support\Str::limit($it->title, 22) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="pt-4 border-t border-sand-200 flex items-center justify-between">
                                    <div>
                                        <span class="text-[11px] uppercase tracking-wider text-stone-500 block">From</span>
                                        <span class="text-xl font-bold text-forest price-display" data-usd="{{ $package->starting_price_usd }}">${{ number_format($package->starting_price_usd) }}</span>
                                        <span class="text-xs text-stone-500">/ person</span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="button" onclick="openPackageDrawer({{ $package->id }})" class="px-3.5 py-2 bg-sand-100 hover:bg-sand-200 text-forest text-xs font-bold rounded-xl transition-all" title="Quick Itinerary Modal">
                                            <i class="fa-solid fa-eye mr-1"></i> Quick View
                                        </button>
                                        <a href="{{ route('packages.show', $package->slug) }}" class="px-4 py-2 bg-forest hover:bg-forest-light text-white text-xs font-bold rounded-xl transition-all">
                                            Details &rarr;
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $packages->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-3xl border border-sand-200 p-8">
                    <div class="w-16 h-16 mx-auto bg-sand-100 text-terracotta rounded-full flex items-center justify-center text-2xl mb-4">
                        <i class="fa-solid fa-compass"></i>
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-forest">No expeditions match your criteria</h3>
                    <p class="text-stone-500 text-sm mt-2 max-w-md mx-auto">Try clearing your filters or search keywords, or let us custom craft a bespoke route specifically for you.</p>
                    <a href="{{ route('packages.index') }}" class="inline-block mt-6 px-6 py-2.5 bg-forest text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-forest-light transition-all">
                        Reset Filters
                    </a>
                </div>
            @endif

            <!-- Custom Request Banner -->
            <div class="mt-16 bg-forest text-white p-8 sm:p-10 rounded-3xl flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
                <div class="space-y-1 text-center md:text-left">
                    <span class="text-xs uppercase tracking-widest text-terracotta-light font-bold">Tailor-Made Experience</span>
                    <h4 class="font-serif text-2xl sm:text-3xl font-bold">Have unique dates or a personal island dream?</h4>
                    <p class="text-sand-200 text-sm max-w-2xl font-light">We can remodel any of these routes or craft one from scratch specifically around your travel rhythm, accommodation wishlist, and family interests.</p>
                </div>
                <button type="button" onclick="window.openInquiryModal ? window.openInquiryModal('Custom Itinerary Inquiry') : null" class="whitespace-nowrap px-8 py-3.5 bg-terracotta hover:bg-terracotta-dark text-white text-xs uppercase font-bold tracking-wider rounded-full transition-all shadow-md">
                    Request Bespoke Proposal
                </button>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
<script>
    window.CURRENCY_RATES = @json($currencyRates);

    // Direct JSON Itinerary Drawer Handler
    window.openPackageDrawer = function(packageId) {
        fetch(`/api/packages/${packageId}/itinerary`)
            .then(res => res.json())
            .then(data => {
                if (!data.success || !data.package) return;
                const pkg = data.package;

                const tagEl = document.getElementById('modal-tour-tag');
                const titleEl = document.getElementById('modal-tour-title');
                const metaEl = document.getElementById('modal-tour-meta');
                const priceEl = document.getElementById('modal-price');
                const flowEl = document.getElementById('modal-day-flow');

                if (tagEl) tagEl.textContent = pkg.subtitle || 'Boutique Journey';
                if (titleEl) titleEl.textContent = pkg.title;
                if (metaEl) metaEl.textContent = `${pkg.duration_label} • Max ${pkg.group_size_max} Guests • ${pkg.difficulty}`;
                if (priceEl) {
                    priceEl.textContent = `$${Number(pkg.starting_price_usd).toLocaleString()}`;
                    priceEl.setAttribute('data-usd', pkg.starting_price_usd);
                }

                if (flowEl && pkg.itinerary) {
                    flowEl.innerHTML = pkg.itinerary.map(day => `
                        <div class="border-l-2 border-terracotta/40 pl-4 py-1.5 space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-terracotta">Day ${day.day_number}</span>
                                <h5 class="font-serif text-base font-bold text-forest">${day.title}</h5>
                            </div>
                            <p class="text-xs text-stone-600 leading-relaxed">${day.full_description || ''}</p>
                            ${day.stay_notes ? `<span class="inline-block text-[11px] text-stone-400 italic"><i class="fa-solid fa-bed mr-1 text-forest"></i>${day.stay_notes}</span>` : ''}
                        </div>
                    `).join('');
                }

                const modal = document.getElementById('itinerary-modal');
                if (modal) {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            })
            .catch(err => {
                console.error('Failed to load itinerary data:', err);
            });
    };
</script>
@endpush

