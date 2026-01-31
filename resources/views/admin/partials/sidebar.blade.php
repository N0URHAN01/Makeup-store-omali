<aside id="adminSidebar"
    class="fixed top-20 left-0 md:left-4 h-[calc(100vh-5rem)] w-64 bg-white text-gray-700 space-y-3 py-6 px-4 
           shadow-md rounded-none md:rounded-2xl border border-pink-50 overflow-y-auto 
           transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-40">

    <!-- Logo -->
    <div class="flex items-center space-x-2 px-2 mb-5">
        <div class="w-8 h-8 bg-pink-500 text-white flex items-center justify-center rounded-lg font-bold">O</div>
        <span class="text-xl font-semibold text-pink-600">Om Ali</span>
    </div>

    <!-- Navigation -->
    <nav class="space-y-2">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center space-x-3 py-2.5 px-3 rounded-lg transition duration-200 
                  hover:bg-pink-50 hover:text-pink-600 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.products.index') }}"
           class="flex items-center space-x-3 py-2.5 px-3 rounded-lg transition duration-200 
                  hover:bg-pink-50 hover:text-pink-600 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0H4m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2"/>
            </svg>
            <span>Products</span>
        </a>

        <a href="{{ route('admin.categories.index') }}"
           class="flex items-center space-x-3 py-2.5 px-3 rounded-lg transition duration-200 
                  hover:bg-pink-50 hover:text-pink-600 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M5 13l4 4L19 7"/>
            </svg>
            <span>Categories</span>
        </a>

        <a href="{{ route('admin.orders.index') }}"
           class="flex items-center space-x-3 py-2.5 px-3 rounded-lg transition duration-200 
                  hover:bg-pink-50 hover:text-pink-600 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M5 13l4 4L19 7"/>
            </svg>
            <span>Orders</span>
        </a>

        <a href="{{ route('admin.governorates.index') }}"
           class="flex items-center space-x-3 py-2.5 px-3 rounded-lg transition duration-200 
                  hover:bg-pink-50 hover:text-pink-600 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M11 19a8 8 0 100-16 8 8 0 000 16z"/>
            </svg>
            <span>Governorates</span>
        </a>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Logout
            </button>
        </form>
    </nav>
</aside>
