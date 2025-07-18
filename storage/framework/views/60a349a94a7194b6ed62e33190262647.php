    <?php if(session('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?php echo e(session('success')); ?>',
                showConfirmButton: false,
                timer: 2500
            });
        </script>
    <?php endif; ?>
<?php /**PATH /var/www/html/e-kasir/resources/views/layouts/alert.blade.php ENDPATH**/ ?>