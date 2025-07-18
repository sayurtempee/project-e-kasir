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
    <?php echo $__env->make('layouts.alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-4 text-white">
                DAFTAR MEMBER
            </h1>

            <!-- Button Add Member -->
            <div class="flex justify-end mb-4">
                <a href="<?php echo e(route('member.create')); ?>"
                    class="bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-950 hover:text-black transition duration-300">
                    Tambah Member
                </a>
            </div>

            <div class="mb-4">
                <form action="<?php echo e(route('member.index')); ?>" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Cari member..." value="<?php echo e(request('search')); ?>"
                        class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button type="submit"
                        class="bg-[#1E3A8A] text-white px-4 py-2 rounded-lg hover:bg-blue-950 transition">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Member -->
            <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                <table class="min-w-full table-auto">
                    <thead class="bg-[#1E3A8A] text-white">
                        <tr>
                            <th class="px-6 py-3 text-left">No</th>
                            <th class="px-6 py-3 text-left">Nama</th>
                            <th class="px-6 py-3 text-left">No Telpon</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            
                            <th class="px-6 py-3 text-left">Point</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-6 py-3"><?php echo e($index + 1); ?></td>
                                <td class="px-6 py-3"><?php echo e($member->name); ?></td>
                                <td class="px-6 py-3"><?php echo e($member->no_telp); ?></td>
                                <td class="px-6 py-3"><?php echo e($member->email); ?></td>
                                <td class="px-6 py-3">
                                    <span class="<?php echo e($member->status == 'active' ? 'text-green-600' : 'text-red-600'); ?>">
                                        <?php echo e($member->status == 'active' ? 'Aktif' : 'Tidak Aktif'); ?>

                                    </span>
                                </td>
                                
                                <td class="px-6 py-3"><?php echo e($member->point ?? 0); ?></td>
                                <td class="px-6 py-3">
                                    <div class="flex flex-col gap-2 w-28">
                                        <!-- Tombol Edit -->
                                        <a href="<?php echo e(route('member.edit', $member->id)); ?>"
                                            class="flex items-center justify-center gap-1 bg-yellow-400 text-black font-semibold px-3 py-1.5 rounded hover:bg-yellow-500 transition text-sm w-full">
                                            <i class="fas fa-edit text-base"></i> Edit
                                        </a>

                                        <!-- Tombol Aktif/Nonaktif -->
                                        <form action="<?php echo e(route('member.toggleStatus', $member->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit"
                                                class="flex items-center justify-center gap-1 px-3 py-1.5 rounded text-sm w-full font-semibold transition
                <?php echo e($member->status == 'active' ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-green-500 text-white hover:bg-green-600'); ?>">
                                                <?php echo e($member->status == 'active' ? 'Nonaktifkan' : 'Aktifkan'); ?>

                                            </button>
                                        </form>

                                        <!-- Tombol Hapus -->
                                        <?php if($member->status === 'inactive'): ?>
                                            <form action="<?php echo e(route('member.destroy', $member->id)); ?>" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus member <?php echo e($member->name); ?>?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit"
                                                    class="flex items-center justify-center gap-1 bg-red-600 text-white font-semibold px-3 py-1.5 rounded hover:bg-red-700 transition text-sm w-full">
                                                    <i class="fas fa-trash-alt text-base"></i> Hapus
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button disabled
                                                class="flex items-center justify-center gap-1 bg-gray-400 text-white font-semibold px-3 py-1.5 rounded cursor-not-allowed text-sm w-full">
                                                <i class="fas fa-trash-alt text-base"></i> Hapus
                                            </button>
                                        <?php endif; ?>
                                    </div>
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
<?php /**PATH /var/www/html/e-kasir/resources/views/member/daftar.blade.php ENDPATH**/ ?>