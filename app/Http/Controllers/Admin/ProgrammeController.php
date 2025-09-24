<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Programme;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgrammeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programmes = Programme::withCount(['institutes', 'applicationProgrammes'])
            ->orderBy('name')
            ->paginate(10);

        return Inertia::render('Admin/Programmes/IndexPage', [
            'programmes' => $programmes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Programmes/CreatePage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:programmes'],
        ]);

        try {
            Programme::create([
                'name' => $request->name,
            ]);

            return redirect()->route('admin.programmes.index')
                ->with('success', 'Programme created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create programme: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $programme = Programme::with([
            'institutes' => function ($query) {
                $query->orderBy('name');
            },
            'applicationProgrammes.application.applicant.user'
        ])->findOrFail($id);

        return Inertia::render('Admin/Programmes/ShowPage', [
            'programme' => $programme,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $programme = Programme::findOrFail($id);

        return Inertia::render('Admin/Programmes/EditPage', [
            'programme' => $programme,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $programme = Programme::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:programmes,name,' . $id],
        ]);

        try {
            $programme->update([
                'name' => $request->name,
            ]);

            return redirect()->route('admin.programmes.index')
                ->with('success', 'Programme updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update programme: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $programme = Programme::findOrFail($id);

            // Check if programme is being used by any institutes
            if ($programme->institutes()->count() > 0) {
                return back()->withErrors(['error' => 'Cannot delete programme. It is currently offered by one or more institutes.']);
            }

            // Check if programme has any applications
            if ($programme->applicationProgrammes()->count() > 0) {
                return back()->withErrors(['error' => 'Cannot delete programme. It has associated applications.']);
            }

            $programme->delete();

            return redirect()->route('admin.programmes.index')
                ->with('success', 'Programme deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete programme: ' . $e->getMessage()]);
        }
    }
}
