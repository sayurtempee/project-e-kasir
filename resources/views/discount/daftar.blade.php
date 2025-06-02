<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layouts.head')
    <title>{{ $title }} | e-Kasir</title>
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    @include('layouts.navbar-2')
    @include('layouts.sidebar')

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-4 text-white">
                KELOLA DISKON
            </h1>

            <!-- Tombol Tambah Diskon -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('discount.create') }}"
                    class="bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-950 hover:text-black transition duration-300">
                    Tambah Diskon
                </a>
            </div>

            <!-- Form Pencarian Diskon -->
            <div class="mb-4">
                <form action="{{ route('discount.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Cari diskon..." value="{{ request('search') }}"
                        class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button type="submit"
                        class="bg-[#1E3A8A] text-white px-4 py-2 rounded-lg hover:bg-blue-950 transition">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Tabel Diskon -->
            <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                <table class="min-w-full table-auto">
                    <thead class="bg-[#1E3A8A] text-white">
                        <tr>
                            <th class="px-6 py-3 text-left">Nama Diskon</th>
                            <th class="px-6 py-3 text-left">Besaran Diskon</th>
                            <th class="px-6 py-3 text-left">Tanggal Berlaku</th>
                            <th class="px-6 py-3 text-left">Berlaku Sampai</th>
                            <th class="px-6 py-3 text-left">Status Otomatis</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($discounts as $discount)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-6 py-3">{{ $discount->name }}</td>
                                <td class="px-6 py-3">{{ $discount->discount_percentage }}%</td>
                                <td class="px-6 py-3">{{ $discount->valid_from }}</td>
                                <td class="px-6 py-3">{{ $discount->valid_until ?? '-' }}</td>
                                <td class="px-6 py-3">
                                    @if ($discount->valid_until && \Carbon\Carbon::parse($discount->valid_until)->isPast())
                                        <span class="text-red-600 font-semibold">KADALUARSA</span>
                                    @else
                                        <span class="text-green-500 font-semibold">MASIH BERLAKU</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 flex space-x-4">
                                    <a href="{{ route('discount.edit', $discount->id) }}"
                                        class="flex items-center justify-center bg-yellow-400 text-black font-semibold px-2 py-1 rounded hover:bg-yellow-500 transition">
                                        <i class="fas fa-edit mr-1 text-base"></i> <span class="text-sm">Edit</span>
                                    </a>
                                    <form action="{{ route('discount.destroy', $discount->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus diskon {{ $discount->name }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full flex items-center justify-center bg-red-500 text-white font-semibold px-2 py-1 rounded hover:bg-red-600 transition">
                                            <i class="fas fa-trash-alt mr-1 text-base"></i> <span
                                                class="text-sm">Hapus</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
