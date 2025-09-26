<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationProgramme;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the officer's institute
        $officer = auth()->user();
        $institute = $officer->institutes()->first();

        if (!$institute) {
            return redirect()->route('officer.dashboard')
                ->with('error', 'You are not associated with any institute.');
        }

        // Get applications for programmes offered by this institute
        $query = Application::with([
            'applicant.user',
            'period',
            'programmes.programme',
            'documents',
            'acceptance',
            'offers',
            'rejections'
        ])->whereHas('programmes.programme', function ($q) use ($institute) {
            $q->whereHas('institutes', function ($subQ) use ($institute) {
                $subQ->where('institute_id', $institute->id);
            });
        });

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by period
        if ($request->filled('period_id')) {
            $query->where('period_id', $request->period_id);
        }

        // Filter by programme
        if ($request->filled('programme_id')) {
            $query->whereHas('programmes', function ($q) use ($request) {
                $q->where('programme_id', $request->programme_id);
            });
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

        // Get programmes offered by this institute
        $programmes = $institute->programmes()->orderBy('name')->get();

        return Inertia::render('Officer/Applications/IndexPage', [
            'applications' => $applications,
            'periods' => $periods,
            'programmes' => $programmes,
            'institute' => $institute,
            'filters' => $request->only(['status', 'period_id', 'programme_id', 'search'])
        ]);
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
        ])->whereHas('programmes.programme', function ($q) use ($institute) {
            $q->whereHas('institutes', function ($subQ) use ($institute) {
                $subQ->where('institute_id', $institute->id);
            });
        })->findOrFail($id);

        return Inertia::render('Officer/Applications/ShowPage', [
            'application' => $application,
            'institute' => $institute,
        ]);
    }

    /**
     * Accept an application
     */
    public function accept(Request $request, string $id)
    {
        // Get the officer's institute
        $officer = auth()->user();
        $institute = $officer->institutes()->first();

        if (!$institute) {
            return redirect()->route('officer.dashboard')
                ->with('error', 'You are not associated with any institute.');
        }

        $application = Application::whereHas('programmes.programme', function ($q) use ($institute) {
            $q->whereHas('institutes', function ($subQ) use ($institute) {
                $subQ->where('institute_id', $institute->id);
            });
        })->with(['programmes.programme'])->findOrFail($id);

        $request->validate([
            'programme_id' => ['required', 'exists:programmes,id'],
        ]);

        try {
            // Check if student has already accepted any offer
            if ($application->acceptances()->exists()) {
                return back()->withErrors(['error' => 'This student has already accepted an offer. No more offers can be made.']);
            }

            // Check if this institute has already made an offer for this programme
            $existingOffer = \App\Models\ApplicationProgrammeOffered::where('application_id', $application->id)
                ->where('programme_id', $request->programme_id)
                ->where('institute_id', $institute->id)
                ->first();

            if ($existingOffer) {
                return back()->withErrors(['error' => 'Your institute has already made an offer for this programme.']);
            }

            // Verify the programme is offered by this institute
            $programme = $application->programmes->where('programme_id', $request->programme_id)->first();
            if (!$programme) {
                return back()->withErrors(['error' => 'Invalid programme selection.']);
            }

            // Check if the programme is offered by this institute
            if (!$institute->programmes()->where('programme_id', $request->programme_id)->exists()) {
                return back()->withErrors(['error' => 'You can only make offers for programmes offered by your institute.']);
            }

            // Create offer record
            \App\Models\ApplicationProgrammeOffered::create([
                'application_id' => $application->id,
                'programme_id' => $request->programme_id,
                'institute_id' => $institute->id,
                'user_id' => $officer->id,
            ]);

            // Update application status to RESPONDED if it's still PENDING
            if ($application->status === 'PENDING') {
                $application->update(['status' => 'RESPONDED']);
            }

            return redirect()->route('officer.applications.show', $application->id)
                ->with('success', 'Offer made successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to accept application: ' . $e->getMessage()]);
        }
    }

    /**
     * Reject an application
     */
    public function reject(Request $request, string $id)
    {
        // Get the officer's institute
        $officer = auth()->user();
        $institute = $officer->institutes()->first();

        if (!$institute) {
            return redirect()->route('officer.dashboard')
                ->with('error', 'You are not associated with any institute.');
        }

        $application = Application::whereHas('programmes.programme', function ($q) use ($institute) {
            $q->whereHas('institutes', function ($subQ) use ($institute) {
                $subQ->where('institute_id', $institute->id);
            });
        })->with(['programmes.programme'])->findOrFail($id);

        $request->validate([
            'programme_id' => ['required', 'exists:programmes,id'],
            'reason' => ['required', 'string', 'max:500'],
        ]);

        try {
            // Check if this institute has already responded to this application
            $existingResponse = \App\Models\ApplicationProgrammeRejected::where('application_id', $application->id)
                ->where('institute_id', $institute->id)
                ->where('programme_id', $request->programme_id)
                ->first();

            if ($existingResponse) {
                return back()->withErrors(['error' => 'Your institute has already responded to this programme for this application.']);
            }

            // Verify the programme is offered by this institute
            $programme = $application->programmes->where('programme_id', $request->programme_id)->first();
            if (!$programme) {
                return back()->withErrors(['error' => 'Invalid programme selection.']);
            }

            // Check if the programme is offered by this institute
            if (!$institute->programmes()->where('programme_id', $request->programme_id)->exists()) {
                return back()->withErrors(['error' => 'You can only reject applications for programmes offered by your institute.']);
            }

            // Create rejection record
            \App\Models\ApplicationProgrammeRejected::create([
                'application_id' => $application->id,
                'programme_id' => $request->programme_id,
                'institute_id' => $institute->id,
                'user_id' => $officer->id,
                'reason' => $request->reason,
            ]);

            // Update application status to RESPONDED if it's still PENDING
            if ($application->status === 'PENDING') {
                $application->update(['status' => 'RESPONDED']);
            }

            return redirect()->route('officer.applications.show', $application->id)
                ->with('success', 'Application rejected successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to reject application: ' . $e->getMessage()]);
        }
    }

    /**
     * Offer an application (alternative to direct acceptance)
     */
    public function offer(Request $request, string $id)
    {
        // Get the officer's institute
        $officer = auth()->user();
        $institute = $officer->institutes()->first();

        if (!$institute) {
            return redirect()->route('officer.dashboard')
                ->with('error', 'You are not associated with any institute.');
        }

        $application = Application::whereHas('programmes.programme', function ($q) use ($institute) {
            $q->whereHas('institutes', function ($subQ) use ($institute) {
                $subQ->where('institute_id', $institute->id);
            });
        })->with(['programmes.programme'])->findOrFail($id);

        $request->validate([
            'programme_id' => ['required', 'exists:programmes,id'],
            'offer_details' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            // Check if student has already accepted any offer
            if ($application->acceptances()->exists()) {
                return back()->withErrors(['error' => 'This student has already accepted an offer. No more offers can be made.']);
            }

            // Check if this institute has already made an offer for this programme
            $existingOffer = \App\Models\ApplicationProgrammeOffered::where('application_id', $application->id)
                ->where('programme_id', $request->programme_id)
                ->where('institute_id', $institute->id)
                ->first();

            if ($existingOffer) {
                return back()->withErrors(['error' => 'Your institute has already made an offer for this programme.']);
            }

            // Verify the programme is offered by this institute
            $programme = $application->programmes->where('programme_id', $request->programme_id)->first();
            if (!$programme) {
                return back()->withErrors(['error' => 'Invalid programme selection.']);
            }

            // Check if the programme is offered by this institute
            if (!$institute->programmes()->where('programme_id', $request->programme_id)->exists()) {
                return back()->withErrors(['error' => 'You can only make offers for programmes offered by your institute.']);
            }

            // Create offer record
            \App\Models\ApplicationProgrammeOffered::create([
                'application_id' => $application->id,
                'programme_id' => $request->programme_id,
                'institute_id' => $institute->id,
                'user_id' => $officer->id,
                'offer_details' => $request->offer_details,
            ]);

            // Update application status to RESPONDED if it's still PENDING
            if ($application->status === 'PENDING') {
                $application->update(['status' => 'RESPONDED']);
            }

            return redirect()->route('officer.applications.show', $application->id)
                ->with('success', 'Offer made successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to make offer: ' . $e->getMessage()]);
        }
    }
}
