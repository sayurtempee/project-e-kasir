<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layouts.head')
    <title>Tambah Diskon | e-Kasir</title>
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    @include('layouts.navbar-2')
    @include('layouts.sidebar')

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-4 text-white">
                TAMBAH DISKON
            </h1>

            <form action="{{ route('discount.store') }}" method="POST">
                @csrf
                <!-- Form fields for discount data -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="diskon-name">NAMA DISKON</label>
                    <input class="w-full p-3 rounded-lg border-none" id="diskon-name" type="text" name="name"
                        placeholder="Nama Diskon">
                </div>

                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="diskon-percentage">BESARAN DISKON
                        (%)</label>
                    <input class="w-full p-3 rounded-lg border-none" id="diskon-percentage" type="number"
                        name="discount_percentage" placeholder="Besaran Diskon">
                </div>

                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="valid-from">TANGGAL BERLAKU</label>
                    <input class="w-full p-3 rounded-lg border-none" id="valid-from" type="date" name="valid_from">
                </div>

                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="valid-until">VALID SAMPAI</label>
                    <input class="w-full p-3 rounded-lg border-none" id="valid-until" type="date" name="valid_until">
                </div>

                {{--  <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="status">STATUS DISKON</label>
                    <select class="w-full px-3 py-2 text-gray-700 bg-white rounded" id="status" name="status">
                        <option value="AKTIF">AKTIF</option>
                        <option value="TIDAK AKTIF">TIDAK AKTIF</option>
                    </select>
                </div>  --}}

                <div class="flex justify-end">
                    <button
                        class="bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-950 hover:text-black transition duration-300"
                        type="submit">SIMPAN</button>
                </div>
            </form>

        </div>
    </div>

</body>

</html>
