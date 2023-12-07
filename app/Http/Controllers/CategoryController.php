<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Partition;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //Function To Show All Categories
    public function index()
    {
        $categories = Category::get();
        $partitions = Partition::get();
        return view('welcome',[
            'categories' =>$categories ,
            'partitions' =>$partitions
        ]);
    }

    //Function To Show Each Category

    public function show ($id)
    {
        $cat= Category::find($id);
        return view('Category.show',compact('cat'));
    }

    //Function To View Create Category Form
    public function create ()
    {
        return view ('category.create');
    }

    //Function To Create New Category
    public function store (Request $request)
    {
        // valdation
        $request->validate([
            'name' => 'required|string|max:100',
        ]);
        Category::create([
            'name' => $request->name
        ]);
        return redirect(route('welcome')) ;
    }

    //Function To View Edit Category Form
    public function edit ($id)
    {
        $cat = Category::findOrFail($id);
        return view('category.edit',compact('cat'));
    }
    //Function To update a Category
    public function update (Request $request, $id)
    {
        //validation
        $request->validate([
            'name' => 'required|string|max:100'
        ]);
        $cat = Category::findOrFail($id) ;
        $cat->update([
            'name' => $request->name,
        ]);
        return redirect(route('welcome'));
    }

    //Function To Delete a Category
      public function delete ($id)
      {
        $cat = Category::findOrFail($id);
        $cat->delete();
        return redirect(route('welcome'));
      }
}
