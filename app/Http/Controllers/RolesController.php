<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RolesController extends Controller implements HasMiddleware 
{

    public static function middleware() : array {
        return [
            new Middleware('permission:view roles', only: ['index']),
            new Middleware('permission:create roles', only: ['create']),
            new Middleware('permission:edit roles', only: ['edit']),
            new Middleware('permission:delete roles', only: ['destroy']),
        ];
    }
   
    // show role page
    public function index() {
        $data['roles'] = Role::orderby('created_at','ASC')->paginate(10);
        return view('roles.list',$data);
        
    }


    // show create role page
    public function create() {
        $data['subTitle'] = 'Create';
        $data['permissions'] = Permission::orderby('created_at','ASC')->get();
        return view('roles.create',$data);
    }

    //  store role on DB
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|unique:roles|min:3',
        ]);
        $role = Role::create($validated);
        if (!empty($request->permissions)) {
            foreach ($request->permissions as $value) {
                $role->givePermissionTo($value);
            }
        }
        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }


    //  edit role 
    public function edit($id) {
        $data['role'] = Role::findorFail($id);
        $data['subTitle'] = 'Edit';
        $data['permissions'] = Permission::orderby('created_at','ASC')->get();
        return view('roles.create',$data);
    }

    //  update role on DB
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|unique:roles,name,' . $id
        ]);
        $role = Role::findOrFail($id);
        $role->name = $validated['name'];
        $role->save();
       
        if (!empty($request->permissions)) {
            $role->syncPermissions($request->permissions);
        }else{
            $role->syncPermissions([]);
        }
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }


    //  delete role on DB
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json([
            'status' => true,
            'message' => 'role deleted successfully'
        ]);
    }
}
