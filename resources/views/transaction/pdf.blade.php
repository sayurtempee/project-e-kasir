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

    @php
        $firstTransaction = $transactions->first();
        $member = $firstTransaction && $firstTransaction->member ? $firstTransaction->member : null;
    @endphp

    @if ($member)
        <p>
            <strong>Member:</strong> {{ $member->name }}<br>
            <strong>No. Telp:</strong> {{ $member->no_telp }}
        </p>
    @endif

    @php
        $chunkedTransactions = $transactions->chunk(20);
    @endphp

    @foreach ($chunkedTransactions as $chunk)
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
                @foreach ($chunk as $transaction)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $transaction->product->name ?? '-' }}</td>
                        <td>{{ $transaction->product->category->name ?? '-' }}</td>
                        <td>{{ $transaction->quantity }} {{ $transaction->product->stock_unit ?? '-' }}</td>
                        <td>Rp{{ number_format($transaction->product->price, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

    <h3 style="text-align: center; font-weight: bold;">
        Total Keuntungan Semua: Rp{{ number_format($transactions->sum('total_price'), 0, ',', '.') }}
    </h3>
</body>

</html>
