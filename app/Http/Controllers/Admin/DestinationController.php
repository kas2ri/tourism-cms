<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function __construct(
        protected ImageUploadService $imageService
    ) {}

    public function index(): View
    {
        $destinations = Destination::latest()->paginate(15);
        return view('admin.destinations.index', compact('destinations'));
    }

    public function create(): View
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:destinations,slug'],
            'short_desc' => ['nullable', 'string'],
            'best_season' => ['nullable', 'string', 'max:255'],
            'hero_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'hero_image_url' => ['nullable', 'string', 'url'],
        ]);

        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']);

        $heroImage = $validated['hero_image_url'] ?? null;
        if ($request->hasFile('hero_image_file')) {
            $uploaded = $this->imageService->upload($request->file('hero_image_file'), 'destinations', 800, 500);
            $heroImage = $uploaded['original'];
        }

        Destination::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'short_desc' => $validated['short_desc'] ?? null,
            'best_season' => $validated['best_season'] ?? null,
            'hero_image' => $heroImage,
        ]);

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination created successfully.');
    }

    /**
     * Display the specified destination (redirects to edit).
     */
    public function show(Destination $destination): RedirectResponse
    {
        return redirect()->route('admin.destinations.edit', $destination);
    }

    public function edit(Destination $destination): View
    {
        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(Request $request, Destination $destination): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:destinations,slug,' . $destination->id],
            'short_desc' => ['nullable', 'string'],
            'best_season' => ['nullable', 'string', 'max:255'],
            'hero_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'hero_image_url' => ['nullable', 'string'],
        ]);

        $heroImage = $destination->hero_image;
        if ($request->hasFile('hero_image_file')) {
            $this->imageService->delete($destination->hero_image);
            $uploaded = $this->imageService->upload($request->file('hero_image_file'), 'destinations', 800, 500);
            $heroImage = $uploaded['original'];
        } elseif (!empty($validated['hero_image_url'])) {
            $heroImage = $validated['hero_image_url'];
        }

        $destination->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['slug']),
            'short_desc' => $validated['short_desc'] ?? null,
            'best_season' => $validated['best_season'] ?? null,
            'hero_image' => $heroImage,
        ]);

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination updated successfully.');
    }

    public function destroy(Destination $destination): RedirectResponse
    {
        $this->imageService->delete($destination->hero_image);
        $destination->delete();

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination deleted successfully.');
    }
}
