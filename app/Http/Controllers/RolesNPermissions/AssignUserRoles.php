<?php

namespace App\Http\Controllers\RolesNPermissions;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permissions;


class AssignUserRoles extends Controller
{
    public function index()
    {
        return User::getAllPermissions();
    }

    public function store(Request $request)
    {
        $request->validate(['role' => 'required|string', 'user' => 'required|int']);
        $user = User::find($request->user);
        $role = Role::find($request->role);
        return $this->assignUserToRole($user, $role);
    }

    public function show($id)
    {
    }

    public function update($id, Request $request)
    {
    }

    public function destroy($id)
    {
    }

    public static function assignUserToRole(User $user, Role $role)
    {
        return $user->assignRole($role);
    }
}
