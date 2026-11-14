@extends('layouts.admin')

@section('title', 'Edit Package: ' . $package->title)
@section('page_title', 'Edit Tour Package')

@section('header_actions')
    <a href="{{ route('admin.packages.index') }}" class="px-4 py-2 border border-stone-300 text-stone-700 hover:bg-stone-100 text-xs font-bold uppercase tracking-wider rounded-xl transition-all">
        &larr; Back to Packages
    </a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.packages.update', $package) }}" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    <!-- Main Package Details Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200 shadow-sm space-y-6">
        <h2 class="font-serif text-xl font-bold text-forest border-b border-stone-100 pb-3">Package Overview & Pricing</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <div class="md:col-span-2">
                <label for="title" class="block font-bold text-stone-700 mb-1">Tour Title *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $package->title) }}" required
                       class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm font-semibold">
            </div>

            <div>
                <label for="slug" class="block font-bold text-stone-700 mb-1">URL Slug *</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $package->slug) }}" required
                       class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">
            </div>

            <div>
                <label for="subtitle" class="block font-bold text-stone-700 mb-1">Subtitle / Badge Tagline</label>
                <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $package->subtitle) }}"
                       class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">
            </div>

            <div>
                <label for="duration_days" class="block font-bold text-stone-700 mb-1">Duration (Days) *</label>
                <input type="number" id="duration_days" name="duration_days" value="{{ old('duration_days', $package->duration_days) }}" min="1" max="60" required
                       class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">
            </div>

            <div>
                <label for="starting_price_usd" class="block font-bold text-stone-700 mb-1">Starting Price (USD) *</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-stone-400 font-bold">$</span>
                    <input type="number" id="starting_price_usd" name="starting_price_usd" value="{{ old('starting_price_usd', $package->starting_price_usd) }}" step="0.01" min="0" required
                           class="w-full pl-8 pr-3 py-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm font-bold text-forest">
                </div>
            </div>

            <div>
                <label for="group_size_max" class="block font-bold text-stone-700 mb-1">Max Travelers *</label>
                <input type="number" id="group_size_max" name="group_size_max" value="{{ old('group_size_max', $package->group_size_max) }}" min="1" max="100" required
                       class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">
            </div>

            <div>
                <label for="difficulty" class="block font-bold text-stone-700 mb-1">Trip Difficulty</label>
                <select id="difficulty" name="difficulty" class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm bg-white">
                    <option value="Easy" {{ old('difficulty', $package->difficulty) === 'Easy' ? 'selected' : '' }}>Easy (Leisurely Slow Pace)</option>
                    <option value="Moderate" {{ old('difficulty', $package->difficulty) === 'Moderate' ? 'selected' : '' }}>Moderate (Scenic Hikes & Exploration)</option>
                    <option value="Challenging" {{ old('difficulty', $package->difficulty) === 'Challenging' ? 'selected' : '' }}>Challenging (Highland Trails & Trekking)</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label for="overview" class="block font-bold text-stone-700 mb-1">Short Summary / Overview</label>
                <textarea id="overview" name="overview" rows="3"
                          class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">{{ old('overview', $package->overview) }}</textarea>
            </div>

            <!-- Hero Cover Upload -->
            <div>
                <label class="block font-bold text-stone-700 mb-1">Current Cover Image</label>
                @if($package->hero_image)
                    <img src="{{ $package->hero_image }}" alt="Cover" class="w-32 h-20 rounded-xl object-cover border border-stone-200 mb-2">
                @endif
                <input type="file" id="hero_image_file" name="hero_image_file" accept="image/jpeg,image/png,image/webp"
                       class="w-full text-xs text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-forest file:text-white hover:file:bg-forest-light cursor-pointer">
            </div>

            <div>
                <label for="hero_image_url" class="block font-bold text-stone-700 mb-1">Or Image URL</label>
                <input type="text" id="hero_image_url" name="hero_image_url" value="{{ old('hero_image_url', $package->hero_image) }}"
                       class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-xs">
            </div>

            <div class="flex items-center gap-6 pt-2">
                <label class="flex items-center gap-2 cursor-pointer font-bold text-forest">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $package->is_featured) ? 'checked' : '' }} class="rounded text-forest focus:ring-forest border-stone-300">
                    <span>Feature on Public Homepage</span>
                </label>

                <div class="flex items-center gap-2">
                    <label for="order" class="font-bold text-stone-700">Display Order:</label>
                    <input type="number" id="order" name="order" value="{{ old('order', $package->order) }}" class="w-20 p-2 rounded-xl border border-stone-300 text-xs">
                </div>
            </div>
        </div>
    </div>

    <!-- Day-by-Day Itineraries Repeater Section -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200 shadow-sm space-y-6">
        <div class="flex items-center justify-between border-b border-stone-100 pb-3">
            <div>
                <h2 class="font-serif text-xl font-bold text-forest">Day-by-Day Itinerary Schedule</h2>
                <p class="text-xs text-stone-500">Configure day numbers, milestones, morning/afternoon/evening details, and stay notes.</p>
            </div>
            <button type="button" onclick="addItineraryDay()" class="px-4 py-2 bg-sand-100 hover:bg-forest hover:text-white text-forest text-xs font-bold rounded-xl transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i> Add Itinerary Day
            </button>
        </div>

        <div id="itinerary-days-container" class="space-y-4">
            @forelse($package->itineraries as $index => $it)
                <div class="itinerary-day-row p-5 rounded-2xl bg-sand-50/50 border border-sand-200 space-y-4 text-xs">
                    <div class="flex items-center justify-between font-bold text-forest text-sm">
                        <span class="day-label">Day {{ $it->day_number }}</span>
                        <button type="button" onclick="removeItineraryDay(this)" class="text-stone-400 hover:text-rose-600 text-sm" title="Remove day">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <input type="hidden" name="itineraries[{{ $index }}][day_number]" value="{{ $it->day_number }}" class="day-number-input">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-stone-700 mb-1">Day Title *</label>
                            <input type="text" name="itineraries[{{ $index }}][title]" value="{{ $it->title }}" required class="w-full p-2.5 rounded-xl border border-stone-300 text-xs focus:outline-none focus:border-forest bg-white">
                        </div>
                        <div>
                            <label class="block font-bold text-stone-700 mb-1">Stay Location / Hotels</label>
                            <input type="text" name="itineraries[{{ $index }}][location]" value="{{ $it->location }}" class="w-full p-2.5 rounded-xl border border-stone-300 text-xs focus:outline-none focus:border-forest bg-white">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-bold text-stone-700 mb-1">Morning Activities</label>
                            <textarea name="itineraries[{{ $index }}][morning_desc]" rows="2" class="w-full p-2.5 rounded-xl border border-stone-300 text-xs focus:outline-none focus:border-forest bg-white">{{ $it->morning_desc }}</textarea>
                        </div>
                        <div>
                            <label class="block font-bold text-stone-700 mb-1">Afternoon Details</label>
                            <textarea name="itineraries[{{ $index }}][afternoon_desc]" rows="2" class="w-full p-2.5 rounded-xl border border-stone-300 text-xs focus:outline-none focus:border-forest bg-white">{{ $it->afternoon_desc }}</textarea>
                        </div>
                        <div>
                            <label class="block font-bold text-stone-700 mb-1">Evening & Dinner</label>
                            <textarea name="itineraries[{{ $index }}][evening_desc]" rows="2" class="w-full p-2.5 rounded-xl border border-stone-300 text-xs focus:outline-none focus:border-forest bg-white">{{ $it->evening_desc }}</textarea>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-stone-400 text-center py-4">No itinerary days mapped yet. Click below to add days!</p>
            @endforelse
        </div>

        <button type="button" onclick="addItineraryDay()" class="w-full py-3 border-2 border-dashed border-stone-300 hover:border-forest text-stone-600 hover:text-forest text-xs font-bold uppercase tracking-wider rounded-2xl transition-all">
            + Add Another Day to Route
        </button>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-4">
        <a href="{{ route('admin.packages.index') }}" class="px-6 py-3 rounded-full border border-stone-300 text-xs font-bold text-stone-700 hover:bg-stone-100">
            Cancel
        </a>
        <button type="submit" class="px-8 py-3.5 bg-forest hover:bg-forest-light text-white font-bold text-xs uppercase tracking-wider rounded-full shadow-lg transition-all">
            Update Tour Package
        </button>
    </div>
</form>

@push('scripts')
<script>
    let dayIndex = {{ $package->itineraries->count() + 1 }};

    function addItineraryDay() {
        dayIndex++;
        const container = document.getElementById('itinerary-days-container');
        const count = container.querySelectorAll('.itinerary-day-row').length + 1;

        const row = document.createElement('div');
        row.className = 'itinerary-day-row p-5 rounded-2xl bg-sand-50/50 border border-sand-200 space-y-4 text-xs';
        row.innerHTML = `
            <div class="flex items-center justify-between font-bold text-forest text-sm">
                <span class="day-label">Day ${count}</span>
                <button type="button" onclick="removeItineraryDay(this)" class="text-stone-400 hover:text-rose-600 text-sm" title="Remove day">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
            <input type="hidden" name="itineraries[${dayIndex}][day_number]" value="${count}" class="day-number-input">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-stone-700 mb-1">Day Title *</label>
                    <input type="text" name="itineraries[${dayIndex}][title]" required placeholder="Day title..." class="w-full p-2.5 rounded-xl border border-stone-300 text-xs focus:outline-none focus:border-forest bg-white">
                </div>
                <div>
                    <label class="block font-bold text-stone-700 mb-1">Stay Location / Hotels</label>
                    <input type="text" name="itineraries[${dayIndex}][location]" placeholder="Location or boutique lodge..." class="w-full p-2.5 rounded-xl border border-stone-300 text-xs focus:outline-none focus:border-forest bg-white">
                </div>
                <div class="md:col-span-2">
                    <label class="block font-bold text-stone-700 mb-1">Morning Activities</label>
                    <textarea name="itineraries[${dayIndex}][morning_desc]" rows="2" placeholder="Morning excursions..." class="w-full p-2.5 rounded-xl border border-stone-300 text-xs focus:outline-none focus:border-forest bg-white"></textarea>
                </div>
                <div>
                    <label class="block font-bold text-stone-700 mb-1">Afternoon Details</label>
                    <textarea name="itineraries[${dayIndex}][afternoon_desc]" rows="2" placeholder="Afternoon activities..." class="w-full p-2.5 rounded-xl border border-stone-300 text-xs focus:outline-none focus:border-forest bg-white"></textarea>
                </div>
                <div>
                    <label class="block font-bold text-stone-700 mb-1">Evening & Dinner</label>
                    <textarea name="itineraries[${dayIndex}][evening_desc]" rows="2" placeholder="Evening..." class="w-full p-2.5 rounded-xl border border-stone-300 text-xs focus:outline-none focus:border-forest bg-white"></textarea>
                </div>
            </div>
        `;
        container.appendChild(row);
    }

    function removeItineraryDay(btn) {
        const row = btn.closest('.itinerary-day-row');
        row.remove();
        reindexDays();
    }

    function reindexDays() {
        const rows = document.querySelectorAll('#itinerary-days-container .itinerary-day-row');
        rows.forEach((r, idx) => {
            const num = idx + 1;
            r.querySelector('.day-label').textContent = `Day ${num}`;
            r.querySelector('.day-number-input').value = num;
        });
    }
</script>
@endpush
@endsection

