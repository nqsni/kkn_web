<x-dashboard-layout title="Penilaian Logbook">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi-proposal.index') }}">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-logbook.index') }}" :active="true">Penilaian Logbook</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-laporan.index') }}">Penilaian Laporan Akhir</x-nav-item>
        <x-nav-item href="#">Penilaian Akhir</x-nav-item>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-dosen-soft text-role-dosen text-sm">{{ session('success') }}</div>
    @endif

    <div class="mb-6">
        <p class="font-display text-xl font-semibold">Penilaian Logbook Mingguan</p>
        <p class="text-sm text-ink/60 mt-1">Logbook dari mahasiswa bimbinganmu.</p>
    </div>

    @if ($proyekList->isEmpty())
        <div class="bg-white rounded-2xl border border-border p-10 text-center">
            <p class="text-sm text-ink/60">Belum ada logbook yang diupload mahasiswa bimbinganmu.</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach ($proyekList as $proyek)
                <div class="bg-white rounded-2xl border border-border p-5">
                    <p class="font-display text-base font-semibold mb-1">{{ $proyek->judul }}</p>
                    <p class="text-sm text-ink/60 mb-4">{{ $proyek->mahasiswa->name }}</p>

                    <div class="space-y-2">
                        @foreach ($proyek->logbook as $log)
                            <div class="flex items-center justify-between border border-border rounded-2xl px-4 py-3">
                                <div>
                                    <p class="text-sm font-medium">Minggu ke-{{ $log->minggu_ke }}</p>
                                    <p class="text-xs text-ink/50 mt-0.5">{{ Str::limit($log->deskripsi_kegiatan, 60) }}</p>
                                </div>
                                <div class="flex items-center gap-3 shrink-0">
                                    @if ($log->nilai !== null)
                                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-accent-kiwi/15 text-accent-kiwi">
                                            {{ $log->nilai }}
                                        </span>
                                    @else
                                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-accent-yellow/20 text-role-mahasiswa">
                                            Belum dinilai
                                        </span>
                                    @endif
                                    <a href="{{ route('dosen.penilaian-logbook.edit', $log) }}"
                                       class="text-xs font-medium text-role-dosen hover:underline">
                                        {{ $log->nilai !== null ? 'Ubah' : 'Nilai' }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-dashboard-layout>