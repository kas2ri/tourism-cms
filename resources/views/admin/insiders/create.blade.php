@extends('layouts.admin')

@section('title', 'Add Insider')
@section('page_title', 'Create Insider / Guide Profile')

@section('header_actions')
    <a href="{{ route('admin.insiders.index') }}" class="px-4 py-2 border border-stone-300 text-stone-700 hover:bg-stone-100 text-xs font-bold uppercase tracking-wider rounded-xl transition-all">
        &larr; Back to Insiders
    </a>
@endsection

@section('content')
<div class="max-w-2xl bg-white rounded-3xl p-6 sm:p-8 border border-stone-200 shadow-sm">
    <form method="POST" action="{{ route('admin.insiders.store') }}" enctype="multipart/form-data" class="space-y-6 text-xs">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block font-bold text-stone-700 mb-1">Full Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Rohan Jayawardena"
                       class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm font-semibold">
            </div>

            <div>
                <label for="role" class="block font-bold text-stone-700 mb-1">Role / Guiding Specialty *</label>
                <input type="text" id="role" name="role" value="{{ old('role') }}" required placeholder="e.g. Driver-Storyteller"
                       class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="experience_years" class="block font-bold text-stone-700 mb-1">Years of Experience *</label>
                <input type="number" id="experience_years" name="experience_years" value="{{ old('experience_years', 10) }}" min="0" max="60" required
                       class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">
            </div>

            <div>
                <label for="languages" class="block font-bold text-stone-700 mb-1">Languages Spoken (comma separated)</label>
                <input type="text" id="languages" name="languages" value="{{ old('languages', 'English, Sinhala') }}" placeholder="e.g. English, Sinhala, Tamil"
                       class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">
            </div>
        </div>

        <div>
            <label for="bio" class="block font-bold text-stone-700 mb-1">Storyteller Bio / Philosophy Quote *</label>
            <textarea id="bio" name="bio" rows="4" required placeholder="Personal philosophy, roots, and island memories shared with travelers..."
                      class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm">{{ old('bio') }}</textarea>
        </div>

        <div>
            <label for="avatar_file" class="block font-bold text-stone-700 mb-1">Upload Portrait Photo</label>
            <input type="file" id="avatar_file" name="avatar_file" accept="image/jpeg,image/png,image/webp"
                   class="w-full text-xs text-stone-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-forest file:text-white hover:file:bg-forest-light cursor-pointer">
        </div>

        <div>
            <label for="avatar_url" class="block font-bold text-stone-700 mb-1">Or Photo URL</label>
            <input type="text" id="avatar_url" name="avatar_url" value="{{ old('avatar_url') }}" placeholder="https://images.unsplash.com/..."
                   class="w-full p-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-xs">
        </div>

        <div class="flex items-center justify-end gap-4 pt-4 border-t border-stone-100">
            <a href="{{ route('admin.insiders.index') }}" class="px-5 py-2.5 rounded-full border border-stone-300 text-stone-700 hover:bg-stone-100 font-bold">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 bg-forest hover:bg-forest-light text-white font-bold uppercase tracking-wider rounded-full shadow transition-all">
                Save Insider Profile
            </button>
        </div>
    </form>
</div>
@endsection

