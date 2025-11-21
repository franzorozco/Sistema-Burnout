<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Redirect;
<<<<<<< HEAD

use App\Models\User;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
=======
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
>>>>>>> feature/Estadisticas

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
        $permissions = Permission::all();
        $users = User::all();
        $role = null;
        $rolePermissions = [];

        return view('admin.role.create', compact('permissions', 'users', 'role', 'rolePermissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        // Crear el rol
        $role = Role::create($request->validated());
        $role->created_by = $request->input('created_by', auth()->id()); 
        $role->save();

        // Sincronizar permisos: evita duplicados
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions); 
        }

        // Redireccionar para evitar re-envío de formulario al refrescar
        return Redirect::route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): View
    {
        return view('admin.role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        $permissions = Permission::all();
        $users = User::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.role.edit', compact('role', 'permissions', 'rolePermissions', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());

        // Sincronizar permisos sin duplicados
        $role->syncPermissions($request->permissions ?? []);

        return Redirect::route('admin.roles.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

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
