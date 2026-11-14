@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Overview & Platform Metrics')

@section('header_actions')
    <a href="{{ route('admin.packages.create') }}" class="px-4 py-2 bg-forest hover:bg-forest-light text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow flex items-center gap-1.5">
        <i class="fa-solid fa-plus"></i> New Tour Package
    </a>
@endsection

@section('content')
<div class="space-y-8">
    
    <!-- Metrics Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        <!-- Metric 1 -->
        <div class="bg-white p-5 rounded-3xl border border-stone-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between text-stone-400 mb-2">
                <span class="text-xs uppercase font-bold tracking-wider">Packages</span>
                <i class="fa-solid fa-route text-terracotta text-base"></i>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-forest">{{ $metrics['total_packages'] }}</div>
                <div class="text-[11px] text-stone-500 mt-0.5">Active expeditions</div>
            </div>
        </div>

        <!-- Metric 2 -->
        <div class="bg-white p-5 rounded-3xl border border-stone-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between text-stone-400 mb-2">
                <span class="text-xs uppercase font-bold tracking-wider">Destinations</span>
                <i class="fa-solid fa-mountain-sun text-emerald-600 text-base"></i>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-forest">{{ $metrics['total_destinations'] }}</div>
                <div class="text-[11px] text-stone-500 mt-0.5">Island regions</div>
            </div>
        </div>

        <!-- Metric 3 -->
        <div class="bg-white p-5 rounded-3xl border border-stone-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between text-stone-400 mb-2">
                <span class="text-xs uppercase font-bold tracking-wider">Insiders</span>
                <i class="fa-solid fa-user-tie text-terracotta text-base"></i>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-forest">{{ $metrics['total_insiders'] }}</div>
                <div class="text-[11px] text-stone-500 mt-0.5">Vetted guides</div>
            </div>
        </div>

        <!-- Metric 4 -->
        <div class="bg-white p-5 rounded-3xl border border-stone-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between text-stone-400 mb-2">
                <span class="text-xs uppercase font-bold tracking-wider">Reviews</span>
                <i class="fa-solid fa-star text-gold text-base"></i>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-forest">{{ $metrics['total_reviews'] }}</div>
                <div class="text-[11px] text-stone-500 mt-0.5">5.0 Star testimonials</div>
            </div>
        </div>

        <!-- Metric 5 -->
        <div class="bg-white p-5 rounded-3xl border border-stone-200 shadow-sm flex flex-col justify-between {{ $metrics['pending_inquiries'] > 0 ? 'ring-2 ring-terracotta/30 bg-terracotta/5' : '' }}">
            <div class="flex items-center justify-between text-stone-400 mb-2">
                <span class="text-xs uppercase font-bold tracking-wider text-terracotta">New Leads</span>
                <i class="fa-solid fa-inbox text-terracotta text-base"></i>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-terracotta">{{ $metrics['pending_inquiries'] }}</div>
                <div class="text-[11px] text-stone-500 mt-0.5">Awaiting contact</div>
            </div>
        </div>

        <!-- Metric 6 -->
        <div class="bg-white p-5 rounded-3xl border border-stone-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between text-stone-400 mb-2">
                <span class="text-xs uppercase font-bold tracking-wider">Total Leads</span>
                <i class="fa-solid fa-users text-forest text-base"></i>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-forest">{{ $metrics['total_inquiries'] }}</div>
                <div class="text-[11px] text-stone-500 mt-0.5">All-time proposals</div>
            </div>
        </div>
    </div>

    <!-- Quick Management & Recent Inquiries -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Cols: Incoming Customization Inquiries -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 border border-stone-200 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-serif text-xl font-bold text-forest">Recent Trip Customization Inquiries</h3>
                    <p class="text-xs text-stone-500">Incoming traveler inquiries from the website trip builder and booking modals.</p>
                </div>
                <a href="{{ route('admin.inquiries.index') }}" class="text-xs font-bold text-terracotta hover:underline">
                    View All &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-stone-700">
                    <thead class="bg-stone-50 text-stone-500 uppercase tracking-wider text-[10px] font-bold border-b border-stone-200">
                        <tr>
                            <th class="p-3">Guest Name</th>
                            <th class="p-3">Party & Duration</th>
                            <th class="p-3">Est. Budget</th>
                            <th class="p-3">Status</th>
                            <th class="p-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($recentInquiries as $inq)
                            <tr class="hover:bg-sand-50/50 transition-colors">
                                <td class="p-3">
                                    <div class="font-bold text-forest">{{ $inq->name }}</div>
                                    <div class="text-[11px] text-stone-400">{{ $inq->email }}</div>
                                </td>
                                <td class="p-3">
                                    <div>{{ $inq->guests }} Guests &bull; {{ $inq->duration_days ?? 'N/A' }} Days</div>
                                    <div class="text-[11px] text-stone-400">{{ ucfirst($inq->travel_type ?? 'Private') }} &bull; {{ $inq->tier ?? 'Custom' }}</div>
                                </td>
                                <td class="p-3 font-bold text-forest">
                                    {{ $inq->estimated_cost_usd ? '$' . number_format($inq->estimated_cost_usd) : 'Bespoke' }}
                                </td>
                                <td class="p-3">
                                    @php
                                        $statusBadge = match($inq->status) {
                                            'new' => 'bg-emerald-100 text-emerald-800',
                                            'contacted' => 'bg-sky-100 text-sky-800',
                                            'converted' => 'bg-purple-100 text-purple-800',
                                            default => 'bg-stone-100 text-stone-800',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusBadge }}">
                                        {{ $inq->status }}
                                    </span>
                                </td>
                                <td class="p-3 text-right">
                                    <a href="{{ route('admin.inquiries.show', $inq) }}" class="px-3 py-1 bg-stone-100 hover:bg-forest hover:text-white rounded-lg font-bold text-[11px] transition-colors">
                                        Review
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-stone-400">
                                    No inquiries received yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right 1 Col: Quick Links & Expeditions -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-6 border border-stone-200 shadow-sm">
                <h3 class="font-serif text-xl font-bold text-forest mb-4">Quick Management Actions</h3>
                <div class="grid grid-cols-2 gap-3 text-xs">
                    <a href="{{ route('admin.packages.create') }}" class="p-3 rounded-2xl bg-sand-50 hover:bg-forest hover:text-white border border-sand-200 transition-all flex flex-col items-center text-center gap-1 group">
                        <i class="fa-solid fa-route text-terracotta text-lg group-hover:text-white"></i>
                        <span class="font-bold">Add Tour</span>
                    </a>
                    <a href="{{ route('admin.destinations.create') }}" class="p-3 rounded-2xl bg-sand-50 hover:bg-forest hover:text-white border border-sand-200 transition-all flex flex-col items-center text-center gap-1 group">
                        <i class="fa-solid fa-mountain text-emerald-600 text-lg group-hover:text-white"></i>
                        <span class="font-bold">Add Region</span>
                    </a>
                    <a href="{{ route('admin.insiders.create') }}" class="p-3 rounded-2xl bg-sand-50 hover:bg-forest hover:text-white border border-sand-200 transition-all flex flex-col items-center text-center gap-1 group">
                        <i class="fa-solid fa-user-plus text-terracotta text-lg group-hover:text-white"></i>
                        <span class="font-bold">Add Guide</span>
                    </a>
                    <a href="{{ route('admin.inquiries.export') }}" class="p-3 rounded-2xl bg-sand-50 hover:bg-forest hover:text-white border border-sand-200 transition-all flex flex-col items-center text-center gap-1 group">
                        <i class="fa-solid fa-file-csv text-sky-600 text-lg group-hover:text-white"></i>
                        <span class="font-bold">Export CSV</span>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-stone-200 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-serif text-lg font-bold text-forest">Active Expeditions</h3>
                    <a href="{{ route('admin.packages.index') }}" class="text-xs text-terracotta font-bold hover:underline">All &rarr;</a>
                </div>
                <div class="space-y-3">
                    @foreach($recentPackages as $pkg)
                        <div class="flex items-center justify-between text-xs p-2 rounded-xl bg-stone-50 hover:bg-sand-50 transition-colors">
                            <div class="flex items-center gap-2 truncate pr-2">
                                <span class="w-6 h-6 rounded-full bg-forest text-sand-100 flex items-center justify-center font-bold text-[10px] shrink-0">
                                    {{ $pkg->order ?: $loop->iteration }}
                                </span>
                                <span class="font-bold text-forest truncate">{{ $pkg->title }}</span>
                            </div>
                            <span class="font-bold text-stone-600 shrink-0">${{ number_format($pkg->starting_price_usd) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

