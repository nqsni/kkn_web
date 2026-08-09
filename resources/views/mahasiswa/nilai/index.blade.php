<x-dashboard-layout title="Nilai Saya">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('mahasiswa.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proyek.index') }}">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.war.index') }}">War Proyek Tersedia</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proposal.index') }}">Proposal</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.logbook.index') }}">Logbook Mingguan</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.laporan-akhir.index') }}">Laporan Akhir</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.nilai.index') }}" :active="true">Nilai Saya</x-nav-item>
    </x-slot:sidebar>

    <div class="max-w-3xl">
        <div class="mb-6">
            <p class="font-display text-xl font-semibold">Nilai — {{ $proyek->judul }}</p>
            <p class="text-sm text-ink/60 mt-1">Rincian penilaian KKN kamu.</p>
        </div>

        @if (!$proyek->nilaiAkhir)
            <div class="bg-white rounded-xl border border-border p-10 text-center">
                <p class="text-sm text-ink/60">Nilai akhir belum ditetapkan. Menunggu rapat koordinasi DPL & Pengelola Program.</p>
            </div>
        @else
            {{-- NILAI AKHIR (highlight) --}}
            <div class="bg-ink rounded-xl p-6 mb-5 flex items-center justify-between">
                <div>
                    <p class="text-xs text-white/50">Nilai Akhir</p>
                    <p class="font-display text-3xl font-semibold text-white mt-1">{{ number_format($proyek->nilaiAkhir->nilai_akhir, 2) }}</p>
                </div>
                <div class="w-16 h-16 rounded-full border-2 border-white/30 flex items-center justify-center">
                    <span class="font-display text-2xl font-semibold text-white">{{ $proyek->nilaiAkhir->nilai_mutu }}</span>
                </div>
            </div>

            {{-- BREAKDOWN KOMPONEN --}}
            <div class="grid grid-cols-3 gap-4 mb-5">
                <div class="bg-white rounded-xl border border-border p-5">
                    <p class="text-xs text-ink/40">LRK <span class="text-ink/30">(15%)</span></p>
                    <p class="font-display text-xl font-semibold mt-1">{{ number_format($proyek->nilaiAkhir->nilai_lrk, 2) }}</p>
                </div>
                <div class="bg-white rounded-xl border border-border p-5">
                    <p class="text-xs text-ink/40">Kinerja <span class="text-ink/30">(70%)</span></p>
                    <p class="font-display text-xl font-semibold mt-1">{{ number_format($proyek->nilaiAkhir->nilai_kinerja, 2) }}</p>
                </div>
                <div class="bg-white rounded-xl border border-border p-5">
                    <p class="text-xs text-ink/40">LPK <span class="text-ink/30">(15%)</span></p>
                    <p class="font-display text-xl font-semibold mt-1">{{ number_format($proyek->nilaiAkhir->nilai_lpk, 2) }}</p>
                </div>
            </div>

            {{-- DETAIL KINERJA --}}
            @if ($proyek->penilaianKinerja)
                <div class="bg-white rounded-xl border border-border p-6">
                    <p class="text-sm font-medium mb-4">Rincian Kinerja</p>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-ink/60">Pelaksanaan <span class="text-ink/30">(30%)</span></span>
                            <span class="font-medium">{{ number_format($proyek->penilaianKinerja->pelaksanaan, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-ink/60">Disiplin <span class="text-ink/30">(15%)</span></span>
                            <span class="font-medium">{{ number_format($proyek->penilaianKinerja->disiplin, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-ink/60">Kerjasama <span class="text-ink/30">(15%)</span></span>
                            <span class="font-medium">{{ number_format($proyek->penilaianKinerja->kerjasama, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-ink/60">Penghayatan <span class="text-ink/30">(10%)</span></span>
                            <span class="font-medium">{{ number_format($proyek->penilaianKinerja->penghayatan, 2) }}</span>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</x-dashboard-layout>