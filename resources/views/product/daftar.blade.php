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

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: @json(session('success')),
                        timer: 3000,
                        showConfirmButton: false
                    });
                </script>
            @endif

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
            @if (auth()->user()->role === 'admin')
                <div class="flex justify-end mb-4">
                    <a href="{{ route('product.create') }}"
                        class="font-semibold py-2 px-4 rounded-lg transition duration-300
                       bg-[#1E3A8A] text-white hover:bg-blue-950 hover:border-black hover:text-black">
                        Tambah Produk
                    </a>
                </div>
            @endif

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
                    @if (auth()->user()->role === 'kasir')
                        <a href="{{ route('member.create') }}"
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-purple-800 transition duration-300 flex items-center gap-2">
                            <i class="fas fa-user-plus"></i>
                            Tambah Member
                        </a>
                    @endif
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
                            <th class="px-6 py-3 text-left">Kategori</th>
                            <th class="px-6 py-3 text-left">Barcode Produk</th>
                            {{--  <th class="px-6 py-3 text-left">Barcode</th>  --}}
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
                                <td class="px-6 py-3">
                                    <button onclick="showBarcodeModal('{{ $product->id }}', '{{ $product->code }}')"
                                        class="text-blue-600 font-bold hover:underline focus:outline-none">
                                        {{ $product->code }}
                                    </button>
                                </td>
                                {{--  <td class="px-6 py-3">
                                    <svg id="barcode-{{ $product->id }}" class="w-[200px] h-[50px]"></svg>
                                </td>  --}}
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
                                    <button type="button" onclick="toggleModal('modalDetail-{{ $product->id }}')"
                                        class="flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-2 py-1 rounded transition w-full">
                                        <i class="fas fa-eye mr-1 text-base"></i>
                                        <span class="text-sm">Lihat</span>
                                    </button>
                                    <!-- Modal Detail Produk -->
                                    <div id="modalDetail-{{ $product->id }}"
                                        class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden items-center justify-center min-h-screen px-4 py-6 overflow-y-auto">

                                        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-8 relative">
                                            <!-- Tombol Close -->
                                            <button onclick="toggleModal('modalDetail-{{ $product->id }}')"
                                                class="absolute top-4 right-4 text-gray-500 hover:text-black text-2xl font-bold">
                                                &times;
                                            </button>

                                            <!-- Judul -->
                                            <h2 class="text-2xl font-semibold text-indigo-600 mb-6 text-center">Detail
                                                Produk</h2>

                                            <!-- Isi Detail Produk -->
                                            <div class="space-y-4 text-base text-gray-800">
                                                <!-- Gambar -->
                                                <div
                                                    class="relative w-[300px] h-[300px] mx-auto group overflow-hidden rounded-xl shadow-md">
                                                    <img src="{{ Storage::url($product->img) }}"
                                                        alt="{{ $product->name }}"
                                                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" />
                                                </div>

                                                <!-- Informasi Produk -->
                                                <div class="space-y-2 px-4">
                                                    <p><strong>Nama Produk:</strong> {{ $product->name }}</p>
                                                    <p><strong>Harga:</strong>
                                                        Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                                    <p><strong>Stok:</strong> {{ $product->stock }}</p>
                                                    <p><strong>Kategori:</strong> {{ $product->category->name ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--  end modal-detail  --}}
                                    @if (auth()->user()->role === 'admin')
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
                                    @endif
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

    <!-- Modal Barcode -->
    <div id="barcodeModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">Barcode Produk</h2>
            <div class="flex justify-center">
                <svg id="modal-barcode" class="w-[250px] h-[80px]"></svg>
            </div>
            <div class="mt-4 text-right">
                <button onclick="closeBarcodeModal()"
                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Tutup
                </button>
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
                fetch("/cart/scan", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            "X-Requested-With": "XMLHttpRequest"
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

        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.toggle('hidden');
                modal.classList.toggle('flex');
            }
        }

        function showBarcodeModal(id, code) {
            // Render barcode baru ke dalam modal
            JsBarcode("#modal-barcode", code, {
                format: "CODE128",
                width: 2,
                height: 80,
                displayValue: true
            });

            // Tampilkan modal
            document.getElementById('barcodeModal').classList.remove('hidden');
        }

        function closeBarcodeModal() {
            document.getElementById('barcodeModal').classList.add('hidden');
        }
    </script>
</body>

</html>
