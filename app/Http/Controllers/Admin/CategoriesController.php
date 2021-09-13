<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::when($request->name, function($query, $value){
            $query->where(function($query) use ($value){
                $query->where('name', 'LIKE', '%{$value}%')
                ->orWhere('description', 'LIKE', '%{$value}%');
            });
        })
        ->when($request->parent_id, function($query, $value){
            $query->where('parent_id', 'LIKE', $value);
        })
        // الي تحت حتى لا يظهر في الجدول id يظهر اسم ال category
        ->leftjoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
        ->select([
            'categories.*',
            'parents.name as parent_name',
        ])
        ->get();

        // $query = Category::query();
        // if ($request->name){
        //     $query->where(function($query) use ($request){
        //         $query->where('name', 'LIKE', '%{$request->name}%')
        //         ->orWhere('description', 'LIKE', '%{$request->description}%');
        //     });
        // }
        // if ($request->parent_id){
        //     $query->where('parent_id', 'LIKE', $request->parent_id);
        // }
        // $categories = $query->get();

        $parents = Category::orderBy('name', 'asc')->get();

        return view('admin.categories.index',[
            'categories' => $categories,
            'parents' => $parents,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Category::orderBy('name', 'asc')->get();

//        return view('admin.categories.create')->with('parents', $parents);
         return view('admin.categories.create', [
             'parents' => $parents,
             'category' => new Category(),
         ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();

        // $category->name = $request->name;
        $category->name = $request->get('name');
        $category->slug = Str::slug($request->name);
        $category->description = $request->input('description');
        $category->parent_id = $request->post('parent_id');
        $category->status = $request->post('status');

        $category->save();

        return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*
        $category = Category::findOrFail($id);

        return view('admin.categories.show', [
            'category' => $category,
        ]);
        */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $category = Category::where('id', '=', $id)->first();
        
        $category = Category::findOrFail($id);

        // if($category == null){
        //     abort(404);
        // }

        $parents = Category::where('id', '<>', $id)
        ->orderBy('name', 'asc')->get();
        
        return view('admin.categories.edit', [
            'id' => $id,
            'category' => $category,
            'parents' => $parents,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->input('description');
        $category->parent_id = $request->post('parent_id');
        $category->status = $request->post('status');

        $category->save();

        return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Method 1
        // $category = Category::findOrFail($id);
        // $category->delete();

        // Method 2
        // $category = Category::where('id', '=', $id)->delete();

        // Method 3 
        Category::destroy($id);

        return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category deleted.');
    }
}
