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
        {{ $date ? \Carbon\Carbon::parse($date)->locale('id')->translatedFormat('l, d F Y') : '(Semua tanggal)' }}</h2>

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
            @foreach ($transactions as $i => $transaction)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $transaction->product->name ?? '-' }}</td>
                    <td>{{ $transaction->product->category->name ?? '-' }}</td>
                    <td>{{ $transaction->quantity }} {{ $transaction->product->stock_unit ?? '-' }}</td>
                    <td>Rp{{ number_format($transaction->product->price ?? 0, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                    <td>{{ $transaction->created_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y H:i') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
