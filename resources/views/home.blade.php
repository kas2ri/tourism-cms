@extends('layouts.app')

@section('title', 'Kiyara Holidays - Boutique Ceylon Journeys & Slow Luxury Travel')

@section('content')

    @php
        $defaultSections = [
            ['id' => 'hero', 'label' => 'Hero & Quick Search', 'enabled' => true, 'order' => 1],
            ['id' => 'featured_packages', 'label' => 'Signature & Group Journeys', 'enabled' => true, 'order' => 2],
            ['id' => 'experiences', 'label' => 'Experiential Offerings & Soul', 'enabled' => true, 'order' => 3],
            ['id' => 'trip_builder', 'label' => 'Custom Trip Builder & Estimator', 'enabled' => true, 'order' => 4],
            ['id' => 'destinations', 'label' => 'Island Regions & Destinations', 'enabled' => true, 'order' => 5],
            ['id' => 'insiders', 'label' => 'Local Insiders & Drivers', 'enabled' => true, 'order' => 6],
            ['id' => 'reviews', 'label' => 'Guest Testimonials', 'enabled' => true, 'order' => 7],
        ];

        $homepageSections = setting('homepage_sections_order', $defaultSections);

        if (is_string($homepageSections)) {
            $homepageSections = json_decode($homepageSections, true) ?: $defaultSections;
        }

        // Sort by order ascending
        usort($homepageSections, function ($a, $b) {
            return ($a['order'] ?? 0) <=> ($b['order'] ?? 0);
        });
    @endphp

    @foreach($homepageSections as $section)
        @if(!empty($section['enabled']))
            @includeIf("components.sections." . $section['id'], [
                'packages' => $packages,
                'destinations' => $destinations,
                'insiders' => $insiders,
                'reviews' => $reviews,
                'siteSettings' => $siteSettings,
                'currencyRates' => $currencyRates,
                'toursData' => $toursData,
            ])
        @endif
    @endforeach

    <!-- Insiders Modal Component (Always available for triggers) -->
    <x-insiders-grid :insiders="$insiders" />

@endsection

@push('scripts')
<script>
    // Injected Dynamic Database Data for Client-Side Interactivity
    window.TOURS_DATA = @json($toursData);
    window.CURRENCY_RATES = @json($currencyRates);
</script>
@endpush
