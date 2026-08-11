<x-dashboard-layout title="Nilai Logbook">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi-proposal.index') }}">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-logbook.index') }}" :active="true">Penilaian Logbook</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-laporan.index') }}">Penilaian Laporan Akhir</x-nav-item>
        <x-nav-item href="#">Penilaian Akhir</x-nav-item>
    </x-slot:sidebar>

    <a href="{{ route('dosen.penilaian-logbook.index') }}" class="text-sm text-ink/50 hover:text-ink mb-4 inline-block">← Kembali</a>

    <div class="grid grid-cols-3 gap-5">
        <div class="col-span-2">
            <div class="bg-white rounded-2xl border border-border p-6">
                <p class="font-display text-lg font-semibold mb-1">Minggu ke-{{ $logbook->minggu_ke }}</p>
                <p class="text-sm text-ink/60 mb-4">{{ $logbook->proyek->mahasiswa->name }} — {{ $logbook->proyek->judul }}</p>

                <p class="text-xs text-ink/40 mb-1">Deskripsi Kegiatan</p>
                <p class="text-sm text-ink/70 mb-4">{{ $logbook->deskripsi_kegiatan }}</p>

                <a href="{{ Storage::url($logbook->file_logbook) }}" target="_blank"
                   class="inline-block text-sm text-role-dosen hover:underline font-medium">
                    📄 Lihat File Logbook →
                </a>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-2xl border border-border p-6">
                <p class="text-sm font-medium mb-4">Beri Nilai</p>

                @if ($errors->any())
                    <div class="mb-4 px-4 py-3 rounded-2xl bg-role-panitia-soft text-role-panitia text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('dosen.penilaian-logbook.update', $logbook) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Nilai (0-100)</label>
                        <input type="number" name="nilai" value="{{ old('nilai', $logbook->nilai) }}" min="0" max="100" step="0.01"
                               class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Catatan (opsional)</label>
                        <textarea name="catatan_dosen" rows="3"
                                  class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">{{ old('catatan_dosen', $logbook->catatan_dosen) }}</textarea>
                    </div>
                    <button type="submit"
                            class="w-full px-4 py-2.5 rounded-2xl bg-brand text-white text-sm font-medium hover:bg-brand/90 transition">
                        Simpan Nilai
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>