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
            <h1 class="text-3xl font-bold mb-4 text-white">
                TAMBAH ADMIN
            </h1>

            <form method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="nama">NAMA</label>
                    <input
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline"
                        id="nama" type="text" placeholder="Nama" name="name" value="{{ old('name') }}"
                        autofocus>
                    @error('name')
                        <div class="text-red-200 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="email">EMAIL</label>
                    <input
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline"
                        id="email" type="email" placeholder="Email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="text-red-200 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="password">PASSWORD</label>
                    <div class="relative">
                        <input
                            class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline pr-10"
                            id="password" type="password" placeholder="Password" name="password">
                        <button type="button" onclick="toggleVisibility('password', this)"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 focus:outline-none">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-red-200 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- KONFIRMASI PASSWORD -->
                <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="password_confirmation">KONFIRMASI
                        PASSWORD</label>
                    <div class="relative">
                        <input
                            class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline pr-10"
                            id="password_confirmation" type="password" placeholder="Ulangi Password"
                            name="password_confirmation">
                        <button type="button" onclick="toggleVisibility('password_confirmation', this)"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 focus:outline-none">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="text-red-200 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{--  <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="status">STATUS</label>
                    <select
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline"
                        id="status" name="status" required>
                        <option value="">Pilih Status</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif
                        </option>
                    </select>
                    @error('status')
                        <div class="text-red-200 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>  --}}

                <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="role">ROLE</label>
                    <select
                        class="w-full px-3 py-2 text-gray-700 leading-tight rounded-lg focus:outline-none focus:shadow-outline"
                        id="role" name="role">
                        <option value="">Pilih Role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    </select>
                    @error('role')
                        <div class="text-red-200 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-white text-sm font-bold mb-2" for="photo">FOTO PROFIL</label>
                    <label for="photo"
                        class="flex items-center justify-center w-full px-4 py-2 bg-white text-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v4a1 1 0 001 1h3m10-6h2a1 1 0 011 1v10a1 1 0 01-1 1h-2M8 17h8m-6-4v4m0 0l-3-3m3 3l3-3" />
                        </svg>
                        Pilih Foto
                    </label>
                    <input type="file" id="photo" name="photo" accept="image/*" class="hidden"
                        onchange="document.getElementById('file-name').textContent = this.files[0]?.name || ''">
                    <p id="file-name" class="mt-2 text-sm text-white italic"></p>
                    @error('photo')
                        <div class="text-red-200 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button
                        class="bg-[#1E3A8A] text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-950 hover:text-black transition duration-300"
                        type="submit">TAMBAH</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleVisibility(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</body>

</html>
