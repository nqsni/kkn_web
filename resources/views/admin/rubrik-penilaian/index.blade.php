<x-dashboard-layout title="Rubrik Penilaian">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('admin.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('admin.periode.index') }}">Periode KKN</x-nav-item>
        <x-nav-item href="{{ route('admin.data-master.index') }}">Data Master</x-nav-item>
        <x-nav-item href="{{ route('admin.rubrik-penilaian.index') }}" :active="true">Rubrik Penilaian</x-nav-item>
        <x-nav-item href="{{ route('admin.users.index') }}">Manajemen User</x-nav-item>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-dosen-soft text-role-dosen text-sm">{{ session('success') }}</div>
    @endif

    <div class="mb-6">
        <p class="font-display text-xl font-semibold">Rubrik Penilaian</p>
        <p class="text-sm text-ink/60 mt-1">
            Referensi bobot komponen penilaian KKN-PPM Polman.
            <span class="text-role-panitia">Catatan: perhitungan nilai akhir saat ini masih memakai bobot tetap sesuai standar (15/70/15), bukan dari tabel ini.</span>
        </p>
    </div>

    <div class="bg-white rounded-2xl border border-border p-5 mb-6 max-w-md">
        <form method="POST" action="{{ route('admin.rubrik-penilaian.store') }}" class="flex gap-2">
            @csrf
            <input type="text" name="komponen" placeholder="Nama komponen"
                   class="flex-1 rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
            <input type="number" name="bobot" placeholder="Bobot %" step="0.01" min="0" max="100"
                   class="w-28 rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
            <button type="submit" class="px-4 py-2 rounded-2xl bg-brand text-white text-sm font-medium hover:bg-brand/90 transition whitespace-nowrap">
                + Tambah
            </button>
        </form>
    </div>

    <div class="space-y-2 max-w-md">
        @forelse ($rubrikList as $rubrik)
            <div class="flex items-center justify-between bg-white rounded-2xl border border-border px-4 py-3">
                <form method="POST" action="{{ route('admin.rubrik-penilaian.update', $rubrik) }}" class="flex items-center gap-3 flex-1">
                    @csrf @method('PATCH')
                    <span class="text-sm font-medium flex-1">{{ $rubrik->komponen }}</span>
                    <input type="number" name="bobot" value="{{ $rubrik->bobot }}" step="0.01" min="0" max="100"
                           class="w-20 rounded-2xl border-border focus:border-brand focus:ring-brand text-xs py-1">
                    <span class="text-xs text-ink/40">%</span>
                    <button type="submit" class="text-xs text-role-dosen hover:underline">Simpan</button>
                </form>
                <form method="POST" action="{{ route('admin.rubrik-penilaian.destroy', $rubrik) }}" onsubmit="return confirm('Hapus?')" class="ml-2">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-xs text-role-panitia hover:underline">Hapus</button>
                </form>
            </div>
        @empty
            <p class="text-sm text-ink/40">Belum ada rubrik penilaian.</p>
        @endforelse
    </div>
</x-dashboard-layout>