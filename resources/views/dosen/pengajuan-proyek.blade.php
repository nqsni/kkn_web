<x-dashboard-layout title="Pengajuan Proyek KKN">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.pengajuan.proyek') }}" :active="true">Pengajuan Proyek</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi.proposal') }}">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian') }}">Penilaian Mahasiswa</x-nav-item>
        <x-nav-item href="{{ route('dosen.profile') }}">Profile Dosen</x-nav-item>
    </x-slot:sidebar>

    <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
        <h2 class="font-display text-xl font-bold text-gray-800 mb-6">Formulir Pengajuan Proyek</h2>
        
        <form action="#" method="POST" class="space-y-6 max-w-3xl">
            <!-- CSRF Token diletakkan di sini jika form sudah terhubung ke backend -->
            <!-- @csrf -->
            
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Nama Proyek / Program Kerja</label>
                <input type="text" placeholder="Masukkan nama proyek KKN" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-emerald-500">
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Lokasi / Mitra Desa</label>
                <input type="text" placeholder="Masukkan lokasi pelaksanaan" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-emerald-500">
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Deskripsi Singkat Proyek</label>
                <textarea rows="4" placeholder="Jelaskan secara singkat tujuan dan ruang lingkup proyek..." class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-emerald-500"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" class="px-5 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">Kirim Pengajuan</button>
            </div>
        </form>
    </div>
</x-dashboard-layout>