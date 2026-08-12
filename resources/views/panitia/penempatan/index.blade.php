<x-dashboard-layout title="Penempatan Dosen Pembimbing">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('panitia.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('panitia.validasi-proyek.index') }}">Validasi Proyek KKN</x-nav-item>
        <x-nav-item href="{{ route('panitia.penempatan.index') }}" :active="true">Penempatan Dosen</x-nav-item>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-dosen-soft text-role-dosen text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <p class="font-display text-xl font-semibold">Belum Ada Dosen Pembimbing</p>
        <p class="text-sm text-ink/60 mt-1">{{ $proyekBelumAdaDosen->count() }} proyek perlu ditetapkan dosen pembimbingnya.</p>
    </div>

    @if ($proyekBelumAdaDosen->isEmpty())
        <div class="bg-white rounded-2xl border border-border p-10 text-center mb-10">
            <p class="text-sm text-ink/60">Semua proyek sudah punya dosen pembimbing.</p>
        </div>
    @else
        <div class="space-y-3 mb-10">
            @foreach ($proyekBelumAdaDosen as $proyek)
                <div class="bg-white rounded-2xl border border-border p-5">
                    <div class="flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="font-display text-base font-semibold">{{ $proyek->judul }}</p>
                            <p class="text-sm text-ink/60 mt-1">{{ $proyek->lokasi }} · Pengaju: {{ $proyek->mahasiswa->name ?? '-' }}</p>
                        </div>
                        <form method="POST" action="{{ route('panitia.penempatan.assign', $proyek) }}" class="flex items-center gap-2 shrink-0">
                            @csrf
                            <select name="dosen_id" required class="rounded-2xl border-border text-sm focus:border-brand focus:ring-brand">
                                <option value="">Pilih Dosen</option>
                                @foreach ($dosenList as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit"
                                    class="px-4 py-2 rounded-2xl bg-brand text-white text-xs font-semibold hover:bg-brand/90 transition whitespace-nowrap">
                                Tetapkan
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mb-4">
        <p class="font-display text-lg font-semibold">Sudah Ditempatkan</p>
    </div>

    @if ($proyekSudahAdaDosen->isEmpty())
        <p class="text-sm text-ink/40">Belum ada.</p>
    @else
        <div class="space-y-2">
            @foreach ($proyekSudahAdaDosen as $proyek)
                <div class="flex items-center justify-between bg-white rounded-2xl border border-border px-5 py-3">
                    <div>
                        <p class="text-sm font-medium">{{ $proyek->judul }}</p>
                        <p class="text-xs text-ink/40">Dosen: {{ $proyek->dosen->name ?? '-' }}</p>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-role-admin-soft text-role-admin">Ditempatkan</span>
                </div>
            @endforeach
        </div>
    @endif
</x-dashboard-layout>