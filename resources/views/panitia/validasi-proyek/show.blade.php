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
                <p class="text-sm text-ink/60 mb-4">Diajukan oleh {{ $proyek->mahasiswa->name }} ({{ $proyek->mahasiswa->email }})</p>

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

                    <form method="POST" action="{{ route('panitia.validasi-proyek.update', $proyek) }}" x-data="{ keputusan: '' }">
                        @csrf

                        <div class="flex gap-3 mb-4">
                            <button type="button" onclick="document.getElementById('keputusan_lolos').click()"
                                    class="flex-1 px-4 py-3 rounded-2xl border-2 border-accent-kiwi text-accent-kiwi text-sm font-semibold hover:bg-accent-kiwi/10 transition">
                                ✓ Loloskan
                            </button>
                            <button type="button" onclick="document.getElementById('keputusan_tolak').click()"
                                    class="flex-1 px-4 py-3 rounded-2xl border-2 border-role-panitia text-role-panitia text-sm font-semibold hover:bg-role-panitia-soft transition">
                                ✕ Tolak
                            </button>
                        </div>

                        <div class="hidden" id="form-tolak">
                            <textarea name="catatan_validasi" rows="3" placeholder="Alasan penolakan (wajib diisi)"
                                      class="w-full rounded-2xl border-border focus:border-brand focus:ring-brand text-sm mb-3"></textarea>
                        </div>

                        <input type="hidden" name="keputusan" id="keputusan-input" value="">

                        <button type="submit" id="keputusan_lolos" onclick="document.getElementById('keputusan-input').value='lolos'; document.getElementById('form-tolak').classList.add('hidden');" class="hidden"></button>
                        <button type="submit" id="keputusan_tolak" onclick="event.preventDefault(); document.getElementById('keputusan-input').value='tidak_lolos'; document.getElementById('form-tolak').classList.remove('hidden');" class="hidden"></button>

                        <button type="submit"
                                class="w-full px-5 py-2.5 rounded-2xl bg-ink text-white text-sm font-medium hover:bg-ink/90 transition">
                            Kirim Keputusan
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
                @foreach ($proyek->timKkn as $tim)
                    <div class="flex items-center justify-between text-sm py-1.5">
                        <span>{{ $tim->mahasiswa->name }}</span>
                        <span class="text-xs text-ink/40">{{ $tim->peran === 'pengaju' ? 'Pengaju' : 'Anggota' }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-dashboard-layout>