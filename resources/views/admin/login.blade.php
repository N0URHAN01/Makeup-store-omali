<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Om Ali - Admin Login</title>
    @vite('resources/css/app.css')
    <link href="https://unpkg.com/lucide-static@latest/font/lucide.css" rel="stylesheet">
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-pink-50 via-pink-100 to-pink-200 px-4">

    <div class="bg-white/95 shadow-2xl rounded-2xl p-6 w-full max-w-[360px] border border-pink-100 transition-all duration-300 hover:shadow-pink-200">
        <!-- Header -->
        <h1 class="text-center text-2xl font-extrabold text-pink-600 mb-1 tracking-tight">Om Ali</h1>
        <h2 class="text-center text-sm font-semibold text-gray-700 mb-6">Admin Login</h2>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-pink-600 mb-1">Email</label>
                <div class="relative">
                    <i class="lucide lucide-mail absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                    <input type="email" name="email"
                        class="w-full pl-9 pr-3 py-2 border border-pink-200 rounded-lg bg-pink-50/40 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 placeholder:text-gray-400 text-gray-700 transition"
                        placeholder="admin@example.com" required>
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-semibold text-pink-600 mb-1">Password</label>
                <div class="relative">
                    <i class="lucide lucide-lock absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                    <input type="password" name="password" id="password"
                        class="w-full pl-9 pr-9 py-2 border border-pink-200 rounded-lg bg-pink-50/40 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 placeholder:text-gray-400 text-gray-700 transition"
                        placeholder="••••••••" required>
                    <i id="togglePassword"
                       class="lucide lucide-eye absolute right-3 top-2.5 text-gray-500 cursor-pointer text-sm transition hover:text-pink-500"></i>
                </div>
            </div>

            <!-- Button -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-pink-600 text-white py-2.5 rounded-xl hover:bg-pink-700 transition-all duration-200 shadow-md font-medium tracking-wide">
                    <i class="lucide lucide-log-in"></i>
                    <span>Login</span>
                </button>
            </div>
        </form>

        <!-- Footer -->
        <p class="text-center text-xs text-gray-400 mt-8">
            © 2025 Om Ali Admin Panel
        </p>
    </div>

    <!-- Toggle Password Script -->
    <script>
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");

        togglePassword.addEventListener("click", () => {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            togglePassword.classList.toggle("lucide-eye");
            togglePassword.classList.toggle("lucide-eye-off");
        });
    </script>

</body>
</html>
