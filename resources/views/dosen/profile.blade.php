<x-dashboard-layout title="Profile Dosen">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.pengajuan.proyek') }}">Pengajuan Proyek</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi.proposal') }}">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian') }}">Penilaian Mahasiswa</x-nav-item>
        <x-nav-item href="{{ route('dosen.profile') }}" :active="true">Profile Dosen</x-nav-item>
    </x-slot:sidebar>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Kartu Identitas -->
        <div class="col-span-1 bg-white rounded-xl border border-border p-6 shadow-sm flex flex-col items-center text-center">
            <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mb-4">
                <span class="text-3xl font-bold text-emerald-600">A</span>
            </div>
            <h3 class="font-bold text-lg text-gray-800">{{ auth()->user()->name }}</h3>
            <p class="text-sm text-gray-500 mb-6">Dosen Pembimbing Lapangan</p>
            
            <!-- Tombol Logout -->
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                <!-- @csrf (Aktifkan saat backend siap) -->
                <button type="submit" class="w-full py-2 px-4 bg-red-50 text-red-600 font-semibold rounded-lg hover:bg-red-100 transition">
                    Keluar (Logout)
                </button>
            </form>
        </div>

        <!-- Detail Biodata -->
        <div class="col-span-1 md:col-span-2 bg-white rounded-xl border border-border p-6 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-800 mb-6">Biodata Dosen</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</label>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                </div>
                <hr class="border-gray-100">
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">NIK / NIDN</label>
                    <p class="mt-1 text-sm font-medium text-gray-900">0123456789</p>
                </div>
                <hr class="border-gray-100">
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Email Akun</label>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>