<x-dashboard-layout title="Kapasitas — {{ $periode->nama }}">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('admin.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('admin.periode.index') }}" :active="true">Periode KKN</x-nav-item>
        <x-nav-item href="{{ route('admin.data-master.index') }}">Data Master</x-nav-item>
        <x-nav-item href="{{ route('admin.rubrik-penilaian.index') }}">Rubrik Penilaian</x-nav-item>
        <x-nav-item href="{{ route('admin.users.index') }}">Manajemen User</x-nav-item>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-dosen-soft text-role-dosen text-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-panitia-soft text-role-panitia text-sm">{{ session('error') }}</div>
    @endif

    <a href="{{ route('admin.periode.index') }}" class="text-sm text-ink/50 hover:text-ink mb-4 inline-block">← Kembali</a>

    <p class="font-display text-xl font-semibold mb-6">Kapasitas & Rilis — {{ $periode->nama }}</p>

    {{-- TRACKER --}}
    @php
        $selisih = $periode->selisih_kuota;
    @endphp
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-border p-5">
            <p class="text-xs text-ink/40">Mahasiswa Terdaftar</p>
            <p class="font-display text-2xl font-semibold mt-1">{{ $jumlahMahasiswa }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-border p-5">
            <p class="text-xs text-ink/40">Total Kuota Proyek</p>
            <p class="font-display text-2xl font-semibold mt-1">{{ $periode->total_kuota }}</p>
        </div>
        <div class="rounded-2xl p-5 {{ $selisih > 0 ? 'bg-role-panitia-soft' : 'bg-accent-kiwi/15' }}">
            <p class="text-xs {{ $selisih > 0 ? 'text-role-panitia' : 'text-accent-kiwi' }}">
                {{ $selisih > 0 ? 'Kurang Kuota' : 'Kuota Cukup' }}
            </p>
            <p class="font-display text-2xl font-semibold mt-1 {{ $selisih > 0 ? 'text-role-panitia' : 'text-accent-kiwi' }}">
                {{ $selisih > 0 ? $selisih : 0 }}
            </p>
        </div>
    </div>

    {{-- MENUNGGU RILIS --}}
    <p class="font-display text-lg font-semibold mb-4">Menunggu Rilis ({{ $menungguRilis->count() }})</p>

    @if ($menungguRilis->isEmpty())
        <p class="text-sm text-ink/40 mb-8">Tidak ada proyek yang menunggu rilis.</p>
    @else
        <div class="space-y-3 mb-8">
            @foreach ($menungguRilis as $proyek)
                <div class="bg-white rounded-2xl border border-border p-5">
                    <div class="flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="font-display text-base font-semibold truncate">{{ $proyek->judul }}</p>
                            <p class="text-sm text-ink/60 mt-1">
                                {{ $proyek->pengaju_type === 'dosen' ? 'Diajukan Dosen: ' . $proyek->dosen?->name : 'Diajukan Mahasiswa: ' . $proyek->mahasiswa?->name }}
                            </p>
                            <p class="text-xs text-ink/40 mt-1">Tim {{ $proyek->jumlah_anggota }}/{{ $proyek->kuota_tim }}</p>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <form method="POST" action="{{ route('admin.periode.kapasitas.update-kuota', [$periode, $proyek]) }}" class="flex items-center gap-1">
                                @csrf @method('PATCH')
                                <input type="number" name="kuota_tim" value="{{ $proyek->kuota_tim }}" min="{{ $proyek->jumlah_anggota }}"
                                       class="w-16 rounded-xl border-border text-xs py-1.5 focus:border-brand focus:ring-brand">
                                <button type="submit" class="px-2 py-1.5 rounded-xl border border-border text-xs hover:bg-paper transition">Update</button>
                            </form>

                            <form method="POST" action="{{ route('admin.periode.kapasitas.rilis', [$periode, $proyek]) }}">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 rounded-xl bg-brand text-white text-xs font-semibold hover:bg-brand/90 transition">
                                    Rilis ke War
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- SUDAH DIRILIS --}}
    <p class="font-display text-lg font-semibold mb-4">Sudah Dirilis ({{ $sudahDirilis->count() }})</p>
    @if ($sudahDirilis->isEmpty())
        <p class="text-sm text-ink/40">Belum ada.</p>
    @else
        <div class="space-y-2">
            @foreach ($sudahDirilis as $proyek)
                <div class="flex items-center justify-between bg-white rounded-2xl border border-border px-5 py-3">
                    <div>
                        <p class="text-sm font-medium">{{ $proyek->judul }}</p>
                        <p class="text-xs text-ink/40">Tim {{ $proyek->jumlah_anggota }}/{{ $proyek->kuota_tim }}</p>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $proyek->status === 'penuh' ? 'bg-role-admin-soft text-role-admin' : 'bg-accent-kiwi/15 text-accent-kiwi' }}">
                        {{ $proyek->status === 'penuh' ? 'Penuh' : 'Tersedia' }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif
</x-dashboard-layout>