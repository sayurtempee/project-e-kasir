<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Invoice Pembelian'); ?></title>
    <?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body class="bg-[#3B82F6] text-black">
    <div class="min-h-screen p-4">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/layouts/app.blade.php ENDPATH**/ ?>