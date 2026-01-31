<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Category;
use App\Models\Governorate;

class OrderController extends Controller
{
    /* ==============================
        AJAX – Products by Category
    ===============================*/
    public function getProductsByCategory($category_id)
    {
        return response()->json(
            Product::where('category_id', $category_id)->get()
        );
    }

    /* ==============================
        Orders List
    ===============================*/
    public function index()
    {
        $orders = Order::with('items.product', 'governorate')
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /* ==============================
        Create Order
    ===============================*/
    public function create()
    {
        return view('admin.orders.create', [
            'categories'   => Category::all(),
            'products'     => Product::all(),
            'governorates' => Governorate::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'   => 'required',
            'customer_phone1' => 'required',
            'customer_phone2' => 'required',
            'governorate_id'  => 'required|exists:governorates,id',
            'items'           => 'required|array',
        ]);

        $order = Order::create([
            'order_code'      => 'ORD-' . time(),
            'customer_name'   => $request->customer_name,
            'customer_email'  => $request->customer_email,
            'customer_phone1' => $request->customer_phone1,
            'customer_phone2' => $request->customer_phone2,
            'notes'           => $request->notes,
            'address'         => $request->address,
            'governorate_id'  => $request->governorate_id,
            'status'          => 'pending',
        ]);

        $total = 0;

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $price   = $product->discounted_price ?? $product->price;

            $lineTotal = $price * $item['quantity'];
            $total += $lineTotal;

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'quantity'   => $item['quantity'],
                'price'      => $price,
                'total'      => $lineTotal,
            ]);
        }

        $shipping = Governorate::find($request->governorate_id)->shipping_cost;

        $order->update([
            'shipping_cost' => $shipping,
            'total_price'   => $total + $shipping,
        ]);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order created successfully.');
    }

    /* ==============================
        Show Order
    ===============================*/
    public function show($id)
    {
        $order = Order::with('items.product', 'governorate')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /* ==============================
        Edit Order
    ===============================*/
    public function edit($id)
    {
        return view('admin.orders.edit', [
            'order'        => Order::with('items.product')->findOrFail($id),
            'products'     => Product::all(),
            'governorates' => Governorate::all(),
            'statuses'     => ['pending','confirmed','shipped','delivered','cancelled'],
        ]);
    }

    /* ==============================
        Update Order (FIXED)
    ===============================*/
    public function update(Request $request, $id)
    {
        $order = Order::with('items')->findOrFail($id);

        $request->validate([
            'customer_name'   => 'required',
            'customer_phone1' => 'required',
            'governorate_id'  => 'required|exists:governorates,id',
            'status'          => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        /* ========= Update customer info ========= */
        $order->update($request->only([
            'customer_name',
            'customer_email',
            'customer_phone1',
            'customer_phone2',
            'address',
            'notes',
            'governorate_id',
            'status',
        ]));

        /* ========= Update items ONLY if pending ========= */
        if ($order->status === 'pending' && $request->has('items')) {
            foreach ($request->items as $itemId => $data) {
                $item = OrderItem::where('order_id', $order->id)
                    ->where('id', $itemId)
                    ->first();

                if ($item && isset($data['quantity'])) {
                    $item->update([
                        'quantity' => (int) $data['quantity'],
                        'total'    => $item->price * (int) $data['quantity'],
                    ]);
                }
            }
        }

        /* ========= Recalculate totals ========= */
        $this->recalculateOrderTotals($order);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order updated successfully.');
    }

    /* ==============================
        Delete Order
    ===============================*/
    public function destroy($id)
    {
        Order::findOrFail($id)->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    /* ==============================
        Order Items Actions
    ===============================*/
    public function deleteItem($itemId)
    {
        $item  = OrderItem::findOrFail($itemId);
        $order = $item->order;

        if (in_array($order->status, ['confirmed','shipped','delivered'])) {
            abort(403);
        }

        $item->delete();
        $this->recalculateOrderTotals($order);

        return back()->with('success', 'Order item deleted.');
    }

    public function updateItemQuantity(Request $request, $itemId)
    {
        $item = OrderItem::findOrFail($itemId);

        if (in_array($item->order->status, ['confirmed','shipped','delivered'])) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item->update([
            'quantity' => $request->quantity,
            'total'    => $request->quantity * $item->price,
        ]);

        $this->recalculateOrderTotals($item->order);

        return back()->with('success', 'Item updated.');
    }

    public function addItem(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        if (in_array($order->status, ['confirmed','shipped','delivered'])) {
            abort(403);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $price   = $product->discounted_price ?? $product->price;

        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'quantity'   => $request->quantity,
            'price'      => $price,
            'total'      => $price * $request->quantity,
        ]);

        $this->recalculateOrderTotals($order);

        return back()->with('success', 'Item added.');
    }

    /* ==============================
        Helper – Recalculate Totals
    ===============================*/
    private function recalculateOrderTotals(Order $order)
    {
        $order->load('items', 'governorate');

        $totalItems = $order->items->sum('total');


       if (in_array($order->status, ['confirmed','shipped','delivered'])) {
            $shipping = $order->shipping_cost;
        } else {
            $shipping = $order->governorate->shipping_cost ?? 0;
        }
        $order->update([
            'shipping_cost' => $shipping,
            'total_price'   => $totalItems + $shipping,
        ]);
    }
}
