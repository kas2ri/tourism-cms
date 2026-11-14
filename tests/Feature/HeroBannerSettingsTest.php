<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HeroBannerSettingsTest extends TestCase
{
    use DatabaseTransactions;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::firstOrCreate(
            ['email' => 'admin@kiyaraholidays.com'],
            [
                'name' => 'Kiyara Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );
    }

    /**
     * Requirement 1 & 3: format_hero_headline helper converts [text] into terracotta styled span.
     */
    public function test_format_hero_headline_converts_brackets_to_terracotta_span(): void
    {
        $raw = "Not just a holiday, but a journey that [lingers in your soul.]";
        $formatted = format_hero_headline($raw);

        $expected = 'Not just a holiday, but a journey that <span class="italic underline decoration-[#c86d51] decoration-4 underline-offset-8">lingers in your soul.</span>';
        $this->assertEquals($expected, $formatted);
    }

    /**
     * Requirement 1 & 3: Homepage renders hero headline with brackets styled and trust badges from database.
     */
    public function test_homepage_renders_dynamic_hero_elements(): void
    {
        SiteSetting::set('hero_headline', 'Discover Sri Lanka [with authentic wonder.]', 'text', 'homepage');
        SiteSetting::set('hero_subheadline', 'Explore hidden gems with private storytellers.', 'text', 'homepage');
        SiteSetting::set('hero_badge_1', '100% Eco Certified Journeys', 'text', 'homepage');
        SiteSetting::set('hero_badge_2', 'Boutique Stays Only', 'text', 'homepage');
        SiteSetting::set('hero_badge_3', 'Dedicated Local Chauffeurs', 'text', 'homepage');

        $response = $this->get('/');
        $response->assertStatus(200);

        // Headline & Underline
        $response->assertSee('Discover Sri Lanka', false);
        $response->assertSee('<span class="italic underline decoration-[#c86d51] decoration-4 underline-offset-8">with authentic wonder.</span>', false);

        // Subheadline
        $response->assertSee('Explore hidden gems with private storytellers.', false);

        // Badges
        $response->assertSee('100% Eco Certified Journeys', false);
        $response->assertSee('Boutique Stays Only', false);
        $response->assertSee('Dedicated Local Chauffeurs', false);
    }

    /**
     * Requirement 2: Admin can upload hero background image and update hero settings in /admin/settings.
     */
    public function test_admin_can_upload_hero_image_and_update_all_hero_settings(): void
    {
        Storage::fake('public');

        $fakeImage = UploadedFile::fake()->image('custom-hero.jpg', 1920, 1080);

        $payload = [
            'company_name' => 'Kiyara Holidays',
            'company_slogan' => 'Boutique Ceylon Journeys',
            'license_number' => 'SLTDA/TDA/02914',
            'contact_phone' => '+94 77 123 4567',
            'whatsapp_number' => '+94771234567',
            'emergency_hotline' => '+94 77 999 8888',
            'contact_email' => 'hello@kiyaraholidays.com',
            'contact_address' => '42/B Lighthouse Street, Galle Fort, Sri Lanka',
            'hero_headline' => 'Unrushed moments in [ancient Ceylon.]',
            'hero_subheadline' => 'Slow, intentional journeys across sacred kingdoms and misty highlands.',
            'hero_background_image' => $fakeImage,
            'hero_badge_1' => 'Zero Plastic Policy',
            'hero_badge_2' => 'Small Circles (Max 10)',
            'hero_badge_3' => 'Licensed Island Experts',
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.settings.update'), $payload);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Check file was stored in public disk banners directory
        $savedPath = SiteSetting::get('hero_background_image');
        $this->assertNotNull($savedPath);
        $this->assertStringStartsWith('banners/', $savedPath);
        Storage::disk('public')->assertExists($savedPath);

        // Check settings in DB
        $this->assertEquals('Unrushed moments in [ancient Ceylon.]', SiteSetting::get('hero_headline'));
        $this->assertEquals('Zero Plastic Policy', SiteSetting::get('hero_badge_1'));
        $this->assertEquals('Small Circles (Max 10)', SiteSetting::get('hero_badge_2'));
        $this->assertEquals('Licensed Island Experts', SiteSetting::get('hero_badge_3'));

        // Check public homepage reflects all updates
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('<span class="italic underline decoration-[#c86d51] decoration-4 underline-offset-8">ancient Ceylon.</span>', false);
        $homeResponse->assertSee('Zero Plastic Policy', false);
        $homeResponse->assertSee('Small Circles (Max 10)', false);
        $homeResponse->assertSee('Licensed Island Experts', false);
        $homeResponse->assertSee(Storage::url($savedPath), false);
    }
}

