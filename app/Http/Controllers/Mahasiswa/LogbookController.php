<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\LogbookMingguan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogbookController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $proyek = $user->proyek_aktif;

        if (!$proyek) {
            return redirect()->route('mahasiswa.proyek.index')
                ->with('error', 'Kamu belum memiliki proyek KKN aktif.');
        }

        $proyek->load('proposal', 'logbook');

        $bisaUpload = $proyek->proposal && $proyek->proposal->status === 'acc';
        $mingguSelanjutnya = $proyek->logbook->count() + 1;

        return view('mahasiswa.logbook.index', compact('proyek', 'bisaUpload', 'mingguSelanjutnya'));
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
            return redirect()->route('mahasiswa.logbook.index')
                ->with('error', 'Proposal belum di-ACC dosen, belum bisa upload logbook.');
        }

        $request->validate([
            'minggu_ke' => 'required|integer|min:1',
            'file_logbook' => 'required|file|mimes:pdf|max:5120',
            'deskripsi_kegiatan' => 'required|string',
        ]);

        $sudahAda = $proyek->logbook()->where('minggu_ke', $request->minggu_ke)->exists();
        if ($sudahAda) {
            return redirect()->route('mahasiswa.logbook.index')
                ->with('error', 'Logbook untuk minggu ke-' . $request->minggu_ke . ' sudah pernah diupload.');
        }

        $path = $request->file('file_logbook')->store('logbook', 'public');

        LogbookMingguan::create([
            'proyek_kkn_id' => $proyek->id,
            'minggu_ke' => $request->minggu_ke,
            'file_logbook' => $path,
            'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
        ]);

        return redirect()->route('mahasiswa.logbook.index')
            ->with('success', 'Logbook minggu ke-' . $request->minggu_ke . ' berhasil diupload.');
    }
}