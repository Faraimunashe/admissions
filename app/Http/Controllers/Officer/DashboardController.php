<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the officer dashboard.
     */
    public function index()
    {
        // Get the officer's institute
        $officer = auth()->user();
        $institute = $officer->institutes()->first();

        return Inertia::render('Officer/Dashboard/IndexPage', [
            'institute' => $institute,
        ]);
    }
}
