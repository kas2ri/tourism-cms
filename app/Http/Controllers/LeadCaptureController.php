<?php

namespace App\Http\Controllers;

use App\Jobs\SendGuideDownloadEmail;
use App\Models\LeadDownload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LeadCaptureController extends Controller
{
    /**
     * Validate and store "Secret Ceylon Guide" form downloads.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'guide_slug' => ['nullable', 'string', 'max:100'],
        ]);

        $lead = LeadDownload::create([
            'email' => $validated['email'],
            'name' => $validated['name'] ?? null,
            'guide_slug' => $validated['guide_slug'] ?? 'secret-ceylon-guide',
        ]);

        // Dispatch asynchronous email notification event/job
        SendGuideDownloadEmail::dispatch($lead);

        $toastTitle = 'Guidebook On Its Way!';
        $toastMessage = "We've dispatched 'Secret Ceylon 2025' to {$lead->email}. Check your inbox shortly.";

        if ($request->wantsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => $toastMessage,
                'toast' => [
                    'title' => $toastTitle,
                    'message' => $toastMessage,
                ],
                'lead' => [
                    'id' => $lead->id,
                    'email' => $lead->email,
                ],
            ], 201);
        }

        return redirect()->back()->with('toast', [
            'title' => $toastTitle,
            'message' => $toastMessage,
        ]);
    }
}

