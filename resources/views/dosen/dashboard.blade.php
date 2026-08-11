<x-dashboard-layout title="Dashboard Dosen Pembimbing">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}" :active="true">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi-proposal.index') }}">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-logbook.index') }}">Penilaian Logbook</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-laporan.index') }}">Penilaian Laporan Akhir</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-akhir.index') }}">Penilaian Akhir</x-nav-item>
    </x-slot:sidebar>

    <div class="bg-white rounded-2xl border border-border p-6">
        <p class="font-display text-2xl font-semibold">Halo, {{ auth()->user()->name }} 👋</p>
        <p class="text-sm text-ink/60 mt-1">Kelola validasi dan penilaian mahasiswa bimbingan kamu di sini.</p>
    </div>
</x-dashboard-layout>