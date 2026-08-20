<x-dashboard-layout title="Detail Proyek KKN">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.proyek.index') }}" :active="true">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi-proposal.index') }}">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-logbook.index') }}">Tinjau Logbook</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-laporan.index') }}">Penilaian Laporan Akhir</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-akhir.index') }}">Penilaian Akhir</x-nav-item>
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

    <a href="{{ route('dosen.proyek.index') }}" class="text-sm text-ink/50 hover:text-ink mb-4 inline-block">← Kembali</a>

    <div class="grid grid-cols-3 gap-5">
        <div class="col-span-2">
            <div class="bg-white rounded-2xl border border-border p-6">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <p class="font-display text-xl font-semibold">{{ $proyek->judul }}</p>
                    <span class="shrink-0 text-xs font-medium px-3 py-1 rounded-full {{ $statusBadge['class'] }}">
                        {{ $statusBadge['label'] }}
                    </span>
                </div>
                <p class="text-sm text-ink/70 leading-relaxed">{{ $proyek->deskripsi }}</p>
                <p class="text-sm text-ink/60 mt-4"><span class="text-ink/40">Lokasi:</span> {{ $proyek->lokasi }}</p>

                @if ($proyek->status === 'tidak_lolos' && $proyek->catatan_validasi)
                    <div class="mt-5 pt-5 border-t border-border">
                        <p class="text-xs text-ink/40 mb-1">Catatan Panitia</p>
                        <p class="text-sm text-role-panitia bg-role-panitia-soft rounded-2xl px-4 py-3">{{ $proyek->catatan_validasi }}</p>
                    </div>
                @endif
            </div>
            @if ($proyek->status === 'diajukan')
            <div class="bg-white rounded-2xl border border-role-panitia/30 p-6">
                <p class="text-sm font-semibold text-role-panitia mb-2">Batalkan Pengajuan</p>
                <p class="text-xs text-ink/50 mb-3">Proyek ini masih menunggu validasi panitia. Kamu bisa membatalkannya untuk mengajukan proyek lain.</p>
                <form method="POST" action="{{ route('dosen.proyek.destroy', $proyek) }}"
                    onsubmit="return confirm('Yakin mau batalkan proyek ini? Semua anggota yang sudah diundang juga akan terlepas.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded-2xl border-2 border-role-panitia text-role-panitia text-sm font-semibold hover:bg-role-panitia-soft transition">
                        Batalkan Proyek Ini
                    </button>
                </form>
            </div>
        @endif
        </div>

        <div>
            <div class="bg-white rounded-2xl border border-border p-6">
                <p class="text-sm font-medium mb-1">Tim ({{ $proyek->jumlah_anggota }}/{{ $proyek->kuota_tim }})</p>
                <div class="w-full h-1.5 bg-paper rounded-full overflow-hidden mb-4 mt-2">
                    <div class="h-full bg-brand" style="width: {{ $proyek->kuota_tim > 0 ? min(100, ($proyek->jumlah_anggota / $proyek->kuota_tim) * 100) : 0 }}%"></div>
                </div>
                @forelse ($proyek->timKkn as $tim)
                    <div class="flex items-center justify-between text-sm py-1">
                        <span>{{ $tim->mahasiswa->name }}</span>
                    </div>
                @empty
                    <p class="text-xs text-ink/40">Belum ada anggota.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-dashboard-layout>