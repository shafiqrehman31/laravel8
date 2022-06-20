<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function allcategory()
    {
        #query Bulider 
        // $categories = DB::table('categories')
        //             ->join('users', 'categories.user_id','users.id')
        //             ->select('categories.*', 'users.name')
        //             ->latest()->paginate(5);
        #Eloquent Method
        $categories = Category::latest()->paginate(5);
        $trashCat = Category::onlyTrashed()->latest()->paginate(3);
        #QUERY BULIDER MATHOD
        //$categories = DB::table('categories')->latest()->paginate(5);
        return view('admin.category.index', compact('categories' , 'trashCat'));
    }
    #function for to add new category
    public function AddCategory(Request $request)
    {
        $validateddata = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ],
        [
            'category_name.required' => 'Please Put Category Name',
            'category_name.max' => 'Category Name Must be not incressed 255 char',
            'category_name.unique' => 'Category Name Must be Unique',
        ]);

        #Eloquent Method
        Category::insert([
            'category_name' => $request->category_name,
            'user_id'   =>  Auth::User()->id,
            'created_at'  => Carbon::now()
        ]);

        # Professional Mathod
        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();

        #QUERY BULIDER MATHOD
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);
        return Redirect()->back()->with('Success', 'Category Inserted Successfullly');

    }
    # Edit Function Where Select the The Spacic field
    public function EditCategory($id)
    {
        #Eloquent Method
        $categories = Category::find($id);

        # Professional Mathod
        //$categories = DB::table('categories')->where('id', $id)->first();
        return view('admin.category.edit', compact('categories'));
    }
    # Update Function Use for To Update Spacic ID
    public function UpdateCategory(Request $request, $id)
    {
        $validateddata = $request->validate([
            'category_name' => 'required|max:255',
        ],
        [
            'category_name.required' => 'Please Put Category Name',
            'category_name.max' => 'Category Name Must be not incressed 255 char',
        ]);
        #Eloquent Method
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id'   =>  Auth::user()->id
        ]);

        # Professional Mathod
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->where('id',$id)->update($data);
        return Redirect()->route('all.category')->with('Success', 'Category Update Successfullly');
    }

    # Trash Function To delete Record and move to Trash
    public function TrashCategory($id)
    {
        $delete = Category::find($id)->delete();
        return Redirect()->back()->with('Success', 'Category Move Trash Successfullly');
    }

    # Restore Function To delete Record and move to Trash
    public function RestoreCategory($id)
    {
        $delete = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('Success', 'Category Restorer Successfullly');
    }
    # Parmannently Deleted Function To delete Record and move to Trash
    public function DeleteCategory($id)
    {
        $delete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('Success', 'Category Parmannently Deleted Successfullly');
    }
    
}
