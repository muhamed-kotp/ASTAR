<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Partition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiItemController extends Controller
{
    //Function To Show All Items
    public function index()
    {
        $items = Item::get();

        return response()->json($items);
    }
    //Function To Show Each Item
    public function show($id)
    {
        $item = Item::findOrFail($id);

        return response()->json($item);
    }

    //Function To Create New Item
    public function store(Request $request)
    {
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
    }
    //Function To update Item
    public function update(Request $request, $id)
    {
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
    }
    //Function To Delete Item
    public function delete($id)
    {
        $item = Item::findOrFail($id);

        if ($item->img !== null) {
            unlink(public_path('uploads/items/') . $item->img);
        }

        $item->delete();

        $success= 'The Item is Deleated sucssefully' ;
        return response()->json($success);
    }
}