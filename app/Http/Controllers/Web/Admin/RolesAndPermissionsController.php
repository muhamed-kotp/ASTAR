<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\Roles\RoleStoreRequest;
use App\Http\Requests\Admin\Roles\RoleUpdateRequest;
use App\Traits\AuthorizeCheck;

class RolesAndPermissionsController extends Controller
{
    use AuthorizeCheck;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorizCheck('view-settings');
        $roles = Role::all();
        return view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizCheck('create-settings');
        $permissions = Permission::all();
        return view('roles.create',compact('permissions'));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        $data = $request->validated();
            Role::create([
            'name'=>$request->role,
            'guard_name'=>'web'
            ])->givePermissionTo($request->permissions);
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
            return redirect()->route('role-permission.index')->with('success', 'Role created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorizCheck('view-settings');
        $role = Role::findOrFail($id);
        $permissions = $role->permissions;
        return view('roles.show',compact('role','permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorizCheck('edit-settings');
        $role = Role::findOrFail($id);
        $permissionsPerRole = $role->permissions->toArray();
        $permissions = Permission::all();
        return view('roles.edit',compact('role','permissions','permissionsPerRole'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, string $id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->permissions;
        $role->revokePermissionTo($permissions);
        $role->givePermissionTo($request->permissions);
        $role->update([
            'name' => $request->role
        ]);
        $role = $role->refresh();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        return redirect()->route('role-permission.index')->with('success', 'Role Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $this->authorizCheck('delete-settings');
        $role = Role::findOrFail($id);
        $permissions = $role->permissions;
        $role->revokePermissionTo($permissions);
        $role->delete();
        return redirect()->route('role-permission.index')->with('success', 'Role deleted successfully');

    }
}
