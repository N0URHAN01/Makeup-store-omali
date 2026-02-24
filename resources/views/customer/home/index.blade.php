<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta charset="UTF-8">
    <title> Home</title>

    @vite('resources/css/app.css')
</head>
<body class="bg-white">

    {{-- Navbar --}}
    @include('customer.home.sections.navbar')

    {{-- Hero --}}
    @include('customer.home.sections.hero')

    {{-- Categories --}}
    @include('customer.home.sections.categories')

    {{-- Products Section --}}
   @include('customer.home.sections.products')

</body>
</html>
