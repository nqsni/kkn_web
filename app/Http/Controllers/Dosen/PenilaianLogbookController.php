<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\LogbookMingguan;
use App\Models\ProyekKkn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianLogbookController extends Controller
{
    public function index()
    {
        $dosenId = Auth::id();

        $proyekList = ProyekKkn::where('dosen_id', $dosenId)
            ->whereHas('logbook')
            ->with(['logbook' => function ($q) {
                $q->orderBy('mahasiswa_id')->orderBy('minggu_ke');
            }, 'logbook.mahasiswa'])
            ->get();

        return view('dosen.penilaian-logbook.index', compact('proyekList'));
    }

    public function edit(LogbookMingguan $logbook)
    {
        if ($logbook->proyek->dosen_id !== Auth::id()) {
            abort(403);
        }

        $logbook->load('proyek', 'mahasiswa');

        return view('dosen.penilaian-logbook.edit', compact('logbook'));
    }

    public function update(Request $request, LogbookMingguan $logbook)
    {
        if ($logbook->proyek->dosen_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'catatan_dosen' => 'nullable|string',
        ]);

        $logbook->update($validated);

        return redirect()->route('dosen.penilaian-logbook.index')
            ->with('success', 'Catatan untuk logbook minggu ke-' . $logbook->minggu_ke . ' (' . $logbook->mahasiswa->name . ') berhasil disimpan.');
    }
}