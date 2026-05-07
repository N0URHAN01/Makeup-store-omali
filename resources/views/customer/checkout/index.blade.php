<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Checkout</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-white">

@include('customer.home.sections.navbar')

<main class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
  <h1 class="text-3xl font-extrabold text-gray-900">Checkout</h1>

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

    {{-- FORM --}}
    <form action="{{ route('checkout.store') }}" method="POST"
          class="lg:col-span-2 rounded-3xl border border-gray-200 p-6">
      @csrf

      <h2 class="text-lg font-extrabold text-gray-900">Customer Info</h2>

      <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">

        {{-- NAME --}}
        <div>
          <label class="text-sm font-semibold text-gray-700">Name</label>
          <input id="name" name="customer_name" value="{{ old('customer_name') }}"
                 class="mt-1 w-full rounded-xl border-gray-200 focus:border-pink-400 focus:ring-pink-400" required>
          <p id="name-live-error" class="text-xs text-red-600 mt-1 hidden"></p>
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
            class="mt-1 w-full rounded-xl border-gray-200 focus:border-pink-400 focus:ring-pink-400" required>

            <option value="">Select</option>

            @foreach($governorates as $g)
              <option value="{{ $g->id }}"
                      data-shipping="{{ $g->shipping_cost }}"
                      @selected(old('governorate_id') == $g->id)>
                {{ $g->name }}
              </option>
            @endforeach
          </select>

          <p id="gov-live-error" class="text-xs text-red-600 mt-1 hidden"></p>
          @error('governorate_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- ADDRESS --}}
        <div>
          <label class="text-sm font-semibold text-gray-700">Address</label>
          <input name="address" value="{{ old('address') }}"
                 class="mt-1 w-full rounded-xl border-gray-200 focus:border-pink-400 focus:ring-pink-400" required>
          @error('address')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
      </div>

      <button class="mt-6 w-full rounded-2xl bg-pink-600 px-4 py-3 text-white font-semibold hover:bg-pink-700">
        Confirm order
      </button>
    </form>

    {{-- ORDER SUMMARY --}}
    <div class="rounded-3xl border border-gray-200 p-6 h-fit">
      <h2 class="text-lg font-extrabold text-gray-900">Order Summary</h2>

      @foreach($cart as $item)
        <div class="flex justify-between text-sm mt-2">
          <span>{{ $item['name'] }} × {{ $item['qty'] }}</span>
          <span>{{ number_format($item['price'] * $item['qty'],2) }} EGP</span>
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

<script>
document.addEventListener("DOMContentLoaded", function(){

    const phone1 = document.getElementById("phone1");
    const phone2 = document.getElementById("phone2");
    const name = document.getElementById("name");
    const gov = document.getElementById("governorate");

    const p1Err = document.getElementById("phone1-live-error");
    const p2Err = document.getElementById("phone2-live-error");
    const nErr = document.getElementById("name-live-error");
    const gErr = document.getElementById("gov-live-error");

    function validatePhone(val, err, required=true){
        if(!val.value && required){
            err.innerText = "Required";
            err.classList.remove("hidden");
            return false;
        }
        if(val.value && !/^01[0-9]{9}$/.test(val.value)){
            err.innerText = "Invalid phone";
            err.classList.remove("hidden");
            return false;
        }
        err.classList.add("hidden");
        return true;
    }

    function validateName(){
        if(!name.value.trim()){
            nErr.innerText="Required";
            nErr.classList.remove("hidden");
        } else nErr.classList.add("hidden");
    }

    function validateGov(){
        if(!gov.value){
            gErr.innerText="Select governorate";
            gErr.classList.remove("hidden");
        } else gErr.classList.add("hidden");
    }

    phone1.addEventListener("input", ()=>validatePhone(phone1,p1Err,true));
    phone2.addEventListener("input", ()=>validatePhone(phone2,p2Err,false));
    name.addEventListener("input", validateName);
    gov.addEventListener("change", validateGov);


//shipping and total calculation

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

});


</script>

</body>
</html>