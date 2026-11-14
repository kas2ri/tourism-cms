@extends('layouts.admin')

@section('title', 'Manage Insiders')
@section('page_title', 'Insiders & Driver-Storytellers')

@section('header_actions')
    <a href="{{ route('admin.insiders.create') }}" class="px-4 py-2 bg-forest hover:bg-forest-light text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow flex items-center gap-1.5">
        <i class="fa-solid fa-plus"></i> New Insider Guide
    </a>
@endsection

@section('content')
<div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-stone-200 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="font-serif text-xl font-bold text-forest">Our Island Storytellers</h2>
            <p class="text-xs text-stone-500">Manage licensed guides, naturalists, and wellness curators showcased to travelers.</p>
        </div>
        <div class="text-xs text-stone-500 font-medium">
            Showing {{ $insiders->total() }} total insiders
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-stone-700">
            <thead class="bg-stone-50 text-stone-500 uppercase tracking-wider text-[10px] font-bold border-b border-stone-200">
                <tr>
                    <th class="p-4">Guide Photo & Name</th>
                    <th class="p-4">Role / Title</th>
                    <th class="p-4">Experience</th>
                    <th class="p-4">Languages</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($insiders as $insider)
                    <tr class="hover:bg-sand-50/50 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $insider->avatar ?? 'https://placehold.co/100x100' }}" alt="{{ $insider->name }}" class="w-12 h-12 rounded-full object-cover border-2 border-forest shrink-0">
                                <div>
                                    <div class="font-bold text-sm text-forest">{{ $insider->name }}</div>
                                    <div class="text-[11px] text-stone-400 line-clamp-1 max-w-xs">"{{ $insider->bio }}"</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 font-semibold text-stone-800">
                            {{ $insider->role }}
                        </td>
                        <td class="p-4 font-bold text-terracotta">
                            {{ $insider->experience_years }} Years
                        </td>
                        <td class="p-4">
                            {{ is_array($insider->languages) ? implode(', ', $insider->languages) : ($insider->languages ?? 'English') }}
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.insiders.edit', $insider) }}" class="px-3 py-1.5 bg-stone-100 hover:bg-forest hover:text-white rounded-lg font-bold text-[11px] transition-colors">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.insiders.destroy', $insider) }}" onsubmit="return confirm('Delete insider \'{{ $insider->name }}\'?');" class="inline">
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
                        <td colspan="5" class="p-8 text-center text-stone-400">
                            No insiders added yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($insiders->hasPages())
        <div class="p-4 border-t border-stone-200">
            {{ $insiders->links() }}
        </div>
    @endif
</div>
@endsection

