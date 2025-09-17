<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StudentProfileRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class StudentProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $studentProfiles = StudentProfile::paginate();

        return view('student-profile.index', compact('studentProfiles'))
            ->with('i', ($request->input('page', 1) - 1) * $studentProfiles->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $studentProfile = new StudentProfile();

        return view('student-profile.create', compact('studentProfile'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentProfileRequest $request): RedirectResponse
    {
        StudentProfile::create($request->validated());

        return Redirect::route('student-profiles.index')
            ->with('success', 'StudentProfile created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $studentProfile = StudentProfile::find($id);

        return view('student-profile.show', compact('studentProfile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $studentProfile = StudentProfile::find($id);

        return view('student-profile.edit', compact('studentProfile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentProfileRequest $request, StudentProfile $studentProfile): RedirectResponse
    {
        $studentProfile->update($request->validated());

        return Redirect::route('student-profiles.index')
            ->with('success', 'StudentProfile updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        StudentProfile::find($id)->delete();

        return Redirect::route('student-profiles.index')
            ->with('success', 'StudentProfile deleted successfully');
    }
}
