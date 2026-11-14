<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class ThemeAndLayoutSeeder extends Seeder
{
    /**
     * Run the database seeds for Color Theme & Homepage Section Layout.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'hero_headline',
                'value' => 'Not just a holiday, but a journey that [lingers in your soul.]',
                'type' => 'text',
                'group' => 'homepage',
            ],
            [
                'key' => 'hero_subheadline',
                'value' => 'We move away from crowded tourist coaches. Join intimate, thoughtfully guided journeys, stay in colonial heritage bungalows and eco-villas, and connect directly with local islanders.',
                'type' => 'text',
                'group' => 'homepage',
            ],
            [
                'key' => 'hero_background_image',
                'value' => 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=2000&q=80',
                'type' => 'text',
                'group' => 'homepage',
            ],
            [
                'key' => 'hero_badge_1',
                'value' => 'Carbon-Balanced Trips',
                'type' => 'text',
                'group' => 'homepage',
            ],
            [
                'key' => 'hero_badge_2',
                'value' => 'Max 12 Travelers on Groups',
                'type' => 'text',
                'group' => 'homepage',
            ],
            [
                'key' => 'hero_badge_3',
                'value' => 'SLTDA Certified Insider Drivers',
                'type' => 'text',
                'group' => 'homepage',
            ],
            [
                'key' => 'whatsapp_widget_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'contact',
            ],
            [
                'key' => 'theme_primary_color',
                'value' => '#1a3b32',
                'type' => 'text',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_secondary_color',
                'value' => '#c86d51',
                'type' => 'text',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_background_color',
                'value' => '#f4efe6',
                'type' => 'text',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_text_color',
                'value' => '#1e292b',
                'type' => 'text',
                'group' => 'theme',
            ],
            [
                'key' => 'homepage_sections_order',
                'value' => json_encode([
                    ['id' => 'hero', 'label' => 'Hero & Quick Search', 'enabled' => true, 'order' => 1],
                    ['id' => 'featured_packages', 'label' => 'Signature & Group Journeys', 'enabled' => true, 'order' => 2],
                    ['id' => 'experiences', 'label' => 'Experiential Offerings & Soul', 'enabled' => true, 'order' => 3],
                    ['id' => 'trip_builder', 'label' => 'Custom Trip Builder & Estimator', 'enabled' => true, 'order' => 4],
                    ['id' => 'destinations', 'label' => 'Island Regions & Destinations', 'enabled' => true, 'order' => 5],
                    ['id' => 'insiders', 'label' => 'Local Insiders & Drivers', 'enabled' => true, 'order' => 6],
                    ['id' => 'reviews', 'label' => 'Guest Testimonials', 'enabled' => true, 'order' => 7],
                ]),
                'type' => 'json',
                'group' => 'layout',
            ],
        ];

        foreach ($settings as $st) {
            SiteSetting::updateOrCreate(['key' => $st['key']], $st);
        }

        Cache::forget('site_settings');
    }
}

