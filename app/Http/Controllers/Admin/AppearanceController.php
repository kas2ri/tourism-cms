<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AppearanceController extends Controller
{
    /**
     * Default layout order and visibility.
     */
    public const DEFAULT_SECTIONS = [
        ['id' => 'hero', 'label' => 'Hero & Quick Search', 'enabled' => true, 'order' => 1],
        ['id' => 'featured_packages', 'label' => 'Signature & Group Journeys', 'enabled' => true, 'order' => 2],
        ['id' => 'experiences', 'label' => 'Experiential Offerings & Soul', 'enabled' => true, 'order' => 3],
        ['id' => 'trip_builder', 'label' => 'Custom Trip Builder & Estimator', 'enabled' => true, 'order' => 4],
        ['id' => 'destinations', 'label' => 'Island Regions & Destinations', 'enabled' => true, 'order' => 5],
        ['id' => 'insiders', 'label' => 'Local Insiders & Drivers', 'enabled' => true, 'order' => 6],
        ['id' => 'reviews', 'label' => 'Guest Testimonials', 'enabled' => true, 'order' => 7],
    ];

    /**
     * Default theme colors.
     */
    public const DEFAULT_THEME = [
        'theme_primary_color' => '#1a3b32',
        'theme_secondary_color' => '#c86d51',
        'theme_background_color' => '#f4efe6',
        'theme_text_color' => '#1e292b',
    ];

    /**
     * Display the Appearance & Layout customization page.
     */
    public function edit(): View
    {
        $themePrimary = setting('theme_primary_color', self::DEFAULT_THEME['theme_primary_color']);
        $themeSecondary = setting('theme_secondary_color', self::DEFAULT_THEME['theme_secondary_color']);
        $themeBackground = setting('theme_background_color', self::DEFAULT_THEME['theme_background_color']);
        $themeText = setting('theme_text_color', self::DEFAULT_THEME['theme_text_color']);

        $sectionsOrder = setting('homepage_sections_order', self::DEFAULT_SECTIONS);
        if (is_string($sectionsOrder)) {
            $sectionsOrder = json_decode($sectionsOrder, true) ?: self::DEFAULT_SECTIONS;
        }

        // Ensure all default sections exist and are indexed
        $existingMap = collect($sectionsOrder)->keyBy('id');
        $mergedSections = [];
        $orderCounter = 1;

        foreach ($sectionsOrder as $sec) {
            $mergedSections[] = [
                'id' => $sec['id'],
                'label' => $sec['label'] ?? (collect(self::DEFAULT_SECTIONS)->firstWhere('id', $sec['id'])['label'] ?? ucfirst($sec['id'])),
                'enabled' => filter_var($sec['enabled'] ?? true, FILTER_VALIDATE_BOOLEAN),
                'order' => (int) ($sec['order'] ?? $orderCounter++),
            ];
        }

        // Add any missing default sections if not present
        foreach (self::DEFAULT_SECTIONS as $def) {
            if (! $existingMap->has($def['id'])) {
                $def['order'] = count($mergedSections) + 1;
                $mergedSections[] = $def;
            }
        }

        usort($mergedSections, fn($a, $b) => ($a['order'] ?? 0) <=> ($b['order'] ?? 0));

        return view('admin.appearance.edit', [
            'themePrimary' => $themePrimary,
            'themeSecondary' => $themeSecondary,
            'themeBackground' => $themeBackground,
            'themeText' => $themeText,
            'sections' => $mergedSections,
        ]);
    }

    /**
     * Update the Appearance & Layout settings.
     */
    public function update(Request $request): RedirectResponse
    {
        if ($request->has('reset_defaults')) {
            foreach (self::DEFAULT_THEME as $key => $color) {
                SiteSetting::set($key, $color, 'text', 'theme');
            }
            SiteSetting::set('homepage_sections_order', self::DEFAULT_SECTIONS, 'json', 'layout');
            Cache::forget('site_settings');

            return redirect()->route('admin.appearance.edit')
                ->with('success', 'Theme and layout settings successfully reset to factory defaults.');
        }

        $validated = $request->validate([
            'theme_primary_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'theme_secondary_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'theme_background_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'theme_text_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'homepage_sections_order' => ['nullable'],
            'sections' => ['nullable', 'array'],
        ]);

        // Save theme colors
        SiteSetting::set('theme_primary_color', $validated['theme_primary_color'], 'text', 'theme');
        SiteSetting::set('theme_secondary_color', $validated['theme_secondary_color'], 'text', 'theme');
        SiteSetting::set('theme_background_color', $validated['theme_background_color'], 'text', 'theme');
        SiteSetting::set('theme_text_color', $validated['theme_text_color'], 'text', 'theme');

        // Process sections order
        $sections = null;
        if (! empty($validated['homepage_sections_order'])) {
            $raw = $validated['homepage_sections_order'];
            $sections = is_string($raw) ? json_decode($raw, true) : $raw;
        }

        if (empty($sections) && ! empty($request->input('sections'))) {
            $sections = $request->input('sections');
        }

        if (! empty($sections) && is_array($sections)) {
            $sanitizedSections = [];
            $order = 1;
            foreach ($sections as $sec) {
                if (isset($sec['id'])) {
                    $sanitizedSections[] = [
                        'id' => $sec['id'],
                        'label' => $sec['label'] ?? (collect(self::DEFAULT_SECTIONS)->firstWhere('id', $sec['id'])['label'] ?? ucfirst($sec['id'])),
                        'enabled' => filter_var($sec['enabled'] ?? false, FILTER_VALIDATE_BOOLEAN),
                        'order' => (int) ($sec['order'] ?? $order++),
                    ];
                }
            }
            usort($sanitizedSections, fn($a, $b) => ($a['order'] ?? 0) <=> ($b['order'] ?? 0));
            SiteSetting::set('homepage_sections_order', $sanitizedSections, 'json', 'layout');
        }

        // Clear application cache explicitly
        Cache::forget('site_settings');

        return redirect()->route('admin.appearance.edit')
            ->with('success', 'Theme and layout settings successfully updated and live cache cleared.');
    }
}

