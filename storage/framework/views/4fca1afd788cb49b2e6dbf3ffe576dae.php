<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: sans-serif;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Laporan Transaksi
        <?php echo e($date ? \Carbon\Carbon::parse($date)->locale('id')->translatedFormat('l, d F Y') : '(Semua tanggal)'); ?></h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Nama Kategori</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total Harga</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($i + 1); ?></td>
                    <td><?php echo e($transaction->product->name ?? '-'); ?></td>
                    <td><?php echo e($transaction->product->category->name ?? '-'); ?></td>
                    <td><?php echo e($transaction->quantity); ?></td>
                    <td>Rp<?php echo e(number_format($transaction->product->price ?? 0, 0, ',', '.')); ?></td>
                    <td>Rp<?php echo e(number_format($transaction->total_price, 0, ',', '.')); ?></td>
                    <td><?php echo e($transaction->created_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y H:i')); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/transaction/laporan.blade.php ENDPATH**/ ?>