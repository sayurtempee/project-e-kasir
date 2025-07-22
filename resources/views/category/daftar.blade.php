<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @include('layouts.head')
    <title>{{ $title }} | e-Kasir</title>
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    @include('layouts.navbar-2')
    @include('layouts.sidebar')

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-4 text-white">DAFTAR KATEGORI</h1>

            <!-- Tombol Tambah Kategori -->
            @if (auth()->user()->role === 'admin')
            <div class="flex justify-end mb-4">
                <a href="{{ route('category.create') }}"
                    class="bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-950 hover:text-black transition duration-300">
                    Tambah Kategori
                </a>
            </div>
            @endif

            <!-- Form Pencarian -->
            <div class="mb-4">
                <form action="{{ route('category.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Cari kategori..." value="{{ request('search') }}"
                        class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <input type="hidden" name="tab" value="{{ request('tab') }}" />
                    <button type="submit"
                        class="bg-[#1E3A8A] text-white px-4 py-2 rounded-lg hover:bg-blue-950 transition">
                        Cari
                    </button>
                </form>
            </div>

            @if (session('success'))
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-500 text-white p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto bg-white rounded-lg shadow-lg mb-8">
                <table class="min-w-full table-auto bg-white rounded-lg shadow-lg">
                    <thead class="bg-[#1E3A8A] text-white">
                        <tr>
                            <th class="px-6 py-3 text-left">No</th>
                            <th class="px-6 py-3 text-left">Kategori</th>
                            <th class="px-6 py-3 text-left">Jumlah Produk</th>
                            <th class="px-6 py-3 text-left">Tanggal Input</th>
                            @if (auth()->user()->role === 'admin')
                                <th class="px-6 py-3 text-left">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3">{{ $category->name }}</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="{{ $category->products_count == 0 ? 'text-red-600 font-semibold' : 'text-green-600 font-semibold' }}">
                                        {{ $category->products_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">{{ $category->created_at->format('d-m-Y') }}</td>
                                @if (auth()->user()->role === 'admin')
                                    <td class="px-6 py-3 flex space-x-2">
                                        <a href="{{ route('category.edit', $category->id) }}"
                                            class="flex items-center bg-yellow-400 text-black font-semibold px-2 py-1 rounded hover:bg-yellow-500 transition">
                                            <i class="fas fa-edit mr-1"></i> <span class="text-sm">Edit</span>
                                        </a>
                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $category->name }}?');"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="flex items-center bg-red-500 text-white font-semibold px-2 py-1 rounded hover:bg-red-600 transition">
                                                <i class="fas fa-trash-alt mr-1"></i> <span class="text-sm">Hapus</span>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center px-6 py-4 text-gray-500 italic">Tidak ada
                                    kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
