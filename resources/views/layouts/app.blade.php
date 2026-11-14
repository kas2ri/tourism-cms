<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Kiyara Holidays')) - Boutique Slow Travel & Experiential Journeys Sri Lanka</title>
    <meta name="description" content="@yield('meta_description', 'Boutique, slow, and experiential luxury travel operator based in Sri Lanka. Curated small group departures and bespoke chauffeured journeys.')">

    <!-- OpenGraph Meta -->
    <meta property="og:title" content="@yield('title', 'Kiyara Holidays - Boutique Ceylon Journeys')">
    <meta property="og:description" content="Authentic, slow-paced exploration championing human warmth, wild landscapes, and respectful tourism in Sri Lanka.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Google Fonts Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Dynamic Theme Styling -->
    <style>
        :root {
            --color-primary: {{ setting('theme_primary_color', '#1a3b32') }};
            --color-secondary: {{ setting('theme_secondary_color', '#c86d51') }};
            --color-bg-sand: {{ setting('theme_background_color', '#f4efe6') }};
            --color-text-main: {{ setting('theme_text_color', '#1e292b') }};
        }

        body {
            background-color: var(--color-bg-sand);
            color: var(--color-text-main);
        }

        .bg-forest {
            background-color: var(--color-primary) !important;
        }
        .text-forest {
            color: var(--color-primary) !important;
        }
        .border-forest {
            border-color: var(--color-primary) !important;
        }
        .bg-terracotta {
            background-color: var(--color-secondary) !important;
        }
        .text-terracotta {
            color: var(--color-secondary) !important;
        }
        .border-terracotta {
            border-color: var(--color-secondary) !important;
        }
        .bg-sand-50 {
            background-color: var(--color-bg-sand) !important;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-sand-50 text-stone-800 font-sans antialiased selection:bg-terracotta selection:text-white">

    <!-- Navigation Bar -->
    <x-navbar />

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- Shared Modals and Drawers -->
    <x-itinerary-drawer />
    <x-inquiry-modal />
    <x-guide-modal />
    <x-whatsapp-widget />
    <x-toast />

    @stack('scripts')
</body>
</html>

