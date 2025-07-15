<head>
    
    <?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="min-h-screen bg-[#3B82F6] py-10 px-4">
        <div class="mb-6 flex justify-end">
            <a href="<?php echo e(url()->previous()); ?>"
                class="inline-flex items-center px-4 py-2 bg-[#1E3A8A] text-white text-sm font-semibold rounded-md
                       hover:bg-blue-950 hover:shadow-lg hover:scale-105 transition-all duration-300 ease-in-out">
                ← Kembali
            </a>
        </div>

        <div
            class="max-w-3xl mx-auto bg-blue-950 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300">
            <h1 class="text-4xl font-bold text-white text-center mb-12 animate__animated animate__fadeIn">Edit Profil
            </h1>

            <form method="POST" action="<?php echo e(route('user.update')); ?>" enctype="multipart/form-data" class="space-y-8">
                
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Foto Profil -->
                <div class="mb-6 flex flex-col items-center space-y-4">
                    <div class="w-40 h-40 rounded-full overflow-hidden bg-gray-300" id="preview-container">
                        <?php if($user->photo): ?>
                            <img id="preview-image" src="<?php echo e(asset('storage/' . $user->photo)); ?>" alt="Profile Photo"
                                class="w-full h-full object-cover">
                        <?php else: ?>
                            <?php
                                $name = strtoupper(str_replace(' ', '', Auth::user()->name));
                                $initials = substr($name, 0, 2);
                            ?>
                            <div
                                class="w-full h-full bg-indigo-500 flex items-center justify-center text-white text-7xl font-bold rounded-full">
                                <?php echo e($initials); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="flex flex-col items-center space-y-2">
                        <label class="block text-sm font-medium text-white">Ganti Foto Profil</label>
                        <input id="photo" type="file" name="photo" accept="image/*" onchange="previewFile()"
                            class="mt-1 block w-full text-sm text-white file:py-2 file:px-4 file:border file:border-white file:bg-white file:text-black hover:file:bg-gray-100">

                        <?php if($user->photo): ?>
                            <label
                                class="inline-flex items-center mt-6 space-x-3 cursor-pointer hover:scale-105 transition-transform duration-300 ease-in-out">
                                <input type="checkbox" name="hapus_foto" value="1"
                                    class="h-5 w-5 text-red-500 border-white rounded-lg focus:ring-2 focus:ring-red-500">
                                <span class="text-lg font-semibold text-red-600 hover:text-red-700">
                                    <span class="flex items-center">
                                        Hapus Foto Profil
                                    </span>
                                </span>
                            </label>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Form Input Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-white">Nama</label>
                    <input type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>" required
                        class="mt-1 block w-full px-4 py-2 rounded-lg border border-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white">
                </div>

                <!-- Form Input Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-white">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>"
                        class="mt-1 block w-full px-4 py-2 rounded-lg border border-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white">
                </div>

                <!-- Button Simpan -->
                <div class="flex justify-center">
                    <button type="submit"
                        class="w-1/2 py-3 bg-green-600 text-white rounded-lg font-bold text-lg hover:bg-green-700 transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-indigo-400">
                        Simpan Perubahan
                    </button>
                </div>
                <input type="hidden" name="redirect_to" value="<?php echo e(url()->previous()); ?>">
            </form>
        </div>
    </div>

    <script>
        function previewFile() {
            const preview = document.getElementById('preview-image');
            const file = document.getElementById('photo').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function() {
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $attributes = $__attributesOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__attributesOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $component = $__componentOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__componentOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/e-kasir/resources/views/profile/edit.blade.php ENDPATH**/ ?>