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
            <div class="mb-6 flex justify-end">
                <a href="<?php echo e(route('discount.index')); ?>"
                    class="inline-flex items-center px-4 py-2 bg-[#1E3A8A] text-white text-sm font-semibold rounded-md
                           hover:bg-blue-950 hover:text-black hover:shadow-lg hover:scale-105 transition-all duration-300">
                    ← Kembali
                </a>
            </div>
            <h1 class="text-3xl font-bold mb-4 text-white">
                UBAH DISKON
            </h1>

            <!-- Form Edit Diskon -->
            <form action="<?php echo e(route('discount.update', $discount->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Nama Diskon -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="diskon-name">NAMA DISKON</label>
                    <input class="w-full p-3 rounded-lg border-none" id="diskon-name" type="text" name="name"
                        value="<?php echo e($discount->name); ?>" placeholder="Nama Diskon">
                </div>

                <!-- Besaran Diskon -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="diskon-percentage">BESARAN DISKON
                        (%)</label>
                    <input class="w-full p-3 rounded-lg border-none" id="diskon-percentage" type="number"
                        name="discount_percentage" value="<?php echo e($discount->discount_percentage); ?>"
                        placeholder="Besaran Diskon">
                </div>

                <!-- Tanggal Berlaku -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="valid-from">TANGGAL BERLAKU</label>
                    <input class="w-full p-3 rounded-lg border-none" id="valid-from" type="date" name="valid_from"
                        value="<?php echo e($discount->valid_from); ?>">
                </div>

                <!-- Valid Sampai -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="valid-until">VALID SAMPAI</label>
                    <input class="w-full p-3 rounded-lg border-none" id="valid-until" type="date" name="valid_until"
                        value="<?php echo e($discount->valid_until); ?>">
                </div>

                <!-- Status Diskon -->
                

                <!-- Tombol Ubah -->
                <div class="flex justify-end">
                    <button
                        class="bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-950 hover:text-black transition duration-300"
                        type="submit">UBAH</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/discount/edit.blade.php ENDPATH**/ ?>