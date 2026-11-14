@extends('layouts.admin')

@section('title', 'Add Review')
@section('page_title', 'Create Traveler Testimonial')

@section('header_actions')
    <a href="{{ route('admin.reviews.index') }}" class="px-4 py-2 border border-stone-300 text-stone-700 hover:bg-stone-100 text-xs font-bold uppercase tracking-wider rounded-xl transition-all">
        &larr; Back to Reviews
    </a>
@endsection

@section('content')
<div class="max-w-2xl bg-white rounded-3xl p-6 sm:p-8 border border-stone-200 shadow-sm">
    <form method="POST" action="{{ route('admin.reviews.store') }}" enctype="multipart/form-data" class="space-y-6 text-xs">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="guest_name" class="block font-bold text-stone-700 mb-1">Guest Name *</label>
                <input type="text" id="guest_name" name="guest_name" value="{{ old('guest_name') }}" required placeholder="e.g. Sarah Jenkins"
                       class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm font-semibold">
            </div>

            <div>
                <label for="guest_country" class="block font-bold text-stone-700 mb-1">Guest Origin / City</label>
                <input type="text" id="guest_country" name="guest_country" value="{{ old('guest_country') }}" placeholder="e.g. Melbourne, Australia"
                       class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="rating" class="block font-bold text-stone-700 mb-1">Rating (1 to 5 Stars) *</label>
                <select id="rating" name="rating" class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm bg-white">
                    <option value="5" selected>5 Stars (Outstanding)</option>
                    <option value="4">4 Stars (Very Good)</option>
                    <option value="3">3 Stars (Average)</option>
                </select>
            </div>

            <div>
                <label for="tour_name" class="block font-bold text-stone-700 mb-1">Tour / Journey Taken</label>
                <input type="text" id="tour_name" name="tour_name" value="{{ old('tour_name') }}" placeholder="e.g. Small Group Trip or Private Honeymoon"
                       class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">
            </div>
        </div>

        <div>
            <label for="text" class="block font-bold text-stone-700 mb-1">Review Content *</label>
            <textarea id="text" name="text" rows="4" required placeholder="Guest impression, memories, and experience..."
                      class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">{{ old('text') }}</textarea>
        </div>

        <div>
            <label for="avatar_file" class="block font-bold text-stone-700 mb-1">Optional Guest Photo Avatar</label>
            <input type="file" id="avatar_file" name="avatar_file" accept="image/jpeg,image/png,image/webp"
                   class="w-full text-xs text-stone-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-forest file:text-white hover:file:bg-forest-light cursor-pointer">
        </div>

        <div class="pt-2">
            <label class="flex items-center gap-2 cursor-pointer font-bold text-forest">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', true) ? 'checked' : '' }} class="rounded text-forest focus:ring-forest border-stone-300">
                <span>Feature on Homepage Testimonials Slider</span>
            </label>
        </div>

        <div class="flex items-center justify-end gap-4 pt-4 border-t border-stone-100">
            <a href="{{ route('admin.reviews.index') }}" class="px-5 py-2.5 rounded-full border border-stone-300 text-stone-700 hover:bg-stone-100 font-bold">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 bg-forest hover:bg-forest-light text-white font-bold uppercase tracking-wider rounded-full shadow transition-all">
                Publish Review
            </button>
        </div>
    </form>
</div>
@endsection

