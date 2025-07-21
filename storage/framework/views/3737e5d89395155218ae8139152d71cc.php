<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Data Transaksi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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

        img {
            width: 40px;
            height: 40px;
            object-fit: cover;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <h2>Data Transaksi</h2>

    <?php
        $firstTransaction = $transactions->first();
        $member = $firstTransaction && $firstTransaction->member ? $firstTransaction->member : null;
    ?>

    <?php if($member): ?>
        <p>
            <strong>Member:</strong> <?php echo e($member->name); ?><br>
            <strong>No. Telp:</strong> <?php echo e($member->no_telp); ?>

        </p>
    <?php endif; ?>

    <?php
        $chunkedTransactions = $transactions->chunk(20);
    ?>

    <?php $__currentLoopData = $chunkedTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total Harga</th>
                    <th>Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($transaction->product->name); ?></td>
                        <td><?php echo e($transaction->product->category->name ?? '-'); ?></td>
                        <td><?php echo e($transaction->quantity); ?> <?php echo e($transaction->product->stock_unit); ?></td>
                        <td>Rp<?php echo e(number_format($transaction->product->price, 0, ',', '.')); ?></td>
                        <td>Rp<?php echo e(number_format($transaction->total_price, 0, ',', '.')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d H:i:s')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <?php if(!$loop->last): ?>
            <div class="page-break"></div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <h3 style="text-align: center; font-weight: bold;">
        Total Keseluruhan: Rp<?php echo e(number_format($transactions->sum('total_price'), 0, ',', '.')); ?>

    </h3>
</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/transaction/pdf.blade.php ENDPATH**/ ?>