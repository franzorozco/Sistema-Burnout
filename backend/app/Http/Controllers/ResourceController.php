<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ResourceRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $resources = Resource::paginate();

        return view('resource.index', compact('resources'))
            ->with('i', ($request->input('page', 1) - 1) * $resources->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $resource = new Resource();

        return view('resource.create', compact('resource'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResourceRequest $request): RedirectResponse
    {
        Resource::create($request->validated());

        return Redirect::route('resources.index')
            ->with('success', 'Resource created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $resource = Resource::find($id);

        return view('resource.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $resource = Resource::find($id);

        return view('resource.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResourceRequest $request, Resource $resource): RedirectResponse
    {
        $resource->update($request->validated());

        return Redirect::route('resources.index')
            ->with('success', 'Resource updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Resource::find($id)->delete();

        return Redirect::route('resources.index')
            ->with('success', 'Resource deleted successfully');
    }
}
