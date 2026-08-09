<x-dashboard-layout title="Dashboard Dosen Pembimbing">
<x-slot:sidebar>
    <!-- Menu Dashboard -->
    <x-nav-item href="{{ route('dosen.dashboard') }}" :active="request()->routeIs('dosen.dashboard')">
        Dashboard
    </x-nav-item>

    <!-- Menu Pengajuan Proyek -->
    <x-nav-item href="{{ route('dosen.pengajuan.proyek') }}" :active="request()->routeIs('dosen.pengajuan.proyek')">
        Pengajuan Proyek
    </x-nav-item>

    <!-- Menu Validasi Proposal -->
    <x-nav-item href="{{ route('dosen.validasi.proposal') }}" :active="request()->routeIs('dosen.validasi.proposal')">
        Validasi Proposal
    </x-nav-item>

    <!-- Menu Penilaian Mahasiswa -->
    <x-nav-item href="{{ route('dosen.penilaian') }}" :active="request()->routeIs('dosen.penilaian')">
        Penilaian Mahasiswa
    </x-nav-item>

    <!-- Menu Profile -->
    <x-nav-item href="{{ route('dosen.profile') }}" :active="request()->routeIs('dosen.profile')">
        Profile Dosen
    </x-nav-item>
</x-slot:sidebar>

    <div class="bg-white rounded-xl border border-border p-6">
        <p class="font-display text-2xl font-semibold">Halo, {{ auth()->user()->name }} 👋</p>
        <p class="text-sm text-ink/60 mt-1">Kelola validasi dan penilaian mahasiswa bimbingan kamu di sini.</p>
    </div>
</x-dashboard-layout>