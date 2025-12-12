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



    public function getProductsByCategory($category_id)
{
    $products = Product::where('category_id', $category_id)->get();

    return response()->json($products);
}

    /**
     * List all orders
     */
    public function index()
    {
        $orders = Order::with('items.product', 'governorate')
                       ->latest()
                       ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }


    /**
     * Show form to create manual order
     */
    public function create()
    {
        return view('admin.orders.create', [
            'categories' => Category::all(),
            'products' => Product::all(),
            'governorates' => Governorate::all()
        ]);
    }


    /**
     * Store new order
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name'     => 'required',
            'customer_phone1'   => 'required',
            'customer_phone2'   => 'required',
            'governorate_id'    => 'required|exists:governorates,id',
            'items'             => 'required|array',
        ]);

        // Create Order
        $order = Order::create([
            'order_code'       => 'ORD-' . time(),
            'customer_name'    => $request->customer_name,
            'customer_email'   => $request->customer_email,
            'customer_phone1'  => $request->customer_phone1,
            'customer_phone2'  => $request->customer_phone2,
            'notes'            => $request->notes,
            'address'          => $request->address,
            'governorate_id'   => $request->governorate_id,
        ]);

        // Add items
        $total = 0;

        foreach ($request->items as $item) {

            $product = Product::findOrFail($item['product_id']);
            $price = $product->price;

            $lineTotal = $price * $item['quantity'];
            $total += $lineTotal;

            OrderItem::create([
                'order_id'  => $order->id,
                'product_id'=> $product->id,
                'quantity'  => $item['quantity'],
                'price'     => $price,
                'total'     => $lineTotal,
            ]);
        }

        // apply shipping price
        $shipping = Governorate::find($request->governorate_id)->shipping_cost;

        $order->update([
            'shipping_cost' => $shipping,
            'total_price'   => $total + $shipping,
        ]);

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order created successfully.');
    }



    /**
     * Show order details
     */
    public function show($id)
    {
        $order = Order::with('items.product', 'governorate')->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }


    /**
     * Edit order (customer info + status)
     */
    public function edit($id)
    {
        return view('admin.orders.edit', [
            'order'        => Order::with('items.product')->findOrFail($id),
            'products'     => Product::all(),
            'governorates' => Governorate::all(),
            'statuses'     => ['pending','confirmed','shipped','delivered','cancelled'],
        ]);
    }



    /**
     * Update order main data (not items)
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'customer_name' => 'required',
            'customer_phone1' => 'required',
            'governorate_id' => 'required|exists:governorates,id',
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled'
        ]);

        $order->update($request->only([
            'customer_name',
            'customer_email',
            'customer_phone1',
            'customer_phone2',
            'address',
            'notes',
            'governorate_id',
            'status'
        ]));

        // recalculate totals after governorate change
        $this->recalculateOrderTotals($order);

        return redirect()->route('admin.orders.show', $order->id)
                         ->with('success', 'Order updated successfully.');
    }


    /**
     * Delete order
     */
    public function destroy($id)
    {
        Order::findOrFail($id)->delete();

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order deleted successfully.');
    }


    /**
     * Remove a single item from an order
     */
    public function deleteItem($itemId)
    {
        $item = OrderItem::findOrFail($itemId);
        $order = $item->order;

        $item->delete();

        $this->recalculateOrderTotals($order);

        return back()->with('success', 'Order item deleted.');
    }


    /**
     * Update quantity of item
     */
    public function updateItemQuantity(Request $request, $itemId)
    {
        $item = OrderItem::findOrFail($itemId);

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item->quantity = $request->quantity;
        $item->total = $item->quantity * $item->price;
        $item->save();

        $this->recalculateOrderTotals($item->order);

        return back()->with('success', 'Item updated.');
    }


    /**
     * Add new item to order
     */
    public function addItem(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product_id);
        $price = $product->price;

        OrderItem::create([
            'order_id'  => $order->id,
            'product_id'=> $product->id,
            'quantity'  => $request->quantity,
            'price'     => $price,
            'total'     => $price * $request->quantity,
        ]);

        $this->recalculateOrderTotals($order);

        return back()->with('success', 'Item added.');
    }


    /**
     * Helper function – Recalculate totals for order
     */
    private function recalculateOrderTotals(Order $order)
    {
        $totalItems = $order->items()->sum('total');
        $shipping = $order->governorate->shipping_cost;

        $order->update([
            'shipping_cost' => $shipping,
            'total_price'   => $totalItems + $shipping,
        ]);
    }
}
