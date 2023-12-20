<?php

namespace App\Http\Controllers\Web\Category;

use App\Models\Category;
use App\Models\Partition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\AuthorizeCheck;

class CategoryController extends Controller
{
    use AuthorizeCheck;

    //Function To Show All Categories
    public function index()
    {
        $categories = Category::get();
        $partitions = Partition::get();
        return view('welcome',[
            'categories' =>$categories ,
            'partitions' =>$partitions
        ]);
    } //End Method

    //Function To Show Each Category

    public function show ($id)
    {
        $cat= Category::find($id);
        return view('Category.show',compact('cat'));
    } //End Method

    //Function To View Create Category Form
    public function create ()
    {
        $this->authorizCheck('create-categories');
        return view ('category.create');
    } //End Method

    //Function To Create New Category
    public function store (Request $request)
    {
        $this->authorizCheck('create-categories');
        // valdation
        $request->validate([
            'name' => 'required|string|max:100',
        ]);
        Category::create([
            'name' => $request->name
        ]);
        return redirect(route('welcome')) ;
    } //End Method

    //Function To View Edit Category Form
    public function edit ($id)
    {
        $this->authorizCheck('edit-categories');
        $cat = Category::findOrFail($id);
        return view('category.edit',compact('cat'));
    } //End Method

    //Function To update a Category
    public function update (Request $request, $id)
    {
        $this->authorizCheck('edit-categories');
        //validation
        $request->validate([
            'name' => 'required|string|max:100'
        ]);
        $cat = Category::findOrFail($id) ;
        $cat->update([
            'name' => $request->name,
        ]);
        return redirect(route('welcome'));
    } //End Method

    //Function To Delete a Category
      public function delete ($id)
      {
        $this->authorizCheck('delete-categories');
        $cat = Category::findOrFail($id);
        $cat->delete();
        return redirect(route('welcome'));
      } //End Method
}
