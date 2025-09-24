<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Application::with([
            'applicant.user',
            'period',
            'programmes.programme',
            'documents',
            'acceptance',
            'offers',
            'rejections'
        ]);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by period
        if ($request->filled('period_id')) {
            $query->where('period_id', $request->period_id);
        }

        // Search by applicant name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('applicant.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('applicant', function ($q) use ($search) {
                $q->where('firstnames', 'like', "%{$search}%")
                  ->orWhere('surname', 'like', "%{$search}%");
            });
        }

        $applications = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Get periods for filter dropdown
        $periods = \App\Models\Period::orderBy('name')->get();

        return Inertia::render('Admin/Applications/IndexPage', [
            'applications' => $applications,
            'periods' => $periods,
            'filters' => $request->only(['status', 'period_id', 'search'])
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $application = Application::with([
            'applicant.user',
            'period',
            'programmes.programme.institutes',
            'documents',
            'acceptance.programme',
            'acceptance.institute',
            'offers.programme',
            'offers.institute',
            'offers.user',
            'rejections.programme',
            'rejections.institute',
            'rejections.user'
        ])->findOrFail($id);

        return Inertia::render('Admin/Applications/ShowPage', [
            'application' => $application,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $application = Application::with([
            'applicant.user',
            'period',
            'programmes.programme',
            'documents',
            'acceptance',
            'offers',
            'rejections'
        ])->findOrFail($id);

        // Get all periods for dropdown
        $periods = \App\Models\Period::orderBy('name')->get();

        return Inertia::render('Admin/Applications/EditPage', [
            'application' => $application,
            'periods' => $periods,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $application = Application::findOrFail($id);

        $request->validate([
            'status' => ['required', 'in:PENDING,RESPONDED'],
            'period_id' => ['required', 'exists:periods,id'],
        ]);

        try {
            $application->update([
                'status' => $request->status,
                'period_id' => $request->period_id,
            ]);

            return redirect()->route('admin.applications.index')
                ->with('success', 'Application updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update application: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $application = Application::findOrFail($id);

            // Delete related records first
            $application->programmes()->delete();
            $application->documents()->delete();
            $application->acceptance()->delete();
            $application->offers()->delete();
            $application->rejections()->delete();

            // Delete the application
            $application->delete();

            return redirect()->route('admin.applications.index')
                ->with('success', 'Application deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete application: ' . $e->getMessage()]);
        }
    }

    /**
     * Accept an application
     */
    public function accept(Request $request, string $id)
    {
        $application = Application::with(['programmes.programme'])->findOrFail($id);

        $request->validate([
            'programme_id' => ['required', 'exists:programmes,id'],
            'institute_id' => ['required', 'exists:institutes,id'],
        ]);

        try {
            // Check if application is already accepted
            if ($application->acceptance) {
                return back()->withErrors(['error' => 'Application has already been accepted.']);
            }

            // Create acceptance record
            \App\Models\ApplicationAccepted::create([
                'application_id' => $application->id,
                'programme_id' => $request->programme_id,
                'institute_id' => $request->institute_id,
            ]);

            // Update application status
            $application->update(['status' => 'RESPONDED']);

            return redirect()->route('admin.applications.show', $application->id)
                ->with('success', 'Application accepted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to accept application: ' . $e->getMessage()]);
        }
    }

    /**
     * Reject an application
     */
    public function reject(Request $request, string $id)
    {
        $application = Application::with(['programmes.programme'])->findOrFail($id);

        $request->validate([
            'programme_id' => ['required', 'exists:programmes,id'],
            'institute_id' => ['required', 'exists:institutes,id'],
            'reason' => ['required', 'string', 'max:500'],
        ]);

        try {
            // Create rejection record
            \App\Models\ApplicationProgrammeRejected::create([
                'application_id' => $application->id,
                'programme_id' => $request->programme_id,
                'institute_id' => $request->institute_id,
                'user_id' => auth()->id(),
                'reason' => $request->reason,
            ]);

            // Update application status
            $application->update(['status' => 'RESPONDED']);

            return redirect()->route('admin.applications.show', $application->id)
                ->with('success', 'Application rejected successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to reject application: ' . $e->getMessage()]);
        }
    }
}
