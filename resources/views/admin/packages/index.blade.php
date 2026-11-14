@extends('layouts.admin')

@section('title', 'Manage Packages')
@section('page_title', 'Tour Packages & Curated Itineraries')

@section('header_actions')
    <a href="{{ route('admin.packages.create') }}" class="px-4 py-2 bg-forest hover:bg-forest-light text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow flex items-center gap-1.5">
        <i class="fa-solid fa-plus"></i> New Tour Package
    </a>
@endsection

@section('content')
<div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-stone-200 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="font-serif text-xl font-bold text-forest">All Curated Expeditions</h2>
            <p class="text-xs text-stone-500">Manage packages, reorder displays, upload hero cover photography, and configure day-by-day itineraries.</p>
        </div>
        <div class="text-xs text-stone-500 font-medium">
            Showing {{ $packages->total() }} total packages
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-stone-700">
            <thead class="bg-stone-50 text-stone-500 uppercase tracking-wider text-[10px] font-bold border-b border-stone-200">
                <tr>
                    <th class="p-4 w-12 text-center">Order</th>
                    <th class="p-4">Cover & Title</th>
                    <th class="p-4">Duration</th>
                    <th class="p-4">Price (USD)</th>
                    <th class="p-4">Difficulty & Size</th>
                    <th class="p-4 text-center">Featured</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($packages as $pkg)
                    <tr class="hover:bg-sand-50/50 transition-colors">
                        <td class="p-4 text-center font-bold text-forest text-sm">
                            <span class="inline-block w-7 h-7 leading-7 rounded-full bg-stone-100">
                                {{ $pkg->order }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $pkg->hero_image ?? 'https://placehold.co/120x80' }}" 
                                     alt="{{ $pkg->title }}" 
                                     class="w-16 h-12 rounded-xl object-cover border border-stone-200 shrink-0">
                                <div>
                                    <div class="font-bold text-sm text-forest">{{ $pkg->title }}</div>
                                    <div class="text-[11px] text-stone-400">/packages/{{ $pkg->slug }} &bull; {{ $pkg->itineraries_count }} days mapped</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="font-semibold">{{ $pkg->duration_days }} Days / {{ max(1, $pkg->duration_days - 1) }} Nights</span>
                        </td>
                        <td class="p-4 font-bold text-forest text-sm">
                            ${{ number_format($pkg->starting_price_usd) }}
                        </td>
                        <td class="p-4">
                            <div>{{ $pkg->difficulty ?? 'Moderate' }}</div>
                            <div class="text-[11px] text-stone-400">Max {{ $pkg->group_size_max }} guests</div>
                        </td>
                        <td class="p-4 text-center">
                            @if($pkg->is_featured)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800">Featured</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-stone-100 text-stone-500">Standard</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.packages.edit', $pkg) }}" class="px-3 py-1.5 bg-stone-100 hover:bg-forest hover:text-white rounded-lg font-bold text-[11px] transition-colors" title="Edit Package">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.packages.destroy', $pkg) }}" onsubmit="return confirm('Delete package \'{{ $pkg->title }}\' and all its itineraries?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-600 transition-colors" title="Delete Package">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-stone-400">
                            No packages found. Create your first tour package above!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($packages->hasPages())
        <div class="p-4 border-t border-stone-200">
            {{ $packages->links() }}
        </div>
    @endif
</div>
@endsection

