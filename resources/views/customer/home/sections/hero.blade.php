<section class="relative overflow-hidden bg-[#fdf8fb]">

  {{-- BACKGROUND SOFT GLOW --}}
  <div class="absolute -top-40 -left-40 w-[500px] h-[500px] bg-pink-200/40 rounded-full blur-3xl"></div>
  <div class="absolute -bottom-40 -right-40 w-[400px] h-[400px] bg-fuchsia-200/40 rounded-full blur-3xl"></div>

  {{-- CONCENTRIC RINGS --}}
  @foreach([700,500,320] as $size)
    <div class="absolute rounded-full pointer-events-none"
         style="width:{{$size}}px;height:{{$size}}px;
         border:1px solid rgba(233,30,140,{{ $loop->iteration * 0.04 }});
         top:50%;left:50%;transform:translate(-50%,-50%);">
    </div>
  @endforeach

  <div class="relative max-w-5xl mx-auto px-6 py-16 text-center">

    {{-- BADGES --}}
    <div class="flex flex-wrap justify-center gap-2 mb-8">
      <span class="px-4 py-1 rounded-full text-xs font-semibold tracking-widest text-white
                   bg-gradient-to-r from-pink-600 to-fuchsia-600 shadow">
        NEW ARRIVALS
      </span>

      <span class="px-4 py-1 rounded-full text-xs font-semibold tracking-widest
                   bg-white border border-pink-200 text-pink-700">
        FREE SHIPPING 2000+ EGP
      </span>

      <span class="px-4 py-1 rounded-full text-xs font-semibold tracking-widest
                   bg-white border border-pink-200 text-pink-700">
        AUTHENTIC PRODUCTS
      </span>
    </div>

    {{-- TITLE --}}
    <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 leading-tight">
      Discover Your
      <span class="block bg-gradient-to-r from-pink-600 via-fuchsia-600 to-rose-500
                   bg-clip-text text-transparent">
        Beauty
      </span>
    </h1>

    {{-- DESCRIPTION --}}
    <p class="mt-6 text-gray-600 text-lg max-w-xl mx-auto leading-relaxed">
      Premium makeup, cosmetics & perfumes — curated with care to elevate your beauty experience.
    </p>

    {{-- BUTTONS --}}
    <div class="mt-10 flex flex-wrap justify-center gap-4">

      <a href="#"
         class="px-8 py-3 rounded-full font-semibold text-white
                bg-gradient-to-r from-pink-600 to-fuchsia-600
                shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition">
        Shop Now
      </a>

      <a href="{{ route('order.track') }}"
         class="px-8 py-3 rounded-full font-semibold
                bg-white border border-pink-200 text-pink-700
                hover:bg-pink-50 hover:border-pink-300 transition">
        Track Your Order
      </a>

    </div>

   

  </div>

</section>