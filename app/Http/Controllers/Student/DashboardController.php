<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Period;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function index()
    {
        $applicant = auth()->user()->applicant()->first();

        if (!$applicant) {
            return redirect()->route('profile.index')
                ->with('error', 'Please complete your applicant profile to access the dashboard.');
        }

        // Get active period
        $activePeriod = Period::active()->first();

        // Get student's applications
        $applications = $applicant->applications()
            ->with([
                'period',
                'programmes.programme',
                'offers.programme',
                'offers.institute',
                'rejections.programme',
                'rejections.institute',
                'acceptance.programme',
                'acceptance.institute'
            ])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Check if student can apply (has no application for active period)
        $canApply = false;
        if ($activePeriod) {
            $existingApplication = $applicant->applications()
                ->where('period_id', $activePeriod->id)
                ->first();
            $canApply = !$existingApplication;
        }

        // Statistics
        $stats = [
            'total_applications' => $applicant->applications()->count(),
            'pending_applications' => $applicant->applications()->where('status', 'PENDING')->count(),
            'responded_applications' => $applicant->applications()->where('status', 'RESPONDED')->count(),
            'accepted_offers' => $applicant->applications()->whereHas('acceptance')->count(),
        ];

        return Inertia::render('Student/Dashboard/IndexPage', [
            'activePeriod' => $activePeriod,
            'applications' => $applications,
            'canApply' => $canApply,
            'stats' => $stats,
        ]);
    }
}
