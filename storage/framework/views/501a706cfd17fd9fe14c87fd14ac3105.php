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
                DAFTAR ADMIN
            </h1>

            <?php if($users->isEmpty()): ?>
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Belum ada admin terdaftar.</td>
                </tr>
            <?php endif; ?>

            <!-- Button Tambah Admin -->
            <div class="flex justify-end mb-4">
                <a href="<?php echo e(route('admin.create')); ?>"
                    class="bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-950 hover:text-black transition duration-300">
                    Tambah Admin
                </a>
            </div>

            <div class="mb-4">
                <form action="<?php echo e(route('admin.index')); ?>" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Cari admin..." value="<?php echo e(request('search')); ?>"
                        class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button type="submit"
                        class="bg-[#1E3A8A] text-white px-4 py-2 rounded-lg hover:bg-blue-950 transition">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Admin -->
            <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                <table class="min-w-full table-auto">
                    <thead class="bg-[#1E3A8A] text-white">
                        <tr>
                            <th class="px-6 py-3 text-left">No</th>
                            <th class="px-6 py-3 text-left">Foto</th>
                            <th class="px-6 py-3 text-left">Nama</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Role</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-6 py-3"><?php echo e($index + 1); ?></td>
                                <td class="px-6 py-3">
                                    <?php if($admin->photo): ?>
                                        <img src="<?php echo e(asset('storage/' . $admin->photo)); ?>"
                                            alt="Foto <?php echo e($admin->name); ?>" class="w-10 h-10 rounded-full object-cover">
                                    <?php else: ?>
                                        <div
                                            class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-semibold">
                                            N/A
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-3"><?php echo e($admin->name); ?></td>
                                <td class="px-6 py-3"><?php echo e($admin->email); ?></td>
                                <td class="px-6 py-3">
                                    <span
                                        class="<?php echo e($admin->status === 'aktif' ? 'text-green-500 font-semibold' : 'text-red-500 font-semibold'); ?>">
                                        <?php echo e(ucfirst($admin->status)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-3"><?php echo e($admin->role); ?></td>
                                <td class="px-6 py-3 flex space-x-4">
                                    <a href="<?php echo e(route('admin.edit', $admin->id)); ?>"
                                        class="flex items-center justify-center bg-yellow-400 text-black font-semibold px-2 py-1 rounded hover:bg-yellow-500 transition">
                                        <i class="fas fa-edit mr-1 text-base"></i> <span class="text-sm">Edit</span>
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <?php if($admin->role === 'admin'): ?>
                                        <?php if(auth()->id() === $admin->id): ?>
                                            
                                            <form action="<?php echo e(route('admin.destroy', $admin->id)); ?>" method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('Yakin ingin menghapus akun Anda <?php echo e($admin->name); ?>?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</button>
                                            </form>
                                        <?php else: ?>
                                            <button type="button"
                                                class="bg-red-300 text-white px-3 py-1 rounded cursor-not-allowed opacity-60"
                                                disabled>Hapus</button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        
                                        <form action="<?php echo e(route('admin.destroy', $admin->id)); ?>" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Yakin ingin menghapus kasir <?php echo e($admin->name); ?> ini?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/admin/daftar.blade.php ENDPATH**/ ?>