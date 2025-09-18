<?php

namespace App\Http\Controllers;

use App\Models\Rotation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RotationRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class RotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $rotations = Rotation::paginate();

        return view('admin.rotation.index', compact('rotations'))
            ->with('i', ($request->input('page', 1) - 1) * $rotations->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $rotation = new Rotation();

        return view('admin.rotation.create', compact('rotation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RotationRequest $request): RedirectResponse
    {
        Rotation::create($request->validated());

        return Redirect::route('admin.rotations.index')
            ->with('success', 'Rotation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $rotation = Rotation::find($id);

        return view('admin.rotation.show', compact('rotation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $rotation = Rotation::find($id);

        return view('admin.rotation.edit', compact('rotation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RotationRequest $request, Rotation $rotation): RedirectResponse
    {
        $rotation->update($request->validated());

        return Redirect::route('admin.rotations.index')
            ->with('success', 'Rotation updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Rotation::find($id)->delete();

        return Redirect::route('admin.rotations.index')
            ->with('success', 'Rotation deleted successfully');
    }
}
