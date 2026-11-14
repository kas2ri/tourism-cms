<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * Test that the homepage loads with dynamic content and all Blade components.
     */
    public function test_homepage_renders_all_sections_and_dynamic_components(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        // Header & Branding
        $response->assertSee('KIYARA');
        $response->assertSee('Boutique Ceylon Journeys');
        $response->assertSee('+94 (77) 123-4567');

        // Dynamic Packages from database
        $response->assertSee('The Heritage & Cloud Highlands Trail', false);
        $response->assertSee('Connoisseur', false);
        $response->assertSee('Prana', false);
        $response->assertSee('Sacred Peaks', false);
        $response->assertSee('Wander Women', false);

        // Trip builder
        $response->assertSee('Design & Estimate Your Journey', false);
        $response->assertSee('Estimated Total Investment');

        // Reviews
        $response->assertSee('What Our Wanderers Say');
        $response->assertSee('Sarah Jenkins');

        // Insiders
        $response->assertSee('Rohan Jayawardena');
        $response->assertSee('Dr. Nilmini Senanayake');

        // Modals & Widgets markup present
        $response->assertSee('id="itinerary-modal"', false);
        $response->assertSee('id="inquiry-modal"', false);
        $response->assertSee('id="guide-modal"', false);
        $response->assertSee('id="wa-chatbox"', false);
        $response->assertSee('id="toast-notification"', false);
    }
}
