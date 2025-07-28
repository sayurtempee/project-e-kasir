<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Pembelian</title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
        }

        .print-container {
            width: 300px;
            margin: auto;
            padding: 10px;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 4px 0;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }

        @media print {
            @page {
                size: auto;
                /* Gunakan ukuran printer default */
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
            }

            .print-container {
                width: 100%;
                padding: 20px;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="print-container">
        <div class="center bold">Kasir .Mii </div>
        <div class="center">Jl. Ky Tinggi Rt 009 Rw 03, No.17</div>
        <div class="center">Telp: 0812-3456-7890</div>
        <div class="line"></div>

        <div>No. Transaksi: #<?php echo e($transactions->first()->id); ?></div>
        <div>Tanggal Transaksi: <?php echo e(\Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y H:i')); ?></div>
        
        <?php if(isset($memberName) && $memberName): ?>
            <div>Nama Member: <?php echo e($memberName); ?></div>
        <?php endif; ?>
        <?php if($memberPhone): ?>
            <div>No. Telepon: <?php echo e($memberPhone); ?></div>
        <?php endif; ?>

        <div class="line"></div>

        <table>
            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="left leading-tight" colspan="2">
                        Nama Produk: <?php echo e($trx->product->name); ?><br>
                        <span class="text-sm text-gray-500">Kategori: <?php echo e($trx->product->category->name); ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="left">
                        <?php echo e($trx->quantity); ?> <?php echo e($trx->product->stock_unit); ?> x
                        <span class="bold">Rp<?php echo e(number_format($trx->product->price)); ?></span>
                        <br>
                        <span class="text-xs text-gray-500">Harga Asli:
                            Rp<?php echo e(number_format($trx->product->price * $trx->quantity)); ?></span>
                    </td>
                    <td class="right">
                        Rp<?php echo e(number_format($trx->total_price)); ?>

                        <br>
                        <span class="text-xs text-gray-500">Setelah Diskon</span>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>

        <div class="line"></div>
        <table>
            <?php if(!empty($diskonPoin) && $diskonPoin > 0): ?>
                <tr>
                    <td class="left bold">Poin Digunakan</td>
                    <td class="right bold"><?php echo e($diskonPoin); ?> poin</td>
                </tr>
            <?php endif; ?>
            <?php if(!empty($diskonPersen) && $diskonPersen > 0): ?>
                <tr>
                    <td class="left bold">Diskon</td>
                    <td class="right bold"><?php echo e($diskonPersen); ?>%</td>
                </tr>
            <?php endif; ?>
            <?php if(!empty($potongan) && $potongan > 0): ?>
                <tr>
                    <td class="left bold">Potongan Harga</td>
                    <td class="right bold">Rp<?php echo e(number_format($potongan, 0, ',', '.')); ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td class="bold left">UANG DIBAYAR</td>
                <td class="bold right">Rp<?php echo e(number_format($paidAmount, 0, ',', '.')); ?></td>
            </tr>
            <tr>
                <td class="bold left">SUBTOTAL</td>
                <td class="bold right">Rp<?php echo e(number_format($totalBayar, 0, ',', '.')); ?></td>
            </tr>
            <tr>
                <td class="bold left">KEMBALIAN</td>
                <td class="bold right">Rp<?php echo e(number_format($change, 0, ',', '.')); ?></td>
            </tr>
        </table>

        <div class="line"></div>

        <div class="footer">
            Terima kasih atas kunjungan Anda!<br>
            Barang yang sudah dibeli tidak dapat dikembalikan.
        </div>

    </div>
</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/transaction/invoice-pdf.blade.php ENDPATH**/ ?>