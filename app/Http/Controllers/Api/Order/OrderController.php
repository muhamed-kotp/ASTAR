<?php

namespace App\Http\Controllers\Api\Order;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\AuthorizeCheck;

class OrderController extends Controller
{
    use AuthorizeCheck;
    //Function To Show All Orders
    public function index() {
        $this->authorizCheck('view-orders');
        $orders = Order::orderBy("id","desc")->get();
        return response()->json($orders);
    }//End Method

    //Function To Show The Order Details
    public function show($id) {
        $this->authorizCheck('view-orders');
        $order = Order::with('orderDetails')->findOrFail($id);
        return response()->json($order);
    }//End Method

    //Function To Create Order
    public function  store (Request $request)
    {
        $user_id = Auth::user()-> id ;
        $total = session('total');

        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:15',
            'payment_method' =>'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors);
        }

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
        $success= 'Congratulations Your Order is Created sucssefully!' ;
        return response()->json($success);
    }//End Method

}