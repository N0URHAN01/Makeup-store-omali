<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    

//     public function index(Request $request)
// {
//      $latestOrder = null;
//     $orders = collect();

//     if ($request->filled('phone')) {

//         $phone = trim($request->phone);

//         $orders = Order::with('items.product', 'items.variant')
//             ->where(function ($q) use ($phone) {
//                 $q->where('customer_phone1', $phone)
//                   ->orWhere('customer_phone2', $phone);
//             })
//             ->latest()
//             ->get();

//              $latestOrder = $orders->first();
//             $otherOrders = $orders->skip(1)->take(3);
//     }

//     return view('customer.orders.track', compact('orders', 'latestOrder', 'otherOrders'));
// }

public function index(Request $request)
{
    $latestOrder = null;
    $otherOrders = collect();

    if ($request->filled('phone')) {

        $phone = trim($request->phone);

        $orders = Order::with('items.product', 'items.variant')
            ->where(function ($q) use ($phone) {
                $q->where('customer_phone1', $phone)
                  ->orWhere('customer_phone2', $phone);
            })
            ->latest()
            ->get();

        $latestOrder = $orders->first();

        $otherOrders = $orders->skip(1)->take(3); 
    }

    return view('customer.orders.track', compact('latestOrder', 'otherOrders'));
}




public function cancel(Order $order)
{
    if (now()->diffInMinutes($order->created_at) > 60) {
        return back()->with('error', 'Cancel time expired');
    }

    if ($order->status !== 'pending') {
        return back()->with('error', 'Order cannot be cancelled');
    }

    foreach ($order->items as $item) {

        if ($item->variant) {
            $item->variant->increment('stock', $item->quantity);
        } else {
            $item->product->increment('stock', $item->quantity);
        }

    }

    $order->update([
        'status' => 'cancelled'
    ]);

    return back()->with('success', 'Order cancelled successfully');
}
}