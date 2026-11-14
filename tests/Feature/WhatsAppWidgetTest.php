<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WhatsAppWidgetTest extends TestCase
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
     * Requirement 1: WhatsApp widget renders with cleaned phone number and 3 quick-prompt chips.
     */
    public function test_whatsapp_widget_renders_with_cleaned_phone_and_quick_chips(): void
    {
        SiteSetting::set('whatsapp_number', '+94 (77) 123-4567', 'text', 'contact');
        SiteSetting::set('whatsapp_widget_enabled', '1', 'boolean', 'contact');

        $response = $this->get('/');
        $response->assertStatus(200);

        // Cleaned phone number passed to JS
        $response->assertSee("window.WHATSAPP_PHONE = '94771234567';", false);

        // Welcoming copy
        $response->assertSee('Kiyara Island Concierge', false);
        $response->assertSee('Ayubowan!', false);

        // 3 Quick-Prompt Chips
        $response->assertSee('Plan a custom Sri Lanka route', false);
        $response->assertSee('Small group departure dates', false);
        $response->assertSee('Private driver & boutique stays', false);

        // Input & send button
        $response->assertSee('id="wa-input"', false);
        $response->assertSee('id="wa-chatbox"', false);
    }

    /**
     * Requirement 1: When whatsapp_widget_enabled is false, widget is completely hidden from public frontend.
     */
    public function test_whatsapp_widget_hidden_when_disabled(): void
    {
        SiteSetting::set('whatsapp_widget_enabled', '0', 'boolean', 'contact');

        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertDontSee('id="whatsapp-concierge-widget"', false);
        $response->assertDontSee('window.WHATSAPP_PHONE', false);
    }

    /**
     * Requirement 2: Admin can toggle whatsapp_widget_enabled and update whatsapp_number in /admin/settings.
     */
    public function test_admin_can_toggle_whatsapp_widget_and_update_number(): void
    {
        // Admin disables widget
        $response = $this->actingAs($this->admin)->put(route('admin.settings.update'), [
            'company_name' => 'Kiyara Holidays',
            'whatsapp_number' => '+94 77 999 0000',
            'whatsapp_widget_enabled' => '0',
        ]);

        $response->assertRedirect();
        $this->assertEquals('+94 77 999 0000', SiteSetting::get('whatsapp_number'));
        $this->assertFalse(SiteSetting::get('whatsapp_widget_enabled'));

        // Verify public site does not render widget
        $homeResponse = $this->get('/');
        $homeResponse->assertDontSee('id="whatsapp-concierge-widget"', false);

        // Admin re-enables widget
        $this->actingAs($this->admin)->put(route('admin.settings.update'), [
            'company_name' => 'Kiyara Holidays',
            'whatsapp_number' => '+94 77 999 0000',
            'whatsapp_widget_enabled' => '1',
        ]);

        $this->assertTrue(SiteSetting::get('whatsapp_widget_enabled'));

        $homeReenabled = $this->get('/');
        $homeReenabled->assertSee("window.WHATSAPP_PHONE = '94779990000';", false);
        $homeReenabled->assertSee('id="whatsapp-concierge-widget"', false);
    }

    /**
     * Requirement 3: Navbar maintains frosted light background with shadow-sm.
     */
    public function test_navbar_maintains_frosted_light_background_on_scroll(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertSee('bg-[#f4efe6]/95 backdrop-blur-md border-b border-sand-200/80 shadow-sm', false);
    }
}

