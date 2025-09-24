<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['applicant', 'roles'])
            ->paginate(15);

        return Inertia::render('Admin/Users/IndexPage', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $institutes = \App\Models\Institute::all();

        return Inertia::render('Admin/Users/CreatePage', [
            'roles' => $roles,
            'institutes' => $institutes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,name'],
            //'institute_id' => ['required_if:role,officer', 'exists:institutes,id'],
            // Student applicant fields
            // 'title' => ['required_if:role,student', 'string'],
            // 'firstnames' => ['required_if:role,student', 'string', 'max:255'],
            // 'surname' => ['required_if:role,student', 'string', 'max:255'],
            // 'gender' => ['required_if:role,student', 'string', 'in:MALE,FEMALE'],
            // 'phone' => ['required_if:role,student', 'digits:10', 'starts_with:07'],
            // 'address' => ['required_if:role,student', 'string'],
            // 'dob' => ['required_if:role,student', 'date', 'before_or_equal:31-12-2007'],
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->addRole($request->role);

            // Link officer to institute
            if ($request->role === 'officer' && $request->institute_id) {
                $user->institutes()->attach($request->institute_id);
            }

            // Create applicant profile for students
            if ($request->role === 'student') {
                Applicant::create([
                    'user_id' => $user->id,
                    'title' => $request->title,
                    'firstnames' => $request->firstnames,
                    'surname' => $request->surname,
                    'gender' => $request->gender,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'dob' => $request->dob,
                ]);
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create user: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with(['applicant', 'roles', 'institutes'])
            ->findOrFail($id);

        return Inertia::render('Admin/Users/ShowPage', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with(['applicant', 'roles', 'institutes'])
            ->findOrFail($id);

        $roles = Role::all();
        $institutes = \App\Models\Institute::all();

        return Inertia::render('Admin/Users/EditPage', [
            'user' => $user,
            'roles' => $roles,
            'institutes' => $institutes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,name'],
            'institute_id' => ['required_if:role,officer', 'exists:institutes,id'],
            // Student applicant fields
            'title' => ['required_if:role,student', 'string'],
            'firstnames' => ['required_if:role,student', 'string', 'max:255'],
            'surname' => ['required_if:role,student', 'string', 'max:255'],
            'gender' => ['required_if:role,student', 'string', 'in:MALE,FEMALE'],
            'phone' => ['required_if:role,student', 'digits:10', 'starts_with:07'],
            'address' => ['required_if:role,student', 'string'],
            'dob' => ['required_if:role,student', 'date', 'before_or_equal:31-12-2007'],
        ]);

        try {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            // Update role
            $user->syncRoles([$request->role]);

            // Handle institute relationship for officers
            $user->institutes()->detach(); // Remove all existing relationships
            if ($request->role === 'officer' && $request->institute_id) {
                $user->institutes()->attach($request->institute_id);
            }

            // Handle applicant profile for students
            if ($request->role === 'student') {
                if ($user->applicant) {
                    // Update existing applicant profile
                    $user->applicant->update([
                        'title' => $request->title,
                        'firstnames' => $request->firstnames,
                        'surname' => $request->surname,
                        'gender' => $request->gender,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'dob' => $request->dob,
                    ]);
                } else {
                    // Create new applicant profile
                    Applicant::create([
                        'user_id' => $user->id,
                        'title' => $request->title,
                        'firstnames' => $request->firstnames,
                        'surname' => $request->surname,
                        'gender' => $request->gender,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'dob' => $request->dob,
                    ]);
                }
            } else if ($user->applicant) {
                // Remove applicant profile if role changed from student to something else
                $user->applicant->delete();
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update user: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            // Don't allow deleting the current user
            if ($user->id === auth()->id()) {
                return back()->withErrors(['error' => 'You cannot delete your own account.']);
            }

            // Delete associated applicant profile if exists
            if ($user->applicant) {
                $user->applicant->delete();
            }

            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete user: ' . $e->getMessage()]);
        }
    }
}
