<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @include('layouts.head')
    <title>{{ $title }} | e-Kasir</title>
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    @include('layouts.navbar-2')
    @include('layouts.sidebar')

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-4 text-white">
                TAMBAH MEMBER
            </h1>

            @if ($errors->any())
                <div class="mb-4 bg-red-200 text-red-700 p-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('member.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="nama">NAMA</label>
                    <input
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline"
                        id="nama" type="text" placeholder="Nama" name="name" autofocus
                        value="{{ old('name') }}">
                </div>
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="no-telpon">NO TELPON</label>
                    <input
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline"
                        id="no-telpon" type="text" name="no_telp" placeholder="No Telpon"
                        value="{{ old('no_telp') }}">
                </div>
                <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="email">EMAIL</label>
                    <input
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline"
                        id="email" type="email" placeholder="Email" name="email" value="{{ old('email') }}">
                </div>

                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="status">STATUS</label>
                    <select name="status" id="status"
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif
                        </option>
                    </select>
                </div>

                <!-- Input Diskon -->
                {{--  <div class="mb-6">
                    <label for="discount_percentage" class="block text-white text-sm font-bold mb-2">Diskon (%)</label>
                    <input type="number" name="discount_percentage" id="discount_percentage" min="0"
                        max="100" value="{{ old('discount_percentage', 0) }}"
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline"
                        placeholder="Masukkan persentase diskon (0-100)">
                </div>  --}}

                <div class="flex justify-end">
                    <button
                        class="bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-950 hover:text-black transition duration-300"
                        type="submit">TAMBAH</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
