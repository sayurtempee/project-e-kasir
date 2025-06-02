<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Invoice Pembelian')</title>
    @include('layouts.head')
</head>

<body class="bg-[#3B82F6] text-black">
    <div class="min-h-screen p-4">
        @yield('content')
    </div>
</body>

</html>
