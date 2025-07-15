<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title><?php echo e($title ?? 'Tambah Kategori'); ?> | e-Kasir</title>
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    <?php echo $__env->make('layouts.navbar-2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4 bg-white rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-6 text-[#1E3A8A] text-center">Tambah Kategori</h1>

            <form action="<?php echo e(route('category.store')); ?>" method="POST" class="space-y-4 w-full">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="name" class="block font-semibold text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan nama kategori" required autofocus />
                </div>

                <div class="flex justify-between">
                    <a href="<?php echo e(route('category.index')); ?>"
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
<?php /**PATH /var/www/html/e-kasir/resources/views/category/add.blade.php ENDPATH**/ ?>