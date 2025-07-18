<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layouts.head')
    <title>{{ $title }} | e-Kasir</title>
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    @include('layouts.navbar-2')
    @include('layouts.sidebar')
    @include('layouts.alert')

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-4 text-white">
                DAFTAR MEMBER
            </h1>

            <!-- Button Add Member -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('member.create') }}"
                    class="bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-950 hover:text-black transition duration-300">
                    Tambah Member
                </a>
            </div>

            <div class="mb-4">
                <form action="{{ route('member.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Cari member..." value="{{ request('search') }}"
                        class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button type="submit"
                        class="bg-[#1E3A8A] text-white px-4 py-2 rounded-lg hover:bg-blue-950 transition">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Member -->
            <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                <table class="min-w-full table-auto">
                    <thead class="bg-[#1E3A8A] text-white">
                        <tr>
                            <th class="px-6 py-3 text-left">No</th>
                            <th class="px-6 py-3 text-left">Nama</th>
                            <th class="px-6 py-3 text-left">No Telpon</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            {{--  <th class="px-6 py-3 text-left">Diskon</th>  --}}
                            <th class="px-6 py-3 text-left">Point</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $index => $member)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-6 py-3">{{ $index + 1 }}</td>
                                <td class="px-6 py-3">{{ $member->name }}</td>
                                <td class="px-6 py-3">{{ $member->no_telp }}</td>
                                <td class="px-6 py-3">{{ $member->email }}</td>
                                <td class="px-6 py-3">
                                    <span class="{{ $member->status == 'active' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $member->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                {{--  <td class="px-6 py-3">{{ $member->discount_percentage ?? 0 }}%</td>  --}}
                                <td class="px-6 py-3">{{ $member->point ?? 0 }}</td>
                                <td class="px-6 py-3">
                                    <div class="flex flex-col gap-2 w-28">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('member.edit', $member->id) }}"
                                            class="flex items-center justify-center gap-1 bg-yellow-400 text-black font-semibold px-3 py-1.5 rounded hover:bg-yellow-500 transition text-sm w-full">
                                            <i class="fas fa-edit text-base"></i> Edit
                                        </a>

                                        <!-- Tombol Aktif/Nonaktif -->
                                        <form action="{{ route('member.toggleStatus', $member->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="flex items-center justify-center gap-1 px-3 py-1.5 rounded text-sm w-full font-semibold transition
                {{ $member->status == 'active' ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-green-500 text-white hover:bg-green-600' }}">
                                                {{ $member->status == 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>

                                        <!-- Tombol Hapus -->
                                        @if ($member->status === 'inactive')
                                            <form action="{{ route('member.destroy', $member->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus member {{ $member->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex items-center justify-center gap-1 bg-red-600 text-white font-semibold px-3 py-1.5 rounded hover:bg-red-700 transition text-sm w-full">
                                                    <i class="fas fa-trash-alt text-base"></i> Hapus
                                                </button>
                                            </form>
                                        @else
                                            <button disabled
                                                class="flex items-center justify-center gap-1 bg-gray-400 text-white font-semibold px-3 py-1.5 rounded cursor-not-allowed text-sm w-full">
                                                <i class="fas fa-trash-alt text-base"></i> Hapus
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
