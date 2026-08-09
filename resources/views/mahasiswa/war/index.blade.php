<x-dashboard-layout title="War Proyek KKN">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('mahasiswa.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proyek.index') }}">Proyek KKN Saya</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.war.index') }}" :active="true">War Proyek Tersedia</x-nav-item>
        <x-nav-item href="{{ route('mahasiswa.proposal.index') }}">Proposal</x-nav-item>
        <x-nav-item href="#">Logbook Mingguan</x-nav-item>
        <x-nav-item href="#">Laporan Akhir</x-nav-item>
        <x-nav-item href="#">Nilai Saya</x-nav-item>
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

    <div class="mb-6">
        <p class="font-display text-xl font-semibold">War Proyek KKN</p>
        <p class="text-sm text-ink/60 mt-1">Proyek yang sudah lolos validasi dan masih punya slot tim kosong. Siapa cepat, dia dapat.</p>
    </div>

    @if ($proyekTersedia->isEmpty())
        <div class="bg-white rounded-xl border border-border p-10 text-center">
            <p class="text-sm text-ink/60">Belum ada proyek yang tersedia untuk direbut saat ini.</p>
        </div>
    @else
        <div class="grid grid-cols-2 gap-4">
            @foreach ($proyekTersedia as $proyek)
                <div class="bg-white rounded-xl border border-border p-5">
                    <p class="font-display text-base font-semibold">{{ $proyek->judul }}</p>
                    <p class="text-sm text-ink/60 mt-1">{{ $proyek->lokasi }}</p>
                    <p class="text-sm text-ink/70 mt-3 line-clamp-2">{{ $proyek->deskripsi }}</p>

                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-border">
                        <span class="text-xs text-ink/40">
                            Slot tersisa: <span class="font-medium text-role-dosen">{{ $proyek->sisa_slot }}</span> / {{ $proyek->kuota_tim }}
                        </span>
                        <form method="POST" action="{{ route('mahasiswa.war.join', $proyek) }}"
                              onsubmit="return confirm('Yakin mau bergabung ke proyek ini?')">
                            @csrf
                            <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-ink text-white text-xs font-medium hover:bg-ink/90 transition">
                                Ambil Proyek Ini
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-dashboard-layout>