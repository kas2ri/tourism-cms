<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Kiyara Holidays CMS</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-forest-900 text-stone-800 font-sans antialiased min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Ambient Background Glow -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=1600&q=80" 
             alt="Ceylon Landscape" 
             class="w-full h-full object-cover opacity-20 filter blur-sm">
        <div class="absolute inset-0 bg-gradient-to-t from-forest-900 via-forest-900/80 to-forest-900/50"></div>
    </div>

    <div class="relative z-10 max-w-md w-full bg-white rounded-3xl p-8 shadow-2xl border border-sand-200">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex flex-col items-center">
                <span class="font-serif text-3xl font-bold tracking-tight text-forest">
                    KIYARA <span class="italic text-terracotta font-serif">holidays</span>
                </span>
                <span class="text-[10px] tracking-[0.28em] uppercase text-stone-500 font-medium">Boutique Ceylon Journeys</span>
            </a>
            <div class="mt-4 inline-block bg-sand-100 text-forest text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full">
                Admin CMS Portal
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4 text-xs">
            @csrf
            <div>
                <label for="email" class="block font-bold text-stone-700 mb-1">Email Address</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" id="email" name="email" value="{{ old('email', 'admin@kiyaraholidays.com') }}" required autofocus
                           class="w-full pl-10 pr-3 py-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm bg-sand-50/30">
                </div>
            </div>

            <div>
                <label for="password" class="block font-bold text-stone-700 mb-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" id="password" name="password" required value="password123"
                           class="w-full pl-10 pr-3 py-3 rounded-xl border border-stone-300 focus:outline-none focus:border-forest text-sm bg-sand-50/30">
                </div>
            </div>

            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded text-forest focus:ring-forest border-stone-300">
                    <span class="text-stone-600 text-xs">Remember session</span>
                </label>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3.5 bg-forest hover:bg-forest-light text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md">
                    Sign In to CMS
                </button>
            </div>
        </form>

        <div class="mt-6 pt-6 border-t border-sand-200 text-center">
            <p class="text-[11px] text-stone-500">
                Default Credentials: <code class="font-mono bg-sand-100 px-1 py-0.5 rounded text-forest font-bold">admin@kiyaraholidays.com</code> / <code class="font-mono bg-sand-100 px-1 py-0.5 rounded text-forest font-bold">password123</code>
            </p>
        </div>
    </div>
</body>
</html>

