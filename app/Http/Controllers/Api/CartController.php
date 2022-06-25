<?php

namespace App\Http\Controllers\Api;

use App\Models\Pos;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Extra;

class CartController extends Controller
{
    public function AddToCart(Request $request, $id)
    {
        $product = Product::find($id);
        $itemExist = Pos::where('product_id', $id)->first();
        if ($itemExist) {
            $itemExist->increment('product_quantity');
            $itemExist->subtotal = ($itemExist->product_quantity * $itemExist->product_price);
            return $itemExist->save();
        }
        $pos = new Pos();
        $pos->product_id = $id;
        $pos->product_name = $product->product_name;
        $pos->product_quantity = 1;
        $pos->product_price = $product->selling_price;
        $pos->subtotal = $product->selling_price;
        $pos->save();
    }

    public function CartProducts()
    {
        $pos = Pos::orderBy('created_at', 'DESC')->get();
        return response()->json($pos);
    }

    public function RemoveCart(Request $request, $id)
    {
        $cartItem = Pos::findOrFail($id);
        $cartItem->delete();
    }

    public function CartIncrement(Request $request, $id)
    {
        Pos::where('id', $id)->increment('product_quantity');
        $cartItem = Pos::find($id);
        $subTotal = ($cartItem->product_quantity * $cartItem->product_price);
        $cartItem->subtotal = $subTotal;
        $cartItem->save();
    }

    public function CartDecrement(Request $request, $id)
    {
        Pos::where('id', $id)->decrement('product_quantity');
        $cartItem = Pos::find($id);
        $subTotal = ($cartItem->product_quantity * $cartItem->product_price);
        $cartItem->subtotal = $subTotal;
        $cartItem->save();
    }

    public function Vats(){
        $vat = Extra::first();
        return response()->json($vat);
    }
}
