<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Rules\WordsFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

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
        /** Validation Start*/

        /* Method 1
        $this->validate($request,[
        'name' => 'required|alpha|max:255|min:2|unique:categories,name',
        'description' => 'nullable|min:5',
        'parent_id' => [
            'nullable',
            'exsists:categories,id'
        ],
        'image' => [
            'nullable',
            'image',
            'mimes:jpg,png,jpeg,gif,svg',
            'max:1048576',
            // 'dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
            'dimensions:min_width=100,min_height=100'
        ],
        'status' => 'required|in:active,inactive',
        ]);*/

        /* Method 2 
        $Validator = Validator::make($request->all(),[
            'name' => 'required|alpha|max:255|min:2|unique:categories,name',
            'description' => 'nullable|min:5',
            'parent_id' => [
                'nullable',
                'exsists:categories,id'
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,png,jpeg,gif,svg',
                'max:1048576',
                // 'dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
                'dimensions:min_width=100,min_height=100'
            ],

            'status' => 'required|in:active,inactive',
            
        ]);*/

        /* Method 3 
        $request->validate([
            'name' => 'required|alpha|max:255|min:2|unique:categories,name',
                'description' => 'nullable|min:5',
                'parent_id' => [
                    'nullable',
                    'exsists:categories,id'
                ],
                'image' => [
                    'nullable',
                    'image',
                    'mimes:jpg,png,jpeg,gif,svg',
                    'max:1048576',
                    // 'dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
                    'dimensions:min_width=100,min_height=100'
                ],

                'status' => 'required|in:active,inactive',
        ]); */

        // $Validator = Validator::make($request->all());
        // $Validator = Validator::make($request->post());
        // $Validator = Validator::make($request->only(['name', 'status']));
        // $Validator = Validator::make($request->except(['name', 'status']));

        //الدوال الي تحت بتنحط بعد قواعد الفالداشن
        // $fails = $Validator->fails(); اذا لم تنطبق شروط ال validator يعطيك true
        // $failed = $Validator->failed(); هنا يعطيك true في حال لم تنطبق شروط ال validator  ويعطيك اين الخطأ
        // $errors = $Validator->errors(); هنا اذا حدث خطأ يعطيك رسالة الخطأ والحقل الذي  حدث فيه الخطأ
        
        // $clean = $Validator->validated(); في حال تمت العملية
        // $clean = $Validator->validate();

        $this->checkRequest($request); //function خاصة بها تحت

        /** Validation End*/

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
        
        /* $category = Category::where('id', '=', $id)->first();
            if($category == null){
            abort(404);
        }*/

        $category = Category::findOrFail($id);

        

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
    public function update(CategoryRequest $request, $id)
    {
        //ملاحظة : هنا استخدمنا ال customRequest

        /*$request->validate([
            'name' => 'required|alpha|max:255|min:2|unique:categories,name',
                'description' => 'nullable|min:5',
                'parent_id' => [
                    'nullable',
                    'exsists:categories,id'
                ],
                'image' => [
                    'nullable',
                    'image',
                    'mimes:jpg,png,jpeg,gif,svg',
                    'max:1048576',
                    // 'dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
                    'dimensions:min_width=100,min_height=100'
                ],

                'status' => 'required|in:active,inactive',
        ]);*/

        /*  هنا استخدمنا validation عن طريق funtion 
        $this->checkRequest($request, $id);
        */

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
        /* Method 1
        $category = Category::findOrFail($id);
        $category->delete();*/

        /* Method 2
        $category = Category::where('id', '=', $id)->delete();*/

        // Method 3 
        Category::destroy($id);

        return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category deleted.');
    }

    protected function checkRequest(Request $request, $id= 0)
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                /* Method 1 
                    "unique:categories,name,$id", id حتى يتسثنيها في حالة التعديل
                */
                /* Method 2 
                (new Unique('categories', 'name'))->ignore($id),
                */
                /** Method 3 */
                Rule::unique('categories', 'name')->ignore($id),

            ],
            'description' => [
                'nullable', 
                'min:5', 
                /* Method 1
                function($attribute, $value, $fail){
                    if (stripos($value, 'laravel') !== false){
                        $fail('You can not use the word "laravel"!');
                    }
                }
                */
                /* Method 2
                 new WordsFilter(['php','laravel']) by Rule Class
                */
                /** Method 3 */
                'filter:laravel,php', //by AppServiceProvider
            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id'
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,png,jpeg,gif,svg',
                'max:1048576',
                // 'dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
                'dimensions:min_width=100,min_height=100'
            ],
            'status' => [
                'required',
                'in:active,inactive',
            ],
        ],[ // custom message
            'name.required' => 'هذا الحقل مطلوب :attribute',
        ]);
    }
}
