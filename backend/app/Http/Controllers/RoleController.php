<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $roles = $this->buildQuery($request)->paginate(15);

        return view('admin.role.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * $roles->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $role = new Role();

        return view('admin.role.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        Role::create($request->validated());

        return Redirect::route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $role = Role::find($id);

        return view('admin.role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $role = Role::find($id);

        return view('admin.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());

        return Redirect::route('admin.roles.index')
            ->with('success', 'Role updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Role::find($id)->delete();

        return Redirect::route('admin.roles.index')
            ->with('success', 'Role deleted successfully');
    }

    protected function buildQuery(Request $request)
    {
        $query = Role::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if ($request->filled('guard_name')) {
            $query->where('guard_name', 'like', '%'.$request->guard_name.'%');
        }
        if ($request->filled('created_by')) {
            $query->where('created_by', $request->created_by);
        }

        return $query->orderByDesc('id');
    }

    public function exportPdf(Request $request)
    {
        $roles = $this->buildQuery($request)->get();
        $filters = $request->only(['name','guard_name','created_by']);

        $pdf = Pdf::loadView('admin.role.pdf', compact('roles', 'filters'));

        return $pdf->download('roles_report_'.now()->format('Ymd_His').'.pdf');
    }
}
