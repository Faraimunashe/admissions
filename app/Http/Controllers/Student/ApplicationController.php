<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationAccepted;
use App\Models\ApplicationDocument;
use App\Models\ApplicationProgramme;
use App\Models\Applicant;
use App\Models\Period;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Barryvdh\DomPDF\PDF;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applicant = auth()->user()->applicant()->first();

        if (!$applicant) {
            return redirect()->route('profile.index')
                ->with('error', 'Please complete your applicant profile before applying.');
        }

        $applications = $applicant->applications()
            ->with([
                'period',
                'programmes.programme',
                'documents',
                'offers.programme',
                'offers.institute',
                'rejections.programme',
                'rejections.institute',
                'acceptance.programme',
                'acceptance.institute'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Student/Applications/IndexPage', [
            'applications' => $applications,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $applicant = auth()->user()->applicant()->first();

        if (!$applicant) {
            return redirect()->route('profile.index')
                ->with('error', 'Please complete your applicant profile before applying.');
        }

        // Get active period
        $activePeriod = Period::active()->first();

        if (!$activePeriod) {
            return redirect()->route('student.applications.index')
                ->with('error', 'No active admission period is currently open.');
        }

        // Check if student already has an application for this period
        $existingApplication = $applicant->applications()
            ->where('period_id', $activePeriod->id)
            ->first();

        if ($existingApplication) {
            return redirect()->route('student.applications.show', $existingApplication->id)
                ->with('info', 'You already have an application for this period.');
        }

        // Get all programmes for selection
        $programmes = Programme::with('institutes')
            ->orderBy('name')
            ->get();

        return Inertia::render('Student/Applications/CreatePage', [
            'activePeriod' => $activePeriod,
            'programmes' => $programmes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $applicant = auth()->user()->applicant()->first();

        if (!$applicant) {
            return back()->withErrors(['error' => 'Please complete your applicant profile before applying.']);
        }

        // Validate the request
        $request->validate([
            'period_id' => ['required', 'exists:periods,id'],
            'programmes' => ['required', 'array', 'min:3', 'max:3'],
            'programmes.*.programme_id' => ['required', 'exists:programmes,id', 'distinct'],
            'programmes.*.choice' => ['required', 'integer', 'min:1', 'max:3'],
            'documents' => ['required', 'array', 'min:1'],
            'documents.*.file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // 5MB max
            'documents.*.description' => ['required', 'string', 'max:255'],
        ]);

        // Check if period is active (by dates)
        $period = Period::findOrFail($request->period_id);
        if (!($period->start_date <= now() && $period->end_date >= now())) {
            return back()->withErrors(['error' => 'This admission period is no longer active.']);
        }

        // Check if student already has an application for this period
        $existingApplication = $applicant->applications()
            ->where('period_id', $request->period_id)
            ->first();

        if ($existingApplication) {
            return back()->withErrors(['error' => 'You already have an application for this period.']);
        }

        try {
            DB::beginTransaction();

            // Create the application
            $application = $applicant->applications()->create([
                'period_id' => $request->period_id,
                'status' => 'PENDING',
            ]);

            // Create application programmes
            foreach ($request->programmes as $programmeData) {
                $application->programmes()->create([
                    'programme_id' => $programmeData['programme_id'],
                    'choice' => $programmeData['choice'],
                ]);
            }

            // Handle document uploads
            foreach ($request->documents as $documentData) {
                $file = $documentData['file'];
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('application-documents', $fileName, 'public');

                $application->documents()->create([
                    'file_path' => $filePath,
                    'description' => $documentData['description'],
                ]);
            }

            DB::commit();

            return redirect()->route('student.applications.show', $application->id)
                ->with('success', 'Application submitted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to submit application: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $applicant = auth()->user()->applicant()->first();

        if (!$applicant) {
            return redirect()->route('profile.index')
                ->with('error', 'Please complete your applicant profile before viewing applications.');
        }

        $application = $applicant->applications()
            ->with([
                'period',
                'programmes.programme',
                'documents',
                'offers.programme',
                'offers.institute',
                'rejections.programme',
                'rejections.institute',
                'acceptance.programme',
                'acceptance.institute'
            ])
            ->findOrFail($id);

        // Get available institutes for each offered programme
        $offersWithInstitutes = [];
        if ($application->offers) {
            foreach ($application->offers as $offer) {
                $programmeId = $offer->programme_id;

                // Get all institutes that offer this programme and have made offers
                $institutesForProgramme = $application->offers
                    ->where('programme_id', $programmeId)
                    ->map(function($offer) {
                        return [
                            'id' => $offer->institute->id,
                            'name' => $offer->institute->name,
                            'address' => $offer->institute->address,
                            'phone' => $offer->institute->phone,
                            'web' => $offer->institute->web,
                            'logo' => $offer->institute->logo,
                            'offer_id' => $offer->id,
                            'offer_details' => $offer->offer_details ?? null,
                            'created_at' => $offer->created_at
                        ];
                    })
                    ->unique('id')
                    ->values();

                $offersWithInstitutes[] = [
                    'programme' => $offer->programme,
                    'institutes' => $institutesForProgramme
                ];
            }
        }

        // Remove duplicates by programme
        $uniqueOffersWithInstitutes = [];
        $seenProgrammes = [];
        foreach ($offersWithInstitutes as $offer) {
            if (!in_array($offer['programme']->id, $seenProgrammes)) {
                $uniqueOffersWithInstitutes[] = $offer;
                $seenProgrammes[] = $offer['programme']->id;
            }
        }

        return Inertia::render('Student/Applications/ShowPage', [
            'application' => $application,
            'offersWithInstitutes' => $uniqueOffersWithInstitutes,
        ]);
    }

    /**
     * Accept an offered programme.
     */
    public function accept(Request $request, string $id)
    {
        $applicant = auth()->user()->applicant()->first();

        if (!$applicant) {
            return back()->withErrors(['error' => 'Please complete your applicant profile.']);
        }

        $request->validate([
            'programme_id' => ['required', 'exists:programmes,id'],
            'institute_id' => ['required', 'exists:institutes,id'],
        ]);

        $application = $applicant->applications()->findOrFail($id);

        // Check if application has been responded to
        if ($application->status !== 'RESPONDED') {
            return back()->withErrors(['error' => 'This application has not been processed yet.']);
        }

        // Check if student already has any acceptance
        if ($application->acceptances()->exists()) {
            return back()->withErrors(['error' => 'You have already accepted an offer. You cannot accept multiple offers.']);
        }

        // Verify the offer exists
        $offer = $application->offers()
            ->where('programme_id', $request->programme_id)
            ->where('institute_id', $request->institute_id)
            ->first();

        if (!$offer) {
            return back()->withErrors(['error' => 'This offer is not valid for your application.']);
        }

        try {
            // Create acceptance
            $application->acceptances()->create([
                'programme_id' => $request->programme_id,
                'institute_id' => $request->institute_id,
            ]);

            return redirect()->route('student.applications.show', $application->id)
                ->with('success', 'Offer accepted successfully!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to accept offer: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Students cannot edit submitted applications
        return redirect()->route('student.applications.show', $id)
            ->with('error', 'Applications cannot be edited once submitted.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Students cannot update submitted applications
        return redirect()->route('student.applications.show', $id)
            ->with('error', 'Applications cannot be updated once submitted.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Students cannot delete submitted applications
        return redirect()->route('student.applications.index')
            ->with('error', 'Applications cannot be deleted once submitted.');
    }

    /**
     * Download acceptance letter.
     */
    public function downloadAcceptanceLetter(Request $request, string $id)
    {
        $applicant = auth()->user()->applicant()->first();

        if (!$applicant) {
            return redirect()->route('profile.index')
                ->with('error', 'Please complete your applicant profile.');
        }

        $application = $applicant->applications()
            ->with([
                'acceptances.programme',
                'acceptances.institute',
                'period'
            ])
            ->findOrFail($id);

        // Load the user relationship for the applicant
        $applicant->load('user');

        if ($application->acceptances->isEmpty()) {
            return redirect()->route('student.applications.show', $application->id)
                ->with('error', 'No acceptance found for this application.');
        }

        // Get specific acceptance if requested, otherwise get the first one
        $acceptanceId = $request->query('acceptance_id');
        if ($acceptanceId) {
            $acceptance = $application->acceptances->where('id', $acceptanceId)->first();
            if (!$acceptance) {
                return redirect()->route('student.applications.show', $application->id)
                    ->with('error', 'Acceptance not found.');
            }
        } else {
            $acceptance = $application->acceptances->first();
        }
        $institute = $acceptance->institute;
        $programme = $acceptance->programme;
        $period = $application->period;

        // Generate PDF
        $pdf = app(PDF::class)->loadView('acceptance-letter', [
            'applicant' => $applicant,
            'institute' => $institute,
            'programme' => $programme,
            'period' => $period,
            'acceptance' => $acceptance,
            'application' => $application
        ]);

        $filename = 'Acceptance_Letter_' . $institute->name . '_' . $programme->name . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
