<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;

use App\Http\Requests;

class PermissionsController extends Controller
{
    public function index(Request $request)
    {
        if($request->user()->cannot("showRoles")) abort(403, "Request is not authorized");

        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    public function create(Request $request)
    {
        if($request->user()->cannot("createPermission")) abort(403, "Request is not authorized");

        return view('permissions.create');
    }
    public function edit(Request $request, $permissionId)
    {
        if($request->user()->cannot("editPermission")) abort(403, "Request is not authorized");

        $permission = Permission::findOrFail($permissionId);
        return view('permissions.edit', compact('permission'));
    }
    public function update(Request $request, $permissionId)
    {
        if($request->user()->cannot("editPermission")) abort(403, "Request is not authorized");

        $rules = [
            'label'=>'required',
            'code'=>'required|alpha_dash|unique:permissions,code,'.$permissionId,
        ];
        $this->validate($request, $rules);

        $permission = Permission::findOrFail($permissionId);

        $permission->update($request->all());

        return redirect('/permissions')->withMessage('Permission Update Successfully!');
    }
    public function store(Request $request)
    {
        if($request->user()->cannot("createPermission")) abort(403, "Request is not authorized");

        $rules = [
            'label'=>'required',
            'code'=>'required|alpha_dash|unique:permissions,code',
        ];
        $this->validate($request, $rules);

        Permission::create($request->all());

        return redirect()->route("admin.permissions.index")->withMessage('Permission Created Successfully!');

    }
    public function delete(Request $request, $permissionId)
    {
        if($request->user()->cannot("deletePermission")) abort(403, "Request is not authorized");

        $permission = Permission::findOrFail($permissionId);

        $permission->delete();

        return redirect('/permissions')->withMessage('Permission Delete Successfully!');
    }
}
