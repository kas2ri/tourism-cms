<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\Inquiry;
use App\Models\Insider;
use App\Models\LeadDownload;
use App\Models\Package;
use App\Models\PackageItinerary;
use App\Models\Review;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FullStackIntegrationTest extends TestCase
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
     * Requirement 1: Database seed consistency.
     */
    public function test_database_seed_consistency(): void
    {
        // 5 seeded packages
        $this->assertGreaterThanOrEqual(5, Package::count());
        $this->assertGreaterThanOrEqual(50, PackageItinerary::count());

        // 5 destinations
        $this->assertGreaterThanOrEqual(5, Destination::count());

        // 3 insiders
        $this->assertGreaterThanOrEqual(3, Insider::count());

        // 3 reviews
        $this->assertGreaterThanOrEqual(3, Review::count());

        // Admin user
        $admin = User::where('email', 'admin@kiyaraholidays.com')->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->isAdmin());

        // Site settings populated
        $this->assertNotNull(SiteSetting::get('whatsapp_number'));
        $this->assertNotNull(SiteSetting::get('hero_headline'));
        $this->assertNotNull(SiteSetting::get('currency_rates'));
    }

    /**
     * Requirement 2: Public currency rates and conversion math.
     */
    public function test_currency_rates_and_price_conversion_math(): void
    {
        $currencyRates = SiteSetting::get('currency_rates');
        $this->assertIsArray($currencyRates);
        $this->assertArrayHasKey('USD', $currencyRates);
        $this->assertArrayHasKey('EUR', $currencyRates);
        $this->assertArrayHasKey('GBP', $currencyRates);
        $this->assertArrayHasKey('AUD', $currencyRates);

        $this->assertEquals(1.0, $currencyRates['USD']['rate']);
        $this->assertEquals(0.92, $currencyRates['EUR']['rate']);
        $this->assertEquals(0.79, $currencyRates['GBP']['rate']);
        $this->assertEquals(1.52, $currencyRates['AUD']['rate']);

        // Check test package price conversion
        $usdPrice = 2150.00;
        $eurPrice = round($usdPrice * $currencyRates['EUR']['rate']);
        $gbpPrice = round($usdPrice * $currencyRates['GBP']['rate']);
        $audPrice = round($usdPrice * $currencyRates['AUD']['rate']);

        $this->assertEquals(1978, $eurPrice);
        $this->assertEquals(1699, $gbpPrice);
        $this->assertEquals(3268, $audPrice);

        // Verify homepage passes currencyRates into view
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewHas('currencyRates');
        $response->assertSee('window.CURRENCY_RATES =', false);
    }

    /**
     * Requirement 3: Day-by-Day Itinerary slide-over drawer AJAX endpoint.
     */
    public function test_itinerary_drawer_ajax_endpoint_returns_smooth_data(): void
    {
        $packages = Package::with('itineraries')->get();
        $this->assertNotEmpty($packages);

        foreach ($packages as $pkg) {
            $response = $this->getJson(route('api.packages.itinerary', $pkg->id));
            $response->assertStatus(200);
            $response->assertJsonStructure([
                'success',
                'package' => [
                    'id',
                    'title',
                    'slug',
                    'subtitle',
                    'duration_days',
                    'duration_nights',
                    'duration_label',
                    'group_size_max',
                    'difficulty',
                    'starting_price_usd',
                    'hero_image',
                    'overview',
                    'inclusions',
                    'exclusions',
                    'itinerary' => [
                        '*' => [
                            'day_number',
                            'title',
                            'location',
                            'morning',
                            'afternoon',
                            'evening',
                            'stay_notes',
                            'image',
                            'full_description',
                        ],
                    ],
                ],
            ]);

            $json = $response->json();
            $this->assertTrue($json['success']);
            $this->assertEquals($pkg->title, $json['package']['title']);
            $this->assertNotEmpty($json['package']['inclusions']);
            $this->assertNotEmpty($json['package']['exclusions']);
            $this->assertCount($pkg->itineraries->count(), $json['package']['itinerary']);
        }

        // 404 for non-existent package
        $response = $this->getJson(route('api.packages.itinerary', 999999));
        $response->assertStatus(404);
    }

    /**
     * Requirement 4: Submit test requests through Trip Builder inquiry & Guide Download modal,
     * and verify database records appear in the Admin Panel.
     */
    public function test_trip_builder_inquiry_and_guide_download_appear_in_admin_panel(): void
    {
        // 1. Submit Inquiry via AJAX
        $inquiryPayload = [
            'name' => 'Sophia Montgomery',
            'email' => 'sophia.montgomery@chelsea-travel.co.uk',
            'phone' => '+44 7700 900123',
            'country' => 'United Kingdom',
            'travel_type' => 'Tailor-Made Private Chauffeured',
            'duration_days' => 14,
            'guests' => 2,
            'preferred_season' => 'November 2025 - January 2026',
            'tier' => 'Eco-Chic & Heritage',
            'estimated_cost_usd' => 4890.00,
            'notes' => 'Honeymoon journey: tea country seclusion, leopard safari, private catamaran in Mirissa.',
        ];

        $inquiryResponse = $this->postJson(route('inquiries.store'), $inquiryPayload);
        $inquiryResponse->assertStatus(201);
        $inquiryResponse->assertJson([
            'success' => true,
            'inquiry' => [
                'name' => 'Sophia Montgomery',
                'email' => 'sophia.montgomery@chelsea-travel.co.uk',
            ],
        ]);

        $this->assertDatabaseHas('inquiries', [
            'email' => 'sophia.montgomery@chelsea-travel.co.uk',
            'status' => 'new',
            'duration_days' => 14,
            'guests' => 2,
        ]);

        $inquiry = Inquiry::where('email', 'sophia.montgomery@chelsea-travel.co.uk')->first();
        $this->assertNotNull($inquiry);

        // Verify inquiry appears in Admin Panel list
        $adminListResponse = $this->actingAs($this->admin)->get(route('admin.inquiries.index', ['status' => 'new']));
        $adminListResponse->assertStatus(200);
        $adminListResponse->assertSee('Sophia Montgomery');
        $adminListResponse->assertSee('sophia.montgomery@chelsea-travel.co.uk');

        // Verify inquiry detail page in Admin Panel
        $adminShowResponse = $this->actingAs($this->admin)->get(route('admin.inquiries.show', $inquiry));
        $adminShowResponse->assertStatus(200);
        $adminShowResponse->assertSee('Sophia Montgomery');
        $adminShowResponse->assertSee('$4,890', false);
        $adminShowResponse->assertSee('Honeymoon journey: tea country seclusion');

        // 2. Submit Guide Download via AJAX
        $guidePayload = [
            'name' => 'Arthur Pendelton',
            'email' => 'arthur.p@oxford-heritage.org',
            'guide_slug' => 'secret-ceylon-2025',
        ];

        $guideResponse = $this->postJson(route('guide.download'), $guidePayload);
        $guideResponse->assertStatus(201);
        $guideResponse->assertJson([
            'success' => true,
            'lead' => [
                'email' => 'arthur.p@oxford-heritage.org',
            ],
        ]);

        $this->assertDatabaseHas('lead_downloads', [
            'email' => 'arthur.p@oxford-heritage.org',
            'name' => 'Arthur Pendelton',
            'guide_slug' => 'secret-ceylon-2025',
        ]);
    }

    /**
     * Requirement 5: Log into Admin CMS, update package price and hero image,
     * and verify the changes reflect instantly on the public homepage.
     */
    public function test_admin_update_package_price_and_image_reflects_on_homepage(): void
    {
        $package = Package::first();
        $this->assertNotNull($package);

        $newPrice = 2895.00;
        $newTitle = 'Royal Highlands Signature Tour';
        $newHeroImage = 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?w=1200';

        // 1. Admin Updates Package
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.packages.update', $package), [
            'title' => $newTitle,
            'slug' => $package->slug,
            'subtitle' => 'Updated Bestseller',
            'duration_days' => $package->duration_days,
            'difficulty' => 'Curated Leisure',
            'group_size_max' => $package->group_size_max,
            'starting_price_usd' => $newPrice,
            'hero_image_url' => $newHeroImage,
            'overview' => 'Updated overview text for verification.',
            'itineraries' => [
                [
                    'day_number' => 1,
                    'title' => 'Signature Welcome',
                    'location' => 'Negombo',
                    'morning_desc' => 'VIP arrival.',
                    'afternoon_desc' => null,
                    'evening_desc' => null,
                    'stay_notes' => 'Jetwing Beach',
                ],
            ],
        ]);

        $updateResponse->assertRedirect(route('admin.packages.index'));

        // 2. Verify Database updated
        $this->assertDatabaseHas('packages', [
            'id' => $package->id,
            'title' => $newTitle,
            'starting_price_usd' => $newPrice,
            'hero_image' => $newHeroImage,
        ]);

        // 3. Verify changes reflect instantly on the public homepage
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee($newTitle, false);
        $homeResponse->assertSee('$' . number_format($newPrice), false);
        $homeResponse->assertSee($newHeroImage, false);
    }
}
