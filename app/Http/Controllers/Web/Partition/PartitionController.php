<?php

namespace App\Http\Controllers\Web\Partition;

use App\Models\Category;
use App\Models\Partition;
use App\Http\Controllers\Controller;
use App\Traits\AuthorizeCheck;
use Illuminate\Http\Request;

class PartitionController extends Controller
{
    use AuthorizeCheck;

    //Function To Show All Partitions
    public function index()
    {
        $partitions = Partition::get();

        return view(
            'welcome',
            compact('partitions')
        );
    }//End Method

    //Function To Show Each Partition
    public function show($id)
    {
        $partition = Partition::findOrFail($id);

        return view(
            'partition.show',
            compact('partition')
        );
    }//End Method

        //Function To Create New Partition
    public function create()
    {
        $this->authorizCheck('create-partitions');
        $categories = Category::select('id', 'name')->get();
        return view(
            'partition.create', compact('categories')
        );
    }//End Method

        //Function To Store New Partition
    public function store(Request $request)
    {
        $this->authorizCheck('create-partitions');
        // validation
        $request->validate([
            'title' => 'required|string|max:100',
            'img' => 'required|image|mimes:jpg,png',
            'category_id' => 'required|exists:categories,id',

        ]);
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

        return redirect(route('welcome'));
    }//End Method

    //Function To Store New Partition
    public function edit($id)
    {
        $this->authorizCheck('edit-partitions');
        $categories = Category::select('id', 'name')->get();
        $partition = Partition::findOrFail($id);

        return view(
            'partition.edit', [
                'partition' => $partition,
                'categories' => $categories,
            ]
        );
    }//End Method

        //Function To update a Partition
    public function update(Request $request, $id)
    {
        $this->authorizCheck('edit-partitions');
        // validation
        $request->validate([
            'title' => 'required|string|max:100',
            'img' => 'nullable|image|mimes:jpg,png',
            'category_id' => 'required|exists:categories,id',
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
            'img' => $name,
            'category_id' => $request->category_id,
        ]);

        return redirect(route('welcome'));
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

        return redirect(route('welcome'));
    }//End Method
}
