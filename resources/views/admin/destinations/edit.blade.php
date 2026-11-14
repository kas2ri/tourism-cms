@extends('layouts.admin')

@section('title', 'Edit Destination: ' . $destination->name)
@section('page_title', 'Edit Island Region')

@section('header_actions')
    <a href="{{ route('admin.destinations.index') }}" class="px-4 py-2 border border-stone-300 text-stone-700 hover:bg-stone-100 text-xs font-bold uppercase tracking-wider rounded-xl transition-all">
        &larr; Back to Destinations
    </a>
@endsection

@section('content')
<div class="max-w-2xl bg-white rounded-3xl p-6 sm:p-8 border border-stone-200 shadow-sm">
    <form method="POST" action="{{ route('admin.destinations.update', $destination) }}" enctype="multipart/form-data" class="space-y-6 text-xs">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block font-bold text-stone-700 mb-1">Destination / Region Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $destination->name) }}" required
                   class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm font-semibold">
        </div>

        <div>
            <label for="slug" class="block font-bold text-stone-700 mb-1">Slug *</label>
            <input type="text" id="slug" name="slug" value="{{ old('slug', $destination->slug) }}" required
                   class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">
        </div>

        <div>
            <label for="best_season" class="block font-bold text-stone-700 mb-1">Best Season to Visit</label>
            <input type="text" id="best_season" name="best_season" value="{{ old('best_season', $destination->best_season) }}"
                   class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">
        </div>

        <div>
            <label for="short_desc" class="block font-bold text-stone-700 mb-1">Highlights & Description</label>
            <textarea id="short_desc" name="short_desc" rows="4"
                      class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">{{ old('short_desc', $destination->short_desc) }}</textarea>
        </div>

        <div>
            <label class="block font-bold text-stone-700 mb-1">Current Photo</label>
            @if($destination->hero_image)
                <img src="{{ $destination->hero_image }}" alt="{{ $destination->name }}" class="w-32 h-20 rounded-xl object-cover border border-stone-200 mb-2">
            @endif
            <input type="file" id="hero_image_file" name="hero_image_file" accept="image/jpeg,image/png,image/webp"
                   class="w-full text-xs text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-forest file:text-white hover:file:bg-forest-light cursor-pointer">
        </div>

        <div>
            <label for="hero_image_url" class="block font-bold text-stone-700 mb-1">Or Photo URL</label>
            <input type="text" id="hero_image_url" name="hero_image_url" value="{{ old('hero_image_url', $destination->hero_image) }}"
                   class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-xs">
        </div>

        <div class="flex items-center justify-end gap-4 pt-4 border-t border-stone-100">
            <a href="{{ route('admin.destinations.index') }}" class="px-5 py-2.5 rounded-full border border-stone-300 text-stone-700 hover:bg-stone-100 font-bold">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 bg-forest hover:bg-forest-light text-white font-bold uppercase tracking-wider rounded-full shadow transition-all">
                Update Destination
            </button>
        </div>
    </form>
</div>
@endsection

