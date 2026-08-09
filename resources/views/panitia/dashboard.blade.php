<x-dashboard-layout title="Dashboard Panitia KKN">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('panitia.dashboard') }}" :active="request()->routeIs('panitia.dashboard')">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('panitia.validasi.proyek') }}" :active="request()->routeIs('panitia.validasi.proyek')">Validasi Proyek</x-nav-item>
        <x-nav-item href="{{ route('panitia.validasi.proposal') }}" :active="request()->routeIs('panitia.validasi.proposal')">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('panitia.lihat.nilai') }}" :active="request()->routeIs('panitia.lihat.nilai')">Lihat Nilai</x-nav-item>
        <x-nav-item href="{{ route('panitia.profile') }}" :active="request()->routeIs('panitia.profile')">Profile Panitia</x-nav-item>
    </x-slot:sidebar>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
                <p class="font-display text-2xl font-semibold">Selamat Datang, {{ auth()->user()->name }}!</p>
                <p class="text-sm text-gray-500 mt-1">Pantau dan kelola seluruh alur kegiatan Kuliah Kerja Nyata di sini.</p>
            </div>

            <div class="bg-emerald-50 rounded-xl border border-emerald-100 p-6">
                <h3 class="font-bold text-emerald-800 mb-4">Guideline & Timeline (Sebelum KKN)</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-200 flex items-center justify-center text-emerald-700 font-bold">1</div>
                        <p class="text-sm font-medium text-gray-700">Validasi Penempatan Dosen dan Mahasiswa</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center border-2 border-emerald-200 text-gray-400 font-bold">2</div>
                        <p class="text-sm font-medium text-gray-500">Persetujuan Proposal KKN</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik -->
        <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-4">Statistik KKN</h3>
            <div class="space-y-4">
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 flex justify-between items-center">
                    <span class="text-sm text-gray-600 font-medium">Proyek KKN</span>
                    <span class="text-lg font-bold text-emerald-600">42</span>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 flex justify-between items-center">
                    <span class="text-sm text-gray-600 font-medium">Proposal Pending</span>
                    <span class="text-lg font-bold text-orange-500">15</span>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>