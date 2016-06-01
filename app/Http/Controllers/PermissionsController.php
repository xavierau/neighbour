<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;

use App\Http\Requests;

class PermissionsController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }
    public function edit($permissionId)
    {
        $permission = Permission::findOrFail($permissionId);
        return view('permissions.edit', compact('permission'));
    }
    public function update(Request $request, $permissionId)
    {
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
        $rules = [
            'label'=>'required',
            'code'=>'required|alpha_dash|unique:permissions,code',
        ];
        $this->validate($request, $rules);

        Permission::create($request->all());

        return redirect('/permissions')->withMessage('Permission Created Successfully!');

    }
    public function delete($permissionId)
    {
        $permission = Permission::findOrFail($permissionId);

        $permission->delete();

        return redirect('/permissions')->withMessage('Permission Delete Successfully!');
    }
}
