@extends('layouts.admin')

@section('title', 'Manage Reviews')
@section('page_title', 'Traveler Testimonials & Reviews')

@section('header_actions')
    <a href="{{ route('admin.reviews.create') }}" class="px-4 py-2 bg-forest hover:bg-forest-light text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow flex items-center gap-1.5">
        <i class="fa-solid fa-plus"></i> New Review
    </a>
@endsection

@section('content')
<div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-stone-200 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="font-serif text-xl font-bold text-forest">Guest Impressions & Feedback</h2>
            <p class="text-xs text-stone-500">Approve, feature, and edit traveler stories displayed on the homepage testimonials slider.</p>
        </div>
        <div class="text-xs text-stone-500 font-medium">
            Showing {{ $reviews->total() }} total reviews
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-stone-700">
            <thead class="bg-stone-50 text-stone-500 uppercase tracking-wider text-[10px] font-bold border-b border-stone-200">
                <tr>
                    <th class="p-4">Guest & Country</th>
                    <th class="p-4">Rating</th>
                    <th class="p-4">Tour Name</th>
                    <th class="p-4">Review Excerpt</th>
                    <th class="p-4 text-center">Featured</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($reviews as $rev)
                    <tr class="hover:bg-sand-50/50 transition-colors">
                        <td class="p-4">
                            <div class="font-bold text-sm text-forest">{{ $rev->guest_name }}</div>
                            <div class="text-[11px] text-stone-400">{{ $rev->guest_country ?? 'Verified Guest' }}</div>
                        </td>
                        <td class="p-4 text-gold">
                            @for($i = 0; $i < $rev->rating; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </td>
                        <td class="p-4 font-semibold text-stone-800">
                            {{ $rev->tour_name ?? 'Bespoke Tour' }}
                        </td>
                        <td class="p-4 text-stone-600 max-w-sm">
                            "{{ Str::limit($rev->text, 90) }}"
                        </td>
                        <td class="p-4 text-center">
                            <form method="POST" action="{{ route('admin.reviews.toggle-featured', $rev) }}" class="inline">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase transition-colors {{ $rev->is_featured ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-stone-100 text-stone-500 hover:bg-stone-200' }}" title="Click to toggle featured state">
                                    {{ $rev->is_featured ? 'Featured' : 'Hidden' }}
                                </button>
                            </form>
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.reviews.edit', $rev) }}" class="px-3 py-1.5 bg-stone-100 hover:bg-forest hover:text-white rounded-lg font-bold text-[11px] transition-colors">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.reviews.destroy', $rev) }}" onsubmit="return confirm('Delete review from \'{{ $rev->guest_name }}\'?');" class="inline">
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
                        <td colspan="6" class="p-8 text-center text-stone-400">
                            No reviews recorded yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reviews->hasPages())
        <div class="p-4 border-t border-stone-200">
            {{ $reviews->links() }}
        </div>
    @endif
</div>
@endsection

