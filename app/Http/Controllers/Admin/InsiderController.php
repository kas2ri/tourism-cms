<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insider;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InsiderController extends Controller
{
    public function __construct(
        protected ImageUploadService $imageService
    ) {}

    public function index(): View
    {
        $insiders = Insider::latest()->paginate(15);
        return view('admin.insiders.index', compact('insiders'));
    }

    public function create(): View
    {
        return view('admin.insiders.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0'],
            'bio' => ['required', 'string'],
            'languages' => ['nullable', 'string'],
            'avatar_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'avatar_url' => ['nullable', 'string', 'url'],
        ]);

        $avatar = $validated['avatar_url'] ?? null;
        if ($request->hasFile('avatar_file')) {
            $uploaded = $this->imageService->upload($request->file('avatar_file'), 'insiders', 300, 300);
            $avatar = $uploaded['original'];
        }

        $languages = !empty($validated['languages'])
            ? array_map('trim', explode(',', $validated['languages']))
            : [];

        Insider::create([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'experience_years' => $validated['experience_years'],
            'bio' => $validated['bio'],
            'avatar' => $avatar,
            'languages' => $languages,
        ]);

        return redirect()->route('admin.insiders.index')
            ->with('success', 'Driver-storyteller / Guide added successfully.');
    }

    /**
     * Display the specified insider (redirects to edit).
     */
    public function show(Insider $insider): RedirectResponse
    {
        return redirect()->route('admin.insiders.edit', $insider);
    }

    public function edit(Insider $insider): View
    {
        return view('admin.insiders.edit', compact('insider'));
    }

    public function update(Request $request, Insider $insider): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0'],
            'bio' => ['required', 'string'],
            'languages' => ['nullable', 'string'],
            'avatar_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'avatar_url' => ['nullable', 'string'],
        ]);

        $avatar = $insider->avatar;
        if ($request->hasFile('avatar_file')) {
            $this->imageService->delete($insider->avatar);
            $uploaded = $this->imageService->upload($request->file('avatar_file'), 'insiders', 300, 300);
            $avatar = $uploaded['original'];
        } elseif (!empty($validated['avatar_url'])) {
            $avatar = $validated['avatar_url'];
        }

        $languages = !empty($validated['languages'])
            ? array_map('trim', explode(',', $validated['languages']))
            : [];

        $insider->update([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'experience_years' => $validated['experience_years'],
            'bio' => $validated['bio'],
            'avatar' => $avatar,
            'languages' => $languages,
        ]);

        return redirect()->route('admin.insiders.index')
            ->with('success', 'Insider profile updated successfully.');
    }

    public function destroy(Insider $insider): RedirectResponse
    {
        $this->imageService->delete($insider->avatar);
        $insider->delete();

        return redirect()->route('admin.insiders.index')
            ->with('success', 'Insider removed successfully.');
    }
}
