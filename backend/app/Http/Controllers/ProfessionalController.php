<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProfessionalRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $professionals = Professional::paginate();

        return view('admin.professional.index', compact('professionals'))
            ->with('i', ($request->input('page', 1) - 1) * $professionals->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $professional = new Professional();

        return view('admin.professional.create', compact('professional'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfessionalRequest $request): RedirectResponse
    {
        Professional::create($request->validated());

        return Redirect::route('admin.professionals.index')
            ->with('success', 'Professional created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $professional = Professional::find($id);

        return view('admin.professional.show', compact('professional'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $professional = Professional::find($id);

        return view('admin.professional.edit', compact('professional'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfessionalRequest $request, Professional $professional): RedirectResponse
    {
        $professional->update($request->validated());

        return Redirect::route('admin.professionals.index')
            ->with('success', 'Professional updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Professional::find($id)->delete();

        return Redirect::route('admin.professionals.index')
            ->with('success', 'Professional deleted successfully');
    }
}
