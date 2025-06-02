<?php $__env->startSection('content'); ?>
    <div class="mb-6 flex justify-end">
        <a href="<?php echo e(route('product.index')); ?>"
            class="inline-flex items-center px-4 py-2 bg-[#1E3A8A] text-white text-sm font-semibold rounded-md
             hover:bg-blue-950 hover:text-blue-800 hover:shadow-lg hover:scale-105 transition-all duration-300">
            ← Kembali
        </a>
    </div>

    <?php if(session('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '<?php echo e(session('success')); ?>',
                confirmButtonColor: '#3085d6'
            });
        </script>
    <?php endif; ?>

    <div class="max-w-5xl mx-auto bg-white p-6 shadow-md rounded-2xl">
        <h2 class="text-2xl font-semibold mb-4">Struk Pembelian</h2>
        <table class="w-full table-auto border-collapse border-2 border-gray-300 text-sm">
            <thead>
                <tr class="bg-gray-300">
                    <th class="border p-2">Gambar Produk</th>
                    <th class="border p-2">Nama Produk</th>
                    <th class="border p-2">Nama Kategori</th>
                    
                    <th class="border p-2">Barcode</th>
                    <th class="border p-2">Jumlah</th>
                    <th class="border p-2">Harga</th>
                    <th class="border p-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="border p-2">
                            <div class="flex justify-center items-center">
                                <img src="<?php echo e(Storage::url($trx->product->img)); ?>" alt="<?php echo e($trx->product->name); ?>"
                                    class="w-16 h-16 object-cover rounded">
                            </div>
                        </td>
                        <td class="border p-2"><?php echo e($trx->product->name); ?></td>
                        <td class="border p-2"><?php echo e($trx->product->category->name); ?></td>
                        
                        <td class="border p-2">
                            <svg id="barcode-<?php echo e($trx->id); ?>"></svg>
                        </td>
                        <td class="border p-2"><?php echo e($trx->quantity); ?></td>
                        <td class="border p-2">Rp<?php echo e(number_format($trx->product->price)); ?></td>
                        <td class="border p-2">Rp<?php echo e(number_format($trx->total_price)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <div class="mt-2 flex justify-end">
            <div class="w-full max-w-xs">
                <?php if(isset($transactions[0]->member)): ?>
                    <div class="mb-1 flex justify-between">
                        <span class="text-gray-600"><strong>Nomor:</strong></span>
                        <span class="text-blue-700"><?php echo e($transactions[0]->member->no_telp); ?></span>
                    </div>
                    <div class="mb-1 flex justify-between">
                        <span class="text-gray-600"><strong>Member:</strong></span>
                        <span class="text-blue-700"><?php echo e($transactions[0]->member->name); ?></span>
                    </div>
                <?php endif; ?>
                <div class="mb-1 flex justify-between">
                    <span class="text-gray-600"><strong>SubTotal:</strong></span>
                    <span class="text-green-700">Rp<?php echo e(number_format($grandTotal)); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600"><strong>Kembalian:</strong></span>
                    <span class="text-red-700">Rp<?php echo e(number_format($change, 0, ',', '.')); ?></span>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6">
            <?php
                function center($text, $width = 47)
                {
                    return str_pad($text, $width, ' ', STR_PAD_BOTH);
                }

                function rightAlign($left, $right, $width = 47)
                {
                    $space = $width - strlen($left) - strlen($right);
                    return $left . str_repeat(' ', max(1, $space)) . $right;
                }

                $kasir = center('Kasir .Mii');
                $alamat = center('Jl. Ky Tinggi Rt 009 Rw 03, No.17');
                $telp = center('Telp: 0812-3456-7890');

                $tanggal = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y HH:mm');
                $noTransaksi = '#2';

                $message = "```\n"; // ← Awal blok kode WhatsApp
                $message .= "{$kasir}\n{$alamat}\n{$telp}\n";
                $message .= str_repeat('-', 47) . "\n";
                $message .= "Tanggal       : {$tanggal}\n";
                $message .= "No. Transaksi : {$noTransaksi}\n";
                $message .= str_repeat('-', 47) . "\n";

                $nomor = '';
                foreach ($transactions as $trx) {
                    $namaProduk = $trx->product->name;
                    $qty = $trx->quantity;
                    $harga = number_format($trx->product->price, 0, ',', '.');
                    $subtotal = number_format($trx->total_price, 0, ',', '.');
                    $nomor = $trx->member->no_telp ?? '';

                    $message .= "{$namaProduk}\n";
                    $message .= rightAlign("{$qty} x Rp{$harga}", "Rp{$subtotal}") . "\n";
                }

                $message .= str_repeat('-', 47) . "\n";
                $message .= rightAlign('TOTAL', 'Rp' . number_format($grandTotal, 0, ',', '.')) . "\n";
                $message .= str_repeat('-', 47) . "\n";
                $message .= center('Terima kasih atas kunjungan Anda!') . "\n";
                $message .= center('Barang yang sudah dibeli tidak') . "\n";
                $message .= center('dapat dikembalikan.') . "\n";
                $message .= '```'; // ← Akhir blok kode WhatsApp

                $whatsappUrl = 'https://wa.me/' . $nomor . '?text=' . urlencode($message);
            ?>
            <div class="flex justify-start gap-4 mt-6">
                <a href="<?php echo e(route('invoice.download', ['ids' => implode(',', $transactions->pluck('id')->toArray())])); ?>"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-800 text-white text-sm font-semibold rounded-full
                  hover:bg-[#1E3A8A] hover:text-white hover:shadow-lg hover:scale-105 transition-all duration-300">
                    <i class="fas fa-download"></i> Unduh PDF
                </a>

                <?php if(isset($transactions[0]->member)): ?>
                    <form action="<?php echo e(route('transaction.sendWhatsApp', ['transaction' => $transactions[0]->id])); ?>"
                        method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="ids"
                            value="<?php echo e(implode(',', $transactions->pluck('id')->toArray())); ?>">
                        <input type="hidden" name="no_telp" value="<?php echo e($nomor); ?>">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-full
                    hover:bg-green-700 hover:shadow-lg hover:scale-105 transition-all duration-300">
                            <i class="fab fa-whatsapp"></i> Kirim ke WhatsApp
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    JsBarcode("#barcode-<?php echo e($trx->id); ?>", "<?php echo e($trx->product->code); ?>", {
                        format: "CODE128",
                        lineColor: "#000",
                        width: 1.5,
                        height: 40,
                        displayValue: false
                    });
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                // SweetAlert tampil kalau ada session success
                <?php if(session('success')): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: '<?php echo e(session('success')); ?>',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                <?php endif; ?>
            });
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/e-kasir/resources/views/transaction/invoice.blade.php ENDPATH**/ ?>