<x-dashboard-layout title="Penilaian Akhir">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi-proposal.index') }}">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-logbook.index') }}">Penilaian Logbook</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-laporan.index') }}">Penilaian Laporan Akhir</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-akhir.index') }}" :active="true">Penilaian Akhir</x-nav-item>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-dosen-soft text-role-dosen text-sm">{{ session('success') }}</div>
    @endif

    <div class="mb-6">
        <p class="font-display text-xl font-semibold">Penilaian Akhir</p>
        <p class="text-sm text-ink/60 mt-1">Rekap nilai LRK, Kinerja, dan LPK untuk mahasiswa bimbinganmu.</p>
    </div>

    @if ($proyekList->isEmpty())
        <div class="bg-white rounded-2xl border border-border p-10 text-center">
            <p class="text-sm text-ink/60">Belum ada proyek bimbingan yang siap dinilai.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($proyekList as $proyek)
                <div class="flex items-center justify-between bg-white rounded-2xl border border-border p-5">
                    <div>
                        <p class="font-display text-base font-semibold">{{ $proyek->judul }}</p>
                        <p class="text-sm text-ink/60 mt-1">{{ $proyek->mahasiswa->name }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if ($proyek->nilaiAkhir)
                            <div class="text-right">
                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-accent-kiwi/15 text-accent-kiwi">
                                    {{ number_format($proyek->nilaiAkhir->nilai_akhir, 2) }} · {{ $proyek->nilaiAkhir->nilai_mutu }}
                                </span>
                            </div>
                        @else
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-accent-yellow/20 text-role-mahasiswa">
                                Belum Dinilai
                            </span>
                        @endif
                        <a href="{{ route('dosen.penilaian-akhir.edit', $proyek) }}"
                           class="px-4 py-2 rounded-2xl bg-brand text-white text-xs font-semibold hover:bg-brand/90 transition">
                            {{ $proyek->nilaiAkhir ? 'Ubah Nilai' : 'Beri Nilai' }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-dashboard-layout>