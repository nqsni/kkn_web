<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\ProyekKkn;
use App\Models\User;
use Illuminate\Http\Request;

class ValidasiProyekController extends Controller
{
    public function index()
    {
        $proyekDiajukan = ProyekKkn::where('status', 'diajukan')
            ->with('mahasiswa', 'dosen')
            ->latest()
            ->get();

        $riwayat = ProyekKkn::whereIn('status', ['menunggu_rilis', 'tersedia', 'tidak_lolos', 'penuh'])
            ->with('mahasiswa', 'dosen')
            ->latest()
            ->get();

        return view('panitia.validasi-proyek.index', compact('proyekDiajukan', 'riwayat'));
    }

    public function show(ProyekKkn $proyek)
    {
        $proyek->load('mahasiswa', 'dosen', 'timKkn.mahasiswa');

        $dosenList = $proyek->pengaju_type === 'mahasiswa'
            ? User::role('dosen_pembimbing')->get()
            : collect();

        return view('panitia.validasi-proyek.show', compact('proyek', 'dosenList'));
    }

    public function update(Request $request, ProyekKkn $proyek)
    {
        $rules = [
            'keputusan' => 'required|in:lolos,tidak_lolos',
            'catatan_validasi' => 'nullable|string|required_if:keputusan,tidak_lolos',
        ];

        // Kalau pengaju mahasiswa dan belum ada dosen, wajib pilih dosen saat meloloskan
        if ($proyek->pengaju_type === 'mahasiswa' && !$proyek->dosen_id) {
            $rules['dosen_id'] = 'required_if:keputusan,lolos|exists:users,id';
        }

        $validated = $request->validate($rules);

        if ($proyek->status !== 'diajukan') {
            return redirect()->route('panitia.validasi-proyek.index')
                ->with('error', 'Proyek ini sudah divalidasi sebelumnya.');
        }

        $dataUpdate = [
            'status' => $validated['keputusan'] === 'lolos' ? 'menunggu_rilis' : 'tidak_lolos',
            'catatan_validasi' => $validated['catatan_validasi'] ?? null,
        ];

        if (isset($validated['dosen_id'])) {
            $dataUpdate['dosen_id'] = $validated['dosen_id'];
        }

        $proyek->update($dataUpdate);

        $pesan = $validated['keputusan'] === 'lolos'
            ? 'Proyek diloloskan, menunggu peninjauan Super Admin untuk dirilis.'
            : 'Proyek ditolak.';

        return redirect()->route('panitia.validasi-proyek.index')->with('success', $pesan);
    }
}