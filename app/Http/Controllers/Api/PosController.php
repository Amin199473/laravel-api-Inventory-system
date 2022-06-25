<?php

namespace App\Http\Controllers\Api;

use App\Models\Pos;
use App\Models\Order;
use App\Models\Expense;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PosController extends Controller
{
    public function GetProducts($id)
    {
        $products = Product::where('category_id', $id)->get();
        return response()->json($products);
    }
    public function OrderDone(Request $request)
    {

        $request->validate([
            'customer_id' => 'required',
            'payby' => 'required',
        ]);
        $order = new Order();
        $order->customer_id = $request->customer_id;
        $order->qty = $request->qty;
        $order->subtotal = $request->subtotal;
        $order->vat = $request->vat;
        $order->total = $request->total;
        $order->pay = $request->pay;
        $order->due = $request->due;
        $order->payby = $request->payby;
        $order->order_date = date('d/m/y');
        $order->order_month = date('F');
        $order->order_year = date('Y');
        $order->save();

        $items = Pos::get();
        foreach ($items as $item) {
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $item->product_id;
            $orderDetail->product_quantity = $item->product_quantity;
            $orderDetail->product_price = $item->product_price;
            $orderDetail->subtotal = $item->subtotal;
            $orderDetail->save();

            //update Stock
            $product = Product::find($item->product_id);
            $product->product_quantity = ($product->product_quantity - $item->product_quantity);
            $product->save();
        }
        Pos::truncate();
    }

    public function TodaySell(){
        $date = date('d/m/y');
        $sell = Order::where('order_date', $date)->sum('total');
        dd($sell);
        return response()->json($sell);
      }

      public function TodayIncome(){
        $date = date('d/m/y');
        $income = Order::where('order_date', $date)->sum('pay');
        return response()->json($income);
      }

       public function TodayDue(){
        $date = date('d/m/y');
        $todaydue = Order::where('order_date', $date)->sum('due');
        return response()->json($todaydue);
      }


      public function TodayExpense(){
        $date = date('d/m/y');
        $expense = Expense::where('expense_date', $date)->sum('amount');
        return response()->json($expense);
      }

    public function Stockout(){

     $product = Product::where('product_quantity','<','1')->get();
     return response()->json($product);

    }
}
