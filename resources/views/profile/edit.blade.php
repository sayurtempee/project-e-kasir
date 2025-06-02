<head>
    {{--  <script src="https://cdn.tailwindcss.com"></script>  --}}
    @include('layouts.head')
</head>

<x-app-layout>
    <div class="min-h-screen bg-[#3B82F6] py-10 px-4">
        <div class="mb-6 flex justify-end">
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center px-4 py-2 bg-[#1E3A8A] text-white text-sm font-semibold rounded-md
                       hover:bg-blue-950 hover:shadow-lg hover:scale-105 transition-all duration-300 ease-in-out">
                ← Kembali
            </a>
        </div>

        <div
            class="max-w-3xl mx-auto bg-blue-950 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300">
            <h1 class="text-4xl font-bold text-white text-center mb-12 animate__animated animate__fadeIn">Edit Profil
            </h1>

            <form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data" class="space-y-8">
                {{--  <p class="text-white text-sm mb-2">Form Action: {{ route('profile.update') }}</p>  --}}
                @csrf
                @method('PUT')

                <!-- Foto Profil -->
                <div class="mb-6 flex flex-col items-center space-y-4">
                    <div class="w-40 h-40 rounded-full overflow-hidden bg-gray-300" id="preview-container">
                        @if ($user->photo)
                            <img id="preview-image" src="{{ asset('storage/' . $user->photo) }}" alt="Profile Photo"
                                class="w-full h-full object-cover">
                        @else
                            @php
                                $name = strtoupper(str_replace(' ', '', Auth::user()->name));
                                $initials = substr($name, 0, 2);
                            @endphp
                            <div
                                class="w-full h-full bg-indigo-500 flex items-center justify-center text-white text-7xl font-bold rounded-full">
                                {{ $initials }}
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col items-center space-y-2">
                        <label class="block text-sm font-medium text-white">Ganti Foto Profil</label>
                        <input id="photo" type="file" name="photo" accept="image/*" onchange="previewFile()"
                            class="mt-1 block w-full text-sm text-white file:py-2 file:px-4 file:border file:border-white file:bg-white file:text-black hover:file:bg-gray-100">

                        @if ($user->photo)
                            <label
                                class="inline-flex items-center mt-6 space-x-3 cursor-pointer hover:scale-105 transition-transform duration-300 ease-in-out">
                                <input type="checkbox" name="hapus_foto" value="1"
                                    class="h-5 w-5 text-red-500 border-white rounded-lg focus:ring-2 focus:ring-red-500">
                                <span class="text-lg font-semibold text-red-600 hover:text-red-700">
                                    <span class="flex items-center">
                                        Hapus Foto Profil
                                    </span>
                                </span>
                            </label>
                        @endif
                    </div>
                </div>

                <!-- Form Input Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-white">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="mt-1 block w-full px-4 py-2 rounded-lg border border-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white">
                </div>

                <!-- Form Input Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-white">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="mt-1 block w-full px-4 py-2 rounded-lg border border-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-white">
                </div>

                <!-- Button Simpan -->
                <div class="flex justify-center">
                    <button type="submit"
                        class="w-1/2 py-3 bg-green-600 text-white rounded-lg font-bold text-lg hover:bg-green-700 transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-indigo-400">
                        Simpan Perubahan
                    </button>
                </div>
                <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">
            </form>
        </div>
    </div>

    <script>
        function previewFile() {
            const preview = document.getElementById('preview-image');
            const file = document.getElementById('photo').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function() {
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>
