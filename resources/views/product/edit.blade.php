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
            <!-- Tombol Kembali -->
            <div class="mb-6 flex justify-end">
                <a href="{{ route('product.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-[#1E3A8A] text-white text-sm font-semibold rounded-md
                           hover:bg-blue-950 hover:text-blue-800 hover:shadow-lg hover:scale-105 transition-all duration-300">
                    ← Kembali
                </a>
            </div>

            <!-- Judul Halaman -->
            <h1 class="text-3xl font-bold mb-4 text-white">
                UBAH PRODUK
            </h1>

            <!-- Form Update Produk -->
            <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Upload Gambar Produk -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="product-image">UPLOAD GAMBAR</label>
                    <input class="w-full p-3 rounded-lg border-none bg-white text-black" id="gambar-image"
                        type="file" name="img" accept="image/*" value="{{ $product->img }}">
                    @if ($product->img)
                        <img src="{{ Storage::url($product->img) }}" alt="{{ $product->name }}"
                            class="mt-2 w-32 h-32 object-cover">
                    @endif
                </div>

                <!-- Nama Produk -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="nama-produk">NAMA PRODUK</label>
                    <input class="w-full p-3 rounded-lg border-none" id="nama-produk" type="text"
                        placeholder="Nama Produk" name="name" value="{{ $product->name }}">
                </div>

                <!-- Kategori -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="category_id">KATEGORI</label>
                    <select name="category_id" id="category_id" class="w-full p-3 rounded-lg border-none" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Kode Produk -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="kode-produk">KODE PRODUK</label>
                    <input class="w-full p-3 rounded-lg border-none" id="kode-produk" type="text"
                        placeholder="Kode Produk" name="code" value="{{ old('code', $product->code) }}">
                    @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{--  Barcode Batang  --}}
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="kode-barcode">BARCODE</label>
                    <div class="barcode-container">
                        <svg id="barcode-{{ $product->id }}" class="barcode-svg"></svg>
                    </div>
                </div>

                <!-- Harga Produk -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="harga-produk">HARGA PRODUK</label>
                    <input class="w-full p-3 rounded-lg border-none" id="harga-produk" type="text"
                        placeholder="Harga Produk" name="price" value="{{ $product->price }}">
                </div>

                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="stock">JUMLAH PRODUK</label>
                    <div class="flex gap-2">
                        <input class="w-1/2 px-3 py-2 rounded-lg border-none text-gray-800" type="number"
                            id="stock" name="stock" placeholder="Jumlah Produk"
                            value="{{ old('stock', $product->stock) }}">

                        <select name="stock_unit" class="w-1/2 px-3 py-2 rounded-lg border-none text-gray-800">
                            <option value="" disabled
                                {{ old('stock_unit', $product->stock_unit) ? '' : 'selected' }}>Pilih satuan</option>
                            <option value="pcs"
                                {{ old('stock_unit', $product->stock_unit) == 'pcs' ? 'selected' : '' }}>pcs</option>
                            <option value="pack"
                                {{ old('stock_unit', $product->stock_unit) == 'pack' ? 'selected' : '' }}>pack</option>
                            <option value="dus"
                                {{ old('stock_unit', $product->stock_unit) == 'dus' ? 'selected' : '' }}>dus</option>
                            <option value="kg"
                                {{ old('stock_unit', $product->stock_unit) == 'kg' ? 'selected' : '' }}>kg</option>
                            <option value="porsi"
                                {{ old('stock_unit', $product->stock_unit) == 'porsi' ? 'selected' : '' }}>porsi
                            </option>
                            <option value="kaleng"
                                {{ old('stock_unit', $product->stock_unit) == 'kaleng' ? 'selected' : '' }}>kaleng
                            </option>
                        </select>
                    </div>
                    @error('stock')
                        <div class="text-red-200 text-sm mt-1">{{ $message }}</div>
                    @enderror
                    @error('stock_unit')
                        <div class="text-red-200 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end">
                    <button
                        class="bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-950 hover:text-black transition duration-300"
                        type="submit">UBAH</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            JsBarcode("#barcode-{{ $product->id }}", "{{ $product->code }}", {
                format: "CODE128",
                lineColor: "#000",
                width: 1.5,
                height: 40,
                displayValue: false
            });
        });
    </script>
</body>

</html>
