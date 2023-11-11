<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::orderBy("id","desc")->get();
        $users = User::get();
        return view("order.index", compact("orders"));
    }
    public function show($id) {
        $userOrders = [];
        $order = Order::findOrFail($id);

        foreach ($order->orderDetails as $Details) {
            $item = Item::findOrFail($Details->item_id);
            $userOrders = Arr::prepend($userOrders, $item , $Details->order_quantity);


        }
        return view('order.show',[
            'userOrders'=> $userOrders,
            'order'=> $order
    ]);
    }

    public function checkOut ()
    {
        return view('order.checkout');
    }

    public function  handleCheckOut (Request $request)
    {
        $user_id = Auth::user()-> id ;
        $total = session('total');

        $request ->validate([
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:15',
            'payment_method' =>'required'
        ]);

        $order = Order::create([
            'user_id' => $user_id,
            'address'=> $request->address,
            'phone'=> $request->phone,
            'total' => $total,
            'payment_method' => $request->payment_method
        ]);

        foreach (session('cart') as $id => $details) {
            $item = Item::findOrFail($id);
            OrderDetail::create([
                'order_id'=> $order->id,
                'item_id' => $id,
                'price_each'  => $item->price,
                'order_quantity'=> $details['quantity'],
            ]);

        }
        session()->flush();
        session()->flash('success', 'Your Order Created Successfuly !!');
        return redirect(route('welcome'));
    }

}