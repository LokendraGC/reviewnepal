<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create_permission', ['only' => ['create','store']] );
        $this->middleware('permission:read_permission', ['only' => ['index']] );
        $this->middleware('permission:update_permission', ['only' => ['update','edit']] );
        $this->middleware('permission:delete_permission', ['only' => 'destroy']);
    }

    public function index()
    {
        $permissions = Permission::get();

        return view('backend.roles-permissions.index-permission', [
            'permissions' => $permissions,
        ]);
    }

    public function create()
    {
        return view('backend.roles-permissions.create-permission');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name'
            ]
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('backend.permission')->with('success', 'Permission Created.');
    }

    public function edit(Permission $id)
    {
        $permission = $id;

        return view('backend.roles-permissions.edit-permission', [
            'permission' => $permission,
        ]);
    }

    public function update(Request $request, Permission $id)
    {
        $permission = $id;

        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name,'.$permission->id
            ]
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('backend.permission')->with('success', 'Permission Updated.');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('backend.permission')->with('success', 'Permission Deleted.');
    }
}
