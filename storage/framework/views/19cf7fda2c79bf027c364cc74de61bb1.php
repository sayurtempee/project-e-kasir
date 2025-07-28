<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Permintaan Reset Kata Sandi</title>
    <?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 40px;">
    <table align="center" width="100%"
        style="max-width: 600px; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <tr>
            <td align="center">
                <h2 style="color: #333;">Permintaan Reset Kata Sandi</h2>
                <p style="color: #555;">Kami menerima permintaan untuk mereset kata sandi Anda.</p>
                <p style="color: #555;">Klik tombol di bawah untuk mengatur kata sandi baru:</p>
                <a href="<?php echo e(url('reset-password/' . $token)); ?>?email=<?php echo e(urlencode($email)); ?>"
                    style="display: inline-block; margin: 20px 0; padding: 12px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 6px;">
                    Reset Kata Sandi
                </a>
                <p style="font-size: 14px; color: #777;">Jika tombol tidak berfungsi, salin dan tempel URL ini ke
                    browser Anda:</p>
                <p style="word-break: break-word; font-size: 13px;">
                    <a
                        href="<?php echo e(url('reset-password/' . $token)); ?>?email=<?php echo e(urlencode($email)); ?>"><?php echo e(url('reset-password/' . $token)); ?>?email=<?php echo e(urlencode($email)); ?></a>
                </p>
                <hr style="margin-top: 30px;">
                <p style="font-size: 13px; color: #999;">Jika Anda tidak meminta reset kata sandi, tidak perlu tindakan
                    lebih lanjut.</p>
                <p style="font-size: 13px; color: #999;">Terima kasih,<br><?php echo e(config('app.name')); ?> Team</p>
            </td>
        </tr>
    </table>
</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/emails/forgot.blade.php ENDPATH**/ ?>