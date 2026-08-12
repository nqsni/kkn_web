<x-dashboard-layout title="Detail Proposal">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.proyek.index') }}">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi-proposal.index') }}" :active="true">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-logbook.index') }}">Penilaian Logbook</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-laporan.index') }}">Penilaian Laporan Akhir</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-akhir.index') }}">Penilaian Akhir</x-nav-item>
    </x-slot:sidebar>

    <a href="{{ route('dosen.validasi-proposal.index') }}" class="text-sm text-ink/50 hover:text-ink mb-4 inline-block">← Kembali</a>

    <div class="grid grid-cols-3 gap-5">
        <div class="col-span-2 space-y-5">
            <div class="bg-white rounded-2xl border border-border p-6">
                <p class="font-display text-xl font-semibold mb-1">{{ $proposal->proyek->judul }}</p>
                <p class="text-sm text-ink/60 mb-4">{{ $proposal->proyek->mahasiswa->name ?? '-' }} ({{ $proposal->proyek->mahasiswa->email ?? '-' }})</p>
                <p class="text-sm text-ink/70">{{ $proposal->proyek->deskripsi }}</p>

                <a href="{{ Storage::url($proposal->file_proposal) }}" target="_blank"
                   class="inline-block mt-4 text-sm text-role-dosen hover:underline font-medium">
                    📄 Lihat File Proposal →
                </a>
            </div>

            @if ($proposal->status === 'diajukan')
                <div class="bg-white rounded-2xl border border-border p-6">
                    <p class="font-display text-base font-semibold mb-4">Keputusan</p>

                    @if ($errors->any())
                        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-panitia-soft text-role-panitia text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-4">
                        {{-- ACC + nilai LRK --}}
                        <form method="POST" action="{{ route('dosen.validasi-proposal.update', $proposal) }}"
                              class="p-4 rounded-2xl border-2 border-accent-kiwi/30 bg-accent-kiwi/5">
                            @csrf
                            <input type="hidden" name="keputusan" value="acc">
                            <p class="text-sm font-semibold text-accent-kiwi mb-3">✓ Terima Proposal (ACC)</p>

                            <label class="block text-xs text-ink/60 mb-1">Nilai LRK (Laporan Rencana Kegiatan, 0-100)</label>
                            <input type="number" name="nilai" step="0.01" min="0" max="100"
                                   placeholder="Nilai proposal ini"
                                   class="w-full rounded-2xl border-border focus:border-accent-kiwi focus:ring-accent-kiwi text-sm mb-3">

                            <button type="submit" class="w-full px-4 py-2.5 rounded-2xl bg-accent-kiwi text-white text-sm font-semibold hover:bg-accent-kiwi/90 transition">
                                Terima & Simpan Nilai
                            </button>
                        </form>

                        {{-- Tolak --}}
                        <form method="POST" action="{{ route('dosen.validasi-proposal.update', $proposal) }}"
                              class="p-4 rounded-2xl border-2 border-role-panitia/30 bg-role-panitia-soft">
                            @csrf
                            <input type="hidden" name="keputusan" value="ditolak">
                            <p class="text-sm font-semibold text-role-panitia mb-3">✕ Tolak Proposal</p>
                            <textarea name="catatan_dosen" rows="3" placeholder="Alasan penolakan (wajib diisi)"
                                      class="w-full rounded-2xl border-border focus:border-role-panitia focus:ring-role-panitia text-sm mb-3"></textarea>
                            <button type="submit" class="w-full px-4 py-2.5 rounded-2xl border-2 border-role-panitia text-role-panitia text-sm font-semibold hover:bg-role-panitia/10 transition">
                                Tolak Proposal
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-border p-6">
                    <p class="text-sm text-ink/60">Status: <strong>{{ $proposal->status === 'acc' ? 'Diterima' : 'Ditolak' }}</strong></p>
                    @if ($proposal->status === 'acc' && $proposal->nilai !== null)
                        <p class="text-sm text-ink/70 mt-2">Nilai LRK: <strong>{{ $proposal->nilai }}</strong></p>
                    @endif
                    @if ($proposal->catatan_dosen)
                        <p class="text-sm text-ink/70 mt-2">Catatan: {{ $proposal->catatan_dosen }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <div class="bg-white rounded-2xl border border-border p-6">
                <p class="text-sm font-medium mb-3">Anggota Tim</p>
                @forelse ($proposal->proyek->timKkn as $tim)
                    <div class="flex items-center justify-between text-sm py-1.5">
                        <span>{{ $tim->mahasiswa->name }}</span>
                        <span class="text-xs text-ink/40">{{ $tim->peran === 'pengaju' ? 'Pengaju' : 'Anggota' }}</span>
                    </div>
                @empty
                    <p class="text-xs text-ink/40">Belum ada anggota.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-dashboard-layout>