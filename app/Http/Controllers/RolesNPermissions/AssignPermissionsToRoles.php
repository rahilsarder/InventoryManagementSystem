<?php

namespace App\Http\Controllers\RolesNPermissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class AssignPermissionsToRoles extends Controller
{
    public function index()
    {
    }

    public function store(Request $request)
    {
        $role = Role::find($request->role);
        $permission = Permission::find($request->permission);
        return $this->assignPermissionToRole($role, $permission);
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

    public static function assignPermissionToRole(Role $role, Permission $permmission)
    {
        return $role->givePermissionTo($permmission);
    }
    public static function assignRoleToPermission(Permission $permmission, Role $role)
    {
        return $role->givePermissionTo($permmission);
    }
}
