@extends('admin.layouts.app')

@section('title', 'Create Order')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-8 shadow-md rounded-xl">

    <h2 class="text-2xl font-bold mb-6 text-gray-800">Create Manual Order</h2>

    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf

        <!-- Customer Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="font-semibold">Customer Name</label>
                <input type="text" name="customer_name" class="input" required>
            </div>

            <div>
                <label class="font-semibold">Email</label>
                <input type="email" name="customer_email" class="input">
            </div>

            <div>
                <label class="font-semibold">Phone 1</label>
                <input type="text" name="customer_phone1" class="input" required>
            </div>

            <div>
                <label class="font-semibold">Phone 2</label>
                <input type="text" name="customer_phone2" class="input">
            </div>

            <div>
                <label class="font-semibold">Governorate</label>
                <select name="governorate_id" class="input shipping-select" required>
                    <option value="">-- Select --</option>
                    @foreach($governorates as $gov)
                        <option value="{{ $gov->id }}" data-shipping="{{ $gov->shipping_cost }}">
                            {{ $gov->name }} ({{ $gov->shipping_cost }} EGP)
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-semibold">Address</label>
                <input type="text" name="address" class="input">
            </div>

        </div>

        <div class="mt-4">
            <label class="font-semibold">Notes</label>
            <textarea name="notes" class="input"></textarea>
        </div>

        <hr class="my-6">

        <!-- Order Items -->
        <h3 class="text-xl font-bold mb-4 flex justify-between text-gray-800">
            Order Items
            <button type="button" id="add-product"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                + Add Product
            </button>
        </h3>

        <div id="items-container" class="space-y-4"></div>

        <!-- Totals -->
        <div class="bg-gray-100 p-4 rounded-lg mt-6">
            <p class="font-semibold text-lg">Subtotal: <span id="subtotal">0</span> EGP</p>
            <p class="font-semibold text-lg">Shipping: <span id="shipping">0</span> EGP</p>
            <p class="font-bold text-xl">Total: <span id="total">0</span> EGP</p>
        </div>

        <hr class="my-6">

        <button type="submit"
            class="px-6 py-3 bg-green-600 text-white rounded-lg shadow font-bold text-lg hover:bg-green-700">
            Create Order
        </button>

    </form>
</div>


<!-- =============== JS =============== -->
<script>
let itemIndex = 0;

// Add item row
document.getElementById("add-product").addEventListener("click", function () {

    let html = `
        <div class="border p-4 rounded-lg bg-gray-50 item-row">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>
                    <label class="font-semibold">Product</label>
                    <select name="items[${itemIndex}][product_id]" class="input product-select" required>
                        <option value="">-- Select Product --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                    data-price="{{ $product->price }}">
                                {{ $product->name }} ({{ $product->price }} EGP)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-semibold">Quantity</label>
                    <input type="number" min="1" value="1" 
                        class="input quantity-input" 
                        name="items[${itemIndex}][quantity]" required>
                </div>

                <div>
                    <label class="font-semibold">Price</label>
                    <input type="text" class="input price-field" readonly>
                </div>

            </div>

            <button type="button" class="mt-3 text-red-600 remove-item font-semibold hover:text-red-800">
                Remove
            </button>
        </div>
    `;

    document.getElementById("items-container").insertAdjacentHTML("beforeend", html);
    itemIndex++;
});


// Update price + totals when product selected
document.addEventListener("change", function (e) {
    if (e.target.classList.contains("product-select")) {
        let row = e.target.closest(".item-row");
        let price = e.target.selectedOptions[0].dataset.price || 0;
        row.querySelector(".price-field").value = price;
        updateTotals();
    }

    if (e.target.classList.contains("quantity-input")) {
        updateTotals();
    }

    if (e.target.classList.contains("shipping-select")) {
        updateTotals();
    }
});

// Remove item row
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("remove-item")) {
        e.target.closest(".item-row").remove();
        updateTotals();
    }
});


// Calculate totals
function updateTotals() {
    let subtotal = 0;

    document.querySelectorAll(".item-row").forEach(row => {
        let price = parseFloat(row.querySelector(".price-field").value) || 0;
        let qty = parseInt(row.querySelector(".quantity-input").value) || 1;
        subtotal += price * qty;
    });

    let shipping = parseFloat(
        document.querySelector(".shipping-select")?.selectedOptions[0]?.dataset.shipping || 0
    );

    let total = subtotal + shipping;

    document.getElementById("subtotal").textContent = subtotal.toFixed(2);
    document.getElementById("shipping").textContent = shipping.toFixed(2);
    document.getElementById("total").textContent = total.toFixed(2);
}
</script>

<style>
.input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
}
.input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 4px rgba(37, 99, 235, 0.4);
}
</style>

@endsection
