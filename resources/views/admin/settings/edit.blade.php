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
    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
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
                    <p class="text-[11px] text-stone-400 mt-1">Powers the floating live concierge widget.</p>
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
                <p class="text-xs text-stone-500 mt-0.5">Main welcoming headline and intro narrative seen by visitors on landing.</p>
            </div>

            <div class="space-y-4 pt-1">
                <div>
                    <label for="hero_headline" class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                        Hero Headline
                    </label>
                    <input type="text" id="hero_headline" name="hero_headline" 
                           value="{{ old('hero_headline', $settings['hero_headline'] ?? 'Sri Lanka, Felt Deeply. Travel That Moves Slower.') }}" 
                           class="w-full text-xs font-serif text-base font-bold text-forest border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3">
                </div>

                <div>
                    <label for="hero_subheadline" class="block text-xs font-bold text-stone-700 uppercase mb-1.5">
                        Hero Subheadline
                    </label>
                    <textarea id="hero_subheadline" name="hero_subheadline" rows="3" 
                              class="w-full text-xs border-stone-200 rounded-xl shadow-sm focus:border-terracotta focus:ring-terracotta p-3 leading-relaxed">{{ old('hero_subheadline', $settings['hero_subheadline'] ?? 'Boutique small-group departures and bespoke chauffeured journeys celebrating authentic island hospitality, heritage architecture, and untamed nature.') }}</textarea>
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
@endsection
