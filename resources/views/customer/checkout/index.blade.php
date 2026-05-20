@extends('customer.layouts.app')

@section('title', 'Checkout')

@section('content')

<main class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
  <h1 class="text-3xl font-extrabold text-gray-900">Checkout</h1>

  {{-- ERROR --}}
  @if(session('error'))
    <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
      {{ session('error') }}
    </div>
  @endif

  {{-- ALL ERRORS --}}
  @if ($errors->any())
    <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
      <ul class="space-y-1">
        @foreach ($errors->all() as $error)
          <li>• {{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ================= FORM ================= --}}
    <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST"
          class="lg:col-span-2 rounded-3xl border border-gray-200 p-6">
      @csrf

      <h2 class="text-lg font-extrabold text-gray-900">Customer Info</h2>

      <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">

        {{-- NAME --}}
        <div>
          <label class="text-sm font-semibold text-gray-700">Name</label>
          <input id="name" name="customer_name" value="{{ old('customer_name') }}"
                 class="mt-1 w-full rounded-xl border-gray-200 focus:border-pink-400 focus:ring-pink-400" required>
          @error('customer_name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- EMAIL --}}
        <div>
          <label class="text-sm font-semibold text-gray-700">Email (optional)</label>
          <input name="customer_email" value="{{ old('customer_email') }}"
                 class="mt-1 w-full rounded-xl border-gray-200 focus:border-pink-400 focus:ring-pink-400">
        </div>

        {{-- PHONE 1 --}}
        <div>
          <label class="text-sm font-semibold text-gray-700">Phone 1</label>
          <input id="phone1" name="customer_phone1" value="{{ old('customer_phone1') }}"
           maxlength="11"
           inputmode="numeric"
           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
           class="mt-1 w-full rounded-xl border-gray-200 focus:border-pink-400 focus:ring-pink-400" required>
          <p id="phone1-live-error" class="text-xs text-red-600 mt-1 hidden"></p>
          @error('customer_phone1')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        

        {{-- PHONE 2 --}}
        <div>
          <label class="text-sm font-semibold text-gray-700">Phone 2</label>
          <input id="phone2" name="customer_phone2" value="{{ old('customer_phone2') }}"
           maxlength="11"
           inputmode="numeric"
           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
           class="mt-1 w-full rounded-xl border-gray-200 focus:border-pink-400 focus:ring-pink-400">
          <p id="phone2-live-error" class="text-xs text-red-600 mt-1 hidden"></p>
          @error('customer_phone2')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
      </div>
      
      <h2 class="text-lg font-extrabold text-gray-900 mt-8">Delivery</h2>

      <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">

        {{-- GOVERNORATE --}}
        <div>
          <label class="text-sm font-semibold text-gray-700">Governorate</label>

          <select id="governorate" name="governorate_id"
            class="mt-1 w-full rounded-xl border-gray-200" required>

            <option value="">Select</option>

            @foreach($governorates as $g)
              <option value="{{ $g->id }}"
                      data-shipping="{{ $g->shipping_cost }}"
                      @selected(old('governorate_id') == $g->id)>
                {{ $g->name }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- ADDRESS --}}
        <div>
          <label class="text-sm font-semibold text-gray-700">Address</label>
          <input name="address" value="{{ old('address') }}"
                 class="mt-1 w-full rounded-xl border-gray-200" required>
        </div>

      </div>

      {{--  BUTTON conf order --}}
      <button type="button" onclick="openModal()"
        class="mt-6 w-full rounded-2xl bg-pink-600 px-4 py-3 text-white font-semibold">
        Confirm order
      </button>

    </form>

    {{-- ================= SUMMARY ================= --}}
    <div class="rounded-3xl border border-gray-200 p-6 h-fit">

      <h2 class="text-lg font-extrabold text-gray-900">Order Summary</h2>

      @foreach($cart as $item)
        <div class="flex items-center justify-between text-sm mt-3">

          <div class="flex items-center gap-2">

            <img src="{{ $item['image'] }}"
                 class="w-10 h-10 object-cover rounded-lg border">

            <div>
              <p class="font-semibold">{{ $item['name'] }}</p>

              {{-- VARIANT OF product  name and color --}}
              @if(!empty($item['variant_name']))
                <div class="flex items-center gap-1 text-xs text-gray-500">
                  <span class="w-2.5 h-2.5 rounded-full border"
                        style="background: {{ $item['variant_color'] }}"></span>
                  {{ $item['variant_name'] }}
                </div>
              @endif

              <p class="text-xs text-gray-400">
                Qty: {{ $item['qty'] }}
              </p>
            </div>

          </div>

          <span>
            {{ number_format($item['price'] * $item['qty'],2) }} EGP
          </span>

        </div>
      @endforeach

      <div class="mt-4 border-t pt-3 flex justify-between">
        <span>Subtotal</span>
        <span>{{ number_format($subtotal,2) }} EGP</span>
      </div>

      <div class="mt-2 hidden flex justify-between" id="shipping-row">
        <span>Shipping</span>
        <span id="shipping-cost"></span>
      </div>

      <div class="mt-2 hidden flex justify-between font-bold" id="total-row">
        <span>Total</span>
        <span id="total-price"></span>
      </div>

    </div>

  </div>
</main>

{{-- ================= MODAL ================= --}}
<div id="confirmModal"
     class="fixed inset-0 hidden items-center justify-center bg-black/40 z-50">

  <div class="bg-white rounded-2xl p-6 w-full max-w-md">

    <h2 class="text-lg font-bold">Confirm your order?</h2>
    <p class="text-sm text-gray-500 mt-2">Are you sure?</p>

    <div class="mt-4 flex gap-2">
      <button onclick="closeModal()" class="flex-1 bg-gray-100 rounded-xl py-2">
        Cancel
      </button>

      <button onclick="submitOrder()" class="flex-1 bg-pink-600 text-white rounded-xl py-2">
        Yes
      </button>
    </div>

  </div>
</div>

<script>
function openModal(){
  document.getElementById('confirmModal').classList.remove('hidden');
  document.getElementById('confirmModal').classList.add('flex');
}

function closeModal(){
  document.getElementById('confirmModal').classList.add('hidden');
}

function submitOrder(){
  document.getElementById('checkoutForm').submit();
}

// SHIPPING
const gov = document.getElementById("governorate");
const shippingRow = document.getElementById("shipping-row");
const totalRow = document.getElementById("total-row");
const shippingCostEl = document.getElementById("shipping-cost");
const totalPriceEl = document.getElementById("total-price");

const subtotal = {{ $subtotal }};

function updateTotal() {
    const selected = gov.options[gov.selectedIndex];
    const shipping = parseFloat(selected?.dataset?.shipping || 0);

    if (!gov.value) {
        shippingRow.classList.add("hidden");
        totalRow.classList.add("hidden");
        return;
    }

    const total = subtotal + shipping;

    shippingCostEl.innerText = shipping.toFixed(2) + " EGP";
    totalPriceEl.innerText = total.toFixed(2) + " EGP";

    shippingRow.classList.remove("hidden");
    totalRow.classList.remove("hidden");
}

gov.addEventListener("change", updateTotal);
updateTotal();
</script>

@endsection