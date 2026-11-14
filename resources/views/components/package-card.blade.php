@props([
    'package',
    'index' => 0,
])

@php
    $categories = 'group bespoke';
    if (str_contains($package->slug, 'connoisseur') || str_contains($package->slug, 'bespoke')) {
        $categories = 'bespoke';
    } elseif (str_contains($package->slug, 'prana') || str_contains($package->slug, 'ayurveda')) {
        $categories = 'wellness group';
    } elseif (str_contains($package->slug, 'women')) {
        $categories = 'wellness group bespoke';
    }

    $highlights = $package->itineraries->take(4);
@endphp

<div class="tour-card group bg-white rounded-3xl overflow-hidden border border-sand-200/90 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col" data-category="{{ $categories }}" data-package-id="{{ $package->id }}">
    <div class="relative h-64 overflow-hidden">
        <img src="{{ $package->hero_image ?? 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=800&q=80' }}" 
             alt="{{ $package->title }}" 
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
        
        <div class="absolute top-4 left-4 flex flex-wrap gap-2">
            @if($package->is_featured && $package->order === 1)
                <span class="bg-forest text-white text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow">Bestseller</span>
            @elseif($package->subtitle)
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
                {{ $package->title }}
            </h3>
            
            <p class="text-stone-600 text-sm leading-relaxed mb-4">
                {{ $package->overview }}
            </p>
            
            <!-- Quick Highlights List -->
            @if($highlights->isNotEmpty())
                <div class="grid grid-cols-2 gap-2 text-xs text-stone-600 mb-6 bg-sand-50 p-3 rounded-2xl">
                    @foreach($highlights as $it)
                        <span class="truncate" title="{{ $it->title }}">
                            <i class="fa-solid fa-check text-emerald-600 mr-1"></i> {{ Str::limit($it->title, 22) }}
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
            <button type="button" onclick="window.openItineraryModal ? window.openItineraryModal({{ $index }}, {{ $package->id }}) : null" class="px-4 py-2 bg-sand-100 hover:bg-forest hover:text-white text-forest text-xs font-bold rounded-xl transition-all">
                Explore Plan &rarr;
            </button>
        </div>
    </div>
</div>

