<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Om-Ali</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-pink-50 text-gray-800">
    <nav class="bg-white shadow-md p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-pink-600">Om-Ali 💄</h1>
        <ul class="flex gap-6">
            <li><a href="#" class="hover:text-pink-600">Dashboard</a></li>
            <li><a href="#" class="hover:text-pink-600">Products</a></li>
            <li><a href="#" class="hover:text-pink-600">About</a></li>
            <li><a href="#" class="hover:text-pink-600">Contact</a></li>
        </ul>
    </nav>

    <main class="p-8">
        @yield('content')
    </main>

    <footer class="text-center py-4 bg-white border-t mt-8">
        <p class="text-sm text-gray-500">&copy; 2025 Om-Ali. All rights reserved.</p>
    </footer>
</body>
</html>
