<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{

    public static function middleware() : array {
        return [
            new Middleware('permission:view users', only: ['index']),
            new Middleware('permission:create users', only: ['create']),
            new Middleware('permission:edit users', only: ['edit']),
            new Middleware('permission:delete users', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
    */
    public function index()
    {
       $data['users'] = User::orderby('created_at','ASC')->paginate(10);
        return view('users.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['subTitle'] = 'Create';
        return view('users.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['user'] = User::findorFail($id);
        $data['subTitle'] = 'Edit';
        $data['hasRoles'] = $data['user']->roles->pluck('id');
        $data['roles'] = Role::orderby('created_at','ASC')->get();
        return view('users.create',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$id.',id',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);
       
        if (!empty($request->roles)) {
            $user->syncRoles($request->roles);
        }else{
            $user->syncRoles([]);
        }
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
