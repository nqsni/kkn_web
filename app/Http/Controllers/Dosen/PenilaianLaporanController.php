<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\LaporanAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianLaporanController extends Controller
{
    public function index()
    {
        $dosenId = Auth::id();

        $belumDinilai = LaporanAkhir::whereHas('proyek', function ($q) use ($dosenId) {
                $q->where('dosen_id', $dosenId);
            })
            ->whereNull('nilai')
            ->with('proyek.mahasiswa')
            ->latest()
            ->get();

        $sudahDinilai = LaporanAkhir::whereHas('proyek', function ($q) use ($dosenId) {
                $q->where('dosen_id', $dosenId);
            })
            ->whereNotNull('nilai')
            ->with('proyek.mahasiswa')
            ->latest()
            ->get();

        return view('dosen.penilaian-laporan.index', compact('belumDinilai', 'sudahDinilai'));
    }

    public function edit(LaporanAkhir $laporan)
    {
        if ($laporan->proyek->dosen_id !== Auth::id()) {
            abort(403);
        }

        $laporan->load('proyek.mahasiswa');

        return view('dosen.penilaian-laporan.edit', compact('laporan'));
    }

    public function update(Request $request, LaporanAkhir $laporan)
    {
        if ($laporan->proyek->dosen_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'catatan_dosen' => 'nullable|string',
        ]);

        $laporan->update($validated);

        return redirect()->route('dosen.penilaian-laporan.index')
            ->with('success', 'Nilai laporan akhir berhasil disimpan.');
    }
}