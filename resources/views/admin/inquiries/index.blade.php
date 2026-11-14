@extends('layouts.admin')

@section('title', 'Manage Inquiries')
@section('page_title', 'Inquiries & Trip Customization Leads')

@section('header_actions')
    <a href="{{ route('admin.inquiries.export', ['status' => $status]) }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow flex items-center gap-1.5">
        <i class="fa-solid fa-file-csv"></i> Export {{ ucfirst($status) }} Leads to CSV
    </a>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Status Tabs -->
    <div class="flex flex-wrap items-center gap-2 border-b border-stone-200 pb-3">
        <a href="{{ route('admin.inquiries.index', ['status' => 'all']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $status === 'all' ? 'bg-forest text-white shadow-sm' : 'bg-white hover:bg-sand-50 text-stone-700 border border-stone-200' }}">
            All Leads ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.inquiries.index', ['status' => 'new']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $status === 'new' ? 'bg-terracotta text-white shadow-sm' : 'bg-white hover:bg-sand-50 text-stone-700 border border-stone-200' }}">
            New Inquiries ({{ $counts['new'] }})
        </a>
        <a href="{{ route('admin.inquiries.index', ['status' => 'contacted']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $status === 'contacted' ? 'bg-sky-600 text-white shadow-sm' : 'bg-white hover:bg-sand-50 text-stone-700 border border-stone-200' }}">
            Contacted ({{ $counts['contacted'] }})
        </a>
        <a href="{{ route('admin.inquiries.index', ['status' => 'converted']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $status === 'converted' ? 'bg-purple-600 text-white shadow-sm' : 'bg-white hover:bg-sand-50 text-stone-700 border border-stone-200' }}">
            Booked / Converted ({{ $counts['converted'] }})
        </a>
        <a href="{{ route('admin.inquiries.index', ['status' => 'archived']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $status === 'archived' ? 'bg-stone-600 text-white shadow-sm' : 'bg-white hover:bg-sand-50 text-stone-700 border border-stone-200' }}">
            Archived ({{ $counts['archived'] }})
        </a>
    </div>

    <!-- Leads Table -->
    <div class="bg-white rounded-3xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-stone-700">
                <thead class="bg-stone-50 text-stone-500 uppercase tracking-wider text-[10px] font-bold border-b border-stone-200">
                    <tr>
                        <th class="p-4">Received</th>
                        <th class="p-4">Traveler Contact</th>
                        <th class="p-4">Party & Duration</th>
                        <th class="p-4">Tier & Preference</th>
                        <th class="p-4">Calculated Budget</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($inquiries as $inq)
                        <tr class="hover:bg-sand-50/50 transition-colors">
                            <td class="p-4 text-stone-500 whitespace-nowrap">
                                <div class="font-bold text-stone-800">{{ $inq->created_at->format('M d, Y') }}</div>
                                <div class="text-[10px] text-stone-400">{{ $inq->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-sm text-forest">{{ $inq->name }}</div>
                                <div class="text-stone-500">{{ $inq->email }}</div>
                                @if($inq->phone)
                                    <div class="text-[11px] text-emerald-700 font-semibold">{{ $inq->phone }}</div>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="font-bold text-stone-800">{{ $inq->guests }} Guests</span>
                                <span class="text-stone-500">&bull; {{ $inq->duration_days ? $inq->duration_days . ' Days' : 'Flexible' }}</span>
                                <div class="text-[11px] text-stone-400">{{ $inq->travel_type ?? 'Private' }}</div>
                            </td>
                            <td class="p-4">
                                <div class="font-semibold text-stone-800">{{ $inq->tier ?? 'Custom' }}</div>
                                <div class="text-[11px] text-stone-400">{{ $inq->preferred_season ?? 'Flexible Dates' }}</div>
                            </td>
                            <td class="p-4 font-bold text-forest text-sm whitespace-nowrap">
                                {{ $inq->estimated_cost_usd ? '$' . number_format($inq->estimated_cost_usd) : 'Bespoke' }}
                            </td>
                            <td class="p-4 text-center">
                                @php
                                    $statusBadge = match($inq->status) {
                                        'new' => 'bg-emerald-100 text-emerald-800',
                                        'contacted' => 'bg-sky-100 text-sky-800',
                                        'converted' => 'bg-purple-100 text-purple-800',
                                        default => 'bg-stone-100 text-stone-600',
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusBadge }}">
                                    {{ $inq->status }}
                                </span>
                            </td>
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.inquiries.show', $inq) }}" class="px-3 py-1.5 bg-stone-100 hover:bg-forest hover:text-white rounded-lg font-bold text-[11px] transition-colors">
                                        View Details
                                    </a>
                                    <form method="POST" action="{{ route('admin.inquiries.destroy', $inq) }}" onsubmit="return confirm('Permanently delete this inquiry?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-600 transition-colors" title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-stone-400">
                                No inquiries match the selected filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($inquiries->hasPages())
            <div class="p-4 border-t border-stone-200">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

