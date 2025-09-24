<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\InstituteProgramme;
use App\Models\Programme;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstituteProgrammeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the officer's institute
        $officer = auth()->user();
        $institute = $officer->institutes()->first();

        if (!$institute) {
            return redirect()->route('officer.dashboard')
                ->with('error', 'You are not associated with any institute.');
        }

        // Get programmes for this institute
        $instituteProgrammes = InstituteProgramme::with(['programme'])
            ->where('institute_id', $institute->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Officer/InstituteProgrammes/IndexPage', [
            'instituteProgrammes' => $instituteProgrammes,
            'institute' => $institute,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get the officer's institute
        $officer = auth()->user();
        $institute = $officer->institutes()->first();

        if (!$institute) {
            return redirect()->route('officer.dashboard')
                ->with('error', 'You are not associated with any institute.');
        }

        // Get programmes that are not yet linked to this institute
        $availableProgrammes = Programme::whereDoesntHave('institutes', function ($query) use ($institute) {
            $query->where('institute_id', $institute->id);
        })->orderBy('name')->get();

        return Inertia::render('Officer/InstituteProgrammes/CreatePage', [
            'programmes' => $availableProgrammes,
            'institute' => $institute,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Get the officer's institute
        $officer = auth()->user();
        $institute = $officer->institutes()->first();

        if (!$institute) {
            return redirect()->route('officer.dashboard')
                ->with('error', 'You are not associated with any institute.');
        }

        $request->validate([
            'programme_id' => ['required', 'exists:programmes,id'],
            'active' => ['boolean'],
        ]);

        try {
            // Check if programme is already linked to this institute
            $existingLink = InstituteProgramme::where('institute_id', $institute->id)
                ->where('programme_id', $request->programme_id)
                ->first();

            if ($existingLink) {
                return back()->withErrors(['error' => 'This programme is already linked to your institute.']);
            }

            InstituteProgramme::create([
                'institute_id' => $institute->id,
                'programme_id' => $request->programme_id,
                'active' => $request->boolean('active', true),
            ]);

            return redirect()->route('officer.institute-programmes.index')
                ->with('success', 'Programme linked to your institute successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to link programme: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get the officer's institute
        $officer = auth()->user();
        $institute = $officer->institutes()->first();

        if (!$institute) {
            return redirect()->route('officer.dashboard')
                ->with('error', 'You are not associated with any institute.');
        }

        $instituteProgramme = InstituteProgramme::with(['programme', 'institute'])
            ->where('institute_id', $institute->id)
            ->findOrFail($id);

        // Get applications for this programme at this institute
        $applications = \App\Models\ApplicationProgramme::with([
            'application.applicant.user',
            'programme'
        ])->where('programme_id', $instituteProgramme->programme_id)->get();

        return Inertia::render('Officer/InstituteProgrammes/ShowPage', [
            'instituteProgramme' => $instituteProgramme,
            'applications' => $applications,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Get the officer's institute
        $officer = auth()->user();
        $institute = $officer->institutes()->first();

        if (!$institute) {
            return redirect()->route('officer.dashboard')
                ->with('error', 'You are not associated with any institute.');
        }

        $instituteProgramme = InstituteProgramme::with(['programme'])
            ->where('institute_id', $institute->id)
            ->findOrFail($id);

        return Inertia::render('Officer/InstituteProgrammes/EditPage', [
            'instituteProgramme' => $instituteProgramme,
            'institute' => $institute,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Get the officer's institute
        $officer = auth()->user();
        $institute = $officer->institutes()->first();

        if (!$institute) {
            return redirect()->route('officer.dashboard')
                ->with('error', 'You are not associated with any institute.');
        }

        $instituteProgramme = InstituteProgramme::where('institute_id', $institute->id)
            ->findOrFail($id);

        $request->validate([
            'active' => ['required', 'boolean'],
        ]);

        try {
            $instituteProgramme->update([
                'active' => $request->boolean('active'),
            ]);

            return redirect()->route('officer.institute-programmes.index')
                ->with('success', 'Programme status updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update programme: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the officer's institute
        $officer = auth()->user();
        $institute = $officer->institutes()->first();

        if (!$institute) {
            return redirect()->route('officer.dashboard')
                ->with('error', 'You are not associated with any institute.');
        }

        try {
            $instituteProgramme = InstituteProgramme::where('institute_id', $institute->id)
                ->findOrFail($id);

            // Check if there are any applications for this programme at this institute
            $applicationsCount = \App\Models\ApplicationProgramme::where('programme_id', $instituteProgramme->programme_id)
                ->whereHas('application', function ($query) use ($institute) {
                    $query->whereHas('programmes', function ($subQuery) use ($institute) {
                        $subQuery->where('institute_id', $institute->id);
                    });
                })
                ->count();

            if ($applicationsCount > 0) {
                return back()->withErrors(['error' => 'Cannot remove programme. There are applications for this programme.']);
            }

            $instituteProgramme->delete();

            return redirect()->route('officer.institute-programmes.index')
                ->with('success', 'Programme removed from your institute successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to remove programme: ' . $e->getMessage()]);
        }
    }
}
