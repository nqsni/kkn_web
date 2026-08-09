<x-dashboard-layout title="Dashboard Super Admin">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('admin.dashboard') }}" :active="true">Dashboard</x-nav-item>
        <x-nav-item href="#">Data Master</x-nav-item>
        <x-nav-item href="#">Rubrik Penilaian</x-nav-item>
        <x-nav-item href="#">Manajemen User</x-nav-item>
    </x-slot:sidebar>

    <div class="bg-white rounded-xl border border-border p-6">
        <p class="font-display text-2xl font-semibold">Halo, {{ auth()->user()->name }} 👋</p>
        <p class="text-sm text-ink/60 mt-1">Kelola data master, rubrik penilaian, dan user sistem.</p>
    </div>
</x-dashboard-layout>