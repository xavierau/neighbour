<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RolesController extends Controller
{
    public function index(Request $request) {
        $this->authorize('show', new Role());
        $roles = Cache::tags(['role'])->rememberForever('roles',  function () {
            return Role::all();
        });

        return view('roles.index', compact("roles"));
    }

    public function create(Request $request) {
        $this->authorize('create', new Role());

        $permissions = Permission::select("label", "id")->get();

        return view('roles.create', compact("permissions"));
    }

    public function show(Request $request) {

    }

    public function store(Request $request) {
        $this->authorize('create', new Role());

        $role = Role::create($request->all());

        $role->permissions()->sync($request->get("permissions"));

        return redirect()->route('admin.roles.index')->withMessage('Successfully Create');

    }

    public function update(Request $request, $id) {
        $this->authorize('edit', new Role());

        $role = Role::find($id);
        $role->label = $request->get("label");
        $role->permissions()->sync($request->get("permissions"));
        $role->save();

        return redirect()->route('admin.roles.index')->withMessage('Successfully Update');
    }

    public function edit(Request $request, $id) {
        $this->authorize('edit', new Role());

        $role = Role::find($id);
        $permissions = Permission::select("label", "id")->get();

        return view("roles.edit")->with(compact("role", "permissions"));
    }

    public function destroy(Request $request, $id) {
        $this->authorize('delete', new Role());

        $role = Role::find($id);
        $role->delete();

        return redirect()->route('admin.roles.index')->withMessage('Successfully Delete');
    }
}
