@extends('layouts.admin')

@section('title', 'Inquiry: ' . $inquiry->name)
@section('page_title', 'Inquiry Details: ' . $inquiry->name)

@section('header_actions')
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.inquiries.index') }}" class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Back to Inquiries
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Top Status Banner -->
    <div class="bg-white rounded-2xl border border-stone-200 p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            @if($inquiry->status === 'new')
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full uppercase tracking-wider">New Inquiry</span>
            @elseif($inquiry->status === 'contacted')
                <span class="px-3 py-1 bg-sky-100 text-sky-800 text-xs font-bold rounded-full uppercase tracking-wider">Contacted</span>
            @elseif($inquiry->status === 'converted')
                <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-bold rounded-full uppercase tracking-wider">Booked / Converted</span>
            @else
                <span class="px-3 py-1 bg-stone-100 text-stone-700 text-xs font-bold rounded-full uppercase tracking-wider">Archived</span>
            @endif
            <span class="text-xs text-stone-400">Received {{ $inquiry->created_at->format('d M Y, h:i A') }} ({{ $inquiry->created_at->diffForHumans() }})</span>
        </div>

        <div class="flex items-center gap-2">
            @php
                $cleanPhone = preg_replace('/[^0-9]/', '', $inquiry->phone);
            @endphp
            @if($cleanPhone)
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('Hello ' . $inquiry->name . ', thank you for contacting Kiyara Holidays regarding your bespoke journey in Sri Lanka!') }}" 
                   target="_blank" rel="noopener"
                   class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition-all shadow-sm flex items-center gap-2">
                    <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp Traveler
                </a>
            @endif
            <a href="mailto:{{ $inquiry->email }}?subject={{ urlencode('Kiyara Holidays - Your Custom Journey Inquiry') }}" 
               class="px-4 py-2 bg-forest hover:bg-forest-800 text-sand-100 text-xs font-bold rounded-xl transition-all shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-envelope text-sm"></i> Email Traveler
            </a>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Traveler & Trip Specification (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Traveler Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6">
                <h2 class="text-xs font-bold tracking-wider text-stone-500 uppercase mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-user text-terracotta"></i> Traveler Contact Profile
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-3 bg-stone-50 rounded-xl border border-stone-100">
                        <span class="text-[10px] uppercase font-bold text-stone-400 block mb-0.5">Full Name</span>
                        <span class="text-sm font-bold text-forest">{{ $inquiry->name }}</span>
                    </div>
                    <div class="p-3 bg-stone-50 rounded-xl border border-stone-100">
                        <span class="text-[10px] uppercase font-bold text-stone-400 block mb-0.5">Country / Residence</span>
                        <span class="text-sm font-semibold text-stone-800">{{ $inquiry->country ?: 'Not Specified' }}</span>
                    </div>
                    <div class="p-3 bg-stone-50 rounded-xl border border-stone-100">
                        <span class="text-[10px] uppercase font-bold text-stone-400 block mb-0.5">Email Address</span>
                        <a href="mailto:{{ $inquiry->email }}" class="text-sm font-semibold text-terracotta hover:underline break-all">
                            {{ $inquiry->email }}
                        </a>
                    </div>
                    <div class="p-3 bg-stone-50 rounded-xl border border-stone-100">
                        <span class="text-[10px] uppercase font-bold text-stone-400 block mb-0.5">Phone / WhatsApp</span>
                        <a href="tel:{{ $inquiry->phone }}" class="text-sm font-semibold text-forest hover:text-terracotta">
                            {{ $inquiry->phone ?: 'Not Specified' }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Trip Requirements Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6">
                <h2 class="text-xs font-bold tracking-wider text-stone-500 uppercase mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-compass text-terracotta"></i> Journey Specifications
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <div class="p-4 bg-stone-50 rounded-xl border border-stone-100">
                        <span class="text-[10px] uppercase font-bold text-stone-400 block mb-1">Travel Style</span>
                        <span class="text-sm font-bold text-forest capitalize">{{ $inquiry->travel_type ?: 'Bespoke Tour' }}</span>
                    </div>
                    <div class="p-4 bg-stone-50 rounded-xl border border-stone-100">
                        <span class="text-[10px] uppercase font-bold text-stone-400 block mb-1">Duration</span>
                        <span class="text-sm font-bold text-forest">{{ $inquiry->duration_days }} Days</span>
                    </div>
                    <div class="p-4 bg-stone-50 rounded-xl border border-stone-100">
                        <span class="text-[10px] uppercase font-bold text-stone-400 block mb-1">Party Size</span>
                        <span class="text-sm font-bold text-forest">{{ $inquiry->guests }} Travelers</span>
                    </div>
                    <div class="p-4 bg-stone-50 rounded-xl border border-stone-100">
                        <span class="text-[10px] uppercase font-bold text-stone-400 block mb-1">Preferred Season</span>
                        <span class="text-sm font-bold text-forest">{{ $inquiry->preferred_season ?: 'Any Season' }}</span>
                    </div>
                    <div class="p-4 bg-stone-50 rounded-xl border border-stone-100">
                        <span class="text-[10px] uppercase font-bold text-stone-400 block mb-1">Stay / Hotel Tier</span>
                        <span class="text-sm font-bold text-forest capitalize">{{ $inquiry->tier ?: 'Boutique Heritage' }}</span>
                    </div>
                    <div class="p-4 bg-terracotta/10 border border-terracotta/30 rounded-xl">
                        <span class="text-[10px] uppercase font-bold text-terracotta block mb-1">Est. Total Budget</span>
                        <span class="text-lg font-serif font-bold text-forest">
                            ${{ number_format($inquiry->estimated_cost_usd, 0) }}
                        </span>
                        <span class="text-[10px] text-stone-500 block">USD Total</span>
                    </div>
                </div>
            </div>

            <!-- Guest Notes / Requests -->
            <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6">
                <h2 class="text-xs font-bold tracking-wider text-stone-500 uppercase mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-message text-terracotta"></i> Special Wishes & Traveler Notes
                </h2>
                @if($inquiry->notes)
                    <div class="p-4 bg-stone-50 rounded-xl border-l-4 border-terracotta text-sm text-stone-800 leading-relaxed whitespace-pre-line font-serif italic">
                        "{{ $inquiry->notes }}"
                    </div>
                @else
                    <p class="text-xs text-stone-400 italic">No special preferences, dietary notes, or comments provided.</p>
                @endif
            </div>
        </div>

        <!-- Right Side: Status Management & Admin Notes -->
        <div class="space-y-6">
            <!-- Update Status Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6">
                <h2 class="text-xs font-bold tracking-wider text-stone-500 uppercase mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-gear text-terracotta"></i> Update Lead Status
                </h2>
                
                <form action="{{ route('admin.inquiries.update', $inquiry) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="status" class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                            Lead Stage
                        </label>
                        <select id="status" name="status" 
                                class="w-full text-xs font-medium border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3">
                            <option value="new" {{ old('status', $inquiry->status) === 'new' ? 'selected' : '' }}>
                                🟢 New (Pending Outreach)
                            </option>
                            <option value="contacted" {{ old('status', $inquiry->status) === 'contacted' ? 'selected' : '' }}>
                                🔵 Contacted (Proposal Dispatched)
                            </option>
                            <option value="converted" {{ old('status', $inquiry->status) === 'converted' ? 'selected' : '' }}>
                                🟣 Converted / Booked Journey
                            </option>
                            <option value="archived" {{ old('status', $inquiry->status) === 'archived' ? 'selected' : '' }}>
                                ⚫ Archived / Closed
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="notes" class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                            Concierge Notes / Updates
                        </label>
                        <textarea id="notes" name="notes" rows="4" 
                                  placeholder="Update or add private concierge notes..."
                                  class="w-full text-xs border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3 leading-relaxed">{{ old('notes', $inquiry->notes) }}</textarea>
                    </div>

                    <button type="submit" 
                            class="w-full py-3 px-4 rounded-xl bg-forest hover:bg-forest-800 text-sand-100 font-bold text-xs tracking-wider uppercase transition shadow">
                        Save Status & Notes
                    </button>
                </form>
            </div>

            <!-- Danger Zone: Delete -->
            <div class="bg-rose-50/50 rounded-2xl border border-rose-200 p-6">
                <h3 class="text-xs font-bold text-rose-800 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-trash-can"></i> Delete Record
                </h3>
                <p class="text-xs text-rose-600/90 mb-4">
                    Permanently delete this inquiry from database records.
                </p>
                <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to permanently delete this inquiry record?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full py-2.5 px-3 text-xs font-bold rounded-xl bg-rose-600 hover:bg-rose-700 text-white transition shadow-sm">
                        Delete Lead
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
