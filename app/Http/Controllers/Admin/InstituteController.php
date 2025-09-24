<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $institutes = Institute::with(['programmes', 'users'])
            ->paginate(10);

        return Inertia::render('Admin/Institutes/IndexPage', [
            'institutes' => $institutes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Institutes/CreatePage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'web' => ['nullable', 'url', 'max:255'],
            'logo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        try {
            $logoPath = null;

            if ($request->hasFile('logo')) {
                $logoPath = $this->handleLogoUpload($request->file('logo'));
            }

            Institute::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'web' => $request->web,
                'logo' => $logoPath,
            ]);

            return redirect()->route('admin.institutes.index')
                ->with('success', 'Institute created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create institute: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $institute = Institute::with(['programmes', 'users'])
            ->findOrFail($id);

        return Inertia::render('Admin/Institutes/ShowPage', [
            'institute' => $institute,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $institute = Institute::findOrFail($id);

        return Inertia::render('Admin/Institutes/EditPage', [
            'institute' => $institute,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $institute = Institute::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'web' => ['nullable', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        try {
            $updateData = [
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'web' => $request->web,
            ];

            if ($request->hasFile('logo')) {
                // Delete old logo
                if ($institute->logo) {
                    $this->deleteLogo($institute->logo);
                }

                $updateData['logo'] = $this->handleLogoUpload($request->file('logo'));
            }

            $institute->update($updateData);

            return redirect()->route('admin.institutes.index')
                ->with('success', 'Institute updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update institute: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $institute = Institute::findOrFail($id);

        try {
            // Delete logo file
            if ($institute->logo) {
                $this->deleteLogo($institute->logo);
            }

            $institute->delete();

            return redirect()->route('admin.institutes.index')
                ->with('success', 'Institute deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete institute: ' . $e->getMessage()]);
        }
    }

    /**
     * Handle logo upload and create symlink to public folder
     */
    private function handleLogoUpload($file)
    {
        // Generate unique filename
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Store in storage/app/public/institutes/logos
        $path = $file->storeAs('institutes/logos', $filename, 'public');

        // Create symlink if it doesn't exist
        $this->ensureSymlinkExists();

        return $path;
    }

    /**
     * Delete logo file
     */
    private function deleteLogo($logoPath)
    {
        if ($logoPath && Storage::disk('public')->exists($logoPath)) {
            Storage::disk('public')->delete($logoPath);
        }
    }

    /**
     * Ensure symlink exists for storage
     */
    private function ensureSymlinkExists()
    {
        $target = storage_path('app/public');
        $link = public_path('storage');

        if (!is_link($link)) {
            if (is_dir($link)) {
                rmdir($link);
            }
            symlink($target, $link);
        }
    }
}
