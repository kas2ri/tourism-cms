<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - Kiyara Holidays CMS</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-stone-100 text-stone-800 font-sans antialiased min-h-screen flex flex-col md:flex-row">

    <!-- Mobile Top Header Bar -->
    <div class="md:hidden bg-forest-900 text-white p-4 flex items-center justify-between border-b border-forest-800">
        <a href="{{ route('admin.dashboard') }}" class="font-serif text-xl font-bold tracking-tight text-white">
            KIYARA <span class="italic text-terracotta font-serif">admin</span>
        </a>
        <button type="button" onclick="document.getElementById('admin-sidebar').classList.toggle('hidden')" class="text-sand-200 hover:text-white text-xl">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <!-- Admin Sidebar -->
    <aside id="admin-sidebar" class="hidden md:flex flex-col w-full md:w-64 bg-forest-900 text-sand-200 min-h-screen shrink-0 border-r border-forest-800">
        <!-- Brand Header -->
        <div class="p-6 border-b border-forest-800 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col">
                <span class="font-serif text-2xl font-bold tracking-tight text-white">
                    KIYARA <span class="italic text-terracotta font-serif">holidays</span>
                </span>
                <span class="text-[9px] uppercase tracking-[0.25em] text-sand-200/70 font-semibold">CMS Platform</span>
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 p-4 space-y-1.5 text-xs font-medium">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-forest text-white font-bold' : 'hover:bg-forest-800 hover:text-white text-sand-200' }}">
                <i class="fa-solid fa-chart-pie w-4 text-center text-sm {{ request()->routeIs('admin.dashboard') ? 'text-terracotta' : 'text-stone-400' }}"></i>
                <span>Dashboard</span>
            </a>

            <div class="pt-3 pb-1 px-3 text-[10px] uppercase font-bold text-stone-500 tracking-wider">Content Management</div>

            <a href="{{ route('admin.packages.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.packages.*') ? 'bg-forest text-white font-bold' : 'hover:bg-forest-800 hover:text-white text-sand-200' }}">
                <i class="fa-solid fa-route w-4 text-center text-sm {{ request()->routeIs('admin.packages.*') ? 'text-terracotta' : 'text-stone-400' }}"></i>
                <span>Packages & Itineraries</span>
            </a>

            <a href="{{ route('admin.destinations.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.destinations.*') ? 'bg-forest text-white font-bold' : 'hover:bg-forest-800 hover:text-white text-sand-200' }}">
                <i class="fa-solid fa-mountain-sun w-4 text-center text-sm {{ request()->routeIs('admin.destinations.*') ? 'text-terracotta' : 'text-stone-400' }}"></i>
                <span>Destinations</span>
            </a>

            <a href="{{ route('admin.insiders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.insiders.*') ? 'bg-forest text-white font-bold' : 'hover:bg-forest-800 hover:text-white text-sand-200' }}">
                <i class="fa-solid fa-user-tie w-4 text-center text-sm {{ request()->routeIs('admin.insiders.*') ? 'text-terracotta' : 'text-stone-400' }}"></i>
                <span>Insiders & Guides</span>
            </a>

            <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.reviews.*') ? 'bg-forest text-white font-bold' : 'hover:bg-forest-800 hover:text-white text-sand-200' }}">
                <i class="fa-solid fa-star w-4 text-center text-sm {{ request()->routeIs('admin.reviews.*') ? 'text-terracotta' : 'text-stone-400' }}"></i>
                <span>Guest Reviews</span>
            </a>

            <div class="pt-3 pb-1 px-3 text-[10px] uppercase font-bold text-stone-500 tracking-wider">Leads & System</div>

            @php
                $pendingInquiriesCount = \App\Models\Inquiry::where('status', 'new')->count();
            @endphp
            <a href="{{ route('admin.inquiries.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.inquiries.*') ? 'bg-forest text-white font-bold' : 'hover:bg-forest-800 hover:text-white text-sand-200' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-inbox w-4 text-center text-sm {{ request()->routeIs('admin.inquiries.*') ? 'text-terracotta' : 'text-stone-400' }}"></i>
                    <span>Inquiries & Leads</span>
                </div>
                @if($pendingInquiriesCount > 0)
                    <span class="bg-terracotta text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingInquiriesCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.settings.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-forest text-white font-bold' : 'hover:bg-forest-800 hover:text-white text-sand-200' }}">
                <i class="fa-solid fa-sliders w-4 text-center text-sm {{ request()->routeIs('admin.settings.*') ? 'text-terracotta' : 'text-stone-400' }}"></i>
                <span>Site Settings</span>
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-forest-800 space-y-3">
            <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-2 text-xs text-sand-200/80 hover:text-white py-1 transition-colors">
                <i class="fa-solid fa-arrow-up-right-from-square text-terracotta"></i>
                <span>View Public Site</span>
            </a>

            <div class="pt-2 border-t border-forest-800/80 flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs">
                    <div class="w-8 h-8 rounded-full bg-forest-800 text-sand-100 flex items-center justify-center font-bold text-xs">
                        {{ substr(auth()->user()->name ?? 'AD', 0, 2) }}
                    </div>
                    <div class="truncate max-w-[100px]">
                        <div class="font-bold text-white text-xs truncate">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="text-[10px] text-stone-400">Administrator</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="text-stone-400 hover:text-terracotta text-sm p-1.5 transition-colors" title="Log Out">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Action Header -->
        <header class="bg-white border-b border-stone-200 px-6 py-4 flex items-center justify-between">
            <h1 class="font-serif text-2xl font-bold text-forest">
                @yield('page_title', 'Dashboard')
            </h1>
            <div>
                @yield('header_actions')
            </div>
        </header>

        <!-- Page Alerts -->
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold space-y-1 shadow-sm">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600 text-sm"></i>
                        <span>Please correct the errors below:</span>
                    </div>
                    <ul class="list-disc list-inside pl-5 space-y-0.5 font-normal text-rose-700">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Main Body -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>

