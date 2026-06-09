<script>
function loadCartCount() {
    fetch("{{ route('cart.count') }}")
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('cart-count');

            if (badge) {
                badge.innerText = data.count;
                badge.style.display = data.count > 0 ? 'flex' : 'none';
            }
        })
        .catch(error => console.log(error));
}

document.addEventListener('DOMContentLoaded', function () {
    loadCartCount();
});
</script>

<nav class="fixed top-0 left-0 w-full z-50 bg-white/85 backdrop-blur-xl border-b border-pink-100/70 shadow-[0_8px_30px_rgba(236,72,153,0.04)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center h-16">

            {{-- BRAND --}}
            <a href="{{ route('home') }}"
               class="group flex items-center select-none">

                <div class="flex flex-col leading-none">

                    <span class="text-[30px] sm:text-[34px] font-black tracking-tight text-gray-950"
                          style="font-family: 'Playfair Display', serif;">
                        Om Ali
                    </span>

                    <span class="mt-1 text-[10px] tracking-[0.35em] uppercase font-bold text-pink-500">
                        Beauty Store
                    </span>

                </div>

            </a>

            {{-- DESKTOP LINKS --}}
            <div class="hidden md:flex items-center gap-9 text-[17px] font-semibold text-gray-700"
                 style="font-family: 'Inter', sans-serif;">

                <a href="{{ route('home') }}"
                   class="relative py-2 hover:text-pink-600 transition group">
                    Home
                    <span class="absolute left-0 -bottom-0.5 h-[2px] w-0 bg-pink-500 rounded-full transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="{{ route('products.index') }}"
                   class="relative py-2 hover:text-pink-600 transition group">
                    Shop
                    <span class="absolute left-0 -bottom-0.5 h-[2px] w-0 bg-pink-500 rounded-full transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="{{ route('categories.index') }}"
                   class="relative py-2 hover:text-pink-600 transition group">
                    Categories
                    <span class="absolute left-0 -bottom-0.5 h-[2px] w-0 bg-pink-500 rounded-full transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="#contact"
                   class="relative py-2 hover:text-pink-600 transition group">
                    Contact
                    <span class="absolute left-0 -bottom-0.5 h-[2px] w-0 bg-pink-500 rounded-full transition-all duration-300 group-hover:w-full"></span>
                </a>

            </div>

            {{-- ACTIONS --}}
            <div class="flex items-center gap-3">

                {{-- CART --}}
                <a href="{{ route('cart.index') }}"
                   class="relative inline-flex items-center justify-center w-11 h-11 rounded-full bg-pink-50 hover:bg-pink-100 border border-pink-100 transition group">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-gray-800 group-hover:text-pink-600 transition"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M5 8h14l-1 12H6L5 8z"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9 8V7a3 3 0 016 0v1"/>
                    </svg>

                    <span id="cart-count"
                          class="absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px]
                                 bg-pink-600 text-white text-[10px] font-bold
                                 rounded-full items-center justify-center px-1 shadow-sm">
                        0
                    </span>

                </a>

                {{-- MOBILE MENU BUTTON --}}
                <button id="menuBtn"
                        class="md:hidden inline-flex items-center justify-center w-11 h-11 rounded-full bg-gray-950 text-white hover:bg-pink-600 transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>

                </button>

            </div>

        </div>

    </div>
</nav>

{{-- Push content below navbar --}}
<div class="h-16"></div>

{{-- OVERLAY --}}
<div id="overlay"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-40"></div>

{{-- MOBILE MENU --}}
<div id="mobileMenu"
     class="fixed top-0 right-0 h-full w-[86%] max-w-sm bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50">

    {{-- MOBILE HEADER --}}
    <div class="flex justify-between items-center px-6 h-20 border-b border-pink-100">

        <a href="{{ route('home') }}" class="flex flex-col leading-none" onclick="closeMenuFn()">

            <span class="text-[32px] font-black tracking-tight text-gray-950"
                  style="font-family: 'Playfair Display', serif;">
                Om Ali
            </span>

            <span class="mt-1 text-[10px] tracking-[0.35em] uppercase font-bold text-pink-500">
                Beauty Store
            </span>

        </a>

        <button id="closeMenu"
                class="w-10 h-10 rounded-full bg-pink-50 hover:bg-pink-100 text-gray-900 text-2xl flex items-center justify-center transition">
            &times;
        </button>

    </div>

    {{-- MOBILE LINKS --}}
    <div class="px-6 py-8 space-y-3 text-gray-900 font-semibold"
         style="font-family: 'Inter', sans-serif;">

        <a href="{{ route('home') }}"
           onclick="closeMenuFn()"
           class="flex items-center justify-between px-5 py-4 rounded-2xl bg-pink-50 hover:bg-pink-100 transition">
            <span>Home</span>
            <span class="text-pink-500">→</span>
        </a>

        <a href="{{ route('products.index') }}"
           onclick="closeMenuFn()"
           class="flex items-center justify-between px-5 py-4 rounded-2xl bg-white border border-pink-100 hover:bg-pink-50 transition">
            <span>Shop</span>
            <span class="text-pink-500">→</span>
        </a>

        <a href="#categories"
           onclick="closeMenuFn()"
           class="flex items-center justify-between px-5 py-4 rounded-2xl bg-white border border-pink-100 hover:bg-pink-50 transition">
            <span>Categories</span>
            <span class="text-pink-500">→</span>
        </a>

        <a href="#contact"
           onclick="closeMenuFn()"
           class="flex items-center justify-between px-5 py-4 rounded-2xl bg-white border border-pink-100 hover:bg-pink-50 transition">
            <span>Contact</span>
            <span class="text-pink-500">→</span>
        </a>

        <a href="{{ route('cart.index') }}"
           onclick="closeMenuFn()"
           class="flex items-center justify-center gap-2 mt-6 px-5 py-4 rounded-2xl bg-pink-600 hover:bg-pink-700 text-white transition">
            View Cart
        </a>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const overlay = document.getElementById('overlay');
    const closeMenu = document.getElementById('closeMenu');

    window.closeMenuFn = function () {
        mobileMenu.classList.add('translate-x-full');
        overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openMenu() {
        mobileMenu.classList.remove('translate-x-full');
        overlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    menuBtn?.addEventListener('click', openMenu);
    closeMenu?.addEventListener('click', closeMenuFn);
    overlay?.addEventListener('click', closeMenuFn);
});
</script>