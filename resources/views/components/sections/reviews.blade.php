<!-- Reviews Slider / Guest Testimonials Section -->
<x-reviews-slider :reviews="$reviews ?? []" />

<!-- Guidebook Call To Action Banner -->
<section class="py-20 bg-forest-900 text-sand-50 relative overflow-hidden">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <span class="inline-block px-3 py-1 bg-terracotta text-white text-[11px] font-bold uppercase tracking-widest rounded-full mb-4">
            Free 2025 Edition
        </span>
        <h2 class="font-serif text-3xl sm:text-5xl font-bold text-white mb-4">
            The Insider’s Guide to Ceylon: 40 Hidden Corners
        </h2>
        <p class="text-sand-200 text-base max-w-2xl mx-auto mb-8 font-light">
            Download our free 48-page editorial guidebook. Packed with vetted boutique stays, tipping etiquette, train ticket secrets, and street food safety tips.
        </p>

        <form onsubmit="window.handleInlineGuide ? window.handleInlineGuide(event) : null" class="max-w-md mx-auto flex flex-col sm:flex-row gap-2">
            @csrf
            <label for="inline-guide-email" class="sr-only">Email address</label>
            <input type="email" id="inline-guide-email" name="email" required placeholder="Enter your email address..." 
                   class="px-5 py-3 rounded-full bg-white/10 text-white placeholder-stone-400 border border-white/20 focus:outline-none focus:ring-2 focus:ring-terracotta flex-1 text-sm">
            <button type="submit" class="px-6 py-3 bg-terracotta hover:bg-terracotta-dark text-white rounded-full text-xs uppercase font-bold tracking-wider transition-all">
                Download PDF
            </button>
        </form>
    </div>
</section>

