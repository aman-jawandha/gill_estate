<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::where('name','!=','admin')->where('name','!=','seller')->where('name','!=','buyer')->get();
        return view('admin.roles.index',compact('roles'));
    }

    public function create(){
        $permissions = Permission::get();
        return view('admin.roles.create',compact('permissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'name' => 'required|unique:roles,name',
        'permissions' => 'required|array',
        ]);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            return redirect()->back()->withInput()->with('error', $firstError);
        }

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request)
    {
        $role = Role::findOrFail($request->role_id);
        $validator = Validator::make($request->all(), [
        'name' => 'required|unique:roles,name,' . $role->id,
        'permissions' => 'required|array',
        ]);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            return redirect()->back()->withInput()->with('error', $firstError);
        }

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles')->with('success', 'Role updated successfully.');
    }
}
