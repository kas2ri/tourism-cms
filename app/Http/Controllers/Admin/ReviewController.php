<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(
        protected ImageUploadService $imageService
    ) {}

    public function index(): View
    {
        $reviews = Review::latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function create(): View
    {
        return view('admin.reviews.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_country' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'text' => ['required', 'string'],
            'tour_name' => ['nullable', 'string', 'max:255'],
            'avatar_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $avatar = null;
        if ($request->hasFile('avatar_file')) {
            $uploaded = $this->imageService->upload($request->file('avatar_file'), 'reviews', 200, 200);
            $avatar = $uploaded['original'];
        }

        Review::create([
            'guest_name' => $validated['guest_name'],
            'guest_country' => $validated['guest_country'] ?? null,
            'rating' => $validated['rating'],
            'text' => $validated['text'],
            'tour_name' => $validated['tour_name'] ?? null,
            'avatar' => $avatar,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review added successfully.');
    }

    /**
     * Display the specified review (redirects to edit).
     */
    public function show(Review $review): RedirectResponse
    {
        return redirect()->route('admin.reviews.edit', $review);
    }

    public function edit(Review $review): View
    {
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        $validated = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_country' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'text' => ['required', 'string'],
            'tour_name' => ['nullable', 'string', 'max:255'],
            'avatar_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $avatar = $review->avatar;
        if ($request->hasFile('avatar_file')) {
            $this->imageService->delete($review->avatar);
            $uploaded = $this->imageService->upload($request->file('avatar_file'), 'reviews', 200, 200);
            $avatar = $uploaded['original'];
        }

        $review->update([
            'guest_name' => $validated['guest_name'],
            'guest_country' => $validated['guest_country'] ?? null,
            'rating' => $validated['rating'],
            'text' => $validated['text'],
            'tour_name' => $validated['tour_name'] ?? null,
            'avatar' => $avatar,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    public function toggleFeatured(Review $review): RedirectResponse
    {
        $review->update(['is_featured' => !$review->is_featured]);
        $status = $review->is_featured ? 'featured on public site' : 'unfeatured';

        return back()->with('success', "Review is now {$status}.");
    }

    public function destroy(Review $review): RedirectResponse
    {
        $this->imageService->delete($review->avatar);
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}
