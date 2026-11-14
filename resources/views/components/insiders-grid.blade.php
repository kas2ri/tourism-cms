@props(['insiders' => []])

<div id="insiders-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-3 sm:p-6 overflow-y-auto">
    <div class="bg-white max-w-2xl w-full rounded-3xl shadow-2xl overflow-hidden my-auto border border-sand-200">
        <div class="bg-forest text-white p-6 flex justify-between items-center">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-terracotta-light">The Heart of Kiyara</span>
                <h3 class="font-serif text-2xl font-bold mt-1">Meet Our Local Driver-Storytellers</h3>
            </div>
            <button type="button" onclick="window.closeInsidersModal ? window.closeInsidersModal() : null" class="text-white hover:text-terracotta text-2xl" aria-label="Close modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto text-stone-800 text-xs">
            @forelse($insiders as $insider)
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 bg-sand-50 p-4 rounded-2xl border border-sand-200">
                    <img src="{{ $insider->avatar ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80' }}" 
                         alt="{{ $insider->name }} - {{ $insider->role }}" 
                         class="w-20 h-20 rounded-full object-cover border-2 border-forest shrink-0">
                    <div class="text-center sm:text-left">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                            <h4 class="font-bold text-sm text-forest">{{ $insider->name }}</h4>
                            <span class="bg-forest text-sand-100 text-[10px] px-2 py-0.5 rounded-full">
                                {{ $insider->experience_years ? $insider->experience_years . ' Years Guiding' : $insider->role }}
                            </span>
                        </div>
                        <p class="text-stone-600 mt-1 leading-relaxed">
                            "{{ $insider->bio }}"
                        </p>
                        @if($insider->languages)
                            <div class="mt-2 flex items-center justify-center sm:justify-start gap-1 text-[11px] text-stone-500">
                                <i class="fa-solid fa-language text-terracotta mr-1"></i>
                                <span>Speaks: {{ is_array($insider->languages) ? implode(', ', $insider->languages) : $insider->languages }}</span>
                            </div>
                        @endif
                        <span class="text-[11px] font-semibold text-terracotta block mt-1">
                            <i class="fa-solid fa-award"></i> Specialist: {{ $insider->role }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-stone-500 text-center py-4">No driver-storytellers found.</p>
            @endforelse
        </div>

        <div class="p-4 bg-sand-100 border-t border-sand-200 text-center">
            <button type="button" onclick="if(window.closeInsidersModal) window.closeInsidersModal(); if(window.openInquiryModal) window.openInquiryModal('Driver Request');" class="px-6 py-2.5 bg-forest text-white rounded-full text-xs font-bold uppercase tracking-wider hover:bg-forest-light transition-all">
                Request A Specific Guide For Your Journey
            </button>
        </div>
    </div>
</div>

