<head>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/alpinejs.min.js" defer></script>
    
</head>

<header class="fixed top-0 left-0 right-0 bg-white shadow-md z-10 h-16 flex items-center justify-between p-4">
    <div class="container mx-auto flex justify-between items-center px-4">
        <!-- Hamburger Button for Small Screens -->
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-blue-600">
            <i class="fas fa-bars text-2xl"></i>
        </button>

        <!-- Logo -->
        <div class="text-4xl font-bold">
            <span class="text-blue-900 cursor-pointer" onclick="window.location.href='/dashboard'">
                Kasir
            </span>
            <span class="text-black cursor-pointer" onclick="window.location.href='/dashboard'">
                .Mii
            </span>
        </div>

        <!-- Icons + Profile -->
        <div class="flex items-center space-x-4">
            <!-- Cart Icon -->
            <a href="<?php echo e(route('cart.index')); ?>" title="Total: Rp<?php echo e(number_format($cartTotal)); ?>">
                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center relative">
                    <i class="fas fa-shopping-cart text-white"></i>
                    <?php if($cartCount > 0): ?>
                        <span
                            class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1.5 py-0.5 font-bold">
                            <?php echo e($cartCount); ?>

                        </span>
                    <?php endif; ?>
                </div>
            </a>

            <!-- Profile Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <div @click="open = !open"
                    class="w-10 h-10 rounded-full overflow-hidden cursor-pointer bg-blue-500 flex items-center justify-center text-white font-bold text-lg">
                    <?php if(Auth::user()->photo): ?>
                        <img src="<?php echo e(asset('storage/' . Auth::user()->photo)); ?>" alt="photo-profile"
                            class="w-full h-full object-cover">
                    <?php else: ?>
                        <?php
                            $name = strtoupper(str_replace(' ', '', Auth::user()->name));
                            $initials = substr($name, 0, 2);
                        ?>
                        <div
                            class="w-10 h-10 bg-blue-500 flex items-center justify-center text-white text-lg font-bold rounded-full">
                            <?php echo e($initials); ?>

                        </div>
                    <?php endif; ?>
                </div>
                <!-- Dropdown Menu -->
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1"
                    class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50 origin-top-right">

                    <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                        Profile
                    </a>
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full text-left block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
<?php /**PATH /var/www/html/e-kasir/resources/views/layouts/navbar-2.blade.php ENDPATH**/ ?>