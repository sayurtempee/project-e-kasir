<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | e-Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">  --}}
    @include('layouts.head')
</head>

<body>
    @include('layouts.navbar-1')
    <div class="relative w-full h-full justify-center" x-data>
        <img src="{{ asset('img/bg.jpg') }}" alt="A blue cup filled with coffee on a blue background"
            class="absolute inset-0 w-full h-full object-cover" />
        <div class="relative z-10 flex flex-col md:flex-row items-center p-6 md:p-12">
            <div class="text-left p-6 md:p-12">
                <h2 class="text-lg font-bold text-blue-950">KASIR-SEKOLAH</h2>
                <h1 class="text-4xl md:text-6xl font-bold text-blue-900">#KasirPintar</h1>
                <h1 class="text-4xl md:text-6xl font-bold text-blue-900">#SekolahDigital</h1>
                <p class="text-md md:text-lg text-blue-600 mt-4">"Kasir Sekolah Mudah & Cepat, Transaksi Jadi Tepat!"
            </div>
        </div>
    </div>

    @include('layouts.footer')
</body>

</html>
