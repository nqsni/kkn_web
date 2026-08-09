<x-dashboard-layout title="Proyek KKN Saya">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('mahasiswa.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proyek.index') }}" :active="true">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.war.index') }}">War Proyek Tersedia</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proposal.index') }}">Proposal</x-nav-item>
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

    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-ink/60">Daftar proyek KKN yang kamu ikuti, baik sebagai pengaju maupun anggota tim.</p>
        <a href="{{ route('mahasiswa.proyek.create') }}"
           class="px-4 py-2 rounded-lg bg-ink text-white text-sm font-medium hover:bg-ink/90 transition">
            + Ajukan Proyek Baru
        </a>
    </div>

    @if ($timList->isEmpty())
        <div class="bg-white rounded-xl border border-border p-10 text-center">
            <p class="text-sm text-ink/60">Kamu belum mengikuti proyek KKN apapun.</p>
            <a href="{{ route('mahasiswa.proyek.create') }}" class="inline-block mt-3 text-sm font-medium text-role-dosen hover:underline">
                Ajukan proyek pertamamu →
            </a>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($timList as $tim)
                @php
                    $proyek = $tim->proyek;
                    $statusBadge = match($proyek->status) {
                        'diajukan' => ['label' => 'Menunggu Validasi', 'class' => 'bg-accent-yellow/20 text-role-mahasiswa'],
                        'lolos' => ['label' => 'Lolos', 'class' => 'bg-accent-kiwi/15 text-accent-kiwi'],
                        'tidak_lolos' => ['label' => 'Tidak Lolos', 'class' => 'bg-role-panitia-soft text-role-panitia'],
                        'penuh' => ['label' => 'Tim Lengkap', 'class' => 'bg-role-admin-soft text-role-admin'],
                        default => ['label' => $proyek->status, 'class' => 'bg-paper text-ink/60'],
                    };
                @endphp
                <a href="{{ route('mahasiswa.proyek.show', $proyek) }}"
                   class="block bg-white rounded-xl border border-border p-5 hover:border-ink/20 transition">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="font-display text-base font-semibold truncate">{{ $proyek->judul }}</p>
                            <p class="text-sm text-ink/60 mt-1">{{ $proyek->lokasi }}</p>
                            <p class="text-xs text-ink/40 mt-2">
                                Peran kamu: <span class="font-medium text-ink/60">{{ $tim->peran === 'pengaju' ? 'Pengaju' : 'Anggota' }}</span>
                                · Tim {{ $proyek->jumlah_anggota }}/{{ $proyek->kuota_tim }}
                            </p>
                        </div>
                        <span class="shrink-0 text-xs font-medium px-3 py-1 rounded-full {{ $statusBadge['class'] }}">
                            {{ $statusBadge['label'] }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</x-dashboard-layout>