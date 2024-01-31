<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => User::paginate()
        ]);
    }

    public function edit(string $id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $userrole = $user->roles;
        $userrole;
        return Inertia::render('Users/UserRole', ['user' => $user, 'role' => $roles, 'userrole' => $userrole]);
    }

    public function update(Request $request, User $user)
    {
        $rolesData = $request->role;

        // Convertir los datos en instancias de la clase Permission
        $roles = collect($rolesData)->map(function ($roleData) {
            return new Role($roleData);
        });

        $rolesSeleccionados = $roles->filter(function ($role) {
            return $role->selected === true;
        });

        // Obtener los IDs de los permisos seleccionados
        $rolesIds = $rolesSeleccionados->pluck('id')->toArray();

        //dd($rolesIds);
        $user->roles()->sync($rolesIds);
        return redirect()->route('users.edit', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('users');
    }
}
