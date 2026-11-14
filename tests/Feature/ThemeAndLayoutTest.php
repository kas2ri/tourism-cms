<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ThemeAndLayoutTest extends TestCase
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
     * Requirement 1: Verify default database seed values for theme and layout.
     */
    public function test_default_theme_and_layout_database_seed_values(): void
    {
        $this->assertEquals('#1a3b32', setting('theme_primary_color'));
        $this->assertEquals('#c86d51', setting('theme_secondary_color'));
        $this->assertEquals('#f4efe6', setting('theme_background_color'));
        $this->assertEquals('#1e292b', setting('theme_text_color'));

        $sections = setting('homepage_sections_order');
        $this->assertIsArray($sections);
        $this->assertCount(7, $sections);

        $expectedIds = [
            'hero',
            'featured_packages',
            'experiences',
            'trip_builder',
            'destinations',
            'insiders',
            'reviews',
        ];

        $actualIds = array_column($sections, 'id');
        $this->assertEquals($expectedIds, $actualIds);

        foreach ($sections as $section) {
            $this->assertTrue($section['enabled']);
            $this->assertArrayHasKey('order', $section);
            $this->assertArrayHasKey('label', $section);
        }
    }

    /**
     * Requirement 3: Admin can view the appearance & layout settings page.
     */
    public function test_admin_can_access_appearance_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.appearance.edit'));

        $response->assertStatus(200);
        $response->assertSee('Appearance &amp; Homepage Layout', false);
        $response->assertSee('Dynamic Color Theme Customizer');
        $response->assertSee('Ceylon Forest & Clay', false);
        $response->assertSee('Oceanic Galle & Coral', false);
        $response->assertSee('Sigiriya Sunset & Gold', false);
        $response->assertSee('Homepage Section Layout & Ordering', false);
        $response->assertSee('theme_primary_color');
        $response->assertSee('theme_secondary_color');
        $response->assertSee('theme_background_color');
        $response->assertSee('theme_text_color');
        $response->assertSee('homepage_sections_order');
    }

    /**
     * Test non-admin cannot access appearance page.
     */
    public function test_non_admin_cannot_access_appearance_page(): void
    {
        $guestResponse = $this->get(route('admin.appearance.edit'));
        $guestResponse->assertRedirect(route('admin.login'));

        $regularUser = User::factory()->create(['role' => 'customer']);
        $userResponse = $this->actingAs($regularUser)->get(route('admin.appearance.edit'));
        $userResponse->assertStatus(403);
    }

    /**
     * Requirement 2 & 3: Admin can change theme colors and they reflect on public frontend CSS :root.
     */
    public function test_admin_can_update_theme_colors_and_reflects_in_public_css(): void
    {
        $payload = [
            'theme_primary_color' => '#0d4b68',
            'theme_secondary_color' => '#e05a47',
            'theme_background_color' => '#edf5f8',
            'theme_text_color' => '#17232b',
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.appearance.update'), $payload);
        $response->assertRedirect(route('admin.appearance.edit'));
        $response->assertSessionHas('success');

        $this->assertEquals('#0d4b68', setting('theme_primary_color'));
        $this->assertEquals('#e05a47', setting('theme_secondary_color'));
        $this->assertEquals('#edf5f8', setting('theme_background_color'));
        $this->assertEquals('#17232b', setting('theme_text_color'));

        // Check public frontend homepage :root style block
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('--color-primary: #0d4b68;', false);
        $homeResponse->assertSee('--color-secondary: #e05a47;', false);
        $homeResponse->assertSee('--color-bg-sand: #edf5f8;', false);
        $homeResponse->assertSee('--color-text-main: #17232b;', false);
    }

    /**
     * Requirement 2 & 3: Admin can reorder sections, moving "Custom Trip Builder" above "Featured Packages".
     */
    public function test_admin_can_move_trip_builder_above_featured_packages(): void
    {
        // New order: hero (1), trip_builder (2), featured_packages (3), etc.
        $reordered = [
            ['id' => 'hero', 'label' => 'Hero & Quick Search', 'enabled' => true, 'order' => 1],
            ['id' => 'trip_builder', 'label' => 'Custom Trip Builder & Estimator', 'enabled' => true, 'order' => 2],
            ['id' => 'featured_packages', 'label' => 'Signature & Group Journeys', 'enabled' => true, 'order' => 3],
            ['id' => 'experiences', 'label' => 'Experiential Offerings & Soul', 'enabled' => true, 'order' => 4],
            ['id' => 'destinations', 'label' => 'Island Regions & Destinations', 'enabled' => true, 'order' => 5],
            ['id' => 'insiders', 'label' => 'Local Insiders & Drivers', 'enabled' => true, 'order' => 6],
            ['id' => 'reviews', 'label' => 'Guest Testimonials', 'enabled' => true, 'order' => 7],
        ];

        $payload = [
            'theme_primary_color' => '#1a3b32',
            'theme_secondary_color' => '#c86d51',
            'theme_background_color' => '#f4efe6',
            'theme_text_color' => '#1e292b',
            'homepage_sections_order' => json_encode($reordered),
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.appearance.update'), $payload);
        $response->assertRedirect(route('admin.appearance.edit'));

        // Verify on homepage that trip builder appears before expeditions section
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);

        $content = $homeResponse->getContent();
        $tripBuilderPos = strpos($content, 'id="trip-builder"');
        $expeditionsPos = strpos($content, 'id="expeditions"');

        $this->assertNotFalse($tripBuilderPos, 'Trip builder section should be present');
        $this->assertNotFalse($expeditionsPos, 'Expeditions section should be present');
        $this->assertLessThan(
            $expeditionsPos,
            $tripBuilderPos,
            'Custom Trip Builder should appear before Featured Packages (expeditions) in the HTML source'
        );
    }

    /**
     * Requirement 2 & 3: Admin can toggle visibility to hide a section from the homepage.
     */
    public function test_admin_can_hide_section(): void
    {
        $modified = [
            ['id' => 'hero', 'label' => 'Hero & Quick Search', 'enabled' => true, 'order' => 1],
            ['id' => 'featured_packages', 'label' => 'Signature & Group Journeys', 'enabled' => true, 'order' => 2],
            ['id' => 'experiences', 'label' => 'Experiential Offerings & Soul', 'enabled' => false, 'order' => 3],
            ['id' => 'trip_builder', 'label' => 'Custom Trip Builder & Estimator', 'enabled' => true, 'order' => 4],
            ['id' => 'destinations', 'label' => 'Island Regions & Destinations', 'enabled' => true, 'order' => 5],
            ['id' => 'insiders', 'label' => 'Local Insiders & Drivers', 'enabled' => true, 'order' => 6],
            ['id' => 'reviews', 'label' => 'Guest Testimonials', 'enabled' => true, 'order' => 7],
        ];

        $payload = [
            'theme_primary_color' => '#1a3b32',
            'theme_secondary_color' => '#c86d51',
            'theme_background_color' => '#f4efe6',
            'theme_text_color' => '#1e292b',
            'homepage_sections_order' => json_encode($modified),
        ];

        $this->actingAs($this->admin)->put(route('admin.appearance.update'), $payload);

        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertDontSee('Moments That Can’t Be Googled');
    }

    /**
     * Requirement 3: Admin can reset settings to factory defaults.
     */
    public function test_admin_can_reset_defaults(): void
    {
        // First modify values
        SiteSetting::set('theme_primary_color', '#ff0000', 'text', 'theme');

        $response = $this->actingAs($this->admin)->put(route('admin.appearance.update'), [
            'reset_defaults' => '1',
            'theme_primary_color' => '#ff0000',
            'theme_secondary_color' => '#ff0000',
            'theme_background_color' => '#ff0000',
            'theme_text_color' => '#ff0000',
        ]);

        $response->assertRedirect(route('admin.appearance.edit'));
        $this->assertEquals('#1a3b32', setting('theme_primary_color'));
    }
}
