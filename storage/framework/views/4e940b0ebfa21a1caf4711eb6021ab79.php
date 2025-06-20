<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>
    <?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    <?php echo $__env->make('layouts.navbar-2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-4 text-white">RIWAYAT TRANSAKSI</h1>
            <div class="mb-4">
                <form action="<?php echo e(route('transaction.index')); ?>" method="GET" class="flex items-center gap-2">
                    <input type="date" name="date" value="<?php echo e(request('date')); ?>"
                        class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition">
                        Filter
                    </button>
                </form>
                <?php if(request('date')): ?>
                    <div class="mt-2 text-white">
                        <span class="font-semibold">
                            <?php echo e(\Carbon\Carbon::parse(request('date'))->locale('id')->translatedFormat('l, d F Y')); ?>

                        </span>
                    </div>
                <?php endif; ?>
            </div>

            
            
            <div class="flex justify-end mb-4 mt-2 space-x-3">
                <?php if(request('date')): ?>
                    <form action="<?php echo e(route('transaction.downloadPdf')); ?>" method="GET" target="_blank"
                        class="inline-block">
                        <input type="hidden" name="date" value="<?php echo e(request('date')); ?>">
                        <button type="submit"
                            class="bg-green-600 text-white font-semibold px-4 py-2 rounded hover:bg-green-700 transition">
                            Download PDF
                        </button>
                    </form>
                <?php endif; ?>
                <?php if($transactions->count() > 0): ?>
                    <form action="<?php echo e(route('transaction.destroyAll')); ?>" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua transaksi?');"
                        class="inline-block">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit"
                            class="bg-red-600 text-white font-semibold px-4 py-2 rounded hover:bg-red-700 transition">
                            Hapus Semua Transaksi
                        </button>
                    </form>
                <?php endif; ?>
            </div>
            
            <?php if($transactions->count() > 0): ?>
                <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                    <table class="min-w-full table-auto">
                        <thead class="bg-[#1E3A8A] text-white">
                            <tr>
                                <th class="px-6 py-3 text-left">Gambar</th>
                                <th class="px-6 py-3 text-left">Nama Produk</th>
                                <th class="px-6 py-3 text-left">Nama Kategori</th>
                                <th class="px-6 py-3 text-left">Jumlah</th>
                                <th class="px-6 py-3 text-left">Harga</th>
                                <th class="px-6 py-3 text-left">Total Harga</th>
                                <th class="px-6 py-3 text-left">Tanggal Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-6 py-3">
                                        <?php if($transaction->product && $transaction->product->img): ?>
                                            <img src="<?php echo e(asset('storage/' . $transaction->product->img)); ?>"
                                                alt="<?php echo e($transaction->product->name); ?>"
                                                class="w-16 h-16 object-cover rounded">
                                        <?php else: ?>
                                            <span class="text-sm text-gray-500 italic">Tidak ada gambar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-3"><?php echo e($transaction->product->name ?? '-'); ?></td>
                                    <td class="px-6 py-3"><?php echo e($transaction->product->category->name ?? '-'); ?></td>
                                    <td class="px-6 py-3"><?php echo e($transaction->quantity); ?></td>
                                    <td class="px-6 py-3">Rp<?php echo e(number_format($transaction->product->price)); ?></td>
                                    <td class="px-6 py-3">Rp<?php echo e(number_format($transaction->total_price)); ?></td>
                                    <td class="px-6 py-3">
                                        <?php echo e($transaction->created_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y H:i:s')); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 justify-center">
                    <?php echo e($transactions->onEachSide(1)->links('vendor.pagination.simple-numbers')); ?>

                </div>
            <?php else: ?>
                
                <p class="text-white">Tidak ada transaksi yang ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
<?php /**PATH /var/www/html/e-kasir/resources/views/transaction/index.blade.php ENDPATH**/ ?>