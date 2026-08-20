<x-dashboard-layout title="Tinjau Logbook">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.proyek.index') }}">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi-proposal.index') }}">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-logbook.index') }}" :active="true">Tinjau Logbook</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-laporan.index') }}">Penilaian Laporan Akhir</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-akhir.index') }}">Penilaian Akhir</x-nav-item>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-dosen-soft text-role-dosen text-sm">{{ session('success') }}</div>
    @endif

    <div class="mb-6">
        <p class="font-display text-xl font-semibold">Tinjau Logbook Mingguan</p>
        <p class="text-sm text-ink/60 mt-1">Logbook per mahasiswa dari proyek bimbinganmu. Beri catatan/feedback bila perlu.</p>
    </div>

    @if ($proyekList->isEmpty())
        <div class="bg-white rounded-2xl border border-border p-10 text-center">
            <p class="text-sm text-ink/60">Belum ada logbook yang diupload mahasiswa bimbinganmu.</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach ($proyekList as $proyek)
                <div class="bg-white rounded-2xl border border-border p-5">
                    <p class="font-display text-base font-semibold mb-4">{{ $proyek->judul }}</p>

                    @foreach ($proyek->logbook->groupBy('mahasiswa_id') as $mahasiswaId => $logbookMahasiswa)
                        <div class="mb-4 last:mb-0">
                            <p class="text-sm font-semibold text-ink/70 mb-2">{{ $logbookMahasiswa->first()->mahasiswa->name ?? 'Mahasiswa' }}</p>
                            <div class="space-y-2">
                                @foreach ($logbookMahasiswa as $log)
                                    <div class="flex items-center justify-between border border-border rounded-2xl px-4 py-3">
                                        <div>
                                            <p class="text-sm font-medium">Minggu ke-{{ $log->minggu_ke }}</p>
                                            <p class="text-xs text-ink/50 mt-0.5">{{ Str::limit($log->deskripsi_kegiatan, 60) }}</p>
                                        </div>
                                        <div class="flex items-center gap-3 shrink-0">
                                            @if ($log->catatan_dosen)
                                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-accent-kiwi/15 text-accent-kiwi">
                                                    Sudah Ditinjau
                                                </span>
                                            @else
                                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-accent-yellow/20 text-role-mahasiswa">
                                                    Belum Ditinjau
                                                </span>
                                            @endif
                                            <a href="{{ route('dosen.penilaian-logbook.edit', $log) }}"
                                               class="text-xs font-medium text-role-dosen hover:underline">
                                                {{ $log->catatan_dosen ? 'Ubah' : 'Beri Catatan' }}
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif
</x-dashboard-layout>