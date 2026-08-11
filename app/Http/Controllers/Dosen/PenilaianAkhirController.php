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
            ->whereIn('status', ['lolos', 'penuh'])
            ->with('mahasiswa', 'nilaiAkhir')
            ->get();

        return view('dosen.penilaian-akhir.index', compact('proyekList'));
    }

    public function edit(ProyekKkn $proyek)
    {
        if ($proyek->dosen_id !== Auth::id()) {
            abort(403);
        }

        $proyek->load('penilaianLrk', 'penilaianKinerja', 'penilaianLpk', 'nilaiAkhir', 'mahasiswa');

        return view('dosen.penilaian-akhir.edit', compact('proyek'));
    }

    public function update(Request $request, ProyekKkn $proyek)
    {
        if ($proyek->dosen_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nilai_lrk' => 'required|numeric|min:0|max:100',
            'pelaksanaan' => 'required|numeric|min:0|max:100',
            'disiplin' => 'required|numeric|min:0|max:100',
            'kerjasama' => 'required|numeric|min:0|max:100',
            'penghayatan' => 'required|numeric|min:0|max:100',
            'nilai_lpk' => 'required|numeric|min:0|max:100',
        ]);

        $this->penilaianService->prosesPenilaianAkhir($proyek, $validated);

        return redirect()->route('dosen.penilaian-akhir.index')
            ->with('success', 'Nilai akhir untuk "' . $proyek->judul . '" berhasil disimpan.');
    }
}