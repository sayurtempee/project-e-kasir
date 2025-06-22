<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title><?php echo e($title); ?> | e-Kasir</title>
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    <?php echo $__env->make('layouts.navbar-2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-4 text-white">
                DAFTAR PRODUK
            </h1>

            <?php if(session('error')): ?>
                <div x-data="{ show: true }" x-show="show"
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative">
                    <?php echo e(session('error')); ?>

                    <button @click="show = false"
                        class="absolute top-1 right-2 text-red-700 hover:text-red-900 font-bold" aria-label="Close">
                        &times;
                    </button>
                </div>
            <?php endif; ?>

            <!-- Tombol Tambah Produk -->
            <div class="flex justify-end mb-4">
                <a href="<?php echo e(route('product.create')); ?>"
                    class="font-semibold py-2 px-4 rounded-lg transition duration-300
                       bg-[#1E3A8A] text-white hover:bg-blue-950 hover:border-black hover:text-black">
                    Tambah Produk
                </a>
            </div>

            <div class="mb-4">
                <form action="<?php echo e(route('product.index')); ?>" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Cari produk..." value="<?php echo e(request('search')); ?>"
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
                            
                            <th class="px-6 py-3 text-left">Jumlah Stok</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-6 py-3">
                                    <img src="<?php echo e(Storage::url($product->img)); ?>" alt="<?php echo e($product->name); ?>"
                                        class="w-16 h-16 object-cover rounded">
                                </td>
                                <td class="px-6 py-3"><?php echo e($product->name); ?></td>
                                <td class="px-6 py-3"><?php echo e($product->category->name); ?></td>
                                <td class="px-6 py-3"><?php echo e($product->code); ?></td>
                                <td class="px-6 py-3">
                                    <svg id="barcode-<?php echo e($product->id); ?>" class="w-[200px] h-[50px]"></svg>
                                </td>
                                <td class="px-6 py-3"><?php echo e($product->price); ?></td>
                                
                                <td class="px-6 py-6">
                                    <span
                                        class="<?php echo e($product->stock == 0 ? 'text-red-500 font-semibold' : 'text-green-600'); ?>">
                                        <?php echo e($product->stock); ?> <?php echo e($product->stock_unit); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-3 flex flex-col space-y-1">
                                    <button type="button" onclick="toggleModal('modalDetail-<?php echo e($product->id); ?>')"
                                        class="flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-2 py-1 rounded transition w-full">
                                        <i class="fas fa-eye mr-1 text-base"></i>
                                        <span class="text-sm">Lihat</span>
                                    </button>
                                    <!-- Modal Detail Produk -->
                                    <div id="modalDetail-<?php echo e($product->id); ?>"
                                        class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden items-center justify-center min-h-screen px-4 py-6 overflow-y-auto">

                                        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-8 relative">
                                            <!-- Tombol Close -->
                                            <button onclick="toggleModal('modalDetail-<?php echo e($product->id); ?>')"
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
                                                    <img src="<?php echo e(Storage::url($product->img)); ?>"
                                                        alt="<?php echo e($product->name); ?>"
                                                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" />
                                                </div>

                                                <!-- Informasi Produk -->
                                                <div class="space-y-2 px-4">
                                                    <p><strong>Nama Produk:</strong> <?php echo e($product->name); ?></p>
                                                    <p><strong>Harga:</strong>
                                                        Rp<?php echo e(number_format($product->price, 0, ',', '.')); ?></p>
                                                    <p><strong>Stok:</strong> <?php echo e($product->stock); ?></p>
                                                    <p><strong>Kategori:</strong> <?php echo e($product->category->name ?? '-'); ?>

                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <a href="<?php echo e(route('product.edit', $product->id)); ?>"
                                        class="flex items-center justify-center bg-yellow-400 text-black font-semibold px-2 py-1 rounded hover:bg-yellow-500 transition">
                                        <i class="fas fa-edit mr-1 text-base"></i> <span class="text-sm">Edit</span>
                                    </a>
                                    <form action="<?php echo e(route('product.destroy', $product->id)); ?>" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus <?php echo e($product->name); ?>?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                            class="w-full flex items-center justify-center
                                            <?php echo e($product->stock > 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-red-500 hover:bg-red-600'); ?>

                                            text-white font-semibold px-2 py-1 rounded transition"
                                            <?php echo e($product->stock > 0 ? 'disabled' : ''); ?>>
                                            <i class="fas fa-trash-alt mr-1 text-base"></i>
                                            <span class="text-sm">Hapus</span>
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('cart.store')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="id" value="<?php echo e($product->id); ?>">
                                        <button type="submit"
                                            class="w-full flex items-center justify-center <?php echo e($product->stock <= 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700'); ?> text-white font-medium px-3 py-2 rounded transition"
                                            <?php echo e($product->stock <= 0 ? 'disabled' : ''); ?>>
                                            <i class="fas fa-cart-plus mr-2 text-base"></i>
                                            <span class="text-sm">
                                                <?php echo e($product->stock <= 0 ? 'Stok Habis' : 'Keranjang'); ?>

                                            </span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                JsBarcode("#barcode-<?php echo e($product->id); ?>", "<?php echo e($product->code); ?>", {
                    format: "CODE128",
                    lineColor: "#000",
                    width: 1.5,
                    height: 40,
                    displayValue: false
                });
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
                        const productIndexUrl = "<?php echo e(route('product.index')); ?>";
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
    </script>
</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/product/daftar.blade.php ENDPATH**/ ?>