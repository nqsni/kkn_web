<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\LaporanAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanAkhirController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $proyek = $user->proyek_aktif;

        if (!$proyek) {
            return redirect()->route('mahasiswa.proyek.index')
                ->with('error', 'Kamu belum memiliki proyek KKN aktif.');
        }

        $proyek->load('proposal', 'laporanAkhir');

        $bisaUpload = $proyek->proposal && $proyek->proposal->status === 'acc';

        return view('mahasiswa.laporan-akhir.index', compact('proyek', 'bisaUpload'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $proyek = $user->proyek_aktif;

        if (!$proyek) {
            return redirect()->route('mahasiswa.proyek.index')
                ->with('error', 'Kamu belum memiliki proyek KKN aktif.');
        }

        if (!$proyek->proposal || $proyek->proposal->status !== 'acc') {
            return redirect()->route('mahasiswa.laporan-akhir.index')
                ->with('error', 'Proposal belum di-ACC dosen, belum bisa upload laporan akhir.');
        }

        if ($proyek->laporanAkhir) {
            return redirect()->route('mahasiswa.laporan-akhir.index')
                ->with('error', 'Laporan akhir untuk proyek ini sudah pernah diupload.');
        }

        $request->validate([
            'file_laporan' => 'required|file|mimes:pdf|max:5120',
        ]);

        $path = $request->file('file_laporan')->store('laporan-akhir', 'public');

        LaporanAkhir::create([
            'proyek_kkn_id' => $proyek->id,
            'file_laporan' => $path,
        ]);

        return redirect()->route('mahasiswa.laporan-akhir.index')
            ->with('success', 'Laporan akhir berhasil diupload, menunggu penilaian dosen.');
    }
}