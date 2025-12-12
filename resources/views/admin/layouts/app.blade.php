<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen">

        {{-- ✅ Sidebar --}}
        @include('admin.partials.sidebar')

        <div class="flex-1 flex flex-col">

            {{-- ✅ Navbar --}}
            @include('admin.partials.navbar')

            {{-- ✅ Main Content --}}
            <!-- <main class="ml-72 mt-8 p-20 transition-all"> -->
                <main class="flex-1 mt-20 md:mt-24 md:ml-72 p-4 sm:p-6 lg:p-10 transition-all">

                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>
