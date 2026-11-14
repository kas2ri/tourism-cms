<!-- Top Notification Bar -->
<div class="bg-forest-900 text-sand-200 text-xs py-2 px-4 border-b border-forest-800">
    <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center gap-1.5 text-emerald-400 font-medium">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                2025/2026 Small Group Season Open
            </span>
            <span class="hidden md:inline text-stone-500">|</span>
            <span class="hidden md:inline text-stone-300">Small groups strictly capped at 12 souls</span>
        </div>
        <div class="flex items-center space-x-4">
            <!-- Currency Selector -->
            <div class="flex items-center space-x-1">
                <i class="fa-solid fa-coins text-stone-400"></i>
                <label for="currency-select" class="sr-only">Currency</label>
                <select id="currency-select" onchange="window.updateCurrency ? window.updateCurrency(this.value) : null" class="bg-transparent text-sand-100 text-xs border-none focus:outline-none cursor-pointer pr-1">
                    <option value="USD" class="text-stone-900">USD ($)</option>
                    <option value="EUR" class="text-stone-900">EUR (€)</option>
                    <option value="GBP" class="text-stone-900">GBP (£)</option>
                    <option value="AUD" class="text-stone-900">AUD (A$)</option>
                </select>
            </div>
            <span class="text-stone-500">|</span>
            <a href="tel:+94771234567" class="hover:text-terracotta transition-colors flex items-center gap-1">
                <i class="fa-solid fa-phone text-[10px]"></i> +94 (77) 123-4567
            </a>
        </div>
    </div>
</div>

<!-- Main Sticky Navigation Bar -->
<nav class="sticky top-0 z-40 bg-[#f4efe6]/95 backdrop-blur-md border-b border-sand-200/80 shadow-sm transition-all duration-300" id="main-nav">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="flex flex-col group">
                <span class="font-serif text-3xl font-bold tracking-tight text-forest group-hover:text-terracotta transition-colors">
                    KIYARA <span class="font-normal italic text-terracotta font-serif">holidays</span>
                </span>
                <span class="text-[10px] tracking-[0.28em] uppercase text-stone-500 font-medium">Boutique Ceylon Journeys</span>
            </a>

            <!-- Desktop Navigation Links -->
            <div class="hidden lg:flex items-center space-x-7 text-sm font-medium text-forest-800">
                <a href="{{ route('packages.index') }}" class="hover:text-terracotta transition-colors">Tour Catalog</a>
                <a href="{{ url('/#expeditions') }}" class="hover:text-terracotta transition-colors">Small Group Trips</a>
                <a href="{{ url('/#experiences') }}" class="hover:text-terracotta transition-colors">Curated Moments</a>
                <a href="{{ url('/#trip-builder') }}" class="text-terracotta hover:text-terracotta-dark font-semibold transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-wand-magic-sparkles text-xs"></i> Cost Estimator
                </a>
                <a href="{{ url('/#story') }}" class="hover:text-terracotta transition-colors">Our Philosophy</a>
                <a href="{{ url('/#reviews') }}" class="hover:text-terracotta transition-colors">Traveler Voices</a>
            </div>

            <!-- Action CTAs -->
            <div class="hidden sm:flex items-center space-x-3">
                <button type="button" onclick="window.openGuideModal ? window.openGuideModal() : null" class="px-4 py-2 text-xs font-semibold uppercase tracking-wider text-forest border border-forest/30 rounded-full hover:bg-forest hover:text-white transition-all">
                    <i class="fa-solid fa-book-open mr-1"></i> Free Island Guide
                </button>
                <button type="button" onclick="window.openInquiryModal ? window.openInquiryModal('General Inquiry') : null" class="px-5 py-2.5 text-xs font-semibold uppercase tracking-wider bg-terracotta text-white rounded-full hover:bg-terracotta-dark shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    Plan My Trip
                </button>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <div class="flex lg:hidden items-center space-x-2">
                <button type="button" onclick="window.toggleMobileMenu ? window.toggleMobileMenu() : null" class="p-2 text-forest text-2xl focus:outline-none" aria-label="Toggle menu">
                    <i id="menu-icon" class="fa-solid fa-bars"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <div id="mobile-menu" class="hidden lg:hidden bg-sand-100 border-b border-sand-200 px-6 py-6 space-y-4">
        <a href="{{ route('packages.index') }}" onclick="window.toggleMobileMenu ? window.toggleMobileMenu() : null" class="block text-base font-medium text-forest hover:text-terracotta">All Tour Packages</a>
        <a href="{{ url('/#expeditions') }}" onclick="window.toggleMobileMenu ? window.toggleMobileMenu() : null" class="block text-base font-medium text-forest hover:text-terracotta">Small Group Trips</a>
        <a href="{{ url('/#experiences') }}" onclick="window.toggleMobileMenu ? window.toggleMobileMenu() : null" class="block text-base font-medium text-forest hover:text-terracotta">Curated Moments</a>
        <a href="{{ url('/#trip-builder') }}" onclick="window.toggleMobileMenu ? window.toggleMobileMenu() : null" class="block text-base font-semibold text-terracotta">Cost Estimator & Trip Builder</a>
        <a href="{{ url('/#story') }}" onclick="window.toggleMobileMenu ? window.toggleMobileMenu() : null" class="block text-base font-medium text-forest hover:text-terracotta">Our Philosophy</a>
        <a href="{{ url('/#reviews') }}" onclick="window.toggleMobileMenu ? window.toggleMobileMenu() : null" class="block text-base font-medium text-forest hover:text-terracotta">Traveler Reviews</a>
        <div class="pt-4 flex flex-col gap-2">
            <button type="button" onclick="window.toggleMobileMenu(); window.openGuideModal();" class="w-full py-2.5 text-xs font-semibold uppercase tracking-wider text-forest border border-forest rounded-full">
                Download Ceylon Travel Guide (PDF)
            </button>
            <button type="button" onclick="window.toggleMobileMenu(); window.openInquiryModal('Mobile Inquiry');" class="w-full py-3 text-xs font-semibold uppercase tracking-wider bg-terracotta text-white rounded-full">
                Design Custom Trip
            </button>
        </div>
    </div>
</nav>

