<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @include('layouts.head')
    <title>{{ $title }} | e-Kasir</title>
</head>

<body class="bg-[#3B82F6] min-h-screen grid grid-rows-[auto,1fr,auto]">
    @include('layouts.navbar-2')
    @include('layouts.sidebar')

    <div class="ml-64 mt-16 p-8 font-sans">
        <div class="container mx-auto p-4">
            <div class="mb-6 flex justify-end">
                <a href="{{ route('admin.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-[#1E3A8A] text-white text-sm font-semibold rounded-md
                           hover:bg-blue-950 hover:text-black hover:shadow-lg hover:scale-105 transition-all duration-300">
                    ← Kembali
                </a>
            </div>

            <h1 class="text-3xl font-bold mb-4 text-white">UBAH ADMIN</h1>

            <form action="{{ route('admin.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="name">NAMA</label>
                    <input
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline"
                        id="name" type="text" placeholder="Nama" name="name"
                        value="{{ old('name') ?? $admin->name }}" autofocus
                        @if (old('role', $admin->role) != 'kasir' && old('status', $admin->status) == 'tidak aktif') disabled @endif>
                    @error('name')
                        <div class="text-red-200 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-bold mb-2 text-white">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}"
                        class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:ring focus:border-blue-300"
                        @if (old('role', $admin->role) != 'kasir' && ($admin->status ?? old('status')) == 'tidak aktif') disabled @endif required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status (disabled) -->
                <div class="mb-6">
                    <label for="status" class="block text-white text-sm font-bold mb-2">STATUS</label>
                    <select id="status" name="status" disabled
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline">
                        <option value="aktif" {{ old('status', $admin->status) == 'aktif' ? 'selected' : '' }}>Aktif
                        </option>
                        <option value="tidak aktif"
                            {{ old('status', $admin->status) == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif
                        </option>
                    </select>
                    @error('status')
                        <div class="text-red-200 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Role -->
                <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="role">ROLE</label>
                    <select
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline"
                        id="role" name="role" @if (old('status', $admin->status) == 'tidak aktif') disabled @endif>
                        <option value="admin" {{ (old('role') ?? $admin->role) == 'admin' ? 'selected' : '' }}>Admin
                        </option>
                        <option value="kasir" {{ (old('role') ?? $admin->role) == 'kasir' ? 'selected' : '' }}>Kasir
                        </option>
                    </select>
                    @error('role')
                        <div class="text-red-200 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Foto Profil -->
                <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="photo">FOTO PROFIL</label>

                    <!-- Preview Foto -->
                    <div class="mb-4">
                        @if ($admin->photo)
                            <img id="photo-preview" src="{{ asset('storage/' . $admin->photo) }}" alt="Foto Profil"
                                class="w-32 h-32 object-cover rounded-full border-2 border-white">
                        @else
                            @php
                                $name = strtoupper(str_replace(' ', '', $admin->name));
                                $initials = substr($name, 0, 2);
                            @endphp
                            <div id="photo-preview"
                                class="w-32 h-32 bg-indigo-500 flex items-center justify-center text-white text-4xl font-bold rounded-full border-2 border-white">
                                {{ $initials }}
                            </div>
                        @endif
                    </div>

                    <!-- Input File Custom -->
                    <label for="photo"
                        class="flex items-center justify-center w-full px-4 py-2 bg-white text-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 transition duration-300
                        @if (old('role', $admin->role) != 'kasir' && old('status', $admin->status) == 'tidak aktif') opacity-50 cursor-not-allowed @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v4a1 1 0 001 1h3m10-6h2a1 1 0 011 1v10a1 1 0 01-1 1h-2M8 17h8m-6-4v4m0 0l-3-3m3 3l3-3" />
                        </svg>
                        Pilih Foto Baru
                    </label>
                    <input type="file" id="photo" name="photo" accept="image/*" class="hidden"
                        onchange="previewImage(event)" @if (old('role', $admin->role) != 'kasir' && old('status', $admin->status) == 'tidak aktif') disabled @endif>
                    @error('photo')
                        <div class="text-red-200 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Update -->
                <div class="flex justify-end">
                    <button
                        class="bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-950 hover:text-black transition duration-300"
                        type="submit">UPDATE</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photo-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>

</html>
