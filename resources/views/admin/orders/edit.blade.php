@extends('admin.layouts.app')

@section('title', 'Edit Order')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 rounded shadow">

    <h2 class="text-2xl font-bold mb-6">
        Edit Order #{{ $order->order_code }}
    </h2>

    {{-- ================= MAIN UPDATE FORM ================= --}}
    <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
        @csrf
        @method('PUT')

        {{-- ================= Customer Info ================= --}}
        <h3 class="text-lg font-bold mb-3">Customer Information</h3>

        <div class="grid grid-cols-2 gap-4">
            <input class="input" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required>
            <input class="input" name="customer_email" value="{{ old('customer_email', $order->customer_email) }}">
            <input class="input" name="customer_phone1" value="{{ old('customer_phone1', $order->customer_phone1) }}" required>
            <input class="input" name="customer_phone2" value="{{ old('customer_phone2', $order->customer_phone2) }}">
        </div>

        <textarea class="input mt-3" name="address" placeholder="Address">{{ old('address', $order->address) }}</textarea>
        <textarea class="input mt-3" name="notes" placeholder="Notes">{{ old('notes', $order->notes) }}</textarea>

        <div class="grid grid-cols-2 gap-4 mt-3">
            <select name="governorate_id" class="input"
    @disabled(in_array($order->status, ['confirmed','shipped','delivered']))>
    @foreach($governorates as $gov)
        <option value="{{ $gov->id }}" @selected($order->governorate_id == $gov->id)>
            {{ $gov->name }} ({{ $gov->shipping_cost }} EGP)
        </option>
    @endforeach
</select>

@if(in_array($order->status, ['confirmed','shipped','delivered']))
    <p class="text-red-600 text-sm mt-1">
        ⚠ Cannot change governorate after order confirmation
    </p>
@endif


            <select name="status" class="input">
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected($order->status === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <hr class="my-6">

        {{-- ================= Order Items ================= --}}
        <h3 class="text-lg font-bold mb-3">Order Items</h3>

        @if(in_array($order->status, ['confirmed','shipped','delivered']))
            <p class="text-red-600 font-semibold mb-3">
                ⚠ Products cannot be modified after confirmation
            </p>
        @endif

        @foreach($order->items as $item)
            <div class="flex gap-3 items-center mb-3">

                <div class="w-1/3">
                    <input class="input" value="{{ $item->product->name }}" readonly>
                </div>

                <div class="w-1/6">
                    <input type="number"
                           class="input qty"
                           name="items[{{ $item->id }}][quantity]"
                           value="{{ $item->quantity }}"
                           min="1"
                           data-price="{{ $item->price }}"
                           @disabled(in_array($order->status, ['confirmed','shipped','delivered']))>
                </div>

                <div class="w-1/6">
                    <input class="input price" value="{{ number_format($item->price, 2) }}" readonly>
                </div>

                {{-- Delete Item --}}
                @if(!in_array($order->status, ['confirmed','shipped','delivered']))
                    <div>
                        <button type="submit"
                                form="delete-item-{{ $item->id }}"
                                class="text-red-600 font-bold">
                            ✕
                        </button>
                    </div>
                @endif
            </div>
        @endforeach

        <hr class="my-6">

        {{-- ================= Totals ================= --}}
        <div class="bg-gray-100 p-4 rounded">
            <p>Subtotal: <span id="subtotal">0</span> EGP</p>
            <p>Shipping: {{ number_format($order->shipping_cost, 2) }} EGP</p>
            <p class="font-bold text-lg">
                Total: <span id="total">0</span> EGP
            </p>
        </div>

        <button class="mt-6 bg-green-600 text-white px-6 py-2 rounded">
            Update Order
        </button>
    </form>

    {{-- ================= DELETE ITEM FORMS (OUTSIDE MAIN FORM) ================= --}}
    @foreach($order->items as $item)
        <form id="delete-item-{{ $item->id }}"
              method="POST"
              action="{{ route('admin.orders.deleteItem', $item->id) }}">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

    {{-- ================= ADD PRODUCT ================= --}}
    @if(!in_array($order->status, ['confirmed','shipped','delivered']))
        <hr class="my-6">

        <h3 class="text-lg font-bold mb-3">Add Product</h3>

        <form method="POST" action="{{ route('admin.orders.addItem', $order->id) }}">
            @csrf

            <div class="grid grid-cols-3 gap-4">
                <select name="product_id" class="input" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }} – {{ $product->discounted_price ?? $product->price }} EGP
                        </option>
                    @endforeach
                </select>

                <input type="number" name="quantity" value="1" min="1" class="input">

                <button class="bg-blue-600 text-white rounded px-4">
                    Add
                </button>
            </div>
        </form>
    @endif
</div>

{{-- ================= JS ================= --}}
<script>
function recalc() {
    let subtotal = 0;
    document.querySelectorAll('.qty').forEach(q => {
        subtotal += (q.value * q.dataset.price);
    });

    document.getElementById('subtotal').innerText = subtotal.toFixed(2);
    document.getElementById('total').innerText =
        (subtotal + {{ $order->shipping_cost }}).toFixed(2);
}

document.addEventListener('input', e => {
    if (e.target.classList.contains('qty')) {
        recalc();
    }
});

recalc();
</script>

<style>
.input{
    width:100%;
    border:1px solid #ccc;
    padding:8px;
    border-radius:6px;
}
</style>
@endsection
