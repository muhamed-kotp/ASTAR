<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Partition;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    //Function To Show All Partitions
    public function index()
    {
        $items = Item::get();

        return view(
            'welcome',
            compact('items')
        );
    }
    //Function To Show Each Partition
    public function show($id)
    {
        $item = Item::findOrFail($id);

        return view(
            'items.show',
            compact('item')
        );
    }

    public function create()
    {
        $partitions = Partition::select('id', 'title')->get();
        return view(
            'items.create', compact('partitions')
        );
    }

    public function store(Request $request)
    {
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
    }

    public function edit($id)
    {
        $partitions = Partition::select('id', 'title')->get();
        $item = Item::findOrFail($id);

        return view(
            'items.edit', [
                'item' => $item,
                'partitions' => $partitions,
            ]
        );
    }

    public function update(Request $request, $id)
    {
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
    }

    public function delete($id)
    {
        $item = Item::findOrFail($id);

        if ($item->img !== null) {
            unlink(public_path('uploads/items/') . $item->img);
        }

        $item->delete();

        return redirect(route('partition.show',$item->partition_id));
    }
}