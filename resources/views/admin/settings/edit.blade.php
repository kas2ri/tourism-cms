@extends('layouts.admin')

@section('title', 'Site Settings')
@section('page_title', 'Site Settings & Brand Configuration')

@section('header_actions')
    <a href="{{ url('/') }}" target="_blank" class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm flex items-center gap-1.5">
        <i class="fa-solid fa-arrow-up-right-from-square text-terracotta"></i> View Public Site
    </a>
@endsection

@section('content')
<div class="max-w-4xl space-y-6">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Company & Legal -->
        <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6 space-y-4">
            <div class="border-b border-stone-200 pb-3">
                <h2 class="text-sm font-bold text-forest uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-building text-terracotta"></i> Company & Tourism Accreditation
                </h2>
                <p class="text-xs text-stone-500 mt-0.5">Official legal entity names and SLTDA license references.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-1">
                <div>
                    <label for="company_name" class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                        Company Name
                    </label>
                    <input type="text" id="company_name" name="company_name" 
                           value="{{ old('company_name', $settings['company_name'] ?? 'Kiyara Holidays (Pvt) Ltd.') }}" 
                           class="w-full text-xs font-medium border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3">
                </div>

                <div>
                    <label for="company_slogan" class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                        Tagline / Brand Slogan
                    </label>
                    <input type="text" id="company_slogan" name="company_slogan" 
                           value="{{ old('company_slogan', $settings['company_slogan'] ?? 'Boutique Ceylon Journeys') }}" 
                           class="w-full text-xs font-medium border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3">
                </div>

                <div class="md:col-span-2">
                    <label for="license_number" class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                        Tourism License / Registration No.
                    </label>
                    <input type="text" id="license_number" name="license_number" 
                           value="{{ old('license_number', $settings['license_number'] ?? 'SLTDA/TDA/02914') }}" 
                           placeholder="e.g. SLTDA/TDA/02914"
                           class="w-full text-xs font-medium border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3">
                    <p class="text-[11px] text-stone-400 mt-1">Displayed in website footer for traveler trust and compliance.</p>
                </div>
            </div>
        </div>

        <!-- Hotlines & Contact Channels -->
        <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6 space-y-4">
            <div class="border-b border-stone-200 pb-3">
                <h2 class="text-sm font-bold text-forest uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-headset text-terracotta"></i> Communication & Concierge Channels
                </h2>
                <p class="text-xs text-stone-500 mt-0.5">Phone numbers, direct WhatsApp links, and guest emergency support.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-1">
                <div>
                    <label for="whatsapp_number" class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                        WhatsApp Concierge Number <span class="text-terracotta">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" id="whatsapp_number" name="whatsapp_number" 
                               value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '+94771234567') }}" 
                               placeholder="+94771234567"
                               class="w-full text-xs font-medium border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3 pl-9">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-emerald-600">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </div>
                    </div>
                    <p class="text-[11px] text-stone-400 mt-1">Powers the live wa.me chat redirect on the floating concierge widget.</p>
                </div>

                <!-- WhatsApp Widget Visibility Toggle -->
                <div class="md:col-span-2 p-4 rounded-xl bg-stone-50 border border-stone-200 flex items-center justify-between">
                    <div>
                        <span class="block text-xs font-bold text-forest uppercase">
                            Enable Floating WhatsApp Concierge Widget
                        </span>
                        <p class="text-[11px] text-stone-500 mt-0.5">
                            Show or hide the floating click-to-chat concierge bubble on the bottom right of the website.
                        </p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer select-none">
                        <input type="hidden" name="whatsapp_widget_enabled" value="0">
                        <input type="checkbox" 
                               name="whatsapp_widget_enabled" 
                               value="1" 
                               class="sr-only peer" 
                               {{ filter_var($settings['whatsapp_widget_enabled'] ?? true, FILTER_VALIDATE_BOOLEAN) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                </div>

                <div>
                    <label for="contact_phone" class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                        Reservations Telephone
                    </label>
                    <input type="text" id="contact_phone" name="contact_phone" 
                           value="{{ old('contact_phone', $settings['contact_phone'] ?? '+94 (77) 123-4567') }}" 
                           placeholder="+94 (77) 123-4567"
                           class="w-full text-xs font-medium border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3">
                </div>

                <div>
                    <label for="emergency_hotline" class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                        24/7 Guest Emergency Hotline
                    </label>
                    <input type="text" id="emergency_hotline" name="emergency_hotline" 
                           value="{{ old('emergency_hotline', $settings['emergency_hotline'] ?? '+94 77 999 8888') }}" 
                           placeholder="+94 77 999 8888"
                           class="w-full text-xs font-medium border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3">
                    <p class="text-[11px] text-stone-400 mt-1">Presented in traveler itinerary briefs and emergency assistance notes.</p>
                </div>

                <div>
                    <label for="contact_email" class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                        Primary Contact Email
                    </label>
                    <input type="email" id="contact_email" name="contact_email" 
                           value="{{ old('contact_email', $settings['contact_email'] ?? 'hello@kiyaraholidays.com') }}" 
                           placeholder="hello@kiyaraholidays.com"
                           class="w-full text-xs font-medium border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3">
                </div>

                <div class="md:col-span-2">
                    <label for="contact_address" class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                        Headquarters Office Address
                    </label>
                    <input type="text" id="contact_address" name="contact_address" 
                           value="{{ old('contact_address', $settings['contact_address'] ?? '42/B Lighthouse Street, Galle Fort, Sri Lanka') }}" 
                           class="w-full text-xs font-medium border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3">
                </div>
            </div>
        </div>

        <!-- Homepage Hero Content -->
        <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6 space-y-4">
            <div class="border-b border-stone-200 pb-3">
                <h2 class="text-sm font-bold text-forest uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-panorama text-terracotta"></i> Homepage Hero Banner
                </h2>
                <p class="text-xs text-stone-500 mt-0.5">Main welcoming headline, background banner image, and trust badges seen by visitors on landing.</p>
            </div>

            <div class="space-y-5 pt-1">
                <!-- Hero Background Image Upload & Preview -->
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                        Hero Background Image
                    </label>
                    @php
                        $currentHeroBg = $settings['hero_background_image'] ?? 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=2000&q=80';
                        $currentHeroBgUrl = (str_starts_with($currentHeroBg, 'http://') || str_starts_with($currentHeroBg, 'https://'))
                            ? $currentHeroBg
                            : \Illuminate\Support\Facades\Storage::url($currentHeroBg);
                    @endphp
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 rounded-xl bg-stone-50 border border-stone-200">
                        <div class="relative w-44 h-24 rounded-lg overflow-hidden border border-stone-200 bg-stone-200 shrink-0 shadow-xs">
                            <img id="hero-banner-preview" 
                                 src="{{ $currentHeroBgUrl }}" 
                                 alt="Hero Banner Preview" 
                                 class="w-full h-full object-cover">
                            <div class="absolute bottom-1 right-1 bg-black/60 text-[9px] text-white px-1.5 py-0.5 rounded font-mono">
                                Active Preview
                            </div>
                        </div>
                        <div class="flex-1 space-y-1.5 w-full">
                            <input type="file" 
                                   id="hero_background_image" 
                                   name="hero_background_image" 
                                   accept="image/*"
                                   onchange="previewHeroImage(event)"
                                   class="block w-full text-xs text-stone-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-forest file:text-white hover:file:bg-forest-light file:cursor-pointer border border-stone-200 rounded-xl p-2 bg-white">
                            <p class="text-[11px] text-stone-400">
                                Upload a high-resolution landscape photograph (JPG, PNG, WebP). Stored in <code class="bg-stone-200 px-1 py-0.5 rounded text-stone-600">banners/</code>. Leave empty to preserve current image.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Hero Headline -->
                <div>
                    <label for="hero_headline" class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                        Hero Headline
                    </label>
                    <input type="text" id="hero_headline" name="hero_headline" 
                           value="{{ old('hero_headline', $settings['hero_headline'] ?? 'Not just a holiday, but a journey that [lingers in your soul.]') }}" 
                           class="w-full text-xs font-serif text-base font-bold text-forest border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3">
                    <p class="text-[11px] text-stone-500 mt-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-info text-terracotta"></i>
                        <span>Tip: Wrap accent words in <strong>[brackets]</strong> (e.g. <code class="bg-stone-100 px-1 py-0.5 rounded text-terracotta">[lingers in your soul.]</code>) to render the terracotta italic underline.</span>
                    </p>
                </div>

                <!-- Hero Subheadline -->
                <div>
                    <label for="hero_subheadline" class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                        Hero Subheadline
                    </label>
                    <textarea id="hero_subheadline" name="hero_subheadline" rows="3" 
                              class="w-full text-xs border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3 leading-relaxed">{{ old('hero_subheadline', $settings['hero_subheadline'] ?? 'We move away from crowded tourist coaches. Join intimate, thoughtfully guided journeys, stay in colonial heritage bungalows and eco-villas, and connect directly with local islanders.') }}</textarea>
                </div>

                <!-- 3-Column Trust Badges Row -->
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                        Hero Bottom Trust Badges
                    </label>
                    <p class="text-[11px] text-stone-400 mb-3">Key selling points displayed directly below the search bar to establish guest trust.</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-stone-500 mb-1">
                                <i class="fa-solid fa-leaf text-emerald-600 mr-1"></i> Trust Badge 1
                            </span>
                            <input type="text" id="hero_badge_1" name="hero_badge_1" 
                                   value="{{ old('hero_badge_1', $settings['hero_badge_1'] ?? 'Carbon-Balanced Trips') }}" 
                                   placeholder="e.g. Carbon-Balanced Trips"
                                   class="w-full text-xs font-medium border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3">
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-stone-500 mb-1">
                                <i class="fa-solid fa-users text-terracotta mr-1"></i> Trust Badge 2
                            </span>
                            <input type="text" id="hero_badge_2" name="hero_badge_2" 
                                   value="{{ old('hero_badge_2', $settings['hero_badge_2'] ?? 'Max 12 Travelers on Groups') }}" 
                                   placeholder="e.g. Max 12 Travelers on Groups"
                                   class="w-full text-xs font-medium border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3">
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-stone-500 mb-1">
                                <i class="fa-solid fa-certificate text-amber-500 mr-1"></i> Trust Badge 3
                            </span>
                            <input type="text" id="hero_badge_3" name="hero_badge_3" 
                                   value="{{ old('hero_badge_3', $settings['hero_badge_3'] ?? 'SLTDA Certified Insider Drivers') }}" 
                                   placeholder="e.g. SLTDA Certified Insider Drivers"
                                   class="w-full text-xs font-medium border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" 
                    class="px-6 py-3 rounded-xl bg-forest hover:bg-forest-800 text-sand-100 text-xs font-bold uppercase tracking-wider transition shadow">
                <i class="fa-solid fa-floppy-disk mr-1.5"></i> Save Site Settings
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewHeroImage(event) {
        const file = event.target.files[0];
        if (file) {
            const preview = document.getElementById('hero-banner-preview');
            if (preview) {
                preview.src = URL.createObjectURL(file);
            }
        }
    }
</script>
@endpush
@endsection
