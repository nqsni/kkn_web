<x-dashboard-layout title="Data Master">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('admin.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('admin.periode.index') }}">Periode KKN</x-nav-item>
        <x-nav-item href="{{ route('admin.data-master.index') }}" :active="true">Data Master</x-nav-item>
        <x-nav-item href="{{ route('admin.rubrik-penilaian.index') }}">Rubrik Penilaian</x-nav-item>
        <x-nav-item href="{{ route('admin.users.index') }}">Manajemen User</x-nav-item>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-dosen-soft text-role-dosen text-sm">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-2 gap-6">
        {{-- LOKASI --}}
        <div>
            <p class="font-display text-lg font-semibold mb-4">Lokasi KKN</p>

            <div class="bg-white rounded-2xl border border-border p-5 mb-4">
                <form method="POST" action="{{ route('admin.data-master.store') }}" class="space-y-3">
                    @csrf
                    <input type="hidden" name="jenis" value="lokasi">
                    <input type="text" name="nama" placeholder="Nama lokasi"
                           class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
                    <input type="text" name="keterangan" placeholder="Keterangan (opsional)"
                           class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
                    <button type="submit" class="w-full px-4 py-2 rounded-2xl bg-brand text-white text-sm font-medium hover:bg-brand/90 transition">
                        + Tambah Lokasi
                    </button>
                </form>
            </div>

            <div class="space-y-2">
                @forelse ($lokasiList as $lokasi)
                    <div class="flex items-center justify-between bg-white rounded-2xl border border-border px-4 py-3">
                        <div>
                            <p class="text-sm font-medium">{{ $lokasi->nama }}</p>
                            @if ($lokasi->keterangan)
                                <p class="text-xs text-ink/40">{{ $lokasi->keterangan }}</p>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('admin.data-master.destroy', $lokasi) }}" onsubmit="return confirm('Hapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-role-panitia hover:underline">Hapus</button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-ink/40">Belum ada data lokasi.</p>
                @endforelse
            </div>
        </div>

        {{-- PERIODE --}}
        <div>
            <p class="font-display text-lg font-semibold mb-4">Periode KKN</p>

            <div class="bg-white rounded-2xl border border-border p-5 mb-4">
                <form method="POST" action="{{ route('admin.data-master.store') }}" class="space-y-3">
                    @csrf
                    <input type="hidden" name="jenis" value="periode">
                    <input type="text" name="nama" placeholder="Nama periode (contoh: Ganjil 2026/2027)"
                           class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
                    <input type="text" name="keterangan" placeholder="Keterangan (opsional)"
                           class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
                    <button type="submit" class="w-full px-4 py-2 rounded-2xl bg-brand text-white text-sm font-medium hover:bg-brand/90 transition">
                        + Tambah Periode
                    </button>
                </form>
            </div>

            <div class="space-y-2">
                @forelse ($periodeList as $periode)
                    <div class="flex items-center justify-between bg-white rounded-2xl border border-border px-4 py-3">
                        <div>
                            <p class="text-sm font-medium">{{ $periode->nama }}</p>
                            @if ($periode->keterangan)
                                <p class="text-xs text-ink/40">{{ $periode->keterangan }}</p>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('admin.data-master.destroy', $periode) }}" onsubmit="return confirm('Hapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-role-panitia hover:underline">Hapus</button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-ink/40">Belum ada data periode.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-dashboard-layout>