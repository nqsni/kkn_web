<x-dashboard-layout title="Periode KKN">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('admin.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('admin.periode.index') }}" :active="true">Periode KKN</x-nav-item>
        <x-nav-item href="{{ route('admin.data-master.index') }}">Data Master</x-nav-item>
        <x-nav-item href="{{ route('admin.rubrik-penilaian.index') }}">Rubrik Penilaian</x-nav-item>
        <x-nav-item href="{{ route('admin.users.index') }}">Manajemen User</x-nav-item>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-dosen-soft text-role-dosen text-sm">{{ session('success') }}</div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="font-display text-xl font-semibold">Periode KKN</p>
            <p class="text-sm text-ink/60 mt-1">Kelola periode, akun, dan kapasitas per angkatan KKN.</p>
        </div>
        <a href="{{ route('admin.periode.create') }}"
           class="px-4 py-2 rounded-2xl bg-brand text-white text-sm font-medium hover:bg-brand/90 transition">
            + Buat Periode
        </a>
    </div>

    @if ($periodeList->isEmpty())
        <div class="bg-white rounded-2xl border border-border p-10 text-center">
            <p class="text-sm text-ink/60">Belum ada periode KKN.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($periodeList as $periode)
                @php
                    $badge = match($periode->status) {
                        'aktif' => ['label' => 'Aktif', 'class' => 'bg-accent-kiwi/15 text-accent-kiwi'],
                        'selesai' => ['label' => 'Selesai', 'class' => 'bg-role-admin-soft text-role-admin'],
                        default => ['label' => 'Draft', 'class' => 'bg-paper text-ink/50'],
                    };
                @endphp
                <div class="bg-white rounded-2xl border border-border p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="font-display text-base font-semibold">{{ $periode->nama }}</p>
                            <p class="text-sm text-ink/60 mt-1">
                                {{ \Carbon\Carbon::parse($periode->tanggal_mulai)->format('d M Y') }}
                                –
                                {{ \Carbon\Carbon::parse($periode->tanggal_selesai)->format('d M Y') }}
                            </p>
                            <p class="text-xs text-ink/40 mt-1">{{ $periode->proyek_kkn_count }} proyek terdaftar</p>
                        </div>
                        <span class="shrink-0 text-xs font-semibold px-3 py-1.5 rounded-full {{ $badge['class'] }}">
                            {{ $badge['label'] }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2 mt-4 pt-4 border-t border-border">
                        <a href="{{ route('admin.periode.akun.index', $periode) }}"
                           class="px-3 py-1.5 rounded-2xl border border-border text-xs font-medium hover:bg-paper transition">
                            Kelola Akun
                        </a>
                        <a href="{{ route('admin.periode.kapasitas.index', $periode) }}"
                           class="px-3 py-1.5 rounded-2xl border border-border text-xs font-medium hover:bg-paper transition">
                            Kapasitas & Rilis
                        </a>

                        @if ($periode->status !== 'aktif')
                            <form method="POST" action="{{ route('admin.periode.update-status', $periode) }}" class="ml-auto">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="aktif">
                                <button type="submit" class="px-3 py-1.5 rounded-2xl bg-ink text-white text-xs font-medium hover:bg-ink/90 transition">
                                    Aktifkan
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.periode.update-status', $periode) }}" class="ml-auto">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="selesai">
                                <button type="submit" class="px-3 py-1.5 rounded-2xl border border-border text-xs font-medium hover:bg-paper transition">
                                    Tandai Selesai
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-dashboard-layout>