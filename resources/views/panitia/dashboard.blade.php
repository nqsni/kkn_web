<x-dashboard-layout title="Dashboard Panitia KKN">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('panitia.dashboard') }}" :active="true">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('panitia.validasi-proyek.index') }}">Validasi Proyek KKN</x-nav-item>
        <x-nav-item href="{{ route('panitia.penempatan.index') }}">Penempatan Dosen</x-nav-item>
    </x-slot:sidebar>

    <div class="bg-white rounded-xl border border-border p-6">
        <p class="font-display text-2xl font-semibold">Halo, {{ auth()->user()->name }} 👋</p>
        <p class="text-sm text-ink/60 mt-1">Validasi proyek KKN yang masuk dan atur penempatan.</p>
    </div>
</x-dashboard-layout>