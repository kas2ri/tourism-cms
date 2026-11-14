<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Show settings edit form.
     */
    public function edit(): View
    {
        $settings = SiteSetting::all()->pluck('value', 'key');
        return view('admin.settings.edit', compact('settings'));
    }

    /**
     * Update site settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => ['nullable', 'string', 'max:150'],
            'company_slogan' => ['nullable', 'string', 'max:100'],
            'license_number' => ['nullable', 'string', 'max:50'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'whatsapp_number' => ['nullable', 'string', 'max:50'],
            'whatsapp_widget_enabled' => ['nullable'],
            'emergency_hotline' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:100'],
            'contact_address' => ['nullable', 'string', 'max:255'],
            'hero_headline' => ['nullable', 'string', 'max:255'],
            'hero_subheadline' => ['nullable', 'string'],
            'hero_background_image' => ['nullable', 'image', 'max:10240'],
            'hero_badge_1' => ['nullable', 'string', 'max:100'],
            'hero_badge_2' => ['nullable', 'string', 'max:100'],
            'hero_badge_3' => ['nullable', 'string', 'max:100'],
        ]);

        // Handle Hero Background Image Upload
        if ($request->hasFile('hero_background_image')) {
            $path = $request->file('hero_background_image')->store('banners', 'public');
            SiteSetting::set('hero_background_image', $path, 'text', 'homepage');
        }
        unset($validated['hero_background_image']);

        // Handle WhatsApp Widget Enabled Toggle
        if ($request->has('whatsapp_widget_enabled')) {
            $widgetEnabled = filter_var($request->input('whatsapp_widget_enabled'), FILTER_VALIDATE_BOOLEAN);
            SiteSetting::set('whatsapp_widget_enabled', $widgetEnabled ? '1' : '0', 'boolean', 'contact');
            unset($validated['whatsapp_widget_enabled']);
        }

        foreach ($validated as $key => $val) {
            $group = match ($key) {
                'hero_headline', 'hero_subheadline', 'hero_badge_1', 'hero_badge_2', 'hero_badge_3' => 'homepage',
                'company_name', 'company_slogan', 'license_number' => 'general',
                default => 'contact',
            };
            SiteSetting::set($key, $val, 'text', $group);
        }

        // Clear application cache immediately
        Cache::forget('site_settings');

        return back()->with('success', 'Site settings updated successfully.');
    }
}
