<head>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</head>
<header class="fixed top-0 left-0 right-0 bg-white shadow-md z-50 h-16 flex items-center justify-between p-4">
    <div class="container mx-auto flex justify-between items-center px-4">
        <!-- Logo -->
        <div class="text-4xl font-bold">
            <span class="text-blue-900 cursor-pointer" onclick="window.location.href='/dashboard'">
                Kasir
            </span>
            <span class="text-black cursor-pointer" onclick="window.location.href='/dashboard'">
                .Mii
            </span>
        </div>

        <!-- Navbar -->
        <!-- Tombol LOGIN -->
        <a href="{{ route('login') }}"
            class="bg-[#1E3A8A] text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-950 hover:text-white transition relative z-50">
            LOGIN
        </a>
    </div>
</header>
