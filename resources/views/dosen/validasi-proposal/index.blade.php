<x-dashboard-layout title="Validasi Proposal">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi-proposal.index') }}" :active="true">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-logbook.index') }}">Penilaian Logbook</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian-laporan.index') }}">Penilaian Laporan Akhir</x-nav-item>
        <x-nav-item href="#">Penilaian Akhir</x-nav-item>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-dosen-soft text-role-dosen text-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-panitia-soft text-role-panitia text-sm">{{ session('error') }}</div>
    @endif

    <div class="mb-6">
        <p class="font-display text-xl font-semibold">Menunggu ACC</p>
        <p class="text-sm text-ink/60 mt-1">{{ $menunggu->count() }} proposal dari mahasiswa bimbinganmu.</p>
    </div>

    @if ($menunggu->isEmpty())
        <div class="bg-white rounded-2xl border border-border p-10 text-center mb-10">
            <p class="text-sm text-ink/60">Tidak ada proposal yang menunggu saat ini.</p>
        </div>
    @else
        <div class="space-y-3 mb-10">
            @foreach ($menunggu as $proposal)
                <a href="{{ route('dosen.validasi-proposal.show', $proposal) }}"
                   class="block bg-white rounded-2xl border border-border p-5 hover:border-brand/40 transition">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="font-display text-base font-semibold">{{ $proposal->proyek->judul }}</p>
                            <p class="text-sm text-ink/60 mt-1">{{ $proposal->proyek->mahasiswa->name }} · {{ $proposal->proyek->lokasi }}</p>
                        </div>
                        <span class="shrink-0 text-xs font-semibold px-3 py-1.5 rounded-full bg-accent-yellow/20 text-role-mahasiswa">
                            Menunggu Review
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    <p class="font-display text-lg font-semibold mb-4">Riwayat</p>
    @if ($riwayat->isEmpty())
        <p class="text-sm text-ink/40">Belum ada riwayat.</p>
    @else
        <div class="space-y-2">
            @foreach ($riwayat as $proposal)
                @php
                    $badge = $proposal->status === 'acc'
                        ? ['label' => 'Diterima', 'class' => 'bg-accent-kiwi/15 text-accent-kiwi']
                        : ['label' => 'Ditolak', 'class' => 'bg-role-panitia-soft text-role-panitia'];
                @endphp
                <div class="flex items-center justify-between bg-white rounded-2xl border border-border px-5 py-3">
                    <div>
                        <p class="text-sm font-medium">{{ $proposal->proyek->judul }}</p>
                        <p class="text-xs text-ink/40">{{ $proposal->proyek->mahasiswa->name }}</p>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                </div>
            @endforeach
        </div>
    @endif
</x-dashboard-layout>