<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageItinerary;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function __construct(
        protected ImageUploadService $imageService
    ) {}

    /**
     * List all packages with sorting and order.
     */
    public function index(): View
    {
        $packages = Package::withCount('itineraries')->ordered()->paginate(15);
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show form to create a new package.
     */
    public function create(): View
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created package with nested itineraries.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:packages,slug'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'difficulty' => ['nullable', 'string', 'max:50'],
            'group_size_max' => ['required', 'integer', 'min:1'],
            'starting_price_usd' => ['required', 'numeric', 'min:0'],
            'hero_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'hero_image_url' => ['nullable', 'string', 'url'],
            'overview' => ['nullable', 'string'],
            'is_featured' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer'],
            'itineraries' => ['nullable', 'array'],
            'itineraries.*.day_number' => ['required', 'integer', 'min:1'],
            'itineraries.*.title' => ['required', 'string', 'max:255'],
            'itineraries.*.location' => ['nullable', 'string', 'max:255'],
            'itineraries.*.morning_desc' => ['nullable', 'string'],
            'itineraries.*.afternoon_desc' => ['nullable', 'string'],
            'itineraries.*.evening_desc' => ['nullable', 'string'],
            'itineraries.*.stay_notes' => ['nullable', 'string'],
        ]);

        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        // Ensure unique slug
        $baseSlug = $slug;
        $counter = 1;
        while (Package::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $heroImage = $validated['hero_image_url'] ?? null;
        if ($request->hasFile('hero_image_file')) {
            $uploaded = $this->imageService->upload($request->file('hero_image_file'), 'packages', 800, 500);
            $heroImage = $uploaded['original'];
        }

        $package = Package::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'subtitle' => $validated['subtitle'] ?? null,
            'duration_days' => $validated['duration_days'],
            'difficulty' => $validated['difficulty'] ?? 'Moderate',
            'group_size_max' => $validated['group_size_max'],
            'starting_price_usd' => $validated['starting_price_usd'],
            'hero_image' => $heroImage,
            'overview' => $validated['overview'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'order' => $validated['order'] ?? 0,
        ]);

        // Save nested itineraries
        if (!empty($validated['itineraries'])) {
            foreach ($validated['itineraries'] as $itData) {
                $package->itineraries()->create($itData);
            }
        }

        return redirect()->route('admin.packages.index')
            ->with('success', "Package '{$package->title}' created successfully.");
    }

    /**
     * Display the specified package (redirects to edit).
     */
    public function show(Package $package): RedirectResponse
    {
        return redirect()->route('admin.packages.edit', $package);
    }

    /**
     * Show form to edit an existing package.
     */
    public function edit(Package $package): View
    {
        $package->load('itineraries');
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update package and sync itineraries.
     */
    public function update(Request $request, Package $package): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:packages,slug,' . $package->id],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'difficulty' => ['nullable', 'string', 'max:50'],
            'group_size_max' => ['required', 'integer', 'min:1'],
            'starting_price_usd' => ['required', 'numeric', 'min:0'],
            'hero_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'hero_image_url' => ['nullable', 'string'],
            'overview' => ['nullable', 'string'],
            'is_featured' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer'],
            'itineraries' => ['nullable', 'array'],
            'itineraries.*.day_number' => ['required', 'integer', 'min:1'],
            'itineraries.*.title' => ['required', 'string', 'max:255'],
            'itineraries.*.location' => ['nullable', 'string', 'max:255'],
            'itineraries.*.morning_desc' => ['nullable', 'string'],
            'itineraries.*.afternoon_desc' => ['nullable', 'string'],
            'itineraries.*.evening_desc' => ['nullable', 'string'],
            'itineraries.*.stay_notes' => ['nullable', 'string'],
        ]);

        $heroImage = $package->hero_image;
        if ($request->hasFile('hero_image_file')) {
            $this->imageService->delete($package->hero_image);
            $uploaded = $this->imageService->upload($request->file('hero_image_file'), 'packages', 800, 500);
            $heroImage = $uploaded['original'];
        } elseif (!empty($validated['hero_image_url'])) {
            $heroImage = $validated['hero_image_url'];
        }

        $package->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'subtitle' => $validated['subtitle'] ?? null,
            'duration_days' => $validated['duration_days'],
            'difficulty' => $validated['difficulty'] ?? 'Moderate',
            'group_size_max' => $validated['group_size_max'],
            'starting_price_usd' => $validated['starting_price_usd'],
            'hero_image' => $heroImage,
            'overview' => $validated['overview'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'order' => $validated['order'] ?? 0,
        ]);

        // Sync nested itineraries: replace with updated list
        if (isset($validated['itineraries'])) {
            $package->itineraries()->delete();
            foreach ($validated['itineraries'] as $itData) {
                $package->itineraries()->create($itData);
            }
        }

        return redirect()->route('admin.packages.index')
            ->with('success', "Package '{$package->title}' updated successfully.");
    }

    /**
     * Delete package and associated files.
     */
    public function destroy(Package $package): RedirectResponse
    {
        $title = $package->title;
        $this->imageService->delete($package->hero_image);
        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', "Package '{$title}' and its itineraries were deleted.");
    }
}
