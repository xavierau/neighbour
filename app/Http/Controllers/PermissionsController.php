<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PermissionsController extends Controller
{
    public function index(Request $request) {
        $this->authorize('show', new Permission());

        $permissions = Cache::tags(['permission'])->rememberForever('permissions', function () {
            return Permission::all();
        });

        return view('permissions.index', compact('permissions'));
    }

    public function create(Request $request) {

        // This will always false
        $this->authorize('create');

        return view('permissions.create');
    }

    public function edit(Request $request, $permissionId) {
        $this->authorize('edit', new Permission());

        $permission = Permission::findOrFail($permissionId);

        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, $permissionId) {
        $this->authorize('edit', new Permission());

        $rules = [
            'label' => 'required'
        ];
        $this->validate($request, $rules);

        $permission = Permission::findOrFail($permissionId);

        $permission->update($request->all());

        return redirect('/admin/permissions')->withMessage('Permission Update Successfully!');
    }

    public function store(Request $request) {
        // This will always false
        $this->authorize('create');

        $rules = [
            'label' => 'required',
            'code'  => 'required|alpha_dash|unique:permissions,code',
        ];
        $this->validate($request, $rules);

        Permission::create($request->all());

        return redirect()->route("admin.permissions.index")->withMessage('Permission Created Successfully!');

    }

    public function delete(Request $request, $permissionId) {

        // This will always false
        $this->authorize('delete');

        $permission = Permission::findOrFail($permissionId);

        $permission->delete();

        return redirect('/permissions')->withMessage('Permission Delete Successfully!');
    }
}
