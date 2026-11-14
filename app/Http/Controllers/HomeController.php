<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Insider;
use App\Models\Package;
use App\Models\Review;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the boutique travel homepage.
     */
    public function index(): View
    {
        $packages = Package::with('itineraries')->ordered()->get();
        $destinations = Destination::all();
        $insiders = Insider::all();
        $reviews = Review::featured()->get();
        $siteSettings = SiteSetting::all()->pluck('value', 'key');
        
        $currencyRates = SiteSetting::get('currency_rates', [
            'USD' => ['rate' => 1.0, 'symbol' => '$'],
            'EUR' => ['rate' => 0.92, 'symbol' => '€'],
            'GBP' => ['rate' => 0.79, 'symbol' => '£'],
            'AUD' => ['rate' => 1.52, 'symbol' => 'A$'],
        ]);

        $toursData = $packages->map(function ($pkg) {
            return [
                'id' => $pkg->id,
                'title' => $pkg->title,
                'tag' => $pkg->subtitle ?? 'Boutique Journey',
                'duration' => $pkg->duration_days . ' Days / ' . max(1, $pkg->duration_days - 1) . ' Nights',
                'meta' => 'Max ' . $pkg->group_size_max . ' Travelers',
                'usdPrice' => (float) $pkg->starting_price_usd,
                'days' => $pkg->itineraries->map(function ($it) {
                    $descParts = array_filter([$it->morning_desc, $it->afternoon_desc, $it->evening_desc]);
                    return [
                        'day' => 'Day ' . $it->day_number . ': ' . $it->title,
                        'desc' => !empty($descParts) ? implode(' ', $descParts) : ($it->title ?? ''),
                    ];
                })->values()->toArray(),
            ];
        })->values()->toArray();

        return view('home', compact(
            'packages',
            'destinations',
            'insiders',
            'reviews',
            'siteSettings',
            'currencyRates',
            'toursData'
        ));
    }
}