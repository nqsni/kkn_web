<x-dashboard-layout title="Penilaian Mahasiswa">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('dosen.dashboard') }}">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('dosen.pengajuan.proyek') }}">Pengajuan Proyek</x-nav-item>
        <x-nav-item href="{{ route('dosen.validasi.proposal') }}">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('dosen.penilaian') }}" :active="true">Penilaian Mahasiswa</x-nav-item>
        <x-nav-item href="{{ route('dosen.profile') }}">Profile Dosen</x-nav-item>
    </x-slot:sidebar>

    <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
        <h2 class="font-display text-xl font-bold text-gray-800 mb-6">Rekapitulasi Penilaian Tim Bimbingan</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-emerald-50 border-y border-emerald-100">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-emerald-800">Nama Mahasiswa</th>
                        <th class="px-4 py-3 font-semibold text-emerald-800">Kelompok</th>
                        <th class="px-4 py-3 font-semibold text-emerald-800 text-center">Logbook</th>
                        <th class="px-4 py-3 font-semibold text-emerald-800 text-center">Laporan Akhir</th>
                        <th class="px-4 py-3 font-semibold text-emerald-800 text-center">Nilai Akhir</th>
                        <th class="px-4 py-3 font-semibold text-emerald-800 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4">
                            <p class="font-medium text-gray-800">Amelia Hapsari</p>
                            <p class="text-xs text-gray-500">NIM: 123456789</p>
                        </td>
                        <td class="px-4 py-4">Desa Maju - 01</td>
                        <td class="px-4 py-4 text-center"><span class="text-emerald-600 font-semibold">85</span></td>
                        <td class="px-4 py-4 text-center"><span class="text-gray-400 font-medium">-</span></td>
                        <td class="px-4 py-4 text-center"><span class="text-gray-400 font-medium">-</span></td>
                        <td class="px-4 py-4 text-center">
                            <button class="px-3 py-1.5 text-xs font-medium text-white bg-emerald-600 rounded-md hover:bg-emerald-700">Input Nilai</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard-layout>