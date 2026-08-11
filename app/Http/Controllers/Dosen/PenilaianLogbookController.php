<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\LogbookMingguan;
use App\Models\ProyekKkn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianLogbookController extends Controller
{
    // List mahasiswa bimbingan yang punya logbook
    public function index()
    {
        $dosenId = Auth::id();

        $proyekList = ProyekKkn::where('dosen_id', $dosenId)
            ->whereHas('logbook')
            ->with(['mahasiswa', 'logbook' => function ($q) {
                $q->orderBy('minggu_ke');
            }])
            ->get();

        return view('dosen.penilaian-logbook.index', compact('proyekList'));
    }

    // Form nilai 1 logbook
    public function edit(LogbookMingguan $logbook)
    {
        if ($logbook->proyek->dosen_id !== Auth::id()) {
            abort(403);
        }

        $logbook->load('proyek.mahasiswa');

        return view('dosen.penilaian-logbook.edit', compact('logbook'));
    }

    // Simpan nilai
    public function update(Request $request, LogbookMingguan $logbook)
    {
        if ($logbook->proyek->dosen_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'catatan_dosen' => 'nullable|string',
        ]);

        $logbook->update($validated);

        return redirect()->route('dosen.penilaian-logbook.index')
            ->with('success', 'Nilai logbook minggu ke-' . $logbook->minggu_ke . ' berhasil disimpan.');
    }
}