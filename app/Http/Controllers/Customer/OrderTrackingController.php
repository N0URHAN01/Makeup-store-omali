<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index(Request $request)
    {
        $orders = [];

        if ($request->filled('phone')) {
            $orders = Order::where('customer_phone1', $request->phone)
                ->orWhere('customer_phone2', $request->phone)
                ->with('items.product' , 'items.variant')
                ->latest()
                ->get();
        }

        return view('customer.orders.track', compact('orders'));
    }


    public function cancel(Order $order)
{
    if (now()->diffInMinutes($order->created_at) > 60) {
        return back()->with('error', 'Cancel time expired');
    }

    if ($order->status !== 'pending') {
        return back()->with('error', 'Order cannot be cancelled');
    }

    $order->update(['status' => 'cancelled']);

    return back()->with('success', 'Order cancelled');
}
}