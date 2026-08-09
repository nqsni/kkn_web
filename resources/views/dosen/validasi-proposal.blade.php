<x-dashboard-layout title="Validasi Proposal KKN">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.pengajuan.proyek') }}">Pengajuan Proyek</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi.proposal') }}">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian') }}" :active="true">Penilaian Mahasiswa</x-nav-item>
        <x-nav-item href="{{ route('dosen.profile') }}">Profile Dosen</x-nav-item>
    </x-slot:sidebar>

    <!-- Area Konten Utama -->
    <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-display text-xl font-bold text-gray-800">Daftar Proposal Masuk</h2>
            
            <!-- Kolom Pencarian -->
            <div class="relative">
                <input type="text" placeholder="Cari kelompok..." class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-emerald-500">
            </div>
        </div>

        <!-- Tabel Sederhana -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Nama Kelompok</th>
                        <th class="px-4 py-3 font-semibold">Judul Proyek</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data Dummy (Nanti diganti dengan data dari database) -->
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">Kelompok 01 - Desa Maju</td>
                        <td class="px-4 py-3">Penerapan Teknologi Tepat Guna Pertanian</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-medium">Menunggu Review</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button class="px-3 py-1 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition">Beri Nilai</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard-layout>