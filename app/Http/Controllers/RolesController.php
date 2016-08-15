<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        if($request->user()->cannot("showRoles")) abort(403, "Request is not authorized");
        $roles = Role::all();
        return view('roles.index', compact("roles"));
    }

    public function create(Request $request)
    {
        if($request->user()->cannot("createRole")) abort(403, "Request is not authorized");

        $permissions = Permission::select("label","id")->get();
        return view('roles.create', compact("permissions"));
    }
    public function show(Request $request)
    {


    }

    public function store(Request $request)
    {
        if($request->user()->cannot("createRole")) abort(403, "Request is not authorized");

        $role = Role::create($request->all());

        $role->permissions()->sync($request->get("permissions"));

        return redirect()->route('admin.roles.index')->withMessage('Successfully Create');

    }

    public function update(Request $request, $id)
    {
        if($request->user()->cannot("editRole")) abort(403, "Request is not authorized");
        $role = Role::find($id);
        $role->label = $request->get("label");
        $role->permissions()->sync($request->get("permissions"));
        $role->save();
        return redirect()->route('admin.roles.index')->withMessage('Successfully Update');
    }

    public function edit(Request $request, $id)
    {
        if($request->user()->cannot("editRole")) abort(403, "Request is not authorized");

        $role = Role::find($id);
        $permissions = Permission::select("label","id")->get();
        return view("roles.edit")->with(compact("role", "permissions"));
    }

    public function destroy(Request $request, $id)
    {
        if($request->user()->cannot("editRole")) abort(403, "Request is not authorized");

        $role = Role::find($id);
        $role->delete();
        return redirect()->route('admin.roles.index')->withMessage('Successfully Delete');
    }
}
