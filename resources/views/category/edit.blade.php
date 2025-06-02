<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @include('layouts.head')
    <title>{{ $title ?? 'Edit Kategori' }} | e-Kasir</title>
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    @include('layouts.navbar-2')
    @include('layouts.sidebar')

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4 bg-white rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-6 text-[#1E3A8A] text-center">Edit Kategori</h1>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-500 text-white rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('category.update', $category->id) }}" method="POST" class="space-y-4 w-full">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block font-semibold text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan nama kategori" required />
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('category.index') }}"
                        class="inline-block bg-gray-400 text-white font-semibold px-4 py-2 rounded-lg hover:bg-gray-500 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-[#1E3A8A] text-white font-bold px-6 py-2 rounded-lg hover:bg-blue-950 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
