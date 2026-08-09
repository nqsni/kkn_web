<x-dashboard-layout title="Logbook Mingguan">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('mahasiswa.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proyek.index') }}">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.war.index') }}">War Proyek Tersedia</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proposal.index') }}">Proposal</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.logbook.index') }}" :active="true">Logbook Mingguan</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.laporan-akhir.index') }}">Laporan Akhir</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.nilai.index') }}">Nilai Saya</x-nav-item>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-role-dosen-soft text-role-dosen text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-role-panitia-soft text-role-panitia text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-3 gap-5">

        {{-- FORM UPLOAD --}}
        <div class="col-span-1">
            <div class="bg-white rounded-xl border border-border p-6 sticky top-6">
                <p class="font-display text-base font-semibold mb-1">Upload Logbook</p>

                @if (!$bisaUpload)
                    <p class="text-sm text-ink/60 mt-3">Proposal kamu belum di-ACC dosen. Upload logbook belum tersedia.</p>
                @else
                    @if ($errors->any())
                        <div class="mb-4 mt-3 px-4 py-3 rounded-lg bg-role-panitia-soft text-role-panitia text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('mahasiswa.logbook.store') }}" enctype="multipart/form-data" class="space-y-4 mt-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium mb-1.5">Minggu Ke-</label>
                            <input type="number" name="minggu_ke" value="{{ old('minggu_ke', $mingguSelanjutnya) }}" min="1"
                                   class="w-full rounded-lg border-border focus:border-ink focus:ring-ink text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5">File Logbook (PDF)</label>
                            <input type="file" name="file_logbook" accept=".pdf"
                                   class="w-full text-sm rounded-lg border-border focus:border-ink focus:ring-ink">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5">Deskripsi Kegiatan</label>
                            <textarea name="deskripsi_kegiatan" rows="4"
                                      class="w-full rounded-lg border-border focus:border-ink focus:ring-ink text-sm"
                                      placeholder="Ringkas kegiatan minggu ini">{{ old('deskripsi_kegiatan') }}</textarea>
                        </div>
                        <button type="submit"
                                class="w-full px-4 py-2.5 rounded-lg bg-ink text-white text-sm font-medium hover:bg-ink/90 transition">
                            Upload Logbook
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- RIWAYAT LOGBOOK --}}
        <div class="col-span-2">
            <p class="text-sm text-ink/60 mb-4">Riwayat logbook yang sudah diupload.</p>

            @if ($proyek->logbook->isEmpty())
                <div class="bg-white rounded-xl border border-border p-10 text-center">
                    <p class="text-sm text-ink/60">Belum ada logbook yang diupload.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($proyek->logbook->sortByDesc('minggu_ke') as $log)
                        <div class="bg-white rounded-xl border border-border p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-medium text-sm">Minggu ke-{{ $log->minggu_ke }}</p>
                                    <p class="text-sm text-ink/60 mt-1">{{ $log->deskripsi_kegiatan }}</p>
                                </div>
                                <div class="text-right shrink-0">
                                    @if ($log->nilai !== null)
                                        <span class="text-xs font-medium px-3 py-1 rounded-full bg-role-dosen-soft text-role-dosen">
                                            Nilai: {{ $log->nilai }}
                                        </span>
                                    @else
                                        <span class="text-xs font-medium px-3 py-1 rounded-full bg-role-mahasiswa-soft text-role-mahasiswa">
                                            Belum Dinilai
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ Storage::url($log->file_logbook) }}" target="_blank"
                               class="text-sm text-role-dosen hover:underline mt-3 inline-block">
                                Lihat File →
                            </a>
                            @if ($log->catatan_dosen)
                                <div class="mt-3 pt-3 border-t border-border">
                                    <p class="text-xs text-ink/40 mb-1">Catatan Dosen</p>
                                    <p class="text-sm text-ink/70">{{ $log->catatan_dosen }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-dashboard-layout>