<head>
    <!-- Hanya satu Alpine.js saja -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js" defer></script>
    <!-- Pastikan fontawesome sudah di-load jika pakai ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
</head>

<div x-data="{ sidebarOpen: false }">
    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-blue-600">
        <i class="fas fa-bars text-2xl"></i>
    </button>

    <div :class="{ 'block': sidebarOpen, 'hidden': !sidebarOpen }"
        class="lg:block fixed top-16 left-0 h-[calc(100vh-64px)] w-64 bg-blue-800 p-4 overflow-y-auto z-20">
        <div class="space-y-6">
            <!-- Management Section -->
            <div>
                <h2 class="text-white font-semibold mb-2">Management</h2>
                <div class="space-y-2">
                    <!-- Produk -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full bg-white text-blue-800 font-semibold py-2 px-4 rounded flex justify-between items-center">
                            Produk
                            <i class="fas fa-chevron-down transition-transform duration-300"
                                :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" class="mt-2 pl-4 space-y-2 origin-top text-white">
                            <a href="<?php echo e(route('product.index')); ?>" class="block">Daftar Produk</a>
                            <a href="<?php echo e(route('product.create')); ?>" class="block">Tambah Produk</a>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full bg-white text-blue-800 font-semibold py-2 px-4 rounded flex justify-between items-center">
                            Kategori
                            <i class="fas fa-chevron-down transition-transform duration-300"
                                :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" class="mt-2 pl-4 space-y-2 origin-top text-white">
                            <a href="<?php echo e(route('category.index')); ?>" class="block">Daftar Kategori</a>
                            <a href="<?php echo e(route('category.create')); ?>" class="block">Tambah Kategori</a>
                        </div>
                    </div>

                    <!-- Discount -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full bg-white text-blue-800 font-semibold py-2 px-4 rounded flex justify-between items-center">
                            Diskon
                            <i class="fas fa-chevron-down transition-transform duration-300"
                                :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" class="mt-2 pl-4 space-y-2 origin-top text-white">
                            <a href="<?php echo e(route('discount.index')); ?>" class="block">Kelola Diskon</a>
                            <a href="<?php echo e(route('discount.create')); ?>" class="block">Tambah Diskon</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Section -->
            <div>
                <h2 class="text-white font-semibold mb-2">Admin</h2>
                <div class="space-y-2">
                    <!-- Admin -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full bg-white text-blue-800 font-semibold py-2 px-4 rounded flex justify-between items-center">
                            Admin
                            <i class="fas fa-chevron-down transition-transform duration-300"
                                :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" class="mt-2 pl-4 space-y-2 origin-top text-white">
                            <a href="<?php echo e(route('admin.index')); ?>" class="block">Daftar Admin</a>
                            <a href="<?php echo e(route('admin.create')); ?>" class="block">Tambah Admin</a>
                        </div>
                    </div>

                    <!-- Member -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full bg-white text-blue-800 font-semibold py-2 px-4 rounded flex justify-between items-center">
                            Member
                            <i class="fas fa-chevron-down transition-transform duration-300"
                                :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" class="mt-2 pl-4 space-y-2 origin-top text-white">
                            <a href="<?php echo e(route('member.index')); ?>" class="block">Daftar Member</a>
                            <a href="<?php echo e(route('member.create')); ?>" class="block">Tambah Member</a>
                        </div>
                    </div>

                    <!-- Transaksi -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full bg-white text-blue-800 font-semibold py-2 px-4 rounded flex justify-between items-center">
                            Transaksi
                            <i class="fas fa-chevron-down transition-transform duration-300"
                                :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="mt-2 pl-4 space-y-2 origin-top text-white">
                            <a href="<?php echo e(route('transaction.index')); ?>" class="block">Riwayat Transaksi</a>
                        </div>
                    </div>

                    <!-- Laporan -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full bg-white text-blue-800 font-semibold py-2 px-4 rounded flex justify-between items-center">
                            Laporan
                            <i class="fas fa-chevron-down transition-transform duration-300"
                                :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="mt-2 pl-4 space-y-2 origin-top text-white">
                            <a href="<?php echo e(route('transaction.export')); ?>" class="block">Export Transaksi EXCEL</a>
                            <a href="<?php echo e(route('transaction.exportPdf')); ?>" class="block">Export Transaksi PDF</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/e-kasir/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>