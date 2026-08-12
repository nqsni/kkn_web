<x-dashboard-layout title="Input Penilaian Akhir">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.proyek.index') }}">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi-proposal.index') }}">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-logbook.index') }}">Penilaian Logbook</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-laporan.index') }}">Penilaian Laporan Akhir</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-akhir.index') }}" :active="true">Penilaian Akhir</x-nav-item>
    </x-slot:sidebar>

    <a href="{{ route('dosen.penilaian-akhir.index') }}" class="text-sm text-ink/50 hover:text-ink mb-4 inline-block">← Kembali</a>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl border border-border p-6 mb-5">
            <p class="font-display text-xl font-semibold mb-1">{{ $proyek->judul }}</p>
            <p class="text-sm text-ink/60">{{ $proyek->mahasiswa->name ?? '-' }}</p>
        </div>

        @if ($proyek->nilaiAkhir)
            <div class="bg-ink rounded-2xl p-6 mb-5 flex items-center justify-between">
                <div>
                    <p class="text-xs text-white/50">Nilai Akhir Saat Ini</p>
                    <p class="font-display text-3xl font-semibold text-white mt-1">{{ number_format($proyek->nilaiAkhir->nilai_akhir, 2) }}</p>
                </div>
                <div class="w-16 h-16 rounded-full border-2 border-white/30 flex items-center justify-center">
                    <span class="font-display text-2xl font-semibold text-white">{{ $proyek->nilaiAkhir->nilai_mutu }}</span>
                </div>
            </div>
        @endif

        {{-- LRK & LPK: read-only, sumber otomatis --}}
        <div class="grid grid-cols-2 gap-4 mb-5">
            <div class="bg-white rounded-2xl border border-border p-5">
                <p class="text-xs text-ink/40">LRK <span class="text-ink/30">(dari nilai Proposal, 15%)</span></p>
                <p class="font-display text-xl font-semibold mt-1">
                    {{ $proyek->proposal && $proyek->proposal->nilai !== null ? number_format($proyek->proposal->nilai, 2) : '—' }}
                </p>
                @if (!$proyek->proposal || $proyek->proposal->nilai === null)
                    <p class="text-xs text-role-panitia mt-1">Proposal belum dinilai</p>
                @endif
            </div>
            <div class="bg-white rounded-2xl border border-border p-5">
                <p class="text-xs text-ink/40">LPK <span class="text-ink/30">(dari nilai Laporan Akhir, 15%)</span></p>
                <p class="font-display text-xl font-semibold mt-1">
                    {{ $proyek->laporanAkhir && $proyek->laporanAkhir->nilai !== null ? number_format($proyek->laporanAkhir->nilai, 2) : '—' }}
                </p>
                @if (!$proyek->laporanAkhir || $proyek->laporanAkhir->nilai === null)
                    <p class="text-xs text-role-panitia mt-1">Laporan akhir belum dinilai</p>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-border p-6">
            <p class="font-display text-base font-semibold mb-1">Input Kinerja Mahasiswa</p>
            <p class="text-xs text-ink/40 mb-4">Bobot total 70% dari nilai akhir.</p>

            @if ($errors->any())
                <div class="mb-4 px-4 py-3 rounded-2xl bg-role-panitia-soft text-role-panitia text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('dosen.penilaian-akhir.update', $proyek) }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs text-ink/60 mb-1">Pelaksanaan (30%)</label>
                        <input type="number" name="pelaksanaan" value="{{ old('pelaksanaan', $proyek->penilaianKinerja->pelaksanaan ?? '') }}" min="0" max="100" step="0.01"
                               class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-ink/60 mb-1">Disiplin (15%)</label>
                        <input type="number" name="disiplin" value="{{ old('disiplin', $proyek->penilaianKinerja->disiplin ?? '') }}" min="0" max="100" step="0.01"
                               class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-ink/60 mb-1">Kerjasama (15%)</label>
                        <input type="number" name="kerjasama" value="{{ old('kerjasama', $proyek->penilaianKinerja->kerjasama ?? '') }}" min="0" max="100" step="0.01"
                               class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-ink/60 mb-1">Penghayatan (10%)</label>
                        <input type="number" name="penghayatan" value="{{ old('penghayatan', $proyek->penilaianKinerja->penghayatan ?? '') }}" min="0" max="100" step="0.01"
                               class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
                    </div>
                </div>

                <button type="submit"
                        class="w-full px-5 py-3 rounded-2xl bg-brand text-white text-sm font-semibold hover:bg-brand/90 transition">
                    Hitung & Simpan Nilai Akhir
                </button>
            </form>
        </div>
    </div>
</x-dashboard-layout>