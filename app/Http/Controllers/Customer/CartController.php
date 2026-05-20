<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;


class CartController extends Controller
{
    private function cart(): array
    {
        return session()->get('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session()->put('cart', $cart);
    }

    private function makeKey(int $productId, ?int $variantId = null): string
    {
        return $variantId ? "{$productId}:{$variantId}" : (string)$productId;
    }

    public function index()
    {
        $cart = $this->cart();

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        $count = collect($cart)->sum('qty');

        return view('customer.cart.index', compact('cart', 'subtotal', 'count'));
    }

//     public function add(Request $request)
//     {
//         $data = $request->validate([
//             'product_id' => ['required','integer','exists:products,id'],
//             'variant_id' => ['nullable','integer'], 
//             'qty'        => ['nullable','integer','min:1','max:50'],
//         ]);

//         $product = Product::with('images')->findOrFail($data['product_id']); 

//          $variantId = $data['variant_id'] ?? null;
//         $qty = (int)($data['qty'] ?? 1);

//          $hasVariants = $product->variants
//     ->whereNotNull('color_name')
//     ->where('stock', '>', 0)
//     ->count() > 0;

// if ($hasVariants && !$variantId) {
//     return response()->json([
//         'success' => false,
//         'message' => 'Please choose product options first',
//         'require_variant' => true
//     ], 422);
// }

//         $price = (float) ($product->discount_percentage > 0 ? $product->discounted_price : $product->price);

//         $maxQty = max(0, (int)$product->stock);
//         if ($maxQty <= 0) {
//             return back()->with('error', 'This product is out of stock.');
//         }
//         $qty = min($qty, $maxQty);

//         $cart = $this->cart();
//         $key = $this->makeKey($product->id, $variantId);

//         if (isset($cart[$key])) {
//             $cart[$key]['qty'] = min($cart[$key]['qty'] + $qty, $maxQty);
//         } else {
//             $cart[$key] = [
//                 'key'        => $key,
//                 'product_id'  => $product->id,
//                 'variant_id'  => $variantId,
//                 'name'        => $product->name,
//                 'image'       => $product->image ? asset('storage/'.$product->image) : null,
//                 'price'       => $price,
//                 'qty'         => $qty,
//                 'stock'       => (int)$product->stock,
//             ];
//         }

//         $this->saveCart($cart);

//         return back()->with('success', 'Added to cart ✅');
//     }

public function add(Request $request)
{
    $data = $request->validate([
        'product_id' => ['required','integer','exists:products,id'],
        'variant_id' => ['nullable','integer'],
        'qty'        => ['nullable','integer','min:1','max:50'],
    ]);

    $product = Product::with(['images','variants'])->findOrFail($data['product_id']);

    $variantId = $data['variant_id'] ?? null;
    $qty = (int)($data['qty'] ?? 1);

   $variant = $variantId ? ProductVariant::find($variantId) : null;


    if ($variantId) {
        $variant = $product->variants()->where('id', $variantId)->first();

        if (!$variant) {
            return back()->with('error', 'Invalid variant');
        }
    }

    $hasVariants = $product->variants
        ->whereNotNull('color_name')
        ->where('stock', '>', 0)
        ->count() > 0;

    if ($hasVariants && !$variantId) {
        return response()->json([
            'success' => false,
            'message' => 'Please choose product options first',
            'require_variant' => true
        ], 422);
    }

    $price = (float) ($product->discount_percentage > 0
        ? $product->discounted_price
        : $product->price);

    $maxQty = $variant
        ? (int)$variant->stock
        : (int)$product->stock;

    if ($maxQty <= 0) {
        return back()->with('error', 'Out of stock');
    }

    $qty = min($qty, $maxQty);

    $cart = $this->cart();
    $key = $this->makeKey($product->id, $variantId);

    if (isset($cart[$key])) {
        $cart[$key]['qty'] = min($cart[$key]['qty'] + $qty, $maxQty);
    } else {
        $cart[$key] = [
            'key'         => $key,
            'product_id'  => $product->id,
            'variant_id'  => $variantId,

            'name'        => $product->name,

            'image'       => $variant && $variant->image
                ? asset('storage/'.$variant->image)
                : ($product->image ? asset('storage/'.$product->image) : null),

            'variant_name'  => $variant->color_name ?? null,
            'variant_color' => $variant->color_code ?? null,

            'price'       => $price,
            'qty'         => $qty,
            'stock'       => $maxQty,
        ];
    }

    $this->saveCart($cart);

    return back()->with('success', 'Added to cart ✅');
}

    public function update(Request $request)
    {
        $data = $request->validate([
            'key' => ['required','string'],
            'qty' => ['required','integer','min:1','max:50'],
        ]);

        $cart = $this->cart();

        if (!isset($cart[$data['key']])) {
            return back()->with('error', 'Item not found.');
        }

        // Ensure the new quantity does not exceed stock 
        $cart[$data['key']]['qty'] = min((int)$data['qty'], (int)$cart[$data['key']]['stock']);

        $this->saveCart($cart);
        return back()->with('success', 'Cart updated ✅');
    }

    public function increment(Request $request)
    {
        $data = $request->validate([
            'key' => ['required','string'],
        ]);

        $cart = $this->cart();
        if (!isset($cart[$data['key']])) return back();

        $cart[$data['key']]['qty'] = min($cart[$data['key']]['qty'] + 1, (int)$cart[$data['key']]['stock']);

        $this->saveCart($cart);
        return back();
    }

    public function decrement(Request $request)
    {
        $data = $request->validate([
            'key' => ['required','string'],
        ]);

        $cart = $this->cart();
        if (!isset($cart[$data['key']])) return back();

        $cart[$data['key']]['qty'] = max(1, $cart[$data['key']]['qty'] - 1);

        $this->saveCart($cart);
        return back();
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'key' => ['required','string'],
        ]);

        $cart = $this->cart();
        unset($cart[$data['key']]);

        $this->saveCart($cart);
        return back()->with('success', 'Removed ✅');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared ✅');
    }

    public function count()
    {
        $count = collect($this->cart())->sum('qty');
        return response()->json(['count' => $count]);
    }


    
}