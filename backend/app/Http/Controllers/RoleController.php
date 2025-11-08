<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Redirect;

use App\Models\User;
use App\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $roles = Role::paginate();

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
}
