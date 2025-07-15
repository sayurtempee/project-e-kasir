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
            <!-- Tombol Kembali -->
            <div class="mb-6 flex justify-end">
                <a href="<?php echo e(route('product.index')); ?>"
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
            <form action="<?php echo e(route('product.update', $product->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Upload Gambar Produk -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="product-image">UPLOAD GAMBAR</label>
                    <input class="w-full p-3 rounded-lg border-none bg-white text-black" id="gambar-image"
                        type="file" name="img" accept="image/*" value="<?php echo e($product->img); ?>">
                    <?php if($product->img): ?>
                        <img src="<?php echo e(Storage::url($product->img)); ?>" alt="<?php echo e($product->name); ?>"
                            class="mt-2 w-32 h-32 object-cover">
                    <?php endif; ?>
                </div>

                <!-- Nama Produk -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="nama-produk">NAMA PRODUK</label>
                    <input class="w-full p-3 rounded-lg border-none" id="nama-produk" type="text"
                        placeholder="Nama Produk" name="name" value="<?php echo e($product->name); ?>">
                </div>

                <!-- Kategori -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="category_id">KATEGORI</label>
                    <select name="category_id" id="category_id" class="w-full p-3 rounded-lg border-none" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>"
                                <?php echo e(old('category_id', $product->category_id) == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Kode Produk -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="kode-produk">KODE PRODUK</label>
                    <input class="w-full p-3 rounded-lg border-none" id="kode-produk" type="text"
                        placeholder="Kode Produk" name="code" value="<?php echo e(old('code', $product->code)); ?>">
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
                </div>

                
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="kode-barcode">BARCODE</label>
                    <div class="barcode-container">
                        <svg id="barcode-<?php echo e($product->id); ?>" class="barcode-svg"></svg>
                    </div>
                </div>

                <!-- Harga Produk -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="harga-produk">HARGA PRODUK</label>
                    <input class="w-full p-3 rounded-lg border-none" id="harga-produk" type="text"
                        placeholder="Harga Produk" name="price" value="<?php echo e($product->price); ?>">
                </div>

                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="stock">JUMLAH PRODUK</label>
                    <div class="flex gap-2">
                        <input class="w-1/2 px-3 py-2 rounded-lg border-none text-gray-800" type="number"
                            id="stock" name="stock" placeholder="Jumlah Produk"
                            value="<?php echo e(old('stock', $product->stock)); ?>">

                        <select name="stock_unit" class="w-1/2 px-3 py-2 rounded-lg border-none text-gray-800">
                            <option value="" disabled
                                <?php echo e(old('stock_unit', $product->stock_unit) ? '' : 'selected'); ?>>Pilih satuan</option>
                            <option value="pcs"
                                <?php echo e(old('stock_unit', $product->stock_unit) == 'pcs' ? 'selected' : ''); ?>>pcs</option>
                            <option value="pack"
                                <?php echo e(old('stock_unit', $product->stock_unit) == 'pack' ? 'selected' : ''); ?>>pack</option>
                            <option value="dus"
                                <?php echo e(old('stock_unit', $product->stock_unit) == 'dus' ? 'selected' : ''); ?>>dus</option>
                            <option value="kg"
                                <?php echo e(old('stock_unit', $product->stock_unit) == 'kg' ? 'selected' : ''); ?>>kg</option>
                            <option value="porsi"
                                <?php echo e(old('stock_unit', $product->stock_unit) == 'porsi' ? 'selected' : ''); ?>>porsi
                            </option>
                            <option value="kaleng"
                                <?php echo e(old('stock_unit', $product->stock_unit) == 'kaleng' ? 'selected' : ''); ?>>kaleng
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
            JsBarcode("#barcode-<?php echo e($product->id); ?>", "<?php echo e($product->code); ?>", {
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
<?php /**PATH /var/www/html/e-kasir/resources/views/product/edit.blade.php ENDPATH**/ ?>