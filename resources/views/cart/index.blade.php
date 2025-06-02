<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    @include('layouts.head')
</head>

<body class="bg-[#3B82F6] p-4">
    <div class="mb-6 flex justify-end">
        <a href="{{ route('product.index') }}"
            class="inline-flex items-center px-4 py-2 bg-[#1E3A8A] text-white text-sm font-semibold rounded-md
               hover:bg-blue-950 hover:text-black hover:shadow-lg hover:scale-105 transition-all duration-300">
            ← Kembali
        </a>
    </div>

    <div class="w-full max-w-7xl mx-auto bg-blue-950 p-6 rounded-lg shadow-lg">
        <h2 class="text-3xl font-semibold mb-4 text-white">Keranjang Belanja</h2>

        @if ($carts->count() > 0)
            <div class="flex justify-between items-center mb-4">
                {{-- Pesan Waktu Transaksi --}}
                <div class="bg-yellow-100 border border-yellow-500 text-yellow-800 px-4 py-3 rounded w-full text-center">
                    <strong>Perhatian:</strong> Anda memiliki waktu <span id="timer">02:00</span> untuk
                    menyelesaikan transaksi.
                </div>
            </div>

            @if ($message)
                <div x-data="{ show: true }" x-show="show"
                    class="alert alert-success relative p-4 mb-4 border border-green-400 bg-green-100 text-green-800 rounded">
                    {{ $message }}
                    <button @click="show = false"
                        class="absolute top-1 right-2 text-green-800 hover:text-green-900 font-bold" aria-label="Close">
                        &times;
                    </button>
                </div>
            @endif

            <div class="overflow-x-auto bg-white rounded-lg shadow-lg border-4 border-white">
                <form id="cartForm" action="{{ route('cart.bulkAction') }}" method="POST">
                    @csrf
                    <!-- TABEL KERANJANG -->
                    <table class="w-full text-left mb-4">
                        <thead class="bg-[#1E3A8A] text-white">
                            <tr>
                                <th class="px-6 py-3">Pilih</th>
                                <th class="px-6 py-3">Gambar</th>
                                <th class="px-6 py-3">Nama Produk</th>
                                <th class="px-6 py-3">Nama Ketegori</th>
                                {{--  <th class="px-6 py-3">Kode Produk</th>  --}}
                                <th class="px-6 py-3">Barcode</th>
                                <th class="px-6 py-3">Produk</th>
                                <th class="px-6 py-3">Harga</th>
                                <th class="px-6 py-3">Jumlah</th>
                                <th class="px-6 py-3">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach ($carts as $cart)
                                @php
                                    $total = $cart->product->price * $cart->quantity;
                                    $grandTotal += $total;
                                @endphp
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-3">
                                        <input type="checkbox" name="selected_carts[]" value="{{ $cart->id }}"
                                            class="mr-2">
                                    </td>
                                    <td class="px-6 py-3">
                                        <img src="{{ Storage::url($cart->product->img) }}"
                                            alt="{{ $cart->product->name }}" class="w-16 h-16 object-cover rounded">
                                    </td>
                                    <td class="px-6 py-3">{{ $cart->product->name }}</td>
                                    <td class="px-6 py-3">{{ $cart->product->category->name }}</td>
                                    {{--  <td class="px-6 py-3">{{ $cart->product->code }}</td>  --}}
                                    <td class="px-6 py-3">
                                        <svg id="barcode-{{ $cart->id }}" class="w-[150px] h-[40px]"></svg>
                                    </td>
                                    <td class="px-6 py-3">{{ $cart->product->name }}</td>
                                    <td class="px-6 py-3">Rp{{ number_format($cart->product->price) }}</td>
                                    <td class="px-6 py-3">{{ $cart->quantity }}</td>
                                    <td class="px-6 py-3">Rp{{ number_format($total) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- BAGIAN TOTAL DAN AKSI -->
                    <div class="mt-8 mb-6 px-4 md:px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-end">
                        <!-- Total -->
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1">Total</label>
                            <div class="text-lg font-bold text-gray-800 bg-gray-100 px-4 py-2 rounded">
                                Rp{{ number_format($grandTotal) }}
                            </div>
                        </div>

                        <!-- Uang Dibayar -->
                        <div>
                            <label for="paid_amount" class="block font-semibold text-gray-700 mb-1">Uang Dibayar</label>
                            <input type="number" id="paid_amount" name="paid_amount" min="0"
                                class="w-full min-w-[180px] px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                                placeholder="Masukkan jumlah uang">
                        </div>

                        <!-- Input No Telepon Member untuk cek diskon -->
                        <div>
                            <label for="no_telp" class="block font-semibold text-gray-700 mb-1">No. Telepon Member
                                (opsional)</label>
                            <input type="text" id="no_telp" name="no_telp"
                                value="{{ old('no_telp', $no_telp ?? '') }}"
                                class="w-full min-w-[180px] px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                                placeholder="Masukkan nomor telepon untuk diskon">
                        </div>

                        <!-- Kembalian -->
                        <div>
                            <label for="change" class="block font-semibold text-gray-700 mb-1">Kembalian</label>
                            <input type="text" id="change" readonly
                                class="w-full min-w-[180px] px-4 py-2 bg-gray-100 border border-gray-300 rounded text-gray-700">
                        </div>

                        <div>
                            <p>Total: Rp{{ number_format($cartTotal) }}</p>
                            <p>Poin: {{ $diskonPoin }} poin</p>
                            <p><strong>Total Bayar: Rp{{ number_format($totalBayar) }}</strong></p>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex gap-3 lg:col-span-3">
                            <button type="submit" name="action" value="delete"
                                class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold transition">
                                Hapus Terpilih
                            </button>
                            <button type="submit" name="action" value="check_discount"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold transition">
                                Cek Diskon
                            </button>
                            <button type="submit" name="action" value="buy"
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold transition">
                                Checkout dan Bayar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @else
            <div class="text-right text-lg font-semibold text-gray-300">Total : Rp0</div>
        @endif
    </div>

    {{-- Sweet Alert --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Render barcode untuk tiap produk
            @foreach ($carts as $cart)
                JsBarcode("#barcode-{{ $cart->id }}", "{{ $cart->product->code }}", {
                    format: "CODE128",
                    lineColor: "#000",
                    width: 1.5,
                    height: 40,
                    displayValue: false
                });
            @endforeach
        });

        // Timer countdown 120 detik
        let timeLeft = 120;
        let countdown;
        const timerDisplay = document.getElementById('timer');

        function updateDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        function startCountdown() {
            clearInterval(countdown);

            countdown = setInterval(() => {
                updateDisplay();
                timeLeft--;

                if (timeLeft < 0) {
                    clearInterval(countdown);

                    const extend = confirm('Waktu habis. Apakah Anda ingin menambah waktu 2 menit lagi?');

                    if (extend) {
                        timeLeft = 120;
                        startCountdown();
                    } else {
                        alert('Anda akan dikembalikan ke halaman produk.');

                        fetch("{{ route('cart.clearExpired') }}", {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                window.location.href = "{{ route('product.index') }}";
                            })
                            .catch(error => {
                                console.error("Error:", error);
                            });
                    }
                }
            }, 1000);
        }
        updateDisplay();
        startCountdown();

        // Hitung kembalian berdasarkan total bayar setelah diskon
        document.getElementById('paid_amount').addEventListener('input', function() {
            const total = {{ $totalBayar }};
            const paid = parseInt(this.value);
            const changeInput = document.getElementById('change');

            if (!isNaN(paid) && paid >= total) {
                const change = paid - total;
                changeInput.value = 'Rp' + change.toLocaleString('id-ID');
            } else if (!isNaN(paid)) {
                changeInput.value = 'Uang kurang!';
            } else {
                changeInput.value = '';
            }
        });

        // Validasi uang dibayar sebelum checkout
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('cartForm');
            const paidInput = document.getElementById('paid_amount');

            form.addEventListener('submit', function(e) {
                const action = document.activeElement.value;

                if (action === 'buy') {
                    const paid = paidInput.value.trim();
                    if (paid === '' || isNaN(paid) || parseInt(paid) < {{ $totalBayar }}) {
                        e.preventDefault();
                        alert('Mohon isi Uang Dibayar dengan benar sebelum checkout.');
                        paidInput.focus();
                    }
                }
            });
        });
    </script>
    {{--  @include('layouts.footer')  --}}
</body>

</html>
