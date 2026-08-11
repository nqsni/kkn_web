<x-dashboard-layout title="Manajemen User">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('admin.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('admin.data-master.index') }}">Data Master</x-nav-item>
        <x-nav-item href="{{ route('admin.rubrik-penilaian.index') }}">Rubrik Penilaian</x-nav-item>
        <x-nav-item href="{{ route('admin.users.index') }}" :active="true">Manajemen User</x-nav-item>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-2xl bg-role-dosen-soft text-role-dosen text-sm">{{ session('success') }}</div>
    @endif

    <div class="mb-6">
        <p class="font-display text-xl font-semibold">Manajemen User</p>
        <p class="text-sm text-ink/60 mt-1">{{ $users->count() }} user terdaftar di sistem.</p>
    </div>

    <div class="bg-white rounded-2xl border border-border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-paper border-b border-border">
                <tr>
                    <th class="text-left px-5 py-3 font-medium text-ink/50">Nama</th>
                    <th class="text-left px-5 py-3 font-medium text-ink/50">Email</th>
                    <th class="text-left px-5 py-3 font-medium text-ink/50">Role Saat Ini</th>
                    <th class="text-left px-5 py-3 font-medium text-ink/50">Ubah Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b border-border last:border-0">
                        <td class="px-5 py-3 font-medium">{{ $user->name }}</td>
                        <td class="px-5 py-3 text-ink/60">{{ $user->email }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-role-admin-soft text-role-admin">
                                {{ $user->roles->pluck('name')->implode(', ') ?: '-' }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <select name="role" class="rounded-2xl border-border text-xs focus:border-brand focus:ring-brand">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="text-xs text-role-dosen hover:underline whitespace-nowrap">Simpan</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-dashboard-layout>