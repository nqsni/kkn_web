<x-dashboard-layout title="Validasi Proposal Mahasiswa">
    <x-slot:sidebar>
        <x-nav-item href="{{ route('panitia.dashboard') }}" :active="request()->routeIs('panitia.dashboard')">Dashboard</x-nav-item>
        <x-nav-item href="{{ route('panitia.validasi.proyek') }}" :active="request()->routeIs('panitia.validasi.proyek')">Validasi Proyek</x-nav-item>
        <x-nav-item href="{{ route('panitia.validasi.proposal') }}" :active="request()->routeIs('panitia.validasi.proposal')">Validasi Proposal</x-nav-item>
        <x-nav-item href="{{ route('panitia.lihat.nilai') }}" :active="request()->routeIs('panitia.lihat.nilai')">Lihat Nilai</x-nav-item>
        <x-nav-item href="{{ route('panitia.profile') }}" :active="request()->routeIs('panitia.profile')">Profile Panitia</x-nav-item>
    </x-slot:sidebar>

    <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
        <h2 class="font-display text-xl font-bold text-gray-800 mb-6">Daftar Proposal Mahasiswa</h2>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Kelompok</th>
                        <th class="px-4 py-3 font-semibold">Dokumen Proposal</th>
                        <th class="px-4 py-3 font-semibold">Status Dosen</th>
                        <th class="px-4 py-3 font-semibold text-center">Aksi Panitia</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">Kelompok 01</td>
                        <td class="px-4 py-3"><a href="#" class="text-emerald-600 hover:underline flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Proposal_01.pdf</a></td>
                        <td class="px-4 py-3"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Disetujui Dosen</span></td>
                        <td class="px-4 py-3 text-center">
                            <button class="px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700">Lihat & Sahkan</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard-layout>