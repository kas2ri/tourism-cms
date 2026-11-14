<!-- Island Regions & Destinations Section -->
<section id="destinations" class="py-24 bg-sand-100 border-t border-b border-sand-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16">
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-terracotta font-bold">Unexplored Ceylon</span>
                <h2 class="font-serif text-3xl sm:text-5xl font-bold text-forest mt-2">Island Regions & Destinations</h2>
                <p class="text-stone-600 mt-3 text-base max-w-xl">
                    From cloud-draped tea peaks and sacred royal citadels to untamed ocean coves and leopard sanctuaries.
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="#expeditions" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-terracotta hover:text-terracotta-dark transition-colors">
                    View All Regional Journeys <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($destinations ?? [] as $destination)
                <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-sand-200/80 flex flex-col">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ $destination->hero_image }}" 
                             alt="{{ $destination->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-forest-900/80 via-forest-900/20 to-transparent"></div>
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider rounded-full border border-white/20">
                                Best: {{ $destination->best_season }}
                            </span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <h3 class="font-serif text-2xl font-bold">{{ $destination->name }}</h3>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between bg-white">
                        <p class="text-stone-600 text-sm leading-relaxed mb-6">
                            {{ $destination->short_desc }}
                        </p>
                        <div class="pt-4 border-t border-sand-100 flex items-center justify-between">
                            <span class="text-xs font-semibold text-stone-500">Curated Itineraries</span>
                            <a href="#expeditions" class="text-xs font-bold text-forest group-hover:text-terracotta transition-colors flex items-center gap-1">
                                Discover Tours <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-stone-500">
                    No destinations currently highlighted.
                </div>
            @endforelse
        </div>

    </div>
</section>

