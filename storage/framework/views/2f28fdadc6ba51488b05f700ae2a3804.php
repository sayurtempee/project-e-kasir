<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title><?php echo e($title); ?> | e-Kasir</title>
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    <?php echo $__env->make('layouts.navbar-2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-4 text-white">
                TAMBAH PRODUK
            </h1>

            <form action="<?php echo e(route('product.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label for="category_id" class="block text-white text-sm font-bold mb-2">Kategori Produk</label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled <?php echo e(old('category_id') ? '' : 'selected'); ?>>-- Pilih Kategori --
                        </option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="nama-produk">NAMA PRODUK</label>
                    <input class="w-full px-3 py-2 rounded-lg border-none" type="text" id="nama-produk"
                        placeholder="Nama Produk" name="name">
                </div>
                <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="kode-produk">KODE PRODUK</label>
                    <input class="w-full px-3 py-2 rounded-lg border-none" type="text" id="kode-produk"
                        placeholder="Kode Produk" name="code" value="<?php echo e(old('code')); ?>">

                    <div class="mt-4 flex items-start gap-4">
                        <div id="preview"
                            class="relative w-[300px] h-[300px] border border-gray-300 overflow-hidden rounded-md">
                        </div>
                        <svg id="barcode" class="w-[300px] h-[200px]"></svg>
                    </div>

                    <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <div class="mt-4 gap-4">
                        <button id="rescan" type="button"
                            class="mt-2 bg-white text-blue-600 font-bold py-2 px-4 rounded hover:bg-blue-100 hidden">
                            Scan Ulang
                        </button>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="harga-produk">HARGA PRODUK</label>
                    <input class="w-full px-3 py-2 rounded-lg border-none" type="text" id="harga-produk"
                        placeholder="Harga Produk" name="price">
                </div>
                
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="jumlah-produk">JUMLAH PRODUK</label>
                    <div class="flex gap-2">
                        <input class="w-1/2 px-3 py-2 rounded-lg border-none text-gray-800" type="number"
                            id="stock" placeholder="Jumlah Produk" name="stock" value="<?php echo e(old('stock')); ?>">

                        <select name="stock_unit" class="w-1/2 px-3 py-2 rounded-lg border-none text-gray-800">
                            <option value="" disabled <?php echo e(old('stock_unit') ? '' : 'selected'); ?>>Pilih satuan
                            </option>
                            <option value="pcs" <?php echo e(old('stock_unit') == 'pcs' ? 'selected' : ''); ?>>pcs</option>
                            <option value="pack" <?php echo e(old('stock_unit') == 'pack' ? 'selected' : ''); ?>>pack</option>
                            <option value="dus" <?php echo e(old('stock_unit') == 'dus' ? 'selected' : ''); ?>>dus</option>
                            <option value="kg" <?php echo e(old('stock_unit') == 'kg' ? 'selected' : ''); ?>>kg</option>
                            <option value="porsi" <?php echo e(old('stock_unit') == 'porsi' ? 'selected' : ''); ?>>porsi</option>
                            <option value="kaleng" <?php echo e(old('stock_unit') == 'kaleng' ? 'selected' : ''); ?>>kaleng
                            </option>
                        </select>
                    </div>
                    <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-red-200 text-sm mt-1"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php $__errorArgs = ['stock_unit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-red-200 text-sm mt-1"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="nama-produk">GAMBAR PRODUK</label>
                    <input
                        class="w-full px-4 py-3 rounded-lg bg-white text-black placeholder-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200 cursor-pointer"
                        type="file" id="nama-produk" name="img">
                </div>

                <div class="flex justify-end">
                    <button
                        class="bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-950 hover:text-black transition duration-300"
                        type="submit">TAMBAH</button>
                </div>
            </form>
        </div>

        <script>
            const inputKode = document.getElementById('kode-produk');
            const barcode = document.getElementById('barcode');
            const preview = document.getElementById('preview');
            const rescanBtn = document.getElementById('rescan');

            function resizeBarcode() {
                const rect = preview.getBoundingClientRect();
                barcode.setAttribute('width', rect.width);
                barcode.setAttribute('height', rect.height);
            }

            function generateBarcode(value) {
                if (value.trim() !== '') {
                    resizeBarcode();
                    JsBarcode("#barcode", value, {
                        format: "CODE128",
                        lineColor: "#000",
                        width: 2,
                        height: parseInt(barcode.getAttribute('height')) || 100,
                        displayValue: true,
                        fontSize: 16,
                        margin: 10
                    });
                } else {
                    barcode.innerHTML = '';
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                generateBarcode(inputKode.value);
                inputKode.addEventListener('input', () => generateBarcode(inputKode.value));
            });

            // Fungsi Inisialisasi Quagga
            function startScanner() {
                Quagga.init({
                    inputStream: {
                        name: "Live",
                        type: "LiveStream",
                        target: preview,
                        constraints: {
                            facingMode: "environment",
                            width: {
                                ideal: 1280
                            },
                            height: {
                                ideal: 720
                            }
                        }
                    },
                    locator: {
                        patchSize: "large",
                        halfSample: true
                    },
                    frequency: 10,
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
                        console.error("Quagga init error:", err);
                        return;
                    }

                    Quagga.start();
                    Quagga.onProcessed(() => {
                        const preview = document.getElementById('preview');
                        if (preview) {
                            preview.querySelectorAll('video, canvas').forEach(el => {
                                el.classList.add('absolute', 'top-0', 'left-0', 'w-full', 'h-full',
                                    'object-cover', '[aspect-ratio:1/1]');
                            });
                        }
                    });
                    Quagga.onDetected(onDetectedHandler);
                });
            }

            let scanned = false;

            function onDetectedHandler(data) {
                if (scanned) return;

                const code = data.codeResult.code;
                if (!code || code.length !== 13) return;

                scanned = true;
                console.log("Barcode detected:", code);
                inputKode.value = code;
                generateBarcode(code);

                Quagga.offDetected(onDetectedHandler); // matikan handler dulu
                Quagga.stop();
                rescanBtn.classList.remove("hidden");
            }

            if (navigator.mediaDevices && typeof Quagga !== 'undefined') {
                startScanner();

                rescanBtn.addEventListener('click', () => {
                    scanned = false;
                    rescanBtn.classList.add("hidden");
                    startScanner();
                });
            } else {
                alert("Kamera tidak tersedia atau browser tidak mendukung.");
            }
        </script>
</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/product/add.blade.php ENDPATH**/ ?>