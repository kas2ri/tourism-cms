@props(['reviews' => []])

<section id="reviews" class="py-24 bg-sand-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16">
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-terracotta font-bold">Unfiltered Impressions</span>
                <h2 class="font-serif text-3xl sm:text-5xl font-bold text-forest mt-2">What Our Wanderers Say</h2>
            </div>
            <div class="mt-4 md:mt-0 flex items-center gap-3">
                <div class="flex items-center text-gold text-lg">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <span class="text-sm font-bold text-forest">5.0 / 5.0 on Google & Tripadvisor</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($reviews as $rev)
                @php
                    $initials = collect(explode(' ', $rev->guest_name))->map(fn($part) => substr($part, 0, 1))->take(2)->implode('');
                @endphp
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-sand-200 flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="flex items-center gap-1 text-gold text-xs mb-4">
                            @for($i = 0; $i < ($rev->rating ?? 5); $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        @if($rev->tour_name)
                            <span class="text-[11px] uppercase tracking-wider text-terracotta font-semibold block mb-2">{{ $rev->tour_name }}</span>
                        @endif
                        <p class="text-stone-600 text-sm leading-relaxed">
                            "{{ $rev->text }}"
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-sand-100 flex items-center gap-3">
                        @if($rev->avatar)
                            <img src="{{ $rev->avatar }}" alt="{{ $rev->guest_name }}" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-sand-200 text-forest flex items-center justify-center font-bold text-sm shrink-0">
                                {{ $initials ?: 'KH' }}
                            </div>
                        @endif
                        <div>
                            <div class="font-bold text-sm text-forest">{{ $rev->guest_name }}</div>
                            <div class="text-xs text-stone-500">{{ $rev->guest_country ?? 'Verified Traveler' }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-stone-500 py-8">
                    No reviews yet.
                </div>
            @endforelse
        </div>

    </div>
</section>

