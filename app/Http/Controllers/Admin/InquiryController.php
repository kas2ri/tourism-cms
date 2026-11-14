<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InquiryController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status', 'all');

        $query = Inquiry::latest();
        if ($status !== 'all' && in_array($status, ['new', 'contacted', 'converted', 'archived'])) {
            $query->where('status', $status);
        }

        $inquiries = $query->paginate(20)->withQueryString();

        $counts = [
            'all' => Inquiry::count(),
            'new' => Inquiry::where('status', 'new')->count(),
            'contacted' => Inquiry::where('status', 'contacted')->count(),
            'converted' => Inquiry::where('status', 'converted')->count(),
            'archived' => Inquiry::where('status', 'archived')->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'status', 'counts'));
    }

    public function show(Inquiry $inquiry): View
    {
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:new,contacted,converted,archived'],
            'notes' => ['nullable', 'string'],
        ]);

        $inquiry->update($validated);

        return back()->with('success', 'Inquiry status updated successfully.');
    }

    public function destroy(Inquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Inquiry record deleted.');
    }

    /**
     * Export filtered inquiries as a CSV file.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $status = $request->get('status', 'all');

        $query = Inquiry::latest();
        if ($status !== 'all' && in_array($status, ['new', 'contacted', 'converted', 'archived'])) {
            $query->where('status', $status);
        }

        $filename = 'kiyara_inquiries_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($query) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'ID',
                'Date',
                'Name',
                'Email',
                'Phone',
                'Country',
                'Travel Type',
                'Duration (Days)',
                'Guests',
                'Preferred Season',
                'Accommodation Tier',
                'Estimated Cost (USD)',
                'Status',
                'Notes',
            ]);

            $query->chunk(100, function ($records) use ($handle) {
                foreach ($records as $inq) {
                    fputcsv($handle, [
                        $inq->id,
                        $inq->created_at->format('Y-m-d H:i'),
                        $inq->name,
                        $inq->email,
                        $inq->phone,
                        $inq->country,
                        $inq->travel_type,
                        $inq->duration_days,
                        $inq->guests,
                        $inq->preferred_season,
                        $inq->tier,
                        $inq->estimated_cost_usd,
                        $inq->status,
                        $inq->notes,
                    ]);
                }
            });

            fclose($handle);
        }, 200, $headers);
    }
}

