<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title><?php echo e($title); ?> | e-Kasir</title>
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    <?php echo $__env->make('layouts.navbar-2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4">
            <div class="mb-6 flex justify-end">
                <a href="<?php echo e(route('admin.index')); ?>"
                    class="inline-flex items-center px-4 py-2 bg-[#1E3A8A] text-white text-sm font-semibold rounded-md
                           hover:bg-blue-950 hover:text-black hover:shadow-lg hover:scale-105 transition-all duration-300">
                    ← Kembali
                </a>
            </div>

            <h1 class="text-3xl font-bold mb-4 text-white">UBAH ADMIN</h1>

            <form action="<?php echo e(route('admin.update', $admin->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Nama -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="name">NAMA</label>
                    <input
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline"
                        id="name" type="text" placeholder="Nama" name="name"
                        value="<?php echo e(old('name') ?? $admin->name); ?>" autofocus
                        <?php if(old('role', $admin->role) != 'kasir' && old('status', $admin->status) == 'tidak aktif'): ?> disabled <?php endif; ?>>
                    <?php $__errorArgs = ['name'];
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

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-bold mb-2 text-white">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo e(old('email', $admin->email)); ?>"
                        class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:ring focus:border-blue-300"
                        <?php if(old('role', $admin->role) != 'kasir' && ($admin->status ?? old('status')) == 'tidak aktif'): ?> disabled <?php endif; ?> required>
                    <?php $__errorArgs = ['email'];
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

                <!-- Status (disabled) -->
                <div class="mb-6">
                    <label for="status" class="block text-white text-sm font-bold mb-2">STATUS</label>
                    <select id="status" name="status" disabled
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline">
                        <option value="aktif" <?php echo e(old('status', $admin->status) == 'aktif' ? 'selected' : ''); ?>>Aktif
                        </option>
                        <option value="tidak aktif"
                            <?php echo e(old('status', $admin->status) == 'tidak aktif' ? 'selected' : ''); ?>>Tidak Aktif
                        </option>
                    </select>
                    <?php $__errorArgs = ['status'];
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

                <!-- Role -->
                <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="role">ROLE</label>
                    <select
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline"
                        id="role" name="role" <?php if(old('status', $admin->status) == 'tidak aktif'): ?> disabled <?php endif; ?>>
                        <option value="admin" <?php echo e((old('role') ?? $admin->role) == 'admin' ? 'selected' : ''); ?>>Admin
                        </option>
                        <option value="kasir" <?php echo e((old('role') ?? $admin->role) == 'kasir' ? 'selected' : ''); ?>>Kasir
                        </option>
                    </select>
                    <?php $__errorArgs = ['role'];
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

                <!-- Foto Profil -->
                <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="photo">FOTO PROFIL</label>

                    <!-- Preview Foto -->
                    <div class="mb-4">
                        <?php if($admin->photo): ?>
                            <img id="photo-preview" src="<?php echo e(asset('storage/' . $admin->photo)); ?>" alt="Foto Profil"
                                class="w-32 h-32 object-cover rounded-full border-2 border-white">
                        <?php else: ?>
                            <?php
                                $name = strtoupper(str_replace(' ', '', $admin->name));
                                $initials = substr($name, 0, 2);
                            ?>
                            <div id="photo-preview"
                                class="w-32 h-32 bg-indigo-500 flex items-center justify-center text-white text-4xl font-bold rounded-full border-2 border-white">
                                <?php echo e($initials); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Input File Custom -->
                    <label for="photo"
                        class="flex items-center justify-center w-full px-4 py-2 bg-white text-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 transition duration-300
                        <?php if(old('role', $admin->role) != 'kasir' && old('status', $admin->status) == 'tidak aktif'): ?> opacity-50 cursor-not-allowed <?php endif; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v4a1 1 0 001 1h3m10-6h2a1 1 0 011 1v10a1 1 0 01-1 1h-2M8 17h8m-6-4v4m0 0l-3-3m3 3l3-3" />
                        </svg>
                        Pilih Foto Baru
                    </label>
                    <input type="file" id="photo" name="photo" accept="image/*" class="hidden"
                        onchange="previewImage(event)" <?php if(old('role', $admin->role) != 'kasir' && old('status', $admin->status) == 'tidak aktif'): ?> disabled <?php endif; ?>>
                    <?php $__errorArgs = ['photo'];
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

                <!-- Tombol Update -->
                <div class="flex justify-end">
                    <button
                        class="bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-950 hover:text-black transition duration-300"
                        type="submit">UPDATE</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photo-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/admin/edit.blade.php ENDPATH**/ ?>