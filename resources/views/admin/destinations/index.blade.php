@extends('layouts.admin')

@section('title', 'Manage Destinations')
@section('page_title', 'Destinations & Regions')

@section('header_actions')
    <a href="{{ route('admin.destinations.create') }}" class="px-4 py-2 bg-forest hover:bg-forest-light text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow flex items-center gap-1.5">
        <i class="fa-solid fa-plus"></i> New Destination
    </a>
@endsection

@section('content')
<div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-stone-200 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="font-serif text-xl font-bold text-forest">All Curated Island Regions</h2>
            <p class="text-xs text-stone-500">Manage featured destinations, seasonal weather recommendations, and highlight descriptions.</p>
        </div>
        <div class="text-xs text-stone-500 font-medium">
            Showing {{ $destinations->total() }} total regions
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-stone-700">
            <thead class="bg-stone-50 text-stone-500 uppercase tracking-wider text-[10px] font-bold border-b border-stone-200">
                <tr>
                    <th class="p-4">Region Photo & Name</th>
                    <th class="p-4">Best Season</th>
                    <th class="p-4">Description Snippet</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($destinations as $dest)
                    <tr class="hover:bg-sand-50/50 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $dest->hero_image ?? 'https://placehold.co/120x80' }}" alt="{{ $dest->name }}" class="w-16 h-12 rounded-xl object-cover border border-stone-200 shrink-0">
                                <div>
                                    <div class="font-bold text-sm text-forest">{{ $dest->name }}</div>
                                    <div class="text-[11px] text-stone-400">/destinations/{{ $dest->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 font-semibold text-emerald-800">
                            {{ $dest->best_season ?? 'Year-round' }}
                        </td>
                        <td class="p-4 text-stone-600 max-w-md">
                            {{ Str::limit($dest->short_desc, 90) }}
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.destinations.edit', $dest) }}" class="px-3 py-1.5 bg-stone-100 hover:bg-forest hover:text-white rounded-lg font-bold text-[11px] transition-colors">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.destinations.destroy', $dest) }}" onsubmit="return confirm('Delete destination \'{{ $dest->name }}\'?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-600 transition-colors">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-stone-400">
                            No destinations configured yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($destinations->hasPages())
        <div class="p-4 border-t border-stone-200">
            {{ $destinations->links() }}
        </div>
    @endif
</div>
@endsection

