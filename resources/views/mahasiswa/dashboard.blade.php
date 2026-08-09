<x-dashboard-layout title="Dashboard Mahasiswa">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('mahasiswa.dashboard') }}" :active="true">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proyek.index') }}">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.war.index') }}">War Proyek Tersedia</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proposal.index') }}">Proposal</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.logbook.index') }}">Logbook Mingguan</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.laporan-akhir.index') }}">Laporan Akhir</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.nilai.index') }}">Nilai Saya</x-nav-item>
    </x-slot:sidebar>

    <div class="bg-white rounded-xl border border-border p-6">
        <p class="font-display text-2xl font-semibold">Halo, {{ auth()->user()->name }} 👋</p>
        <p class="text-sm text-ink/60 mt-1">Selamat datang di sistem KKN. Mulai dengan mengajukan proyek KKN kamu.</p>
    </div>
</x-dashboard-layout>