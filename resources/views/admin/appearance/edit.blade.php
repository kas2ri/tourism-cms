@extends('layouts.admin')

@section('title', 'Appearance & Homepage Layout')
@section('page_title', 'Appearance & Homepage Layout')

@section('header_actions')
    <div class="flex items-center gap-3">
        <a href="{{ url('/') }}" target="_blank" class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl text-xs font-bold transition-all flex items-center gap-2 border border-stone-300">
            <i class="fa-solid fa-arrow-up-right-from-square text-terracotta"></i>
            <span>Preview Live Site</span>
        </a>
        <button type="submit" form="appearance-form" class="px-5 py-2 bg-forest hover:bg-forest-light text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-floppy-disk text-terracotta"></i>
            <span>Save Changes</span>
        </button>
    </div>
@endsection

@section('content')
<div class="p-6 max-w-7xl mx-auto space-y-8">

    <form id="appearance-form" method="POST" action="{{ route('admin.appearance.update') }}" class="space-y-8">
        @csrf

        <!-- 1. COLOR THEME CUSTOMIZATION -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200/80 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 border-b border-stone-100 gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-forest-900 text-white flex items-center justify-center text-sm shadow-sm">
                            <i class="fa-solid fa-palette text-terracotta"></i>
                        </span>
                        <h2 class="font-serif text-2xl font-bold text-forest">Dynamic Color Theme Customizer</h2>
                    </div>
                    <p class="text-stone-500 text-xs mt-1">
                        Control global CSS variables across the frontend. Changes immediately style headers, buttons, cards, badges, and accents.
                    </p>
                </div>

                <!-- Theme Presets & Reset -->
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-stone-400 mr-1">Presets:</span>
                    
                    <button type="button" 
                            onclick="applyPreset('#1a3b32', '#c86d51', '#f4efe6', '#1e292b')" 
                            class="px-3 py-1.5 rounded-xl border border-stone-200 hover:border-forest text-xs font-semibold text-stone-700 bg-stone-50 hover:bg-stone-100 transition-all flex items-center gap-1.5 shadow-xs">
                        <span class="w-3 h-3 rounded-full border border-black/10 inline-block" style="background-color: #1a3b32;"></span>
                        <span class="w-3 h-3 rounded-full border border-black/10 inline-block -ml-2" style="background-color: #c86d51;"></span>
                        <span>Ceylon Forest & Clay</span>
                    </button>

                    <button type="button" 
                            onclick="applyPreset('#0d4b68', '#e05a47', '#edf5f8', '#17232b')" 
                            class="px-3 py-1.5 rounded-xl border border-stone-200 hover:border-forest text-xs font-semibold text-stone-700 bg-stone-50 hover:bg-stone-100 transition-all flex items-center gap-1.5 shadow-xs">
                        <span class="w-3 h-3 rounded-full border border-black/10 inline-block" style="background-color: #0d4b68;"></span>
                        <span class="w-3 h-3 rounded-full border border-black/10 inline-block -ml-2" style="background-color: #e05a47;"></span>
                        <span>Oceanic Galle & Coral</span>
                    </button>

                    <button type="button" 
                            onclick="applyPreset('#4a1e28', '#d48818', '#faf5ee', '#281d1a')" 
                            class="px-3 py-1.5 rounded-xl border border-stone-200 hover:border-forest text-xs font-semibold text-stone-700 bg-stone-50 hover:bg-stone-100 transition-all flex items-center gap-1.5 shadow-xs">
                        <span class="w-3 h-3 rounded-full border border-black/10 inline-block" style="background-color: #4a1e28;"></span>
                        <span class="w-3 h-3 rounded-full border border-black/10 inline-block -ml-2" style="background-color: #d48818;"></span>
                        <span>Sigiriya Sunset & Gold</span>
                    </button>

                    <button type="button" 
                            onclick="resetDefaults()" 
                            class="px-3 py-1.5 rounded-xl border border-rose-200 hover:bg-rose-50 text-xs font-semibold text-rose-600 transition-all flex items-center gap-1">
                        <i class="fa-solid fa-arrow-rotate-left text-[11px]"></i>
                        <span>Reset Defaults</span>
                    </button>
                </div>
            </div>

            <!-- Color Inputs Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-6">
                
                <!-- Primary Color -->
                <div class="p-5 rounded-2xl bg-stone-50 border border-stone-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <label for="theme_primary_color" class="block text-xs font-bold uppercase tracking-wider text-forest">
                            Primary Color
                        </label>
                        <span class="text-[10px] text-stone-400 font-mono">--color-primary</span>
                    </div>
                    <p class="text-[11px] text-stone-500 leading-tight">Navbars, main headings, deep contrast sections.</p>
                    <div class="flex items-center gap-3">
                        <input type="color" 
                               id="picker_primary" 
                               value="{{ old('theme_primary_color', $themePrimary) }}"
                               oninput="syncColor('picker_primary', 'theme_primary_color')" 
                               class="w-12 h-10 p-0.5 rounded-xl border border-stone-300 bg-white cursor-pointer shrink-0">
                        <input type="text" 
                               name="theme_primary_color" 
                               id="theme_primary_color" 
                               value="{{ old('theme_primary_color', $themePrimary) }}" 
                               oninput="syncColor('theme_primary_color', 'picker_primary')" 
                               class="font-mono text-xs uppercase font-bold text-stone-800 px-3 py-2 border border-stone-300 rounded-xl bg-white w-full focus:ring-2 focus:ring-forest focus:outline-none"
                               required pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                    </div>
                </div>

                <!-- Secondary Color -->
                <div class="p-5 rounded-2xl bg-stone-50 border border-stone-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <label for="theme_secondary_color" class="block text-xs font-bold uppercase tracking-wider text-forest">
                            Secondary / Accent
                        </label>
                        <span class="text-[10px] text-stone-400 font-mono">--color-secondary</span>
                    </div>
                    <p class="text-[11px] text-stone-500 leading-tight">Buttons, badges, focal highlights, active links.</p>
                    <div class="flex items-center gap-3">
                        <input type="color" 
                               id="picker_secondary" 
                               value="{{ old('theme_secondary_color', $themeSecondary) }}"
                               oninput="syncColor('picker_secondary', 'theme_secondary_color')" 
                               class="w-12 h-10 p-0.5 rounded-xl border border-stone-300 bg-white cursor-pointer shrink-0">
                        <input type="text" 
                               name="theme_secondary_color" 
                               id="theme_secondary_color" 
                               value="{{ old('theme_secondary_color', $themeSecondary) }}" 
                               oninput="syncColor('theme_secondary_color', 'picker_secondary')" 
                               class="font-mono text-xs uppercase font-bold text-stone-800 px-3 py-2 border border-stone-300 rounded-xl bg-white w-full focus:ring-2 focus:ring-forest focus:outline-none"
                               required pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                    </div>
                </div>

                <!-- Background Color -->
                <div class="p-5 rounded-2xl bg-stone-50 border border-stone-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <label for="theme_background_color" class="block text-xs font-bold uppercase tracking-wider text-forest">
                            Background Sand
                        </label>
                        <span class="text-[10px] text-stone-400 font-mono">--color-bg-sand</span>
                    </div>
                    <p class="text-[11px] text-stone-500 leading-tight">Page canvas background, sand cards, soft backdrops.</p>
                    <div class="flex items-center gap-3">
                        <input type="color" 
                               id="picker_background" 
                               value="{{ old('theme_background_color', $themeBackground) }}"
                               oninput="syncColor('picker_background', 'theme_background_color')" 
                               class="w-12 h-10 p-0.5 rounded-xl border border-stone-300 bg-white cursor-pointer shrink-0">
                        <input type="text" 
                               name="theme_background_color" 
                               id="theme_background_color" 
                               value="{{ old('theme_background_color', $themeBackground) }}" 
                               oninput="syncColor('theme_background_color', 'picker_background')" 
                               class="font-mono text-xs uppercase font-bold text-stone-800 px-3 py-2 border border-stone-300 rounded-xl bg-white w-full focus:ring-2 focus:ring-forest focus:outline-none"
                               required pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                    </div>
                </div>

                <!-- Text Color -->
                <div class="p-5 rounded-2xl bg-stone-50 border border-stone-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <label for="theme_text_color" class="block text-xs font-bold uppercase tracking-wider text-forest">
                            Text Main Slate
                        </label>
                        <span class="text-[10px] text-stone-400 font-mono">--color-text-main</span>
                    </div>
                    <p class="text-[11px] text-stone-500 leading-tight">Default paragraph copy, headers, body typography.</p>
                    <div class="flex items-center gap-3">
                        <input type="color" 
                               id="picker_text" 
                               value="{{ old('theme_text_color', $themeText) }}"
                               oninput="syncColor('picker_text', 'theme_text_color')" 
                               class="w-12 h-10 p-0.5 rounded-xl border border-stone-300 bg-white cursor-pointer shrink-0">
                        <input type="text" 
                               name="theme_text_color" 
                               id="theme_text_color" 
                               value="{{ old('theme_text_color', $themeText) }}" 
                               oninput="syncColor('theme_text_color', 'picker_text')" 
                               class="font-mono text-xs uppercase font-bold text-stone-800 px-3 py-2 border border-stone-300 rounded-xl bg-white w-full focus:ring-2 focus:ring-forest focus:outline-none"
                               required pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                    </div>
                </div>

            </div>

            <!-- Live Theme Preview Widget -->
            <div class="mt-6 p-6 rounded-2xl border border-stone-200 transition-all" id="theme-preview-box" style="background-color: {{ $themeBackground }}; color: {{ $themeText }};">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span id="preview-badge" class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest text-white shadow-xs transition-colors" style="background-color: {{ $themeSecondary }};">
                            Live Theme Preview
                        </span>
                        <div>
                            <h4 id="preview-heading" class="font-serif text-lg font-bold transition-colors" style="color: {{ $themePrimary }};">
                                Ceylon Slow Journeys & Experiential Stays
                            </h4>
                            <p id="preview-text" class="text-xs transition-colors" style="color: {{ $themeText }};">
                                Experience unscripted Ceylon hospitality with handcrafted pacing.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <button type="button" id="preview-btn-primary" class="px-4 py-2 rounded-xl text-xs font-bold text-white shadow-sm transition-all" style="background-color: {{ $themePrimary }};">
                            Primary Action
                        </button>
                        <button type="button" id="preview-btn-secondary" class="px-4 py-2 rounded-xl text-xs font-bold text-white shadow-sm transition-all" style="background-color: {{ $themeSecondary }};">
                            Accent CTA
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. HOMEPAGE SECTION LAYOUT ORDERING -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200/80 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-stone-100 gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-forest-900 text-white flex items-center justify-center text-sm shadow-sm">
                            <i class="fa-solid fa-bars-staggered text-terracotta"></i>
                        </span>
                        <h2 class="font-serif text-2xl font-bold text-forest">Homepage Section Layout & Ordering</h2>
                    </div>
                    <p class="text-stone-500 text-xs mt-1">
                        Drag sections up or down to reorder the homepage flow. Toggle the active switch to publish or hide any section.
                    </p>
                </div>
                <div class="flex items-center gap-2 text-xs font-medium text-stone-500">
                    <i class="fa-solid fa-hand-pointer text-terracotta"></i>
                    <span>Drag items by handle or use arrows</span>
                </div>
            </div>

            <!-- Sortable Section List -->
            <div id="sortable-sections" class="space-y-3 pt-6">
                @foreach($sections as $index => $section)
                    <div class="section-row bg-stone-50 hover:bg-stone-100/80 border border-stone-200 rounded-2xl p-4 sm:p-5 flex items-center justify-between gap-4 transition-all duration-200 cursor-grab active:cursor-grabbing"
                         data-id="{{ $section['id'] }}">
                        
                        <!-- Drag Handle & Order Badge & Info -->
                        <div class="flex items-center gap-4 min-w-0">
                            <!-- Drag Handle -->
                            <div class="drag-handle text-stone-400 hover:text-forest p-1 cursor-grab" title="Drag to reorder">
                                <i class="fa-solid fa-grip-vertical text-base"></i>
                            </div>

                            <!-- Visual Order Badge -->
                            <div class="order-badge w-8 h-8 rounded-xl bg-white border border-stone-200 text-forest font-bold text-xs flex items-center justify-center shadow-xs shrink-0">
                                {{ $loop->iteration }}
                            </div>

                            <!-- Section Name & Description -->
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-serif text-lg font-bold text-stone-800 leading-tight">
                                        {{ $section['label'] }}
                                    </h3>
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-mono text-stone-500 bg-stone-200/70">
                                        {{ $section['id'] }}
                                    </span>
                                </div>
                                <p class="text-stone-500 text-xs mt-0.5 truncate max-w-md">
                                    @switch($section['id'])
                                        @case('hero')
                                            Hero search bar, value proposition, and 4 slow-travel pillars.
                                            @break
                                        @case('featured_packages')
                                            Curated multi-day journeys grid, duration filters, and bespoke request card.
                                            @break
                                        @case('experiences')
                                            Soulful micro-experiences (claypot culinary, wildlife tracking, Ceylon tea).
                                            @break
                                        @case('trip_builder')
                                            Interactive journey duration, party size, and estimated total investment calculator.
                                            @break
                                        @case('destinations')
                                            Island regions showcase (Cultural Triangle, Ella, Yala safari, Galle coast).
                                            @break
                                        @case('insiders')
                                            Slow travel manifesto, local chauffeur guardians, and insider drivers.
                                            @break
                                        @case('reviews')
                                            Guest verified testimonials carousel and free 48-page editorial guidebook CTA.
                                            @break
                                        @default
                                            Custom homepage component block.
                                    @endswitch
                                </p>
                            </div>
                        </div>

                        <!-- Actions & Visibility Toggle -->
                        <div class="flex items-center gap-3 shrink-0">
                            <!-- Up / Down Reorder Arrows -->
                            <div class="flex items-center gap-1">
                                <button type="button" 
                                        onclick="moveSectionRow(this, -1)" 
                                        class="p-2 rounded-lg text-stone-400 hover:text-forest hover:bg-white border border-transparent hover:border-stone-200 transition-all text-xs" 
                                        title="Move Up">
                                    <i class="fa-solid fa-arrow-up"></i>
                                </button>
                                <button type="button" 
                                        onclick="moveSectionRow(this, 1)" 
                                        class="p-2 rounded-lg text-stone-400 hover:text-forest hover:bg-white border border-transparent hover:border-stone-200 transition-all text-xs" 
                                        title="Move Down">
                                    <i class="fa-solid fa-arrow-down"></i>
                                </button>
                            </div>

                            <!-- Active / Hidden Toggle Switch -->
                            <label class="relative inline-flex items-center cursor-pointer select-none">
                                <input type="checkbox" 
                                       class="section-toggle sr-only peer" 
                                       data-id="{{ $section['id'] }}"
                                       {{ !empty($section['enabled']) ? 'checked' : '' }}
                                       onchange="handleToggleChange()">
                                <div class="w-12 h-6 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                                <span class="toggle-status-label ml-2 text-xs font-semibold {{ !empty($section['enabled']) ? 'text-emerald-700' : 'text-stone-400' }} w-14">
                                    {{ !empty($section['enabled']) ? 'Active' : 'Hidden' }}
                                </span>
                            </label>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Hidden Input for Serialized Layout Payload -->
            <input type="hidden" name="homepage_sections_order" id="homepage_sections_order_input" value="">

            <div class="mt-8 pt-6 border-t border-stone-100 flex items-center justify-between">
                <span class="text-xs text-stone-400">
                    <i class="fa-solid fa-bolt text-amber-500 mr-1"></i> Saving automatically updates live site & purges cache.
                </span>
                <button type="submit" class="px-6 py-2.5 bg-forest hover:bg-forest-light text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk text-terracotta"></i>
                    <span>Save Theme & Section Flow</span>
                </button>
            </div>
        </div>

    </form>

</div>

@push('scripts')
<!-- SortableJS CDN for Drag-and-Drop section ordering -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

<script>
    // Color Sync and Realtime Preview
    function syncColor(sourceId, targetId) {
        const source = document.getElementById(sourceId);
        const target = document.getElementById(targetId);
        if (!source || !target) return;

        let val = source.value;
        if (targetId.startsWith('picker_') && !val.startsWith('#')) {
            val = '#' + val;
        }
        target.value = val;
        updatePreview();
        updateSerializedLayout();
    }

    function applyPreset(primary, secondary, bg, text) {
        document.getElementById('theme_primary_color').value = primary;
        document.getElementById('picker_primary').value = primary;

        document.getElementById('theme_secondary_color').value = secondary;
        document.getElementById('picker_secondary').value = secondary;

        document.getElementById('theme_background_color').value = bg;
        document.getElementById('picker_background').value = bg;

        document.getElementById('theme_text_color').value = text;
        document.getElementById('picker_text').value = text;

        updatePreview();
    }

    function resetDefaults() {
        applyPreset('#1a3b32', '#c86d51', '#f4efe6', '#1e292b');

        // Reset section rows to default order
        const defaultOrder = [
            'hero',
            'featured_packages',
            'experiences',
            'trip_builder',
            'destinations',
            'insiders',
            'reviews'
        ];

        const container = document.getElementById('sortable-sections');
        const rows = Array.from(container.children);

        defaultOrder.forEach((id) => {
            const row = rows.find(r => r.getAttribute('data-id') === id);
            if (row) {
                container.appendChild(row);
                const toggle = row.querySelector('.section-toggle');
                if (toggle) {
                    toggle.checked = true;
                }
            }
        });

        handleToggleChange();
        refreshBadges();
        updateSerializedLayout();
    }

    function updatePreview() {
        const primary = document.getElementById('theme_primary_color').value || '#1a3b32';
        const secondary = document.getElementById('theme_secondary_color').value || '#c86d51';
        const bg = document.getElementById('theme_background_color').value || '#f4efe6';
        const text = document.getElementById('theme_text_color').value || '#1e292b';

        const previewBox = document.getElementById('theme-preview-box');
        if (previewBox) {
            previewBox.style.backgroundColor = bg;
            previewBox.style.color = text;
        }

        const previewBadge = document.getElementById('preview-badge');
        if (previewBadge) previewBadge.style.backgroundColor = secondary;

        const previewHeading = document.getElementById('preview-heading');
        if (previewHeading) previewHeading.style.color = primary;

        const previewText = document.getElementById('preview-text');
        if (previewText) previewText.style.color = text;

        const btnPrimary = document.getElementById('preview-btn-primary');
        if (btnPrimary) btnPrimary.style.backgroundColor = primary;

        const btnSecondary = document.getElementById('preview-btn-secondary');
        if (btnSecondary) btnSecondary.style.backgroundColor = secondary;
    }

    // Section Ordering & Toggles
    function refreshBadges() {
        const container = document.getElementById('sortable-sections');
        const rows = container.querySelectorAll('.section-row');
        rows.forEach((row, idx) => {
            const badge = row.querySelector('.order-badge');
            if (badge) {
                badge.textContent = idx + 1;
            }
        });
    }

    function handleToggleChange() {
        const rows = document.querySelectorAll('.section-row');
        rows.forEach(row => {
            const toggle = row.querySelector('.section-toggle');
            const label = row.querySelector('.toggle-status-label');
            if (toggle && label) {
                if (toggle.checked) {
                    label.textContent = 'Active';
                    label.className = 'toggle-status-label ml-2 text-xs font-semibold text-emerald-700 w-14';
                    row.classList.remove('opacity-60');
                } else {
                    label.textContent = 'Hidden';
                    label.className = 'toggle-status-label ml-2 text-xs font-semibold text-stone-400 w-14';
                    row.classList.add('opacity-60');
                }
            }
        });
        updateSerializedLayout();
    }

    function moveSectionRow(btn, direction) {
        const row = btn.closest('.section-row');
        if (!row) return;

        const container = document.getElementById('sortable-sections');
        if (direction === -1 && row.previousElementSibling) {
            container.insertBefore(row, row.previousElementSibling);
        } else if (direction === 1 && row.nextElementSibling) {
            container.insertBefore(row.nextElementSibling, row);
        }

        refreshBadges();
        updateSerializedLayout();
    }

    function updateSerializedLayout() {
        const container = document.getElementById('sortable-sections');
        if (!container) return;

        const rows = container.querySelectorAll('.section-row');
        const payload = [];

        rows.forEach((row, index) => {
            const id = row.getAttribute('data-id');
            const label = row.querySelector('h3') ? row.querySelector('h3').textContent.trim() : id;
            const toggle = row.querySelector('.section-toggle');
            const enabled = toggle ? toggle.checked : true;

            payload.push({
                id: id,
                label: label,
                enabled: enabled,
                order: index + 1
            });
        });

        const input = document.getElementById('homepage_sections_order_input');
        if (input) {
            input.value = JSON.stringify(payload);
        }
    }

    // Initialize SortableJS
    document.addEventListener('DOMContentLoaded', () => {
        updatePreview();
        updateSerializedLayout();

        const sortableContainer = document.getElementById('sortable-sections');
        if (sortableContainer && window.Sortable) {
            new Sortable(sortableContainer, {
                animation: 200,
                handle: '.drag-handle',
                ghostClass: 'bg-forest/10',
                chosenClass: 'bg-forest/20',
                dragClass: 'shadow-2xl',
                onEnd: () => {
                    refreshBadges();
                    updateSerializedLayout();
                }
            });
        }
    });
</script>
@endpush
@endsection

