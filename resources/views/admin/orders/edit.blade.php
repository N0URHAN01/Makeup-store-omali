@extends('admin.layouts.app')

@php
use App\Enums\OrderStatus;
@endphp

@section('title', 'Edit Order')

@section('content')

<div class="max-w-6xl mx-auto bg-white p-6 md:p-8 rounded-2xl shadow border border-gray-200">

    <h2 class="text-2xl font-bold mb-6">
        Edit Order #{{ $order->order_code }}
    </h2>

    {{-- ================= MAIN FORM ================= --}}
    <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
        @csrf
        @method('PUT')

        {{-- ================= CUSTOMER INFO ================= --}}
        <h3 class="text-lg font-bold mb-4">Customer Information</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <input class="input"
                   name="customer_name"
                   value="{{ old('customer_name', $order->customer_name) }}"
                   required>

            <input class="input"
                   name="customer_email"
                   value="{{ old('customer_email', $order->customer_email) }}">

            <input class="input"
                   name="customer_phone1"
                   value="{{ old('customer_phone1', $order->customer_phone1) }}"
                   required>

            <input class="input"
                   name="customer_phone2"
                   value="{{ old('customer_phone2', $order->customer_phone2) }}">
        </div>

        <textarea class="input mt-3"
                  name="address"
                  placeholder="Address">{{ old('address', $order->address) }}</textarea>

        <textarea class="input mt-3"
                  name="notes"
                  placeholder="Notes">{{ old('notes', $order->notes) }}</textarea>

        {{-- ================= GOVERNORATE + STATUS ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

            {{-- Governorate --}}
            <select name="governorate_id"
                    class="input"
                    @disabled($order->status !== OrderStatus::PENDING)>

                @foreach($governorates as $gov)
                    <option value="{{ $gov->id }}"
                        @selected($order->governorate_id == $gov->id)>
                        {{ $gov->name }} ({{ $gov->shipping_cost }} EGP)
                    </option>
                @endforeach

            </select>

            {{-- Status --}}
            <select name="status" class="input">

                @foreach(OrderStatus::all() as $status)
                    <option value="{{ $status }}"
                        @selected($order->status === $status)>

                        {{ OrderStatus::label($status) }}

                    </option>
                @endforeach

            </select>

        </div>

        <hr class="my-6">

        {{-- ================= ORDER ITEMS ================= --}}
        <h3 class="text-lg font-bold mb-4">Order Items</h3>

        @if($order->status !== OrderStatus::PENDING)
            <p class="text-red-600 font-semibold mb-3">
                ⚠ You cannot modify items after order processing started
            </p>
        @endif

        @foreach($order->items as $item)

            <div class="flex flex-col md:flex-row gap-3 items-center mb-3">

                {{-- Product Name --}}
                <div class="w-full md:w-1/3">
                    <input class="input"
                           value="{{ $item->product->name }}"
                           readonly>
                </div>

                {{-- Quantity --}}
                <div class="w-full md:w-1/6">
                    <input type="number"
                           class="input"
                           name="items[{{ $item->id }}][quantity]"
                           value="{{ $item->quantity }}"
                           min="1"
                           @disabled($order->status !== OrderStatus::PENDING)>
                </div>

                {{-- Price --}}
                <div class="w-full md:w-1/6">
                    <input class="input"
                           value="{{ number_format($item->price, 2) }}"
                           readonly>
                </div>

                {{-- Delete --}}
                @if($order->status === OrderStatus::PENDING)
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

        {{-- ================= TOTALS ================= --}}
        <div class="bg-gray-100 p-4 rounded-xl text-sm">

            <p>
                Subtotal:
                <span id="subtotal">0</span> EGP
            </p>

            <p>
                Shipping:
                {{ number_format($order->shipping_cost, 2) }} EGP
            </p>

            <p class="font-bold text-lg mt-2">
                Total:
                <span id="total">0</span> EGP
            </p>

        </div>

        {{-- ================= BUTTON ================= --}}
        <button class="mt-6 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-xl">
            Update Order
        </button>

    </form>

    {{-- ================= DELETE ITEM FORMS ================= --}}
    @foreach($order->items as $item)

        <form id="delete-item-{{ $item->id }}"
              method="POST"
              action="{{ route('admin.orders.deleteItem', $item->id) }}">

            @csrf
            @method('DELETE')

        </form>

    @endforeach

    {{-- ================= ADD PRODUCT ================= --}}
    @if($order->status === OrderStatus::PENDING)

        <hr class="my-6">

        <h3 class="text-lg font-bold mb-3">Add Product</h3>

        <form method="POST" action="{{ route('admin.orders.addItem', $order->id) }}">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <select name="product_id" class="input" required>

                    <option value="">Select Product</option>

                    @foreach($products as $product)

                        <option value="{{ $product->id }}">
                            {{ $product->name }} – {{ $product->discounted_price ?? $product->price }} EGP
                        </option>

                    @endforeach

                </select>

                <input type="number"
                       name="quantity"
                       value="1"
                       min="1"
                       class="input">

                <button class="bg-blue-600 text-white rounded-xl px-4 py-2">
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

    document.querySelectorAll('input[name^="items"]').forEach(input => {
        if (input.type === 'number') {
            let price = parseFloat(input.closest('div').nextElementSibling.querySelector('input').value);
            subtotal += input.value * price;
        }
    });

    document.getElementById('subtotal').innerText = subtotal.toFixed(2);

    let shipping = {{ $order->shipping_cost }};
    document.getElementById('total').innerText = (subtotal + shipping).toFixed(2);
}

document.addEventListener('input', function (e) {
    if (e.target.type === 'number') {
        recalc();
    }
});

recalc();
</script>

<style>
.input {
    width: 100%;
    border: 1px solid #ddd;
    padding: 8px;
    border-radius: 8px;
    outline: none;
}
.input:focus {
    border-color: #ec4899;
}
</style>

@endsection