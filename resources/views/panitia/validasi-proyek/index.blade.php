<x-dashboard-layout title="Validasi Proyek KKN">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('panitia.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('panitia.validasi-proyek.index') }}" :active="true">Validasi Proyek KKN</x-nav-item>
        <x-nav-item href="{{ route('panitia.penempatan.index') }}">Penempatan Dosen</x-nav-item>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-dosen-soft text-role-dosen text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-panitia-soft text-role-panitia text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6">
        <p class="font-display text-xl font-semibold">Menunggu Validasi</p>
        <p class="text-sm text-ink/60 mt-1">{{ $proyekDiajukan->count() }} proyek menunggu keputusan kamu.</p>
    </div>

    @if ($proyekDiajukan->isEmpty())
        <div class="bg-white rounded-2xl border border-border p-10 text-center mb-10">
            <p class="text-sm text-ink/60">Tidak ada proyek yang menunggu validasi saat ini.</p>
        </div>
    @else
        <div class="space-y-3 mb-10">
            @foreach ($proyekDiajukan as $proyek)
                <a href="{{ route('panitia.validasi-proyek.show', $proyek) }}"
                   class="block bg-white rounded-2xl border border-border p-5 hover:border-brand/40 transition">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="font-display text-base font-semibold truncate">{{ $proyek->judul }}</p>
                            <p class="text-sm text-ink/60 mt-1">{{ $proyek->lokasi }} · Diajukan oleh {{ $proyek->mahasiswa->name }}</p>
                            <p class="text-xs text-ink/40 mt-1">Kuota tim: {{ $proyek->kuota_tim }} orang</p>
                        </div>
                        <span class="shrink-0 text-xs font-semibold px-3 py-1.5 rounded-full bg-accent-yellow/20 text-role-mahasiswa">
                            Menunggu Review
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    <div class="mb-4">
        <p class="font-display text-lg font-semibold">Riwayat Validasi</p>
    </div>

    @if ($riwayat->isEmpty())
        <p class="text-sm text-ink/40">Belum ada riwayat.</p>
    @else
        <div class="space-y-2">
            @foreach ($riwayat as $proyek)
                @php
                    $badge = match($proyek->status) {
                        'lolos', 'penuh' => ['label' => 'Lolos', 'class' => 'bg-accent-kiwi/15 text-accent-kiwi'],
                        'tidak_lolos' => ['label' => 'Tidak Lolos', 'class' => 'bg-role-panitia-soft text-role-panitia'],
                        default => ['label' => $proyek->status, 'class' => 'bg-paper text-ink/60'],
                    };
                @endphp
                <div class="flex items-center justify-between bg-white rounded-2xl border border-border px-5 py-3">
                    <div>
                        <p class="text-sm font-medium">{{ $proyek->judul }}</p>
                        <p class="text-xs text-ink/40">{{ $proyek->mahasiswa->name }}</p>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                </div>
            @endforeach
        </div>
    @endif
</x-dashboard-layout>