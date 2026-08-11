<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\ProyekKkn;
use Illuminate\Http\Request;

class ValidasiProyekController extends Controller
{
    // List proyek yang menunggu validasi
    public function index()
    {
        $proyekDiajukan = ProyekKkn::where('status', 'diajukan')
            ->with('mahasiswa')
            ->latest()
            ->get();

        $riwayat = ProyekKkn::whereIn('status', ['lolos', 'tidak_lolos', 'penuh'])
            ->with('mahasiswa')
            ->latest()
            ->get();

        return view('panitia.validasi-proyek.index', compact('proyekDiajukan', 'riwayat'));
    }

    // Detail 1 proyek untuk direview
    public function show(ProyekKkn $proyek)
    {
        $proyek->load('mahasiswa', 'timKkn.mahasiswa');

        return view('panitia.validasi-proyek.show', compact('proyek'));
    }

    // Proses ACC / Tolak
    public function update(Request $request, ProyekKkn $proyek)
    {
        $validated = $request->validate([
            'keputusan' => 'required|in:lolos,tidak_lolos',
            'catatan_validasi' => 'nullable|string|required_if:keputusan,tidak_lolos',
        ]);

        if ($proyek->status !== 'diajukan') {
            return redirect()->route('panitia.validasi-proyek.index')
                ->with('error', 'Proyek ini sudah divalidasi sebelumnya.');
        }

        $proyek->update([
            'status' => $validated['keputusan'],
            'catatan_validasi' => $validated['catatan_validasi'] ?? null,
        ]);

        $pesan = $validated['keputusan'] === 'lolos'
            ? 'Proyek berhasil diloloskan.'
            : 'Proyek ditolak dan mahasiswa akan diarahkan ke War.';

        return redirect()->route('panitia.validasi-proyek.index')->with('success', $pesan);
    }
}