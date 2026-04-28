<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create_role', ['only' => ['create','store', 'givePermissionToRole', 'addPermissionToRole']] );
        $this->middleware('permission:read_role', ['only' => ['index']] );
        $this->middleware('permission:update_role', ['only' => ['update','edit']] );
        $this->middleware('permission:delete_role', ['only' => 'destroy']);
    }

    public function index()
    {
        $roles = Role::get();

        return view('backend.roles-permissions.index-role', [
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        return view('backend.roles-permissions.create-role');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name'
            ]
        ]);

        Role::create(['name' => $request->name]);

        return redirect()->route('backend.role')->with('status', 'Role Created.');
    }

    public function edit(Role $id)
    {
        $role = $id;

        return view('backend.roles-permissions.edit-role', [
            'role' => $role,
        ]);
    }

    public function update(Request $request, Role $id)
    {
        $role = $id;

        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('roles')->ignore($role->id), // Ignore the current role's name
            ],
        ]);

        // Attempt to update the role
        try {
            $role->update(['name' => $request->name]);
            return redirect()->route('backend.role')->with('success', 'Role Updated.');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to update role: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('backend.role')->with('success', 'Role Deleted.');
    }

    public function addPermissionToRole($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::get();

        $rolePermissions = DB::table('role_has_permissions')
        ->where('role_has_permissions.role_id', $role->id)
        ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
        ->all();

        return view('backend.roles-permissions.add-permission', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    public function givePermissionToRole(Request $request, $id)
    {
        // $request->validate([
        //     'permission' => 'required',
        // ]);

        $role = Role::findOrFail($id);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('success', 'Permission Added to Role');

    }
}
