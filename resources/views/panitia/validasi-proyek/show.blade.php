<x-dashboard-layout title="Detail Validasi Proyek">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('panitia.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('panitia.validasi-proyek.index') }}" :active="true">Validasi Proyek KKN</x-nav-item>
        <x-nav-item href="{{ route('panitia.penempatan.index') }}">Penempatan Dosen</x-nav-item>
    </x-slot:sidebar>

    <a href="{{ route('panitia.validasi-proyek.index') }}" class="text-sm text-ink/50 hover:text-ink mb-4 inline-block">← Kembali</a>

    <div class="grid grid-cols-3 gap-5">
        <div class="col-span-2 space-y-5">
            <div class="bg-white rounded-2xl border border-border p-6">
                <p class="font-display text-xl font-semibold mb-1">{{ $proyek->judul }}</p>
                <p class="text-sm text-ink/60 mb-4">
                    @if ($proyek->pengaju_type === 'dosen')
                        Diajukan oleh Dosen: {{ $proyek->dosen->name ?? '-' }} ({{ $proyek->dosen->email ?? '-' }})
                    @else
                        Diajukan oleh Mahasiswa: {{ $proyek->mahasiswa->name ?? '-' }} ({{ $proyek->mahasiswa->email ?? '-' }})
                    @endif
                </p>

                <p class="text-sm text-ink/70 leading-relaxed">{{ $proyek->deskripsi }}</p>

                <div class="grid grid-cols-2 gap-4 mt-5 pt-5 border-t border-border">
                    <div>
                        <p class="text-xs text-ink/40">Lokasi</p>
                        <p class="text-sm font-medium mt-0.5">{{ $proyek->lokasi }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-ink/40">Kuota Tim</p>
                        <p class="text-sm font-medium mt-0.5">{{ $proyek->kuota_tim }} orang</p>
                    </div>
                </div>
            </div>

            @if ($proyek->status === 'diajukan')
                <div class="bg-white rounded-2xl border border-border p-6">
                    <p class="font-display text-base font-semibold mb-4">Keputusan Validasi</p>

                    @if ($errors->any())
                        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-panitia-soft text-role-panitia text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form Loloskan --}}
                    <form method="POST" action="{{ route('panitia.validasi-proyek.update', $proyek) }}" class="mb-4 p-4 rounded-2xl border-2 border-accent-kiwi/30 bg-accent-kiwi/5">
                        @csrf
                        <input type="hidden" name="keputusan" value="lolos">
                        <p class="text-sm font-semibold text-accent-kiwi mb-3">✓ Loloskan Proyek</p>

                        @if ($proyek->pengaju_type === 'mahasiswa' && !$proyek->dosen_id)
                            <div class="mb-3">
                                <label class="block text-xs text-ink/60 mb-1">Pilih Dosen Pembimbing</label>
                                <select name="dosen_id" class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm">
                                    <option value="">-- Pilih Dosen --</option>
                                    @foreach ($dosenList as $dosen)
                                        <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif ($proyek->pengaju_type === 'dosen')
                            <p class="text-xs text-ink/50 mb-3">Dosen pembimbing: <strong>{{ $proyek->dosen->name ?? '-' }}</strong> (pengaju proyek ini)</p>
                        @endif

                        <button type="submit" class="w-full px-4 py-2.5 rounded-2xl bg-accent-kiwi text-white text-sm font-semibold hover:bg-accent-kiwi/90 transition">
                            Loloskan Proyek Ini
                        </button>
                    </form>

                    {{-- Form Tolak --}}
                    <form method="POST" action="{{ route('panitia.validasi-proyek.update', $proyek) }}" class="p-4 rounded-2xl border-2 border-role-panitia/30 bg-role-panitia-soft">
                        @csrf
                        <input type="hidden" name="keputusan" value="tidak_lolos">
                        <p class="text-sm font-semibold text-role-panitia mb-3">✕ Tolak Proyek</p>
                        <textarea name="catatan_validasi" rows="3" placeholder="Alasan penolakan (wajib diisi)"
                                  class="w-full rounded-2xl border-border focus:border-role-panitia focus:ring-role-panitia text-sm mb-3"></textarea>
                        <button type="submit" class="w-full px-4 py-2.5 rounded-2xl border-2 border-role-panitia text-role-panitia text-sm font-semibold hover:bg-role-panitia/10 transition">
                            Tolak Proyek Ini
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-border p-6">
                    <p class="text-sm text-ink/60">Proyek ini sudah divalidasi sebelumnya dengan status: <strong>{{ $proyek->status }}</strong></p>
                    @if ($proyek->catatan_validasi)
                        <p class="text-sm text-ink/70 mt-2">Catatan: {{ $proyek->catatan_validasi }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <div class="bg-white rounded-2xl border border-border p-6">
                <p class="text-sm font-medium mb-3">Tim Saat Ini</p>
                @forelse ($proyek->timKkn as $tim)
                    <div class="flex items-center justify-between text-sm py-1.5">
                        <span>{{ $tim->mahasiswa->name }}</span>
                        <span class="text-xs text-ink/40">{{ $tim->peran === 'pengaju' ? 'Pengaju' : 'Anggota' }}</span>
                    </div>
                @empty
                    <p class="text-xs text-ink/40">Belum ada anggota.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-dashboard-layout>