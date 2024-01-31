<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::all();
        $user = User::find(auth()->user()->id);
        $userpermission = $user->getPermissionsViaRoles();
        return Inertia::render('Roles/Index', ['roles' => $role, 'userpermission' => $userpermission]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Roles/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150'
        ]);

        $role =  Role::create(['name' => $request->name]);
        return redirect('roles');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);
        $rolePermission = $role->permissions;
        $permission = Permission::all();
        return Inertia::render('Roles/RolePermission', ['role' => $role, 'permission' => $permission, 'rolpermi' => $rolePermission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $permisosData = $request->permi;

        // Convertir los datos en instancias de la clase Permission
        $permisos = collect($permisosData)->map(function ($permisoData) {
            return new Permission($permisoData);
        });

        $permisosSeleccionados = $permisos->filter(function ($permiso) {
            return $permiso->selected === true;
        });

        // Obtener los IDs de los permisos seleccionados
        $permisosIds = $permisosSeleccionados->pluck('id')->toArray();

        //dd($permisosIds);
        $role->permissions()->sync($permisosIds);
        return redirect()->route('roles.edit', $role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        redirect('roles');
    }
}
