<!-- resources/views/components/app-layout.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
</head>

<body class="font-sans bg-gray-100">
    <div class="min-h-screen">
        <?php echo e($slot); ?>

    </div>
</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/components/app-layout.blade.php ENDPATH**/ ?>