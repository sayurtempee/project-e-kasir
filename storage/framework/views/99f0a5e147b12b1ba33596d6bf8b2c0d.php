<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | e-Kasir</title>
    <?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body class="bg-[#3B82F6] min-h-screen d-flex align-items-center justify-content-center">
    <div class="card shadow-lg border-0 rounded-4 col-md-6 p-4">
        <div class="card-body">
            <div class="text-center mb-4">
                <a href="<?php echo e(route('home')); ?>" class="text-decoration-none text-dark">
                    <h1 class="fw-bold text-5xl text-[#1E3A8A] hover:text-blue-950">Lupa Password</h1>
                </a>
            </div>

            <?php if(session('status')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('status')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('forgot.password.send')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Masukkan Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        placeholder="example@gmail.com" value="<?php echo e(old('email')); ?>" required autofocus>
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

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button type="submit"
                        class="px-4 py-2 rounded text-white bg-[#1E3A8A] hover:bg-blue-950 transition duration-200">
                        Kirim Link Reset Password
                    </button>
                    <span class="small">
                        Sudah punya akun?? <a href="<?php echo e(route('login')); ?>"
                            class="text-blue-600 hover:text-blue-800">login</a>
                    </span>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/auth/forgot-password.blade.php ENDPATH**/ ?>