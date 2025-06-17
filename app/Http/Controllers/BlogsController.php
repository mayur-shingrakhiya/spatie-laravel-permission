<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BlogsController extends Controller implements HasMiddleware
{

    public static function middleware() : array {
        return [
            new Middleware('permission:view blogs', only : ['index']),
            new Middleware('permission:create blogs', only : ['create']),
            new Middleware('permission:edit blogs', only : ['edit']),
            new Middleware('permission:delete blogs', only : ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['blogs'] = Blogs::orderby('created_at','DESC')->paginate(25);
        return view('blogs.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['subTitle'] = 'Create';
        // $data['permissions'] = Permission::orderby('created_at','ASC')->get();
        return view('blogs.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:5',
            'text' => 'nullable',
            'author' => 'required|min:5',
        ]);
        Blogs::create($validated);
        return redirect()->route('blogs.index')->with('success', 'Blog created successfully!');
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
        $data['blog'] = Blogs::findorFail($id);
        $data['subTitle'] = 'Edit';
        return view('blogs.create',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|min:5',
            'text' => 'nullable',
            'author' => 'required|min:5',
        ]);

        Blogs::findOrFail($id)->update($validated);

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request , $id)
    {
        $article = Blogs::findOrFail($id);
        $article->delete();
        return response()->json([
            'status' => true,
            'message' => 'Blog deleted successfully'
        ]);
    }
}
