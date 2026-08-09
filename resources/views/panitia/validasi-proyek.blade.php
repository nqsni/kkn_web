<x-dashboard-layout title="Validasi Proyek KKN">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('panitia.dashboard') }}" :active="request()->routeIs('panitia.dashboard')">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('panitia.validasi.proyek') }}" :active="request()->routeIs('panitia.validasi.proyek')">Validasi Proyek</x-nav-item>
        <x-nav-item href="{{ route('panitia.validasi.proposal') }}" :active="request()->routeIs('panitia.validasi.proposal')">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('panitia.lihat.nilai') }}" :active="request()->routeIs('panitia.lihat.nilai')">Lihat Nilai</x-nav-item>
        <x-nav-item href="{{ route('panitia.profile') }}" :active="request()->routeIs('panitia.profile')">Profile Panitia</x-nav-item>
    </x-slot:sidebar>

    <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
        <h2 class="font-display text-xl font-bold text-gray-800 mb-6">Daftar Ajuan Proyek dari Dosen</h2>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Nama Proyek</th>
                        <th class="px-4 py-3 font-semibold">Dosen Pengaju</th>
                        <th class="px-4 py-3 font-semibold">Lokasi</th>
                        <th class="px-4 py-3 font-semibold text-center">Status / Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">Sistem Irigasi Otomatis</td>
                        <td class="px-4 py-3">Ahmadi, S.T., M.T.</td>
                        <td class="px-4 py-3">Desa Sukamaju</td>
                        <td class="px-4 py-3 text-center">
                            <button class="px-3 py-1 bg-emerald-600 text-white text-xs font-medium rounded hover:bg-emerald-700">Validasi</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard-layout>