<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'emergency_hotline' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:100'],
            'contact_address' => ['nullable', 'string', 'max:255'],
            'hero_headline' => ['nullable', 'string', 'max:255'],
            'hero_subheadline' => ['nullable', 'string'],
        ]);

        foreach ($validated as $key => $val) {
            $group = match ($key) {
                'hero_headline', 'hero_subheadline' => 'homepage',
                'company_name', 'company_slogan', 'license_number' => 'general',
                default => 'contact',
            };
            SiteSetting::set($key, $val, 'text', $group);
        }

        return back()->with('success', 'Site settings updated successfully.');
    }
}
