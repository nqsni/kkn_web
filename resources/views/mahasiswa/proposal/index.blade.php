<x-dashboard-layout title="Proposal KKN">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('mahasiswa.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proyek.index') }}">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.war.index') }}">War Proyek Tersedia</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proposal.index') }}" :active="true">Proposal</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.logbook.index') }}">Logbook Mingguan</x-nav-item>
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

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-border p-6">
            <p class="font-display text-xl font-semibold mb-1">Proposal — {{ $proyek->judul }}</p>

            @if ($proyek->proposal)
                {{-- SUDAH ADA PROPOSAL: tampilkan status --}}
                @php
                    $statusBadge = match($proyek->proposal->status) {
                        'diajukan' => ['label' => 'Menunggu ACC Dosen', 'class' => 'bg-role-mahasiswa-soft text-role-mahasiswa'],
                        'acc' => ['label' => 'Diterima (ACC)', 'class' => 'bg-role-dosen-soft text-role-dosen'],
                        'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-role-panitia-soft text-role-panitia'],
                        default => ['label' => $proyek->proposal->status, 'class' => 'bg-paper text-ink/60'],
                    };
                @endphp

                <div class="flex items-center justify-between mt-4">
                    <span class="text-xs font-medium px-3 py-1 rounded-full {{ $statusBadge['class'] }}">
                        {{ $statusBadge['label'] }}
                    </span>
                    <a href="{{ Storage::url($proyek->proposal->file_proposal) }}" target="_blank"
                       class="text-sm text-role-dosen hover:underline">
                        Lihat File →
                    </a>
                </div>

                @if ($proyek->proposal->status === 'ditolak' && $proyek->proposal->catatan_dosen)
                    <div class="mt-4 pt-4 border-t border-border">
                        <p class="text-xs text-ink/40 mb-1">Catatan Dosen</p>
                        <p class="text-sm text-role-panitia bg-role-panitia-soft rounded-lg px-4 py-3">{{ $proyek->proposal->catatan_dosen }}</p>
                    </div>
                @endif

            @elseif (!in_array($proyek->status, ['lolos', 'penuh']))
                {{-- BELUM LOLOS VALIDASI --}}
                <p class="text-sm text-ink/60 mt-4">Proyek kamu belum lolos validasi panitia. Proposal belum bisa diajukan.</p>

            @elseif (!$isPengaju)
                {{-- BUKAN PENGAJU --}}
                <p class="text-sm text-ink/60 mt-4">Menunggu pengaju proyek mengajukan proposal.</p>

            @else
                {{-- FORM UPLOAD --}}
                <p class="text-sm text-ink/60 mb-5 mt-1">Upload dokumen proposal dalam format PDF untuk diajukan ke dosen pembimbing.</p>

                @if ($errors->any())
                    <div class="mb-4 px-4 py-3 rounded-lg bg-role-panitia-soft text-role-panitia text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('mahasiswa.proposal.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1.5">File Proposal (PDF, maks 5MB)</label>
                        <input type="file" name="file_proposal" accept=".pdf"
                               class="w-full text-sm rounded-lg border-border focus:border-ink focus:ring-ink">
                    </div>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-ink text-white text-sm font-medium hover:bg-ink/90 transition">
                        Ajukan Proposal
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-dashboard-layout>