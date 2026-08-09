<x-dashboard-layout title="Laporan Akhir">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('mahasiswa.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proyek.index') }}">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.war.index') }}">War Proyek Tersedia</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proposal.index') }}">Proposal</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.logbook.index') }}">Logbook Mingguan</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.laporan-akhir.index') }}" :active="true">Laporan Akhir</x-nav-item>
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

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-border p-6">
            <p class="font-display text-xl font-semibold mb-1">Laporan Akhir — {{ $proyek->judul }}</p>

            @if ($proyek->laporanAkhir)
                {{-- SUDAH ADA LAPORAN --}}
                <p class="text-sm text-ink/60 mt-1 mb-4">Laporan akhir sudah diupload.</p>

                <div class="flex items-center justify-between">
                    @if ($proyek->laporanAkhir->nilai !== null)
                        <span class="text-xs font-medium px-3 py-1 rounded-full bg-role-dosen-soft text-role-dosen">
                            Nilai: {{ $proyek->laporanAkhir->nilai }}
                        </span>
                    @else
                        <span class="text-xs font-medium px-3 py-1 rounded-full bg-role-mahasiswa-soft text-role-mahasiswa">
                            Menunggu Penilaian
                        </span>
                    @endif
                    <a href="{{ Storage::url($proyek->laporanAkhir->file_laporan) }}" target="_blank"
                       class="text-sm text-role-dosen hover:underline">
                        Lihat File →
                    </a>
                </div>

                @if ($proyek->laporanAkhir->catatan_dosen)
                    <div class="mt-4 pt-4 border-t border-border">
                        <p class="text-xs text-ink/40 mb-1">Catatan Dosen</p>
                        <p class="text-sm text-ink/70">{{ $proyek->laporanAkhir->catatan_dosen }}</p>
                    </div>
                @endif

            @elseif (!$bisaUpload)
                {{-- BELUM ACC --}}
                <p class="text-sm text-ink/60 mt-4">Proposal kamu belum di-ACC dosen. Upload laporan akhir belum tersedia.</p>

            @else
                {{-- FORM UPLOAD --}}
                <p class="text-sm text-ink/60 mb-5 mt-1">Upload dokumen laporan pelaksanaan kegiatan (LPK) dalam format PDF.</p>

                @if ($errors->any())
                    <div class="mb-4 px-4 py-3 rounded-lg bg-role-panitia-soft text-role-panitia text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('mahasiswa.laporan-akhir.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1.5">File Laporan Akhir (PDF, maks 5MB)</label>
                        <input type="file" name="file_laporan" accept=".pdf"
                               class="w-full text-sm rounded-lg border-border focus:border-ink focus:ring-ink">
                    </div>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-ink text-white text-sm font-medium hover:bg-ink/90 transition">
                        Upload Laporan Akhir
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-dashboard-layout>