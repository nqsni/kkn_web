<x-slot:sidebar>
    <x-nav-item href="{{ route('admin.dashboard') }}" :active="true">Dashboard</x-nav-item>
    <x-nav-item href="{{ route('admin.periode.index') }}">Periode KKN</x-nav-item>
    <x-nav-item href="{{ route('admin.data-master.index') }}">Data Master</x-nav-item>
    <x-nav-item href="{{ route('admin.rubrik-penilaian.index') }}">Rubrik Penilaian</x-nav-item>
    <x-nav-item href="{{ route('admin.users.index') }}">Manajemen User</x-nav-item>
</x-slot:sidebar>