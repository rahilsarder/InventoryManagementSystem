<?php

namespace App\Http\Controllers\RolesNPermissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class RolesController extends Controller
{


    public function index()
    {
        return Role::all();
    }

    public function store(Request $request)
    {
        return Role::create(['name' => $request->name]);
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
}
