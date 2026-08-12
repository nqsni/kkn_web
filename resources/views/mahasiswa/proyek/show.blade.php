<x-dashboard-layout title="Detail Proyek KKN">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('mahasiswa.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proyek.index') }}" :active="true">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.war.index') }}">War Proyek Tersedia</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proposal.index') }}">Proposal</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.logbook.index') }}">Logbook Mingguan</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.laporan-akhir.index') }}">Laporan Akhir</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.nilai.index') }}">Nilai Saya</x-nav-item>
    </x-slot:sidebar>

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

    <a href="{{ route('mahasiswa.proyek.index') }}" class="text-sm text-ink/50 hover:text-ink mb-4 inline-block">← Kembali</a>

    <div class="grid grid-cols-3 gap-5">
        <div class="col-span-2 space-y-5">
            <div class="bg-white rounded-xl border border-border p-6">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <p class="font-display text-xl font-semibold">{{ $proyek->judul }}</p>
                    <span class="shrink-0 text-xs font-medium px-3 py-1 rounded-full {{ $statusBadge['class'] }}">
                        {{ $statusBadge['label'] }}
                    </span>
                </div>
                <p class="text-sm text-ink/70 leading-relaxed">{{ $proyek->deskripsi }}</p>

                <div class="grid grid-cols-2 gap-4 mt-5 pt-5 border-t border-border">
                    <div>
                        <p class="text-xs text-ink/40">Lokasi</p>
                        <p class="text-sm font-medium mt-0.5">{{ $proyek->lokasi }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-ink/40">Dosen Pembimbing</p>
                        <p class="text-sm font-medium mt-0.5">{{ $proyek->dosen->name ?? 'Belum ditentukan' }}</p>
                    </div>
                </div>

                @if ($proyek->status === 'tidak_lolos' && $proyek->catatan_validasi)
                    <div class="mt-5 pt-5 border-t border-border">
                        <p class="text-xs text-ink/40 mb-1">Catatan Panitia</p>
                        <p class="text-sm text-role-panitia bg-role-panitia-soft rounded-lg px-4 py-3">{{ $proyek->catatan_validasi }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-5">
            <div class="bg-white rounded-xl border border-border p-6">
                <p class="text-sm font-medium mb-1">Tim ({{ $proyek->jumlah_anggota }}/{{ $proyek->kuota_tim }})</p>
                <div class="w-full h-1.5 bg-paper rounded-full overflow-hidden mb-4 mt-2">
                    <div class="h-full bg-role-dosen" style="width: {{ $proyek->kuota_tim > 0 ? min(100, ($proyek->jumlah_anggota / $proyek->kuota_tim) * 100) : 0 }}%"></div>
                </div>
                <div class="space-y-2">
                    @foreach ($proyek->timKkn as $tim)
                        <div class="flex items-center justify-between text-sm">
                            <span>{{ $tim->mahasiswa->name }}</span>
                            <span class="text-xs text-ink/40">{{ $tim->peran === 'pengaju' ? 'Pengaju' : 'Anggota' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>