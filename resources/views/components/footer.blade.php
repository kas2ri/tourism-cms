<footer class="bg-forest-900 text-sand-200 pt-16 pb-12 border-t border-forest-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 mb-12">
            
            <!-- Brand Info -->
            <div class="lg:col-span-2 space-y-4">
                <a href="{{ url('/') }}" class="font-serif text-3xl font-bold text-white tracking-tight">
                    KIYARA <span class="italic text-terracotta font-serif">holidays</span>
                </a>
                <p class="text-sm text-stone-400 max-w-sm leading-relaxed">
                    Curated island journeys, small group departures, and tailor-made bespoke itineraries celebrating the authentic pulse of Sri Lanka.
                </p>
                <div class="text-xs text-stone-400 space-y-1">
                    <p><i class="fa-solid fa-location-dot text-terracotta mr-2"></i> 42/B Lighthouse Street, Galle Fort, Sri Lanka</p>
                    <p><i class="fa-solid fa-envelope text-terracotta mr-2"></i> hello@kiyaraholidays.com</p>
                    <p><i class="fa-solid fa-phone text-terracotta mr-2"></i> +94 (77) 123-4567</p>
                </div>
            </div>

            <!-- Links: Expeditions -->
            <div>
                <h4 class="font-bold text-sm uppercase tracking-wider text-white mb-4">Expeditions</h4>
                <ul class="text-sm space-y-2 text-stone-400">
                    <li><a href="#expeditions" class="hover:text-sand-100 transition-colors">Small Group Departures</a></li>
                    <li><a href="#expeditions" class="hover:text-sand-100 transition-colors">Heritage Highland Tour</a></li>
                    <li><a href="#expeditions" class="hover:text-sand-100 transition-colors">Wildlife & Leopard Trail</a></li>
                    <li><a href="#expeditions" class="hover:text-sand-100 transition-colors">Ayurvedic Healing Stays</a></li>
                    <li><a href="#trip-builder" class="hover:text-sand-100 transition-colors">Bespoke Honeymoons</a></li>
                </ul>
            </div>

            <!-- Links: Philosophy & Guides -->
            <div>
                <h4 class="font-bold text-sm uppercase tracking-wider text-white mb-4">Discover</h4>
                <ul class="text-sm space-y-2 text-stone-400">
                    <li><a href="#story" class="hover:text-sand-100 transition-colors">Why Kiyara Holidays</a></li>
                    <li><button type="button" onclick="window.openInsidersModal ? window.openInsidersModal() : null" class="hover:text-sand-100 transition-colors text-left">Our Driver-Storytellers</button></li>
                    <li><a href="#experiences" class="hover:text-sand-100 transition-colors">Local Immersions</a></li>
                    <li><button type="button" onclick="window.openGuideModal ? window.openGuideModal() : null" class="hover:text-sand-100 transition-colors text-left">Island Travel Guide</button></li>
                    <li><a href="#reviews" class="hover:text-sand-100 transition-colors">Traveler Reviews</a></li>
                </ul>
            </div>

            <!-- Accreditations & Socials -->
            <div>
                <h4 class="font-bold text-sm uppercase tracking-wider text-white mb-4">Connectedness</h4>
                <p class="text-xs text-stone-400 mb-4">Official Sri Lanka Tourism Development Authority (SLTDA) Licensed Operator.</p>
                <div class="flex items-center space-x-3 text-stone-300">
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-forest-800 hover:bg-terracotta flex items-center justify-center transition-colors" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-forest-800 hover:bg-terracotta flex items-center justify-center transition-colors" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://pinterest.com" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-forest-800 hover:bg-terracotta flex items-center justify-center transition-colors" aria-label="Pinterest"><i class="fa-brands fa-pinterest-p"></i></a>
                </div>
            </div>

        </div>

        <div class="pt-8 border-t border-forest-800 flex flex-col sm:flex-row items-center justify-between text-xs text-stone-500 gap-4">
            <div>
                &copy; {{ date('Y') }} Kiyara Holidays (Pvt) Ltd. All rights reserved. Handcrafted in Sri Lanka.
            </div>
            <div class="flex space-x-6">
                <a href="#story" class="hover:underline">Privacy Policy</a>
                <a href="#story" class="hover:underline">Booking Terms & Conditions</a>
                <a href="#story" class="hover:underline">Sustainability Charter</a>
            </div>
        </div>
    </div>
</footer>

