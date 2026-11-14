<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackageController extends Controller
{
    /**
     * Display a paginated and filterable tour catalog.
     */
    public function index(Request $request): View
    {
        $query = Package::with('itineraries');

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%")
                  ->orWhere('overview', 'like', "%{$search}%");
            });
        }

        // Travel Style / Category filter
        if ($style = $request->input('style')) {
            if ($style !== 'all') {
                $query->where(function ($q) use ($style) {
                    $q->where('slug', 'like', "%{$style}%")
                      ->orWhere('subtitle', 'like', "%{$style}%")
                      ->orWhere('overview', 'like', "%{$style}%");
                });
            }
        }

        // Duration filter
        if ($duration = $request->input('duration')) {
            if ($duration === 'short') {
                $query->where('duration_days', '<=', 7);
            } elseif ($duration === 'medium') {
                $query->whereBetween('duration_days', [8, 14]);
            } elseif ($duration === 'long') {
                $query->where('duration_days', '>=', 15);
            }
        }

        // Sorting
        $sort = $request->input('sort', 'featured');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('starting_price_usd', 'asc');
                break;
            case 'price_high':
                $query->orderBy('starting_price_usd', 'desc');
                break;
            case 'duration_asc':
                $query->orderBy('duration_days', 'asc');
                break;
            case 'duration_desc':
                $query->orderBy('duration_days', 'desc');
                break;
            case 'featured':
            default:
                $query->orderByDesc('is_featured')->orderBy('order')->orderBy('id');
                break;
        }

        $packages = $query->paginate(6)->withQueryString();

        $currencyRates = SiteSetting::get('currency_rates', [
            'USD' => ['rate' => 1.0, 'symbol' => '$'],
            'EUR' => ['rate' => 0.92, 'symbol' => '€'],
            'GBP' => ['rate' => 0.79, 'symbol' => '£'],
            'AUD' => ['rate' => 1.52, 'symbol' => 'A$'],
        ]);

        return view('packages.index', compact('packages', 'currencyRates'));
    }

    /**
     * Display a detailed package view.
     */
    public function show(string $slug): View
    {
        $package = Package::with(['itineraries' => function ($q) {
            $q->orderBy('day_number', 'asc');
        }])->where('slug', $slug)->firstOrFail();

        $relatedPackages = Package::where('id', '!=', $package->id)
            ->ordered()
            ->take(3)
            ->get();

        $currencyRates = SiteSetting::get('currency_rates', [
            'USD' => ['rate' => 1.0, 'symbol' => '$'],
            'EUR' => ['rate' => 0.92, 'symbol' => '€'],
            'GBP' => ['rate' => 0.79, 'symbol' => '£'],
            'AUD' => ['rate' => 1.52, 'symbol' => 'A$'],
        ]);

        return view('packages.show', compact('package', 'relatedPackages', 'currencyRates'));
    }

    /**
     * JSON endpoint returning day-by-day schedule, inclusions, and lodging notes for the modal drawer.
     */
    public function itineraryData(int $id): JsonResponse
    {
        $package = Package::with(['itineraries' => function ($q) {
            $q->orderBy('day_number', 'asc');
        }])->findOrFail($id);

        $defaultInclusions = [
            'Handpicked boutique hotels, luxury lodges & heritage colonial tea bungalows',
            'Private air-conditioned luxury vehicle with certified SLTDA driver-storyteller',
            'Sigiriya Rock Fortress, Dambulla Cave Temple & cultural monument entries',
            'Scenic 1st-class reserved train passes through the misty highlands',
            'Daily breakfast and curated signature feasts (village hearths & colonial dinners)',
            '24/7 dedicated Kiyara concierge & on-ground WhatsApp support',
        ];

        $defaultExclusions = [
            'International return airfare',
            'Sri Lanka electronic travel authorization (ETA) visa fee',
            'Discretionary driver, guide & hotel porter tips',
            'Personal travel insurance (recommended)',
            'Alcoholic beverages outside curated wine/tea tastings',
        ];

        $itinerary = $package->itineraries->map(function ($day) {
            $descriptions = array_filter([
                $day->morning_desc,
                $day->afternoon_desc,
                $day->evening_desc,
            ]);

            return [
                'day_number' => $day->day_number,
                'title' => $day->title,
                'location' => $day->location,
                'morning' => $day->morning_desc,
                'afternoon' => $day->afternoon_desc,
                'evening' => $day->evening_desc,
                'stay_notes' => $day->stay_notes,
                'image' => $day->image,
                'full_description' => !empty($descriptions) ? implode(' ', $descriptions) : $day->title,
            ];
        });

        return response()->json([
            'success' => true,
            'package' => [
                'id' => $package->id,
                'title' => $package->title,
                'slug' => $package->slug,
                'subtitle' => $package->subtitle ?? 'Boutique Journey',
                'duration_days' => $package->duration_days,
                'duration_nights' => max(1, $package->duration_days - 1),
                'duration_label' => $package->duration_days . ' Days / ' . max(1, $package->duration_days - 1) . ' Nights',
                'group_size_max' => $package->group_size_max,
                'difficulty' => $package->difficulty ?? 'Curated Leisure',
                'starting_price_usd' => (float) $package->starting_price_usd,
                'hero_image' => $package->hero_image,
                'overview' => $package->overview,
                'inclusions' => $defaultInclusions,
                'exclusions' => $defaultExclusions,
                'itinerary' => $itinerary,
            ],
        ]);
    }
}

