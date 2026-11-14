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
            @forelse($packages ?? [] as $package)
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

