<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use DateTime;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function TodayOrders()
    {
        $date = date('d/m/y');
        $orders = Order::with(['customer'])->where('order_date', $date)->orderBy('id', 'DESC')->get();
        return response()->json($orders);
    }

    public function Order($id)
    {
        $order = Order::with(['customer'])->where('id', $id)->first();
        return response()->json($order);
    }

    public function OrderDetails($id)
    {
        $orderDetails = OrderDetail::with(['product'])->where('order_id', $id)->get();

        return response()->json($orderDetails);
    }

    public function SearchOrderByDate(Request $request)
    {
        $newDate = new DateTime($request->date);
        $date = $newDate->format('d/m/y');
        $orders = Order::with(['customer'])->where('order_date',$date)->get();

        return response()->json($orders);
    }
}
