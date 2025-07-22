<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title><?php echo e($title); ?> | e-Kasir</title>
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    <?php echo $__env->make('layouts.navbar-2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-4 text-white">DAFTAR KATEGORI</h1>

            <!-- Tombol Tambah Kategori -->
            <?php if(auth()->user()->role === 'admin'): ?>
            <div class="flex justify-end mb-4">
                <a href="<?php echo e(route('category.create')); ?>"
                    class="bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-950 hover:text-black transition duration-300">
                    Tambah Kategori
                </a>
            </div>
            <?php endif; ?>

            <!-- Form Pencarian -->
            <div class="mb-4">
                <form action="<?php echo e(route('category.index')); ?>" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Cari kategori..." value="<?php echo e(request('search')); ?>"
                        class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <input type="hidden" name="tab" value="<?php echo e(request('tab')); ?>" />
                    <button type="submit"
                        class="bg-[#1E3A8A] text-white px-4 py-2 rounded-lg hover:bg-blue-950 transition">
                        Cari
                    </button>
                </form>
            </div>

            <?php if(session('success')): ?>
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="bg-red-500 text-white p-3 rounded mb-4">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <div class="overflow-x-auto bg-white rounded-lg shadow-lg mb-8">
                <table class="min-w-full table-auto bg-white rounded-lg shadow-lg">
                    <thead class="bg-[#1E3A8A] text-white">
                        <tr>
                            <th class="px-6 py-3 text-left">No</th>
                            <th class="px-6 py-3 text-left">Kategori</th>
                            <th class="px-6 py-3 text-left">Jumlah Produk</th>
                            <th class="px-6 py-3 text-left">Tanggal Input</th>
                            <?php if(auth()->user()->role === 'admin'): ?>
                                <th class="px-6 py-3 text-left">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-6 py-3"><?php echo e($loop->iteration); ?></td>
                                <td class="px-6 py-3"><?php echo e($category->name); ?></td>
                                <td class="px-6 py-3">
                                    <span
                                        class="<?php echo e($category->products_count == 0 ? 'text-red-600 font-semibold' : 'text-green-600 font-semibold'); ?>">
                                        <?php echo e($category->products_count); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-3"><?php echo e($category->created_at->format('d-m-Y')); ?></td>
                                <?php if(auth()->user()->role === 'admin'): ?>
                                    <td class="px-6 py-3 flex space-x-2">
                                        <a href="<?php echo e(route('category.edit', $category->id)); ?>"
                                            class="flex items-center bg-yellow-400 text-black font-semibold px-2 py-1 rounded hover:bg-yellow-500 transition">
                                            <i class="fas fa-edit mr-1"></i> <span class="text-sm">Edit</span>
                                        </a>
                                        <form action="<?php echo e(route('category.destroy', $category->id)); ?>" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus <?php echo e($category->name); ?>?');"
                                            class="inline-block">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                class="flex items-center bg-red-500 text-white font-semibold px-2 py-1 rounded hover:bg-red-600 transition">
                                                <i class="fas fa-trash-alt mr-1"></i> <span class="text-sm">Hapus</span>
                                            </button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center px-6 py-4 text-gray-500 italic">Tidak ada
                                    kategori.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/category/daftar.blade.php ENDPATH**/ ?>