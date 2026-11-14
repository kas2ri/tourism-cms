<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Inquiry;
use App\Models\Insider;
use App\Models\Package;
use App\Models\Review;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the CMS Admin Dashboard with metrics and recent inquiries.
     */
    public function index(): View
    {
        $metrics = [
            'total_packages' => Package::count(),
            'total_destinations' => Destination::count(),
            'total_insiders' => Insider::count(),
            'total_reviews' => Review::count(),
            'pending_inquiries' => Inquiry::where('status', 'new')->count(),
            'total_inquiries' => Inquiry::count(),
        ];

        $recentInquiries = Inquiry::latest()->take(6)->get();
        $recentPackages = Package::ordered()->take(4)->get();

        return view('admin.dashboard', compact('metrics', 'recentInquiries', 'recentPackages'));
    }
}

