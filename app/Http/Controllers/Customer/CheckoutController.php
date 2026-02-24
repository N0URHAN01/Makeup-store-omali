<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Governorate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    private function cart(): array
    {
        return session()->get('cart', []);
    }

    public function index()
    {
        $cart = $this->cart();
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);

        $governorates = Governorate::orderBy('name')->get();

        return view('customer.checkout.index', compact('cart', 'subtotal', 'governorates'));
    }

    public function store(Request $request)
    {
        $cart = $this->cart();
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $data = $request->validate([
            'customer_name'   => ['required','string','max:255'],
            'customer_email'  => ['nullable','email','max:255'],
            'customer_phone1' => ['required','string','max:30'],
            'customer_phone2' => ['nullable','string','max:30'],
            'notes'           => ['nullable','string'],
            'governorate_id'  => ['required','exists:governorates,id'],
            'address'         => ['required','string','max:2000'],
        ]);

        // ⚠️ مهم: حدد اسم عمود الشحن في جدول المحافظات عندك
        // هنا افترضت `shipping_cost`، لو عندك اسم مختلف غيره.
        $gov = Governorate::findOrFail($data['governorate_id']);
        $shipping = (float) ($gov->shipping_cost ?? 0);

        // إعادة التحقق من الأسعار/الستوك من DB (أفضل ممارسة)
        $subtotal = 0;

        DB::beginTransaction();
        try {
            foreach ($cart as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock <= 0) {
                    throw new \Exception("{$product->name} is out of stock.");
                }

                $qty = min((int)$item['qty'], (int)$product->stock);

                $price = (float) ($product->discount_percentage > 0 ? $product->discounted_price : $product->price);

                $subtotal += ($price * $qty);
            }

            $total = $subtotal + $shipping;

            $orderCode = 'OMALI-' . now()->format('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

            $order = Order::create([
                'order_code'     => $orderCode,
                'customer_name'  => $data['customer_name'],
                'customer_email' => $data['customer_email'] ?? null,
                'customer_phone1'=> $data['customer_phone1'],
                'customer_phone2'=> $data['customer_phone2'] ?? '',
                'notes'          => $data['notes'] ?? null,
                'governorate_id' => $data['governorate_id'],
                'address'        => $data['address'],
                'shipping_cost'  => $shipping,
                'total_price'    => $total,
                'status'         => 'pending',
            ]);

            foreach ($cart as $item) {
                $product = Product::findOrFail($item['product_id']);
                $qty = min((int)$item['qty'], (int)$product->stock);

                $price = (float) ($product->discount_percentage > 0 ? $product->discounted_price : $product->price);
                $lineTotal = $price * $qty;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'variant_id' => $item['variant_id'] ?? null,
                    'quantity'   => $qty,
                    'price'      => $price,
                    'total'      => $lineTotal,
                ]);

                // خصم من المخزون
                $product->decrement('stock', $qty);
            }

            DB::commit();

            // فضي السلة
            session()->forget('cart');

            return redirect()->route('checkout.success', $order->order_code);

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function success(Order $order)
    {
        // $order وصل بـ route model binding عن طريق order_code
        $order->load('items.product'); // لو العلاقات موجودة
        return view('customer.checkout.success', compact('order'));
    }
}