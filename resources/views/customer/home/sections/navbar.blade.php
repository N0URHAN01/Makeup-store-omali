<nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-pink-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between items-center h-16">

            {{-- Logo --}}
            <a href="{{ route('home') ?? '#' }}"
               class="flex items-center gap-2 select-none">
                <span class="text-2xl font-extrabold tracking-tight text-gray-900">
                    Om
                </span>
                <span class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-pink-500 to-fuchsia-500 bg-clip-text text-transparent">
                    Ali
                </span>
            </a>

            {{-- Desktop Links --}}
            <div class="hidden md:flex items-center gap-10 text-gray-700 font-semibold">
                <a href="{{ route('home') ?? '#' }}" class="relative hover:text-pink-600 transition">
                    Home
                    <span class="absolute -bottom-2 left-0 w-0 h-[2px] bg-pink-500 transition-all duration-300 group-hover:w-full"></span>
                </a>

                <a href="#" class="hover:text-pink-600 transition">Shop</a>
                <a href="#categories" class="hover:text-pink-600 transition">Categories</a>
                <a href="#" class="hover:text-pink-600 transition">Contact</a>
            </div>

            {{-- Actions --}}
            <!-- <div class="flex items-center gap-3">
                {{-- Cart --}}
                <button class="relative inline-flex items-center justify-center w-10 h-10 rounded-full bg-pink-50 hover:bg-pink-100 transition">
                    <span class="text-lg">🛍️</span>
                    <span class="absolute -top-1 -right-1 bg-pink-600 text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full font-bold">
                        0
                    </span>
                </button> -->
                <a href="{{ route('cart.index') }}" class="relative inline-flex items-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800"
         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M5 8h14l-1 12H6L5 8z"/>
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M9 8V7a3 3 0 016 0v1"/>
    </svg>

    <span id="cart-count"
          class="absolute -top-2 -right-2 bg-pink-600 text-white
                 text-[10px] font-bold rounded-full px-1.5 py-0.5">
        0
    </span>
</a>

                {{-- Mobile Menu Button --}}
                <button id="menuBtn" class="md:hidden w-10 h-10 rounded-full bg-gray-50 hover:bg-gray-100 transition text-xl">
                    ☰
                </button>
            </div>

        </div>
    </div>
</nav>

{{-- Push content below navbar --}}
<div class="h-16"></div>

{{-- Overlay --}}
<div id="overlay" class="fixed inset-0 bg-black/40 hidden z-40"></div>

{{-- Mobile Slide Menu --}}
<div id="mobileMenu"
     class="fixed top-0 right-0 h-full w-[85%] max-w-sm bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50">

    <div class="flex justify-between items-center px-6 h-16 border-b">
        <span class="text-lg font-bold text-gray-900">Menu</span>
        <button id="closeMenu" class="text-2xl text-gray-700">&times;</button>
    </div>

    <div class="px-6 py-8 space-y-6 text-gray-800 font-semibold">
        <a href="{{ route('home') ?? '#' }}" class="block hover:text-pink-600 transition">Home</a>
        <a href="#" class="block hover:text-pink-600 transition">Shop</a>
        <a href="#categories" class="block hover:text-pink-600 transition" onclick="closeMenuFn()">Categories</a>
        <a href="#" class="block hover:text-pink-600 transition">Contact</a>
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
