<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\Inquiry;
use App\Models\Insider;
use App\Models\Package;
use App\Models\Review;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use DatabaseTransactions;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure an admin user exists
        $this->admin = User::firstOrCreate(
            ['email' => 'admin@kiyaraholidays.com'],
            [
                'name' => 'Kiyara Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );
    }

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_login_fails_with_invalid_credentials(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@kiyaraholidays.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_login_succeeds_with_valid_credentials(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@kiyaraholidays.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->admin);
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $regularUser = User::factory()->create([
            'role' => 'customer',
        ]);

        $response = $this->actingAs($regularUser)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_admin_can_view_dashboard_metrics(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Overview &amp; Platform Metrics', false);
        $response->assertSee('Packages', false);
        $response->assertSee('Destinations', false);
    }

    public function test_admin_can_create_package_with_itineraries(): void
    {
        $uid = uniqid();
        $packageData = [
            'title' => 'Ella Cloud Forest ' . $uid,
            'slug' => 'ella-cloud-forest-' . $uid,
            'subtitle' => 'Exclusive Hiking & Tea Trail',
            'duration_days' => 7,
            'difficulty' => 'Challenging',
            'group_size_max' => 8,
            'starting_price_usd' => 1890.00,
            'hero_image_url' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?w=800',
            'overview' => 'Climb past misty ridges and ancient bridges.',
            'is_featured' => 1,
            'order' => 10,
            'itineraries' => [
                [
                    'day_number' => 1,
                    'title' => 'Arrival & Colonial High Tea',
                    'location' => 'Colombo / Kandy',
                    'morning_desc' => 'Airport VIP pickup and welcome garland.',
                    'afternoon_desc' => 'Drive through the verdant valley.',
                    'evening_desc' => 'Colonial supper at Queen\'s Hotel.',
                    'stay_notes' => 'Heritage Junior Suite',
                ],
                [
                    'day_number' => 2,
                    'title' => 'Nine Arch Bridge & Tea Ridge',
                    'location' => 'Ella Highlands',
                    'morning_desc' => 'Watch the morning blue train curve around the viaduct.',
                    'afternoon_desc' => 'Trek Little Adam\'s Peak with naturalist.',
                    'evening_desc' => 'Artisan dinner under tea trees.',
                    'stay_notes' => 'Luxury Glamping Pavilion',
                ],
            ],
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.packages.store'), $packageData);

        $response->assertRedirect(route('admin.packages.index'));
        $this->assertDatabaseHas('packages', [
            'slug' => 'ella-cloud-forest-' . $uid,
            'duration_days' => 7,
        ]);

        $created = Package::where('slug', 'ella-cloud-forest-' . $uid)->first();
        $this->assertNotNull($created);
        $this->assertCount(2, $created->itineraries);
        $this->assertEquals('Arrival & Colonial High Tea', $created->itineraries->first()->title);
    }

    public function test_admin_can_update_package_and_sync_itineraries(): void
    {
        $uid = uniqid();
        $package = Package::create([
            'title' => 'Temp Tour Package ' . $uid,
            'slug' => 'temp-tour-package-' . $uid,
            'duration_days' => 5,
            'group_size_max' => 6,
            'starting_price_usd' => 1200.00,
        ]);

        $updateData = [
            'title' => 'Updated Temp Tour Package ' . $uid,
            'slug' => 'updated-temp-tour-package-' . $uid,
            'subtitle' => 'Refined Itinerary',
            'duration_days' => 6,
            'difficulty' => 'Curated Leisure',
            'group_size_max' => 8,
            'starting_price_usd' => 1350.00,
            'hero_image_url' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?w=800',
            'overview' => 'Updated overview narrative.',
            'itineraries' => [
                [
                    'day_number' => 1,
                    'title' => 'New Day 1',
                    'location' => 'Negombo',
                    'morning_desc' => 'Morning lagoon cruise.',
                    'afternoon_desc' => null,
                    'evening_desc' => null,
                    'stay_notes' => 'Boutique Villa',
                ],
            ],
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.packages.update', $package), $updateData);

        $response->assertRedirect(route('admin.packages.index'));
        $this->assertDatabaseHas('packages', [
            'id' => $package->id,
            'slug' => 'updated-temp-tour-package-' . $uid,
            'duration_days' => 6,
        ]);
        $this->assertDatabaseHas('package_itineraries', [
            'package_id' => $package->id,
            'title' => 'New Day 1',
        ]);
    }

    public function test_admin_can_manage_destinations(): void
    {
        // 1. Create Destination
        $response = $this->actingAs($this->admin)->post(route('admin.destinations.store'), [
            'name' => 'Sinharaja Biosphere Reserve',
            'slug' => 'sinharaja-biosphere-reserve',
            'short_desc' => 'UNESCO primary rainforest sanctuary with endemic canopy birds.',
            'best_season' => 'December to April',
            'hero_image_url' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?w=800',
        ]);

        $response->assertRedirect(route('admin.destinations.index'));
        $this->assertDatabaseHas('destinations', ['name' => 'Sinharaja Biosphere Reserve']);

        $destination = Destination::where('slug', 'sinharaja-biosphere-reserve')->first();

        // 2. Edit & Update Destination
        $response = $this->actingAs($this->admin)->put(route('admin.destinations.update', $destination), [
            'name' => 'Sinharaja Cloud Canopy',
            'slug' => 'sinharaja-cloud-canopy',
            'short_desc' => 'Updated description for virgin canopy forest.',
            'best_season' => 'Year-Round',
            'hero_image_url' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?w=800',
        ]);

        $response->assertRedirect(route('admin.destinations.index'));
        $this->assertDatabaseHas('destinations', ['name' => 'Sinharaja Cloud Canopy']);

        // 3. Delete Destination
        $response = $this->actingAs($this->admin)->delete(route('admin.destinations.destroy', $destination));
        $response->assertRedirect(route('admin.destinations.index'));
        $this->assertDatabaseMissing('destinations', ['id' => $destination->id]);
    }

    public function test_admin_can_manage_insiders(): void
    {
        // 1. Create Insider
        $response = $this->actingAs($this->admin)->post(route('admin.insiders.store'), [
            'name' => 'Dharshan Silva',
            'role' => 'Senior Wildlife Naturalist',
            'experience_years' => 14,
            'bio' => 'Tracked over 300 leopards across Yala and Wilpattu national parks.',
            'languages' => 'English, Sinhala, German',
            'avatar_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300',
        ]);

        $response->assertRedirect(route('admin.insiders.index'));
        $this->assertDatabaseHas('insiders', ['name' => 'Dharshan Silva']);

        $insider = Insider::where('name', 'Dharshan Silva')->first();
        $this->assertContains('German', $insider->languages);

        // 2. Update Insider
        $response = $this->actingAs($this->admin)->put(route('admin.insiders.update', $insider), [
            'name' => 'Dharshan Silva',
            'role' => 'Lead Expedition Director',
            'experience_years' => 15,
            'bio' => 'Updated bio with 15 years experience.',
            'languages' => 'English, Sinhala, German, French',
        ]);

        $response->assertRedirect(route('admin.insiders.index'));
        $this->assertDatabaseHas('insiders', [
            'id' => $insider->id,
            'role' => 'Lead Expedition Director',
            'experience_years' => 15,
        ]);

        // 3. Delete Insider
        $response = $this->actingAs($this->admin)->delete(route('admin.insiders.destroy', $insider));
        $response->assertRedirect(route('admin.insiders.index'));
        $this->assertDatabaseMissing('insiders', ['id' => $insider->id]);
    }

    public function test_admin_can_manage_reviews_and_toggle_featured(): void
    {
        // 1. Create Review
        $response = $this->actingAs($this->admin)->post(route('admin.reviews.store'), [
            'guest_name' => 'Lady Elizabeth Thorne',
            'guest_country' => 'United Kingdom',
            'rating' => 5,
            'text' => 'An impeccably executed safari and tea bungalow retreat.',
            'tour_name' => 'The Heritage & Cloud Highlands Trail',
            'is_featured' => 0,
        ]);

        $response->assertRedirect(route('admin.reviews.index'));
        $this->assertDatabaseHas('reviews', ['guest_name' => 'Lady Elizabeth Thorne']);

        $review = Review::where('guest_name', 'Lady Elizabeth Thorne')->first();
        $this->assertFalse((bool) $review->is_featured);

        // 2. Toggle Featured
        $response = $this->actingAs($this->admin)->post(route('admin.reviews.toggle-featured', $review));
        $response->assertRedirect();
        $this->assertTrue((bool) $review->fresh()->is_featured);

        // 3. Delete Review
        $response = $this->actingAs($this->admin)->delete(route('admin.reviews.destroy', $review));
        $response->assertRedirect(route('admin.reviews.index'));
        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }

    public function test_admin_can_view_and_update_inquiries(): void
    {
        $inquiry = Inquiry::create([
            'name' => 'Dr. Henrik Lindqvist',
            'email' => 'henrik@nordictravel.se',
            'phone' => '+46 8 123 456',
            'country' => 'Sweden',
            'travel_type' => 'Heritage & Slow Travel',
            'duration_days' => 12,
            'guests' => 2,
            'preferred_season' => 'Winter Escapes (Nov - Apr)',
            'tier' => 'Curated Luxury Lodges',
            'estimated_cost_usd' => 5800.00,
            'notes' => 'Interested in architecture and Ceylon birdwatching.',
            'status' => 'new',
        ]);

        // 1. List Inquiries & Filter by status
        $response = $this->actingAs($this->admin)->get(route('admin.inquiries.index', ['status' => 'new']));
        $response->assertStatus(200);
        $response->assertSee('Dr. Henrik Lindqvist');

        // 2. Show Inquiry Details
        $response = $this->actingAs($this->admin)->get(route('admin.inquiries.show', $inquiry));
        $response->assertStatus(200);
        $response->assertSee('henrik@nordictravel.se');
        $response->assertSee('$5,800', false);

        // 3. Update Status to 'contacted'
        $response = $this->actingAs($this->admin)->put(route('admin.inquiries.update', $inquiry), [
            'status' => 'contacted',
            'notes' => 'Sent customized 12-day bespoke itinerary PDF via email.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('inquiries', [
            'id' => $inquiry->id,
            'status' => 'contacted',
            'notes' => 'Sent customized 12-day bespoke itinerary PDF via email.',
        ]);
    }

    public function test_admin_can_export_inquiries_csv(): void
    {
        Inquiry::create([
            'name' => 'CSV Test Traveler',
            'email' => 'csvtest@example.com',
            'phone' => '+1 555 1234567',
            'country' => 'United States',
            'travel_type' => 'Private Chauffeured',
            'duration_days' => 10,
            'guests' => 4,
            'preferred_season' => 'Any Season',
            'tier' => 'Boutique',
            'estimated_cost_usd' => 4200.00,
            'notes' => 'CSV Export test',
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.inquiries.export'));

        $response->assertStatus(200);
        $this->assertEquals('text/csv; charset=UTF-8', $response->headers->get('Content-Type'));
        $content = $response->streamedContent();
        $this->assertStringContainsString('CSV Test Traveler', $content);
        $this->assertStringContainsString('csvtest@example.com', $content);
    }

    public function test_admin_can_update_site_settings(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.settings.edit'));
        $response->assertStatus(200);
        $response->assertSee('Site Settings');

        $response = $this->actingAs($this->admin)->put(route('admin.settings.update'), [
            'company_name' => 'Kiyara Holidays Ceylon',
            'company_slogan' => 'Crafted Island Journeys',
            'contact_phone' => '+94 11 234 5678',
            'whatsapp_number' => '+94770001122',
            'emergency_hotline' => '+94 77 999 0000',
            'contact_email' => 'concierge@kiyaraholidays.com',
            'contact_address' => 'Galle Fort Heritage Quarter, Sri Lanka',
            'hero_headline' => 'Ceylon, Experienced With Soul.',
            'hero_subheadline' => 'Slow-paced private expeditions through sacred mountains and secluded shores.',
            'license_number' => 'SLTDA/TDA/99999',
        ]);

        $response->assertRedirect();

        $this->assertEquals('Kiyara Holidays Ceylon', SiteSetting::get('company_name'));
        $this->assertEquals('+94770001122', SiteSetting::get('whatsapp_number'));
        $this->assertEquals('Ceylon, Experienced With Soul.', SiteSetting::get('hero_headline'));
        $this->assertEquals('concierge@kiyaraholidays.com', SiteSetting::get('contact_email'));
    }

    public function test_admin_can_upload_hero_image_with_automatic_thumbnail_generation(): void
    {
        Storage::fake('public');

        $uid = uniqid();
        $file = \Illuminate\Http\UploadedFile::fake()->image('safari_cover.jpg', 1200, 800);

        $response = $this->actingAs($this->admin)->post(route('admin.packages.store'), [
            'title' => 'Yala Leopard Safari ' . $uid,
            'slug' => 'yala-leopard-safari-' . $uid,
            'duration_days' => 4,
            'group_size_max' => 6,
            'starting_price_usd' => 1400.00,
            'hero_image_file' => $file,
        ]);

        $response->assertRedirect(route('admin.packages.index'));

        $package = Package::where('slug', 'yala-leopard-safari-' . $uid)->first();
        $this->assertNotNull($package);
        $this->assertNotNull($package->hero_image);

        // Check storage path on public disk
        $relativePath = \Illuminate\Support\Str::after($package->hero_image, 'storage/');
        Storage::disk('public')->assertExists($relativePath);

        // Check thumbnail exists on public disk
        $filename = basename($relativePath);
        Storage::disk('public')->assertExists('packages/thumbnails/' . $filename);
    }

    public function test_admin_logout(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
