<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Handle trip inquiries from Custom Trip Builder and general modal.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'duration_days' => ['nullable', 'integer', 'min:1', 'max:60'],
            'guests' => ['nullable', 'integer', 'min:1', 'max:50'],
            'tier' => ['nullable', 'string', 'max:100'],
            'estimated_cost_usd' => ['nullable', 'numeric', 'min:0'],
            'phone' => ['nullable', 'string', 'max:50'],
            'country' => ['nullable', 'string', 'max:100'],
            'travel_type' => ['nullable', 'string', 'max:100'],
            'preferred_season' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $inquiry = Inquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'duration_days' => $validated['duration_days'] ?? null,
            'guests' => $validated['guests'] ?? 2,
            'tier' => $validated['tier'] ?? null,
            'estimated_cost_usd' => $validated['estimated_cost_usd'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'country' => $validated['country'] ?? null,
            'travel_type' => $validated['travel_type'] ?? null,
            'preferred_season' => $validated['preferred_season'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'new',
        ]);

        $toastTitle = 'Proposal Requested!';
        $toastMessage = 'Ayubowan! Our founder or travel curator will craft your journey and email you within 24 hours.';

        if ($request->wantsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => $toastMessage,
                'toast' => [
                    'title' => $toastTitle,
                    'message' => $toastMessage,
                ],
                'inquiry' => [
                    'id' => $inquiry->id,
                    'name' => $inquiry->name,
                    'email' => $inquiry->email,
                ],
            ], 201);
        }

        return redirect()->back()->with('toast', [
            'title' => $toastTitle,
            'message' => $toastMessage,
        ]);
    }
}

