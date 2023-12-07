<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Partition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiPartitionController extends Controller
{

    //Function To Show All Partitions
    public function index()
    {
        $partitions = Partition::get();

        return response()->json($partitions);

    }
    //Function To Show Each Partition
    public function show($id)
    {
        $partition = Partition::with('items')->findOrFail($id);

        return response()->json($partition);

    }

    //Function To Create New Partition
    public function store(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'img' => 'required|image|mimes:jpg,png',
            'category_id' => 'required|exists:categories,id',

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors);
        }
        // move
        $img = $request->file('img');
        $ext = $img->getClientOriginalExtension();
        $name = "partition-" . uniqid() . ".$ext";
        $img->move(public_path('uploads/partitions'), $name);

        Partition::create([
            'title' => $request->title,
            'img' => $name,
            'category_id' => $request->category_id,
        ]);

        $success= 'The Partition is Created sucssefully' ;
        return response()->json($success);
    }
    //Function To update a Partition
    public function update(Request $request, $id)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'img' => 'nullable|image|mimes:jpg,png',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors);
        }

        $partition = Partition::findOrFail($id);
        $name = $partition->img;

        if ($request->hasFile('img')) {
            if ($name !== null) {
                unlink(public_path('uploads/partitions/') . $name);
            }

            $img = $request->file('img');
            $ext = $img->getClientOriginalExtension();
            $name = "partition-" . uniqid() . ".$ext";
            $img->move(public_path('uploads/partitions/'), $name);
        }

        $partition->update([
            'title' => $request->title,
            'img' => $name,
            'category_id' => $request->category_id,
        ]);
        $success= 'The Partition is Updated sucssefully' ;
        return response()->json($success);
    }

    //Function To Delete a Partition
    public function delete($id)
    {
        $partition = Partition::findOrFail($id);

        if ($partition->img !== null) {
            unlink(public_path('uploads/partitions/') . $partition->img);
        }

        $partition->delete();

        $success= 'The Partition is Deleated sucssefully' ;
        return response()->json($success);    }
}