<?php

namespace App\Http\Controllers\Api\Item;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Traits\AuthorizeCheck;


class ItemController extends Controller
{
    use AuthorizeCheck;

    //Function To Show All Items
    public function index()
    {
        $items = Item::get();
        return response()->json($items);
    }//End Method

    //Function To Show Each Item
    public function show($id)
    {
        $item = Item::findOrFail($id);
        return response()->json($item);
    }//End Method

    //Function To Create New Item
    public function store(Request $request)
    {
        $this->authorizCheck('create-items');

        // validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'partition_id' => 'required|exists:partitions,id',
            'img' => 'required|image|mimes:jpg,png',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors);
        }
        // move
        $img = $request->file('img');
        $ext = $img->getClientOriginalExtension();
        $name = "items-" . uniqid() . ".$ext";
        $img->move(public_path('uploads/items'), $name);

        Item::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'img' => $name,
            'partition_id' => $request->partition_id,
        ]);

        $success= 'The Item is Created sucssefully' ;
        return response()->json($success);
    }//End Method

    //Function To update Item
    public function update(Request $request, $id)
    {
        $this->authorizCheck('edit-items');
        // validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'partition_id' => 'required|exists:partitions,id',
            'img' => 'nullable|image|mimes:jpg,png',

        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors);
        }
        $item = Item::findOrFail($id);
        $name = $item->img;

        if ($request->hasFile('img')) {
            if ($name !== null) {
                unlink(public_path('uploads/items/') . $name);
            }

            $img = $request->file('img');
            $ext = $img->getClientOriginalExtension();
            $name = "items-" . uniqid() . ".$ext";
            $img->move(public_path('uploads/items/'), $name);
        }

        $item->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'img' => $name,
            'partition_id' => $request->partition_id,
        ]);

        $success= 'The Item is Updated sucssefully' ;
        return response()->json($success);
    }//End Method


    //Function To Delete Item
    public function delete($id)
    {
        $this->authorizCheck('delete-items');
        $item = Item::findOrFail($id);

        if ($item->img !== null) {
            unlink(public_path('uploads/items/') . $item->img);
        }

        $item->delete();

        $success= 'The Item is Deleated sucssefully' ;
        return response()->json($success);
    }
}//End Method
