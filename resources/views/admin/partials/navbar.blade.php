<nav class="bg-white border-b border-gray-200 px-4 md:px-6 py-3 flex justify-between items-center shadow-sm fixed top-0 left-0 right-0 z-50">
    <!-- Left side -->
    <div class="flex items-center space-x-3">
        <!-- Hamburger Button (Mobile) -->
        <button id="sidebarToggle" class="md:hidden text-pink-600 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Logo -->
        <h1 class="text-xl md:text-2xl font-bold text-pink-600">Om Ali</h1>
    </div>

    <!-- Center Search (Hidden on mobile) -->
    <div class="hidden md:flex items-center w-1/3 relative">
        <input type="text" placeholder="Search..." 
            class="w-full pl-10 pr-4 py-2 text-sm border border-pink-100 rounded-full bg-pink-50/50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-200 focus:border-pink-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-2.5 h-5 w-5 text-pink-400"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>

    <!-- Right side -->
    <div class="flex items-center space-x-4">
        <!-- Notification Button -->
        <button class="text-pink-500 hover:text-pink-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </button>

        <!-- User Info -->
        <div class="flex items-center space-x-2">
            <span class="hidden sm:inline text-gray-700 text-sm font-medium">
                {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
            </span>
            <div class="w-9 h-9 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 font-bold">
                {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('adminSidebar');
        const toggle = document.getElementById('sidebarToggle');

        if (toggle && sidebar) {
            // ✅ لما الشاشة صغيرة يكون السايدبار مخفي
            if (window.innerWidth < 768) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.add('fixed', 'top-0', 'left-0', 'z-40', 'transition-transform', 'duration-300');
            }

            // ✅ عند الضغط على الزر يظهر أو يختفي
            toggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }

        // ✅ يخفي السايدبار لو الشاشة صغرت فجأة
        window.addEventListener('resize', () => {
            if (window.innerWidth < 768) {
                sidebar.classList.add('-translate-x-full');
            } else {
                sidebar.classList.remove('-translate-x-full');
            }
        });
    });
</script>
