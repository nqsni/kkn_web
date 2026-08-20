<x-dashboard-layout title="Proyek KKN Saya">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.proyek.index') }}" :active="true">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi-proposal.index') }}">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-logbook.index') }}">Tinjau Logbook</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-laporan.index') }}">Penilaian Laporan Akhir</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-akhir.index') }}">Penilaian Akhir</x-nav-item>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-dosen-soft text-role-dosen text-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-panitia-soft text-role-panitia text-sm">{{ session('error') }}</div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="font-display text-xl font-semibold">Proyek KKN Saya</p>
            <p class="text-sm text-ink/60 mt-1">Semua proyek yang kamu bimbing, baik yang kamu ajukan sendiri maupun ditugaskan panitia.</p>
        </div>
        <a href="{{ route('dosen.proyek.create') }}"
           class="px-4 py-2 rounded-2xl bg-brand text-white text-sm font-medium hover:bg-brand/90 transition">
            + Ajukan Proyek Baru
        </a>
    </div>

    @if ($proyekList->isEmpty())
        <div class="bg-white rounded-2xl border border-border p-10 text-center">
            <p class="text-sm text-ink/60">Belum ada proyek KKN yang kamu bimbing.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($proyekList as $proyek)
                @php
                    $statusBadge = match($proyek->status) {
                        'diajukan' => ['label' => 'Menunggu Validasi', 'class' => 'bg-accent-yellow/20 text-role-mahasiswa'],
                        'menunggu_rilis' => ['label' => 'Menunggu Rilis Admin', 'class' => 'bg-role-admin-soft text-role-admin'],
                        'tersedia' => ['label' => 'Tersedia (War)', 'class' => 'bg-accent-kiwi/15 text-accent-kiwi'],
                        'tidak_lolos' => ['label' => 'Tidak Lolos', 'class' => 'bg-role-panitia-soft text-role-panitia'],
                        'penuh' => ['label' => 'Tim Lengkap', 'class' => 'bg-role-dosen-soft text-role-dosen'],
                        default => ['label' => $proyek->status, 'class' => 'bg-paper text-ink/60'],
                    };
                @endphp
                <div class="bg-white rounded-2xl border border-border p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <p class="font-display text-base font-semibold truncate">{{ $proyek->judul }}</p>
                                <span class="shrink-0 text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $proyek->pengaju_type === 'dosen' ? 'bg-role-dosen-soft text-role-dosen' : 'bg-role-admin-soft text-role-admin' }}">
                                    {{ $proyek->pengaju_type === 'dosen' ? 'Diajukan Sendiri' : 'Ditugaskan Panitia' }}
                                </span>
                            </div>
                            <p class="text-sm text-ink/60">
                                {{ $proyek->lokasi }}
                                @if ($proyek->pengaju_type === 'mahasiswa')
                                    · Pengaju: {{ $proyek->mahasiswa->name ?? '-' }}
                                @endif
                            </p>
                            <p class="text-xs text-ink/40 mt-1">Tim {{ $proyek->jumlah_anggota }}/{{ $proyek->kuota_tim }}</p>
                        </div>
                        <span class="shrink-0 text-xs font-medium px-3 py-1 rounded-full {{ $statusBadge['class'] }}">
                            {{ $statusBadge['label'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-dashboard-layout>