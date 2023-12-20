<?php

namespace App\Http\Controllers\Api\Partition;

use App\Models\Category;
use App\Models\Partition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Traits\AuthorizeCheck;

class PartitionController extends Controller
{
    use AuthorizeCheck;

    //Function To Show All Partitions
    public function index()
    {
        $partitions = Partition::get();

        return response()->json($partitions);

    }//End Method

    //Function To Show Each Partition
    public function show($id)
    {
        $partition = Partition::with('items')->findOrFail($id);

        return response()->json($partition);

    }//End Method

    //Function To Create New Partition
    public function store(Request $request)
    {
        $this->authorizCheck('create-partitions');
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
    }//End Method

    //Function To update a Partition
    public function update(Request $request, $id)
    {
        $this->authorizCheck('edit-partitions');

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
    }//End Method

    //Function To Delete a Partition
    public function delete($id)
    {
        $this->authorizCheck('delete-partitions');
        $partition = Partition::findOrFail($id);

        if ($partition->img !== null) {
            unlink(public_path('uploads/partitions/') . $partition->img);
        }

        $partition->delete();

        $success= 'The Partition is Deleated sucssefully' ;
        return response()->json($success);
    }//End Method
}
