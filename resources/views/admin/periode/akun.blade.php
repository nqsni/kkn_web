<x-dashboard-layout title="Kelola Akun — {{ $periode->nama }}">
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
    @if (session('error'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-panitia-soft text-role-panitia text-sm">{{ session('error') }}</div>
    @endif

    <a href="{{ route('admin.periode.index') }}" class="text-sm text-ink/50 hover:text-ink mb-4 inline-block">← Kembali</a>

    <p class="font-display text-xl font-semibold mb-1">Kelola Akun — {{ $periode->nama }}</p>
    <p class="text-sm text-ink/60 mb-6">{{ $anggota->count() }} akun terdaftar di periode ini.</p>

    <div class="grid grid-cols-3 gap-5">
        {{-- KIRI: 2 kolom, list anggota --}}
        <div class="col-span-2">
            <div class="bg-white rounded-2xl border border-border overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-paper border-b border-border">
                        <tr>
                            <th class="text-left px-5 py-3 font-medium text-ink/50">Nama</th>
                            <th class="text-left px-5 py-3 font-medium text-ink/50">Email</th>
                            <th class="text-left px-5 py-3 font-medium text-ink/50">Role</th>
                            <th class="text-left px-5 py-3 font-medium text-ink/50"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($anggota as $user)
                            <tr class="border-b border-border last:border-0">
                                <td class="px-5 py-3 font-medium">{{ $user->name }}</td>
                                <td class="px-5 py-3 text-ink/60">{{ $user->email }}</td>
                                <td class="px-5 py-3">
                                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-role-admin-soft text-role-admin">
                                        {{ $user->pivot->role_saat_itu }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <form method="POST" action="{{ route('admin.periode.akun.destroy', [$periode, $user]) }}"
                                          onsubmit="return confirm('Keluarkan akun ini dari periode?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs text-role-panitia hover:underline">Keluarkan</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-5 py-6 text-center text-ink/40">Belum ada akun di periode ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- KANAN: form buat baru & cari existing --}}
        <div class="space-y-5">
            <div class="bg-white rounded-2xl border border-border p-5">
                <p class="text-sm font-semibold mb-3">Buat Akun Baru</p>

                @if ($errors->any())
                    <div class="mb-3 px-3 py-2 rounded-xl bg-role-panitia-soft text-role-panitia text-xs">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.periode.akun.store-new', $periode) }}" class="space-y-3">
                    @csrf
                    <input type="text" name="name" placeholder="Nama lengkap"
                           class="w-full rounded-xl border-border focus:border-brand focus:ring-brand text-sm">
                    <input type="email" name="email" placeholder="Email"
                           class="w-full rounded-xl border-border focus:border-brand focus:ring-brand text-sm">
                    <div>
                        <label class="block text-xs text-ink/50 mb-1">Tanggal Lahir (jadi password)</label>
                        <input type="date" name="tanggal_lahir"
                               class="w-full rounded-xl border-border focus:border-brand focus:ring-brand text-sm">
                    </div>
                    <select name="role" class="w-full rounded-xl border-border focus:border-brand focus:ring-brand text-sm">
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="dosen_pembimbing">Dosen Pembimbing</option>
                        <option value="panitia_kkn">Panitia KKN</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                    <button type="submit" class="w-full px-4 py-2 rounded-xl bg-brand text-white text-xs font-semibold hover:bg-brand/90 transition">
                        Buat & Tambahkan
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-border p-5">
                <p class="text-sm font-semibold mb-3">Tambahkan Akun Lama</p>
                <form method="GET" action="{{ route('admin.periode.akun.index', $periode) }}" class="flex gap-2 mb-3">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama/email"
                           class="flex-1 rounded-xl border-border focus:border-brand focus:ring-brand text-sm">
                    <button type="submit" class="px-3 py-2 rounded-xl border border-border text-xs font-medium hover:bg-paper transition">Cari</button>
                </form>

                @if ($hasilPencarian !== null)
                    <div class="space-y-2">
                        @forelse ($hasilPencarian as $user)
                            <div class="flex items-center justify-between border border-border rounded-xl px-3 py-2">
                                <div class="min-w-0">
                                    <p class="text-xs font-medium truncate">{{ $user->name }}</p>
                                    <p class="text-xs text-ink/40 truncate">{{ $user->email }} · {{ $user->getRoleNames()->first() ?? '-' }}</p>
                                </div>
                                <form method="POST" action="{{ route('admin.periode.akun.store-existing', $periode) }}">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <button type="submit" class="text-xs text-role-dosen hover:underline whitespace-nowrap ml-2">Tambahkan</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-xs text-ink/40">Tidak ditemukan.</p>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dashboard-layout>