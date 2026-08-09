<x-dashboard-layout title="Rekapitulasi Nilai KKN">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('panitia.dashboard') }}" :active="request()->routeIs('panitia.dashboard')">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('panitia.validasi.proyek') }}" :active="request()->routeIs('panitia.validasi.proyek')">Validasi Proyek</x-nav-item>
        <x-nav-item href="{{ route('panitia.validasi.proposal') }}" :active="request()->routeIs('panitia.validasi.proposal')">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('panitia.lihat.nilai') }}" :active="request()->routeIs('panitia.lihat.nilai')">Lihat Nilai</x-nav-item>
        <x-nav-item href="{{ route('panitia.profile') }}" :active="request()->routeIs('panitia.profile')">Profile Panitia</x-nav-item>
    </x-slot:sidebar>

    <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
        <h2 class="font-display text-xl font-bold text-gray-800 mb-6">Database Nilai Mahasiswa</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-emerald-50 border-y border-emerald-100">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-emerald-800">Nama Mahasiswa</th>
                        <th class="px-4 py-3 font-semibold text-emerald-800">NIM</th>
                        <th class="px-4 py-3 font-semibold text-emerald-800 text-center">Logbook</th>
                        <th class="px-4 py-3 font-semibold text-emerald-800 text-center">Laporan Akhir</th>
                        <th class="px-4 py-3 font-semibold text-emerald-800 text-center">Nilai Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 font-medium text-gray-800">Amelia Hapsari</td>
                        <td class="px-4 py-4">123456789</td>
                        <td class="px-4 py-4 text-center"><span class="text-gray-700 font-semibold">85</span></td>
                        <td class="px-4 py-4 text-center"><span class="text-gray-700 font-semibold">90</span></td>
                        <td class="px-4 py-4 text-center"><span class="text-emerald-600 font-bold text-lg">A</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard-layout>