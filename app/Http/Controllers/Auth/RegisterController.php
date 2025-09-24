<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Auth/RegisterPage');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstnames' => ['required', 'string', 'max:250'],
            'surname' => ['required', 'string', 'max:250'],
            'title' => ['required', 'string'],
            'gender' => ['required', 'string', 'in:MALE,FEMALE'],
            'phone' => ['required', 'digits:10', 'starts_with:07'],
            'address' => ['required', 'string'],
            'dob' => ['required', 'date', 'before_or_equal:31-12-2007'],
            'email' => ['required', 'email', 'max:250', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        try {
            $user = User::create([
                'name' => $request->firstnames . ' ' . $request->surname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->addRole('student');

            $applicant = new Applicant();
            $applicant->user_id = $user->id;
            $applicant->title = $request->title;
            $applicant->firstnames = $request->firstnames;
            $applicant->surname = $request->surname;
            $applicant->gender = $request->gender;
            $applicant->phone = $request->phone;
            $applicant->address = $request->address;
            $applicant->dob = $request->dob;
            $applicant->save();


            return back()->with('success', 'User created successfully');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
