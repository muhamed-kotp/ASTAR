<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Partition;
use Illuminate\Http\Request;

class PartitionController extends Controller
{

        //Function To Show All Partitions
    public function index()
    {
        $partitions = Partition::get();

        return view(
            'welcome',
            compact('partitions')
        );
    }
        //Function To Show Each Partition
    public function show($id)
    {
        $partition = Partition::findOrFail($id);

        return view(
            'partition.show',
            compact('partition')
        );
    }

    public function create()
    {
        $categories = Category::select('id','name')->get();
        return view(
            'partition.create',compact('categories')
        );
    }

    public function store(Request $request)
    {
        // validation
        $request->validate([
            'title' => 'required|string|max:100',
            'img' => 'required|image|mimes:jpg,png',
            'category_id'=>'required|exists:categories,id'

        ]);
        // move
        $img = $request->file('img');
        $ext = $img->getClientOriginalExtension();
        $name = "partition-" . uniqid() . ".$ext";
        $img->move(public_path('uploads/partitions'), $name);

         Partition::create([
            'title' => $request->title,
            'img' => $name,
            'category_id' =>$request->category_id
        ]);

        return redirect(route('welcome'));
    }

    public function edit($id)
    {
        $partition = Partition::findOrFail($id);

        return view(
            'partition.edit',
            compact('partition')
        );
    }

    public function update(Request $request, $id)
    {
        // validation
        $request->validate([
            'title' => 'required|string|max:100',
            'img' => 'nullable|image|mimes:jpg,png',
        ]);

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
            'img' => $name
        ]);

        return redirect(route('partition.edit', $id));
    }

    public function delete($id)
    {
        $partition = Partition::findOrFail($id);

        if ($partition->img !== null) {
            unlink(public_path('uploads/partitions/') . $partition->img);
        }

        $partition->delete();

        return redirect(route('welcome'));
    }
}