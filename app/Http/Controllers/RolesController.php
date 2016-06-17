<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact("roles"));
    }

    public function create()
    {
        return view('roles.create');
    }
    public function show()
    {

    }

    public function store(Request $request)
    {
        Role::create($request->all());

        return redirect()->route('admin.roles.index')->withMessage('Successfully Create');

    }

    public function update()
    {
        
    }

    public function edit()
    {
        
    }

    public function destroy()
    {

    }
}
