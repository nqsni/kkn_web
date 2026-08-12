<x-dashboard-layout title="Penilaian Laporan Akhir">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.proyek.index') }}">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi-proposal.index') }}">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-logbook.index') }}">Penilaian Logbook</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-laporan.index') }}" :active="true">Penilaian Laporan Akhir</x-nav-item>
        <x-nav-item href="#">Penilaian Akhir</x-nav-item>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-dosen-soft text-role-dosen text-sm">{{ session('success') }}</div>
    @endif

    <div class="mb-6">
        <p class="font-display text-xl font-semibold">Belum Dinilai</p>
        <p class="text-sm text-ink/60 mt-1">{{ $belumDinilai->count() }} laporan akhir menunggu penilaian.</p>
    </div>

    @if ($belumDinilai->isEmpty())
        <div class="bg-white rounded-2xl border border-border p-10 text-center mb-10">
            <p class="text-sm text-ink/60">Tidak ada laporan akhir yang menunggu penilaian.</p>
        </div>
    @else
        <div class="space-y-3 mb-10">
            @foreach ($belumDinilai as $laporan)
                <div class="flex items-center justify-between bg-white rounded-2xl border border-border p-5">
                    <div>
                        <p class="font-display text-base font-semibold">{{ $laporan->proyek->judul }}</p>
                        <p class="text-sm text-ink/60 mt-1">{{ $laporan->proyek->mahasiswa->name }}</p>
                    </div>
                    <a href="{{ route('dosen.penilaian-laporan.edit', $laporan) }}"
                       class="px-4 py-2 rounded-2xl bg-brand text-white text-xs font-semibold hover:bg-brand/90 transition">
                        Beri Nilai
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    <p class="font-display text-lg font-semibold mb-4">Sudah Dinilai</p>
    @if ($sudahDinilai->isEmpty())
        <p class="text-sm text-ink/40">Belum ada.</p>
    @else
        <div class="space-y-2">
            @foreach ($sudahDinilai as $laporan)
                <div class="flex items-center justify-between bg-white rounded-2xl border border-border px-5 py-3">
                    <div>
                        <p class="text-sm font-medium">{{ $laporan->proyek->judul }}</p>
                        <p class="text-xs text-ink/40">{{ $laporan->proyek->mahasiswa->name }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-accent-kiwi/15 text-accent-kiwi">{{ $laporan->nilai }}</span>
                        <a href="{{ route('dosen.penilaian-laporan.edit', $laporan) }}" class="text-xs text-role-dosen hover:underline">Ubah</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-dashboard-layout>