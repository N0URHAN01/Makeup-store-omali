<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Om Ali</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-pink-50 text-gray-800">

    <div class="min-h-screen flex flex-col">
        <header class="bg-pink-600 text-white p-4 text-center text-2xl font-bold">
            Om Ali Beauty Store
        </header>

        <main class="flex-1">
            @yield('content')
        </main>

        <footer class="bg-gray-900 text-white p-4 text-center">
            &copy; 2025 Om Ali. All rights reserved.
        </footer>
    </div>

    @vite('resources/js/app.js')
</body>
</html>
