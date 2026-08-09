<x-dashboard-layout title="Profile Panitia">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('panitia.dashboard') }}" :active="request()->routeIs('panitia.dashboard')">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('panitia.validasi.proyek') }}" :active="request()->routeIs('panitia.validasi.proyek')">Validasi Proyek</x-nav-item>
        <x-nav-item href="{{ route('panitia.validasi.proposal') }}" :active="request()->routeIs('panitia.validasi.proposal')">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('panitia.lihat.nilai') }}" :active="request()->routeIs('panitia.lihat.nilai')">Lihat Nilai</x-nav-item>
        <x-nav-item href="{{ route('panitia.profile') }}" :active="request()->routeIs('panitia.profile')">Profile Panitia</x-nav-item>
    </x-slot:sidebar>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Kartu Identitas -->
        <div class="col-span-1 bg-white rounded-xl border border-border p-6 shadow-sm flex flex-col items-center text-center">
            <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mb-4">
                <span class="text-3xl font-bold text-emerald-600">P</span>
            </div>
            <h3 class="font-bold text-lg text-gray-800">{{ auth()->user()->name }}</h3>
            <p class="text-sm text-gray-500 mb-6">Panitia KKN / Administrator</p>
            
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full py-2 px-4 bg-red-50 text-red-600 font-semibold rounded-lg hover:bg-red-100 transition">
                    Keluar (Logout)
                </button>
            </form>
        </div>

        <!-- Biodata Lengkap -->
        <div class="col-span-1 md:col-span-2 bg-white rounded-xl border border-border p-6 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-800 mb-6">Biodata Akun</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</label>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                </div>
                <hr class="border-gray-100">
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">NIK / ID Pegawai</label>
                    <p class="mt-1 text-sm font-medium text-gray-900">PNT-2026-001</p>
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