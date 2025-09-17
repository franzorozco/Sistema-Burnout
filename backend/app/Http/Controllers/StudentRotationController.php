<?php

namespace App\Http\Controllers;

use App\Models\StudentRotation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StudentRotationRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class StudentRotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $studentRotations = StudentRotation::paginate();

        return view('student-rotation.index', compact('studentRotations'))
            ->with('i', ($request->input('page', 1) - 1) * $studentRotations->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $studentRotation = new StudentRotation();

        return view('student-rotation.create', compact('studentRotation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRotationRequest $request): RedirectResponse
    {
        StudentRotation::create($request->validated());

        return Redirect::route('student-rotations.index')
            ->with('success', 'StudentRotation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $studentRotation = StudentRotation::find($id);

        return view('student-rotation.show', compact('studentRotation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $studentRotation = StudentRotation::find($id);

        return view('student-rotation.edit', compact('studentRotation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRotationRequest $request, StudentRotation $studentRotation): RedirectResponse
    {
        $studentRotation->update($request->validated());

        return Redirect::route('student-rotations.index')
            ->with('success', 'StudentRotation updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        StudentRotation::find($id)->delete();

        return Redirect::route('student-rotations.index')
            ->with('success', 'StudentRotation deleted successfully');
    }
}
