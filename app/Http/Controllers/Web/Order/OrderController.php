<?php

namespace App\Http\Controllers\Web\Order;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Traits\AuthorizeCheck;

class OrderController extends Controller
{
    use AuthorizeCheck;
        //Function To Show All Orders
    public function index() {
        $this->authorizCheck('view-orders');
        $orders = Order::orderBy("id","desc")->get();
        $users = User::get();
        return view("order.index", compact("orders"));
    }//End Method

        //Function To Show The Order Details
    public function show($id) {
        $this->authorizCheck('view-orders');
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
    }//End Method

    //Function To Create Order
    public function create ()
    {
        return view('order.checkout');
    }//End Method

    //Function To Store Order
    public function  store (Request $request)
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
    }//End Method

}
