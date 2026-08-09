<x-dashboard-layout title="Ajukan Proyek KKN">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('mahasiswa.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proyek.index') }}" :active="true">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.war.index') }}">War Proyek Tersedia</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.logbook.index') }}">Logbook Mingguan</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.laporan-akhir.index') }}">Laporan Akhir</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.nilai.index') }}">Nilai Saya</x-nav-item>
    </x-slot:sidebar>

    <div class="max-w-2xl">
        <a href="{{ route('mahasiswa.proyek.index') }}" class="text-sm text-ink/50 hover:text-ink mb-4 inline-block">← Kembali</a>

        <div class="bg-white rounded-xl border border-border p-6">
            <p class="font-display text-xl font-semibold mb-1">Ajukan Proyek KKN</p>
            <p class="text-sm text-ink/60 mb-6">Isi detail proyek yang akan kamu ajukan untuk divalidasi panitia.</p>

            @if ($errors->any())
                <div class="mb-4 px-4 py-3 rounded-lg bg-role-panitia-soft text-role-panitia text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('mahasiswa.proyek.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1.5">Judul Proyek</label>
                    <input type="text" name="judul" value="{{ old('judul') }}"
                           class="w-full rounded-lg border-border focus:border-ink focus:ring-ink text-sm"
                           placeholder="Contoh: Pemberdayaan UMKM Desa Sukamaju">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="4"
                              class="w-full rounded-lg border-border focus:border-ink focus:ring-ink text-sm"
                              placeholder="Jelaskan rencana kegiatan KKN secara singkat">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Lokasi</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                               class="w-full rounded-lg border-border focus:border-ink focus:ring-ink text-sm"
                               placeholder="Desa/Kelurahan, Kecamatan">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Kuota Tim</label>
                        <input type="number" name="kuota_tim" value="{{ old('kuota_tim', 1) }}" min="1" max="10"
                               class="w-full rounded-lg border-border focus:border-ink focus:ring-ink text-sm">
                    </div>
                </div>

                <p class="text-xs text-ink/40">
                    Kamu otomatis menjadi pengaju proyek ini. Anggota tim lain bisa bergabung setelah proyek lolos validasi.
                </p>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-ink text-white text-sm font-medium hover:bg-ink/90 transition">
                        Ajukan Proyek
                    </button>
                    <a href="{{ route('mahasiswa.proyek.index') }}"
                       class="px-5 py-2.5 rounded-lg border border-border text-sm font-medium hover:bg-paper transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>