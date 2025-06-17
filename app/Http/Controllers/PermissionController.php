<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware() : array {
        return [
            new Middleware('permission:view permissions', only: ['index']),
            new Middleware('permission:create permissions', only: ['create']),
            new Middleware('permission:edit permissions', only: ['edit']),
            new Middleware('permission:delete permissions', only: ['destroy'])
        ];
    }

    // show permission page
    public function index() {
        $data['permissions'] = Permission::orderby('created_at','DESC')->paginate(10);
        return view('permissions.list',$data);
        
    }

    // show create permission page
    public function create() {
        $data['subTitle'] = 'Create';
        return view('permissions.create',$data);
    }

    //  store permission on DB
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|unique:permissions|min:3'
        ]);
        Permission::create($validated);
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully!');
    }

    //  edit permission 
    public function edit($id) {
        $data['permission'] = Permission::findorFail($id);
        $data['subTitle'] = 'Edit';
        return view('permissions.create',$data);
    }

    //  update permission on DB
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|unique:permissions,name,' . $id
        ]);
        $permission = Permission::findOrFail($id);
        $permission->name = $validated['name'];
        $permission->save();
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    //  delete permission on DB
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return response()->json([
            'status' => true,
            'message' => 'Permission deleted successfully'
        ]);
    }

}
