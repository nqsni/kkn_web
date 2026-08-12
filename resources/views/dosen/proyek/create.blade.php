<x-dashboard-layout title="Ajukan Proyek KKN">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.proyek.index') }}" :active="true">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi-proposal.index') }}">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-logbook.index') }}">Penilaian Logbook</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-laporan.index') }}">Penilaian Laporan Akhir</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-akhir.index') }}">Penilaian Akhir</x-nav-item>
    </x-slot:sidebar>

    <div class="max-w-2xl">
        <a href="{{ route('dosen.proyek.index') }}" class="text-sm text-ink/50 hover:text-ink mb-4 inline-block">← Kembali</a>

        <div class="bg-white rounded-2xl border border-border p-6">
            <p class="font-display text-xl font-semibold mb-1">Ajukan Proyek KKN</p>
            <p class="text-sm text-ink/60 mb-1">Periode: <span class="font-medium text-ink">{{ $periode->nama }}</span></p>
            <p class="text-sm text-ink/60 mb-6">Kamu otomatis menjadi dosen pembimbing proyek ini setelah lolos validasi panitia.</p>

            @if ($errors->any())
                <div class="mb-4 px-4 py-3 rounded-2xl bg-role-panitia-soft text-role-panitia text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('dosen.proyek.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1.5">Judul Proyek</label>
                    <input type="text" name="judul" value="{{ old('judul') }}"
                           class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm"
                           placeholder="Contoh: Pemberdayaan UMKM Desa Sukamaju">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="4"
                              class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm"
                              placeholder="Jelaskan rencana kegiatan KKN secara singkat">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Lokasi</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                               class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm"
                               placeholder="Desa/Kelurahan, Kecamatan">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Kuota Tim</label>
                        <input type="number" name="kuota_tim" value="{{ old('kuota_tim', 1) }}" min="1" max="10"
                               class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5">Undang Anggota (opsional)</label>
                    <p class="text-xs text-ink/40 mb-2">Mahasiswa yang dipilih langsung jadi anggota tim tanpa perlu ikut War. Sisa slot kuota tetap terbuka untuk War.</p>

                    @if ($mahasiswaTersedia->isEmpty())
                        <p class="text-sm text-ink/40">Tidak ada mahasiswa tersedia di periode ini.</p>
                    @else
                        <div class="border border-border rounded-2xl max-h-48 overflow-y-auto divide-y divide-border">
                            @foreach ($mahasiswaTersedia as $m)
                                <label class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-paper cursor-pointer">
                                    <input type="checkbox" name="anggota[]" value="{{ $m->id }}"
                                           {{ in_array($m->id, old('anggota', [])) ? 'checked' : '' }}
                                           class="rounded border-border text-brand focus:ring-brand">
                                    <span>{{ $m->name }} <span class="text-ink/40">({{ $m->email }})</span></span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="px-5 py-2.5 rounded-2xl bg-brand text-white text-sm font-medium hover:bg-brand/90 transition">
                        Ajukan Proyek
                    </button>
                    <a href="{{ route('dosen.proyek.index') }}"
                       class="px-5 py-2.5 rounded-2xl border border-border text-sm font-medium hover:bg-paper transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>