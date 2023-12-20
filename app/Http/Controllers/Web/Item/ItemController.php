<?php

namespace App\Http\Controllers\Web\Item;

use App\Models\Item;
use App\Models\Partition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\AuthorizeCheck;


class ItemController extends Controller
{
    use AuthorizeCheck;
    //Function To Show All Partitions
    public function index()
    {
        $items = Item::get();
        return view(
            'welcome',
            compact('items')
        );
    }   //End Method

    //Function To Show Each Partition
    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view(
            'items.show',
            compact('item')
        );
    }    //End Method


    public function create()
    {
        $this->authorizCheck('create-items');
        $partitions = Partition::select('id', 'title')->get();
        return view(
            'items.create', compact('partitions')
        );
    }//End Method

    //Function To Create New Item
    public function store(Request $request)
    {
        $this->authorizCheck('create-items');
        // validation
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'partition_id' => 'required|exists:partitions,id',
            'img' => 'required|image|mimes:jpg,png',

        ]);
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

        return redirect(route('partition.show',$request->partition_id));
    }//End Method

    //Function To Edit New Item
    public function edit($id)
    {
        $this->authorizCheck('edit-items');
        $partitions = Partition::select('id', 'title')->get();
        $item = Item::findOrFail($id);

        return view(
            'items.edit', [
                'item' => $item,
                'partitions' => $partitions,
            ]
        );
    }//End Method

        //Function To update Item
    public function update(Request $request, $id)
    {
        $this->authorizCheck('edit-items');
        // validation
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'partition_id' => 'required|exists:partitions,id',
            'img' => 'nullable|image|mimes:jpg,png',

        ]);

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

        return redirect(route('items.show', $id));
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

        return redirect(route('partition.show',$item->partition_id));
    }
}//End Method
