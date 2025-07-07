<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | e-Kasir</title>

    <?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body class="bg-[#3B82F6] min-h-screen d-flex align-items-center justify-content-center">
    <div class="card shadow-lg border-0 rounded-4 col-md-6 p-4">
        <div class="card-body">
            <div class="text-center mb-4">
                <a href="<?php echo e(route('home')); ?>" class="text-decoration-none text-dark">
                    <h1 class="fw-bold text-5xl text-[#1E3A8A] hover:text-blue-950">Login</h1>
                </a>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('login-user')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="example@gmail.com" autofocus>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Masukkan Password">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button type="submit"
                        class="px-4 py-2 rounded text-white bg-[#1E3A8A] hover:bg-blue-950 transition duration-200">Login</button>
                    <div class="text-end">
                        
                        

                        <div class="small">Kamu lupa password?? <a href="<?php echo e(route('forgot.password')); ?>"
                                class="text-blue-600 hover:text-blue-800">klik disini</a></div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if(session('logout_success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Logout Berhasil',
                text: '<?php echo e(session('logout_success')); ?>',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>

    <?php if(session('logout_success')): ?>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Terima kasih, <?php echo e(session('logout_success')); ?>!',
                text: 'Kamu telah berhasil logout.',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    <?php endif; ?>

    <!-- Show/Hide Password Script -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/auth/login.blade.php ENDPATH**/ ?>