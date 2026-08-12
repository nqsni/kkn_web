<x-dashboard-layout title="Nilai Laporan Akhir">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.proyek.index') }}">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi-proposal.index') }}">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-logbook.index') }}">Penilaian Logbook</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-laporan.index') }}" :active="true">Penilaian Laporan Akhir</x-nav-item>
        <x-nav-item href="#">Penilaian Akhir</x-nav-item>
    </x-slot:sidebar>

    <a href="{{ route('dosen.penilaian-laporan.index') }}" class="text-sm text-ink/50 hover:text-ink mb-4 inline-block">← Kembali</a>

    <div class="grid grid-cols-3 gap-5">
        <div class="col-span-2">
            <div class="bg-white rounded-2xl border border-border p-6">
                <p class="font-display text-lg font-semibold mb-1">{{ $laporan->proyek->judul }}</p>
                <p class="text-sm text-ink/60 mb-4">{{ $laporan->proyek->mahasiswa->name }}</p>

                <a href="{{ Storage::url($laporan->file_laporan) }}" target="_blank"
                   class="inline-block text-sm text-role-dosen hover:underline font-medium">
                    📄 Lihat File Laporan Akhir →
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

                <form method="POST" action="{{ route('dosen.penilaian-laporan.update', $laporan) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Nilai (0-100)</label>
                        <input type="number" name="nilai" value="{{ old('nilai', $laporan->nilai) }}" min="0" max="100" step="0.01"
                               class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Catatan (opsional)</label>
                        <textarea name="catatan_dosen" rows="3"
                                  class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">{{ old('catatan_dosen', $laporan->catatan_dosen) }}</textarea>
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