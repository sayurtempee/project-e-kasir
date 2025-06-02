<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layouts.head')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/alpinejs.min.js" defer></script>
    <script src="https://unpkg.com/alpinejs@3.13.0/dist/alpinejs.min.js" defer></script>
    <title>{{ $title }} | e-Kasir</title>
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    @include('layouts.navbar-2')
    @include('layouts.sidebar')

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4 text-white">
            <h1 class="text-3xl font-bold mb-4">
                DASHBOARD
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-teal-500 p-8 min-h-[150px] rounded-lg text-center border-2 border-white">
                    <div class="text-xl font-bold mb-2">
                        Admin
                    </div>
                    <div class="text-4xl font-bold flex items-center justify-center">
                        <i class="fas fa-user-shield mr-2"></i>
                        {{ $adminCount }}
                    </div>
                </div>

                <div class="bg-teal-500 p-8 min-h-[150px] rounded-lg text-center border-2 border-white">
                    <div class="text-xl font-bold mb-2">
                        Kasir
                    </div>
                    <div class="text-4xl font-bold flex items-center justify-center">
                        <i class="fas fa-cash-register mr-2"></i>
                        {{ $cashierCount }}
                    </div>
                </div>

                <div class="bg-teal-500 p-8 min-h-[150px] rounded-lg text-center border-2 border-white">
                    <div class="text-xl font-bold mb-2">
                        Member
                    </div>
                    <div class="text-4xl font-bold flex items-center justify-center">
                        <i class="fas fa-users mr-2"></i>
                        {{ $memberCount }}
                    </div>
                </div>

                <div class="bg-teal-500 p-8 min-h-[150px] rounded-lg text-center border-2 border-white">
                    <div class="text-xl font-bold mb-2">
                        Total Penjualan
                    </div>
                    <div class="text-4xl font-bold flex items-center justify-center">
                        <span class="mr-2">{{ config('app.currency.symbol') }}</span>
                        {{ number_format($totalMoney, 0, ',', '.') }}
                    </div>
                </div>

                <div class="bg-teal-500 p-8 min-h-[150px] rounded-lg text-center border-2 border-white">
                    <div class="text-xl font-bold mb-2">
                        Produk
                    </div>
                    <div class="text-4xl font-bold flex items-center justify-center">
                        <i class="fas fa-cube mr-2"></i>
                        {{ $productCount }}
                    </div>
                </div>

                <div class="bg-teal-500 p-8 min-h-[150px] rounded-lg text-center border-2 border-white">
                    <div class="text-xl font-bold mb-2">
                        Kategori
                    </div>
                    <div class="text-4xl font-bold flex items-center justify-center">
                        <i class="fas fa-boxes mr-2"></i>
                        {{ $categoryCount }}
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('dashboard') }}" class="mb-6 flex items-center gap-3">
                <label for="range" class="text-white font-semibold whitespace-nowrap">Tampilkan:</label>
                <div class="relative w-52">
                    <!-- Trigger Dropdown: kita ganti jadi button biasa tanpa interaksi JS -->
                    <button type="button" onclick="document.getElementById('dropdown-menu').classList.toggle('hidden')"
                        class="w-full bg-white text-blue-800 font-semibold py-2 px-4 rounded flex justify-between items-center border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                        {{ $range === '30' ? '30 Hari Terakhir' : ($range === 'all' ? 'Semua' : '7 Hari Terakhir') }}
                        <i class="fas fa-chevron-down transition-transform duration-200"></i>
                    </button>

                    <!-- Dropdown Options (hidden by default) -->
                    <div id="dropdown-menu"
                        class="hidden absolute mt-2 w-full bg-white border border-gray-300 rounded shadow-md z-10">
                        <a href="{{ route('dashboard', ['range' => '7']) }}"
                            class="block px-4 py-2 hover:bg-blue-100 text-blue-800 font-semibold {{ $range === '7' ? 'bg-blue-50' : '' }}">
                            7 Hari Terakhir
                        </a>
                        <a href="{{ route('dashboard', ['range' => '30']) }}"
                            class="block px-4 py-2 hover:bg-blue-100 text-blue-800 font-semibold {{ $range === '30' ? 'bg-blue-50' : '' }}">
                            30 Hari Terakhir
                        </a>
                        <a href="{{ route('dashboard', ['range' => 'all']) }}"
                            class="block px-4 py-2 hover:bg-blue-100 text-blue-800 font-semibold {{ $range === 'all' ? 'bg-blue-50' : '' }}">
                            Semua
                        </a>
                    </div>
                </div>
            </form>

            <div class="bg-teal-500 p-6 rounded-lg border-2 border-white">
                <h2 class="text-2xl font-bold mb-4">
                    Statistik Penjualan (
                    {{ $range === '30' ? '30 Hari Terakhir' : ($range === 'all' ? 'Semua' : '7 Hari Terakhir') }} )
                </h2>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>

        {{--  sweat alert  --}}
        @if (session('login_success'))
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Selamat datang, {{ session('login_success') }}!',
                        text: 'Berhasil login.',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        @endif

        {{--  JavaScript  --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var ctx = document.getElementById('lineChart').getContext('2d');
            var lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($dates) !!},
                    datasets: [{
                        label: 'Total Penjualan',
                        data: {!! json_encode($sales) !!},
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: false,
                        tension: 0.3,
                        borderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: 'rgb(75, 192, 192)',
                        pointHoverBackgroundColor: 'rgb(54, 162, 235)',
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal'
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Penjualan'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            enabled: true,
                            mode: 'nearest',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        intersect: false
                    }
                }
            });

            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById('dropdown-menu');
                const button = dropdown.previousElementSibling;

                if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        </script>
</body>

</html>
