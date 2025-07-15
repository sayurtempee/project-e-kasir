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
                <a href="<?php echo e(route('member.index')); ?>"
                    class="inline-flex items-center px-4 py-2 bg-[#1E3A8A] text-white text-sm font-semibold rounded-md
                           hover:bg-blue-950 hover:text-black hover:shadow-lg hover:scale-105 transition-all duration-300">
                    ← Kembali
                </a>
            </div>

            <h1 class="text-3xl font-bold mb-4 text-white">
                UBAH MEMBER
            </h1>

            <!-- Form Edit Member -->
            <form action="<?php echo e(route('member.update', $member->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="name">NAMA</label>
                    <input
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline"
                        id="name" type="text" placeholder="Nama" name="name"
                        value="<?php echo e(old('name', $member->name)); ?>" autofocus>
                </div>
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="no-telp">NO TELPON</label>
                    <input
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline"
                        id="no-telp" type="text" placeholder="No Telpon" name="no_telp" readonly
                        value="<?php echo e(old('no_telp', $member->no_telp)); ?>">
                </div>
                <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="email">EMAIL</label>
                    <input
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline"
                        id="email" type="email" placeholder="Email" name="email"
                        value="<?php echo e(old('email', $member->email)); ?>">
                </div>
                <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="status">STATUS</label>
                    <select name="status" id="status"
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline">
                        <option value="active" <?php echo e(old('status') == 'active' ? 'selected' : ''); ?>>Aktif</option>
                        <option value="inactive" <?php echo e(old('status') == 'inactive' ? 'selected' : ''); ?>>Tidak Aktif
                        </option>
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="point">POIN</label>
                    <input class="w-full px-3 py-2 text-gray-700 rounded-lg focus:outline-none focus:shadow-outline"
                        id="point" name="point" type="number" min="0" max="100"
                        placeholder="Masukkan poin member" value="<?php echo e(old('point', $member->point ?? 0)); ?>" readonly>
                </div>
                <div class="flex justify-end">
                    <button
                        class="bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-950 hover:text-black transition duration-300"
                        type="submit">UPDATE</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/member/edit.blade.php ENDPATH**/ ?>