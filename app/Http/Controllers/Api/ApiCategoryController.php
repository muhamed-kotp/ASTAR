<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Partition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiCategoryController extends Controller
{
    //Function To Show All Categories
    public function index()
    {
        $categories = Category::get();
        $partitions = Partition::get();
        return response()->json([
            'categories' =>$categories ,
            'partitions' =>$partitions
        ]);
    }

    //Function To Show Each Category

    public function show ($id)
    {
        $cat= Category::with('partitions')->findOrFail($id);
        return response()->json($cat);
    }


    //Function To Create New Category
    public function store (Request $request)
    {
        // valdation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors);
        }
        Category::create([
            'name' => $request->name
        ]);
        $success= 'The Category is Created sucssefully' ;
        return response()->json($success);
    }

    //Function To update a Category
    public function update (Request $request, $id)
    {
        //validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors);
        }
        $cat = Category::findOrFail($id) ;
        $cat->update([
            'name' => $request->name,
        ]);
        $success= 'The Category is Updated sucssefully' ;
        return response()->json($success);
    }

    //Function To Delete a Category
      public function delete ($id)
      {
        $cat = Category::findOrFail($id);
        $cat->delete();
        $success= 'The Category is Deleated sucssefully' ;
        return response()->json($success);
      }
}