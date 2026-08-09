<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Dosen - KKN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex h-screen font-sans">

    <!-- Sidebar Hijau -->
    <aside class="w-64 bg-emerald-600 text-white flex flex-col hidden md:flex">
        <div class="p-6 text-2xl font-bold border-b border-emerald-500">
            KKN Portal
        </div>
        <nav class="flex-1 px-4 py-4 space-y-2">
            <a href="{{ route('dosen.dashboard') }}" class="block px-4 py-2 rounded-lg bg-emerald-700 hover:bg-emerald-800">Dashboard</a>
            <a href="{{ route('dosen.pengajuan.proyek') }}" class="block px-4 py-2 rounded-lg hover:bg-emerald-700">Pengajuan Proyek</a>
            <a href="{{ route('dosen.validasi.proposal') }}" class="block px-4 py-2 rounded-lg hover:bg-emerald-700">Validasi Proposal</a>
            <a href="{{ route('dosen.penilaian') }}" class="block px-4 py-2 rounded-lg hover:bg-emerald-700">Penilaian Mahasiswa</a>
        </nav>
        <div class="p-4 border-t border-emerald-500">
            <a href="{{ route('dosen.profile') }}" class="block px-4 py-2 rounded-lg hover:bg-emerald-700">Profile</a>
        </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 flex flex-col overflow-y-auto">
        <!-- Header Atas -->
        <header class="bg-white p-4 shadow-sm flex justify-between items-center">
            <div class="text-gray-600 font-semibold">@yield('header-title', 'Halaman')</div>
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium">Ahmadi (Dosen)</span>
                <div class="w-8 h-8 rounded-full bg-emerald-200"></div>
            </div>
        </header>

        <!-- Area Konten Dinamis -->
        <div class="p-6">
            @yield('content')
        </div>
    </main>

</body>
</html>