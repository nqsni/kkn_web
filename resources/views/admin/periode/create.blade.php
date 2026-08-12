<x-dashboard-layout title="Buat Periode KKN">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('admin.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('admin.periode.index') }}" :active="true">Periode KKN</x-nav-item>
        <x-nav-item href="{{ route('admin.data-master.index') }}">Data Master</x-nav-item>
        <x-nav-item href="{{ route('admin.rubrik-penilaian.index') }}">Rubrik Penilaian</x-nav-item>
        <x-nav-item href="{{ route('admin.users.index') }}">Manajemen User</x-nav-item>
    </x-slot:sidebar>

    <div class="max-w-lg">
        <a href="{{ route('admin.periode.index') }}" class="text-sm text-ink/50 hover:text-ink mb-4 inline-block">← Kembali</a>

        <div class="bg-white rounded-2xl border border-border p-6">
            <p class="font-display text-xl font-semibold mb-1">Buat Periode KKN Baru</p>
            <p class="text-sm text-ink/60 mb-6">Periode baru akan dibuat dengan status "draft".</p>

            @if ($errors->any())
                <div class="mb-4 px-4 py-3 rounded-2xl bg-role-panitia-soft text-role-panitia text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.periode.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1.5">Nama Periode</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Ganjil 2026/2027"
                           class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                               class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                               class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
                    </div>
                </div>
                <button type="submit" class="w-full px-5 py-2.5 rounded-2xl bg-brand text-white text-sm font-medium hover:bg-brand/90 transition">
                    Buat Periode
                </button>
            </form>
        </div>
    </div>
</x-dashboard-layout>