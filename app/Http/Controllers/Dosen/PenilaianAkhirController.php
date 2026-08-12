<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ProyekKkn;
use App\Services\PenilaianService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianAkhirController extends Controller
{
    public function __construct(protected PenilaianService $penilaianService)
    {
    }

    public function index()
    {
        $dosenId = Auth::id();

        $proyekList = ProyekKkn::where('dosen_id', $dosenId)
            ->whereIn('status', ['tersedia', 'penuh'])
            ->with('mahasiswa', 'nilaiAkhir', 'proposal', 'laporanAkhir')
            ->get();

        return view('dosen.penilaian-akhir.index', compact('proyekList'));
    }

    public function edit(ProyekKkn $proyek)
    {
        if ($proyek->dosen_id !== Auth::id()) {
            abort(403);
        }

        $proyek->load('penilaianKinerja', 'nilaiAkhir', 'mahasiswa', 'proposal', 'laporanAkhir');

        return view('dosen.penilaian-akhir.edit', compact('proyek'));
    }

    public function update(Request $request, ProyekKkn $proyek)
    {
        if ($proyek->dosen_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'pelaksanaan' => 'required|numeric|min:0|max:100',
            'disiplin' => 'required|numeric|min:0|max:100',
            'kerjasama' => 'required|numeric|min:0|max:100',
            'penghayatan' => 'required|numeric|min:0|max:100',
        ]);

        try {
            $this->penilaianService->prosesPenilaianAkhir($proyek, $validated);
        } catch (\Exception $e) {
            return back()->withErrors(['nilai' => $e->getMessage()])->withInput();
        }

        return redirect()->route('dosen.penilaian-akhir.index')
            ->with('success', 'Nilai akhir untuk "' . $proyek->judul . '" berhasil disimpan.');
    }
}