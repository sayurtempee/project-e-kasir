@extends('layouts.app')

@section('content')
    <div class="mb-6 flex justify-end">
        <a href="{{ route('product.index') }}"
            class="inline-flex items-center px-4 py-2 bg-[#1E3A8A] text-white text-sm font-semibold rounded-md
             hover:bg-blue-950 hover:text-blue-800 hover:shadow-lg hover:scale-105 transition-all duration-300">
            ← Kembali
        </a>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif

    <div class="max-w-5xl mx-auto bg-white p-6 shadow-md rounded-2xl">
        <h2 class="text-2xl font-semibold mb-4">Struk Pembelian</h2>
        <table class="w-full table-auto border-collapse border-2 border-gray-300 text-sm">
            <thead>
                <tr class="bg-gray-300">
                    <th class="border p-2">Gambar Produk</th>
                    <th class="border p-2">Nama Produk</th>
                    <th class="border p-2">Nama Kategori</th>
                    {{--  <th class="border p-2">Kode</th>  --}}
                    <th class="border p-2">Barcode</th>
                    <th class="border p-2">Jumlah</th>
                    <th class="border p-2">Harga</th>
                    <th class="border p-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $trx)
                    <tr>
                        <td class="border p-2">
                            <div class="flex justify-center items-center">
                                <img src="{{ Storage::url($trx->product->img) }}" alt="{{ $trx->product->name }}"
                                    class="w-16 h-16 object-cover rounded">
                            </div>
                        </td>
                        <td class="border p-2">{{ $trx->product->name }}</td>
                        <td class="border p-2">{{ $trx->product->category->name }}</td>
                        {{--  <td class="border p-2">{{ $trx->product->code }}</td>  --}}
                        <td class="border p-2">
                            <svg id="barcode-{{ $trx->id }}"></svg>
                        </td>
                        <td class="border p-2">{{ $trx->quantity }}</td>
                        <td class="border p-2">Rp{{ number_format($trx->product->price) }}</td>
                        <td class="border p-2">Rp{{ number_format($trx->total_price) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-2 flex justify-end">
            <div class="w-full max-w-xs">
                @if (isset($transactions[0]->member))
                    <div class="mb-1 flex justify-between">
                        <span class="text-gray-600"><strong>Nomor:</strong></span>
                        <span class="text-blue-700">{{ $transactions[0]->member->no_telp }}</span>
                    </div>
                    <div class="mb-1 flex justify-between">
                        <span class="text-gray-600"><strong>Member:</strong></span>
                        <span class="text-blue-700">{{ $transactions[0]->member->name }}</span>
                    </div>
                @endif
                <div class="mb-1 flex justify-between">
                    <span class="text-gray-600"><strong>SubTotal:</strong></span>
                    <span class="text-green-700">Rp{{ number_format($grandTotal) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600"><strong>Kembalian:</strong></span>
                    <span class="text-red-700">Rp{{ number_format($change, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6">
            @php
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
            @endphp
            <div class="flex justify-start gap-4 mt-6">
                <a href="{{ route('invoice.download', ['ids' => implode(',', $transactions->pluck('id')->toArray())]) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-800 text-white text-sm font-semibold rounded-full
                  hover:bg-[#1E3A8A] hover:text-white hover:shadow-lg hover:scale-105 transition-all duration-300">
                    <i class="fas fa-download"></i> Unduh PDF
                </a>

                @if (isset($transactions[0]->member))
                    <form action="{{ route('transaction.sendWhatsApp', ['transaction' => $transactions[0]->id]) }}"
                        method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="ids"
                            value="{{ implode(',', $transactions->pluck('id')->toArray()) }}">
                        <input type="hidden" name="no_telp" value="{{ $nomor }}">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-full
                    hover:bg-green-700 hover:shadow-lg hover:scale-105 transition-all duration-300">
                            <i class="fab fa-whatsapp"></i> Kirim ke WhatsApp
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @foreach ($transactions as $trx)
                    JsBarcode("#barcode-{{ $trx->id }}", "{{ $trx->product->code }}", {
                        format: "CODE128",
                        lineColor: "#000",
                        width: 1.5,
                        height: 40,
                        displayValue: false
                    });
                @endforeach

                // SweetAlert tampil kalau ada session success
                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                @endif
            });
        </script>
    @endsection
