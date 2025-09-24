<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periods = Period::withCount('applications')
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return Inertia::render('Admin/Periods/IndexPage', [
            'periods' => $periods,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Periods/CreatePage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ]);

        try {
            Period::create([
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            return redirect()->route('admin.periods.index')
                ->with('success', 'Period created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create period: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $period = Period::with([
            'applications.applicant.user',
            'applications.applicationProgrammes.programme'
        ])->findOrFail($id);

        return Inertia::render('Admin/Periods/ShowPage', [
            'period' => $period,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $period = Period::findOrFail($id);

        return Inertia::render('Admin/Periods/EditPage', [
            'period' => $period,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $period = Period::findOrFail($id);

        $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ]);

        try {
            $period->update([
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            return redirect()->route('admin.periods.index')
                ->with('success', 'Period updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update period: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $period = Period::findOrFail($id);

            // Check if period has any applications
            if ($period->applications()->count() > 0) {
                return back()->withErrors(['error' => 'Cannot delete period. It has associated applications.']);
            }

            $period->delete();

            return redirect()->route('admin.periods.index')
                ->with('success', 'Period deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete period: ' . $e->getMessage()]);
        }
    }
}
