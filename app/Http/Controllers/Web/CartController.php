<?php

namespace App\Http\Controllers\Web;

use App\Models\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function itemCart()
    {
        return view('cart.index');
    }
    public function addItemtoCart($id)
    {
        $item = Item::findOrFail($id);
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "title" => $item->title,
                "quantity" => 1,
                "price" => $item->price,
                "img" => $item->img
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Item has been added to cart!');
    }

    public function plusQuantity($id)
    {
            $item = Item::findOrFail($id);
            $cart = session()->get('cart');
            if($cart[$id]["quantity"]< $item->quantity)
            {
                $cart[$id]["quantity"] = $cart[$id]["quantity"] +1 ;
                $cart[$id]["price"] = $cart[$id]["quantity"] * $item->price ;
                session()->put('cart', $cart);
                session()->flash('success', 'Item has been added to cart!');
                return redirect()->back();
            }
            else
            {
                session()->flash('fail', 'There is no more items from this product !');
                return redirect()->back();
            }

    }
    public function minusQuantity($id)
    {
            $item = Item::findOrFail($id);
            $cart = session()->get('cart');
            if($cart[$id]["quantity"] > 1)
            {
                $cart[$id]["quantity"] = $cart[$id]["quantity"] -1 ;
                $cart[$id]["price"] = $cart[$id]["quantity"] * $item->price ;
                session()->put('cart', $cart);
                session()->flash('success', 'Item has been removed from cart!');
                return redirect()->back();
            }

    }

    public function delete($id)
    {

            $cart = session()->get('cart');
            if(isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Item successfully deleted.');
            return redirect()->back();
    }
}
