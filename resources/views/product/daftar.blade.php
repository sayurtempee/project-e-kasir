<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.head')
    <title>{{ $title }} | e-Kasir</title>
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    @include('layouts.navbar-2')
    @include('layouts.sidebar')

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-4 text-white">
                DAFTAR PRODUK
            </h1>

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show"
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative">
                    {{ session('error') }}
                    <button @click="show = false"
                        class="absolute top-1 right-2 text-red-700 hover:text-red-900 font-bold" aria-label="Close">
                        &times;
                    </button>
                </div>
            @endif

            <!-- Tombol Tambah Produk -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('product.create') }}"
                    class="font-semibold py-2 px-4 rounded-lg transition duration-300 
                       bg-[#1E3A8A] text-white hover:bg-blue-950 hover:border-black hover:text-black">
                    Tambah Produk
                </a>
            </div>

            <div class="mb-4">
                <form action="{{ route('product.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                        class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button type="submit"
                        class="bg-[#1E3A8A] text-white px-4 py-2 rounded-lg
                               hover:bg-blue-950 hover:text-white transition duration-300">
                        Cari
                    </button>
                    <button type="button" onclick="startBarcodeScanner()"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg 
                        hover:bg-green-800 hover:text-gray-300 transition duration-300 flex items-center space-x-2">
                        <span>Scan Barcode</span>
                    </button>
                </form>
            </div>

            <div id="scanner-container" class="hidden mt-4 p-4">
                <div id="barcode-scanner" class="w-[480px] h-[480px] border rounded mb-4"></div>
            </div>

            <!-- Tabel Daftar Produk -->
            <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                <table class="min-w-full table-auto">
                    <thead class="bg-[#1E3A8A] text-white">
                        <tr>
                            <th class="px-6 py-3 text-left">Gambar</th>
                            <th class="px-6 py-3 text-left">Nama Produk</th>
                            <th class="px-6 py-3 text-left">Nama Kategori</th>
                            <th class="px-6 py-3 text-left">Kode Produk</th>
                            <th class="px-6 py-3 text-left">Barcode</th>
                            <th class="px-6 py-3 text-left">Harga Produk</th>
                            {{--  <th class="px-6 py-3 text-left">Jumlah Stok</th>  --}}
                            <th class="px-6 py-3 text-left">Jumlah Stok</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-6 py-3">
                                    <img src="{{ Storage::url($product->img) }}" alt="{{ $product->name }}"
                                        class="w-16 h-16 object-cover rounded">
                                </td>
                                <td class="px-6 py-3">{{ $product->name }}</td>
                                <td class="px-6 py-3">{{ $product->category->name }}</td>
                                <td class="px-6 py-3">{{ $product->code }}</td>
                                <td class="px-6 py-3">
                                    <svg id="barcode-{{ $product->id }}" class="w-[200px] h-[50px]"></svg>
                                </td>
                                <td class="px-6 py-3">{{ $product->price }}</td>
                                {{--  <td class="px-6 py-3">
                                    <span
                                        class="{{ $product->stock == 0 ? 'text-red-500 font-semibold' : 'text-green-600' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>  --}}
                                <td class="px-6 py-6">
                                    <span
                                        class="{{ $product->stock == 0 ? 'text-red-500 font-semibold' : 'text-green-600' }}">
                                        {{ $product->stock }} {{ $product->stock_unit }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 flex flex-col space-y-1">
                                    <a href="{{ route('product.edit', $product->id) }}"
                                        class="flex items-center justify-center bg-yellow-400 text-black font-semibold px-2 py-1 rounded hover:bg-yellow-500 transition">
                                        <i class="fas fa-edit mr-1 text-base"></i> <span class="text-sm">Edit</span>
                                    </a>
                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus {{ $product->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full flex items-center justify-center 
                                            {{ $product->stock > 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-red-500 hover:bg-red-600' }} 
                                            text-white font-semibold px-2 py-1 rounded transition"
                                            {{ $product->stock > 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-trash-alt mr-1 text-base"></i>
                                            <span class="text-sm">Hapus</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <button type="submit"
                                            class="w-full flex items-center justify-center {{ $product->stock <= 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700' }} text-white font-medium px-3 py-2 rounded transition"
                                            {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-cart-plus mr-2 text-base"></i>
                                            <span class="text-sm">
                                                {{ $product->stock <= 0 ? 'Stok Habis' : 'Keranjang' }}
                                            </span>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($products as $product)
                JsBarcode("#barcode-{{ $product->id }}", "{{ $product->code }}", {
                    format: "CODE128",
                    lineColor: "#000",
                    width: 1.5,
                    height: 40,
                    displayValue: false
                });
            @endforeach
        });

        let html5QrCode;

        function startBarcodeScanner() {
            const scannerContainer = document.getElementById('scanner-container');
            const scannerElement = document.getElementById('barcode-scanner');
            scannerContainer.classList.remove('hidden');

            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: scannerElement,
                    constraints: {
                        facingMode: "environment", // pakai kamera belakang
                        width: {
                            ideal: 480
                        },
                        height: {
                            ideal: 480
                        }
                    }
                },
                locator: {
                    patchSize: "large",
                    halfSample: true
                },
                numOfWorkers: navigator.hardwareConcurrency || 2,
                decoder: {
                    readers: [
                        "code_128_reader",
                        "ean_reader",
                        "ean_8_reader",
                        "upc_reader",
                        "upc_e_reader",
                        "code_39_reader",
                        "code_39_vin_reader",
                        "codabar_reader",
                        "i2of5_reader",
                        "2of5_reader",
                        "code_93_reader"
                    ]
                },
                locate: true
            }, function(err) {
                if (err) {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal menginisialisasi pemindai barcode: ' + err.message,
                    });
                    return;
                }
                Quagga.initialized = true;
                Quagga.start();
            });

            Quagga.onProcessed(() => {
                const preview = document.getElementById('preview');
                if (preview) {
                    preview.querySelectorAll('video, canvas').forEach(el => {
                        el.classList.add('absolute', 'top-0', 'left-0', 'w-full', 'h-full',
                            'object-cover', '[aspect-ratio:1/1]');
                    });
                }
            });

            let scanned = false;
            Quagga.onDetected(function(data) {
                if (scanned) return;

                const barcode = data.codeResult.code;
                if (!barcode || barcode.length !== 13) return; // abaikan jika hasil tidak valid

                scanned = true;
                console.log("Barcode ditemukan:", barcode);
                Quagga.stop();
                scannerContainer.classList.add('hidden');

                // Kirim barcode ke server
                fetch("{{ route('cart.scan') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            barcode: barcode
                        })
                    })
                    .then(response => response.json().then(data => ({
                        status: response.status,
                        body: data
                    })))
                    .then(({
                        status,
                        body
                    }) => {
                        const productIndexUrl = "{{ route('product.index') }}";
                        if (status === 200 && body.message) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: body.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = productIndexUrl;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: body.message ||
                                    'Terjadi kesalahan saat menambahkan produk ke keranjang.',
                            });
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal menambahkan produk ke keranjang.',
                        });
                    });
            });
        }
    </script>
</body>

</html>
