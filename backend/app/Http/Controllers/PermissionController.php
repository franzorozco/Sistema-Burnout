<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PermissionRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $permissions = $this->buildQuery($request)->paginate(15);

        return view('admin.permission.index', compact('permissions'))
            ->with('i', ($request->input('page', 1) - 1) * $permissions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permission = new Permission();

        return view('admin.permission.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request): RedirectResponse
    {
        Permission::create($request->validated());

        return Redirect::route('admin.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $permission = Permission::find($id);

        return view('admin.permission.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $permission = Permission::find($id);

        return view('admin.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, Permission $permission): RedirectResponse
    {
        $permission->update($request->validated());

        return Redirect::route('admin.permissions.index')
            ->with('success', 'Permission updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Permission::find($id)->delete();

        return Redirect::route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully');
    }

    protected function buildQuery(Request $request)
    {
        $query = Permission::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if ($request->filled('guard_name')) {
            $query->where('guard_name', 'like', '%'.$request->guard_name.'%');
        }

        return $query->orderByDesc('id');
    }

    public function exportPdf(Request $request)
    {
        $permissions = $this->buildQuery($request)->get();
        $filters = $request->only(['name','guard_name']);

        $pdf = Pdf::loadView('admin.permission.pdf', compact('permissions', 'filters'));

        return $pdf->download('permissions_report_'.now()->format('Ymd_His').'.pdf');
    }
}
