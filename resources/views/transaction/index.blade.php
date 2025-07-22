<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>
    @include('layouts.head')
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    @include('layouts.navbar-2')
    @include('layouts.sidebar')

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-4 text-white">RIWAYAT TRANSAKSI</h1>
            <div class="mb-4">
                <form action="{{ route('transaction.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition">
                        Filter
                    </button>
                </form>
                @if (request('date'))
                    <div class="mt-2 text-white">
                        <span class="font-semibold">
                            {{ \Carbon\Carbon::parse(request('date'))->locale('id')->translatedFormat('l, d F Y') }}
                        </span>
                    </div>
                @endif
            </div>

            {{--  Button untuk menghapus semua riwayat transaksi  --}}
            {{-- Tombol Download PDF --}}
            <div class="flex justify-end mb-4 mt-2 space-x-3">
                @if (request('date'))
                    <form action="{{ route('transaction.downloadPdf') }}" method="GET" target="_blank"
                        class="inline-block">
                        <input type="hidden" name="date" value="{{ request('date') }}">
                        <button type="submit"
                            class="bg-green-600 text-white font-semibold px-4 py-2 rounded hover:bg-green-700 transition">
                            Download PDF
                        </button>
                    </form>
                @endif
                @if (auth()->user()->role === 'admin')
                    @if ($transactions->count() > 0)
                        <form action="{{ route('transaction.destroyAll') }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua transaksi?');"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 text-white font-semibold px-4 py-2 rounded hover:bg-red-700 transition">
                                Hapus Semua Transaksi
                            </button>
                        </form>
                    @endif
                @endif
            </div>
            <div class="flex justify-center mb-6">
                <div
                    class="w-full bg-[#1E3A8A] border border-[#1E3A8A] text-white px-6 py-4 rounded-lg shadow font-semibold text-lg text-center">
                    Total Keuntungan Semua:
                    <span class="font-bold text-yellow-300">
                        Rp{{ number_format($transactions->sum('total_price'), 0, ',', '.') }}
                    </span>
                </div>
            </div>
            {{--  List Riwayat Transaksi  --}}
            @if ($transactions->count() > 0)
                <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                    <table class="min-w-full table-auto">
                        <thead class="bg-[#1E3A8A] text-white">
                            <tr>
                                <th class="px-6 py-3 text-left">Gambar</th>
                                <th class="px-6 py-3 text-left">Nama Produk</th>
                                <th class="px-6 py-3 text-left">Nama Kategori</th>
                                <th class="px-6 py-3 text-left">Jumlah</th>
                                <th class="px-6 py-3 text-left">Harga Produk</th>
                                <th class="px-6 py-3 text-left">Total Harga</th>
                                <th class="px-6 py-3 text-left">Tanggal Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{--  Looping untuk menampilkan setiap transaksi  --}}
                            @foreach ($transactions as $transaction)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-6 py-3">
                                        @if ($transaction->product && $transaction->product->img)
                                            <img src="{{ asset('storage/' . $transaction->product->img) }}"
                                                alt="{{ $transaction->product->name }}"
                                                class="w-16 h-16 object-cover rounded">
                                        @else
                                            <span class="text-sm text-gray-500 italic">Tidak ada gambar</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3">{{ $transaction->product->name ?? '-' }}</td>
                                    <td class="px-6 py-3">{{ $transaction->product->category->name ?? '-' }}</td>
                                    <td class="px-6 py-3">{{ $transaction->quantity }}
                                        {{ $transaction->product->stock_unit ?? '-' }}</td>
                                    <td class="px-6 py-3">Rp{{ number_format($transaction->product->price) }}</td>
                                    <td class="px-6 py-3">Rp{{ number_format($transaction->total_price) }}</td>
                                    <td class="px-6 py-3">
                                        {{ $transaction->created_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y H:i:s') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{--  pagination  --}}
                <div class="mt-4 justify-center">
                    {{ $transactions->onEachSide(1)->links('vendor.pagination.simple-numbers') }}
                </div>
            @else
                {{--  jika tidak ada riwayat transaksi yang masuk maka tampilkan ini  --}}
                <p class="text-white">Tidak ada transaksi yang ditemukan.</p>
            @endif
        </div>
    </div>
</body>

</html>
