<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $proyek = $user->proyek_aktif;

        if (!$proyek) {
            return redirect()->route('mahasiswa.proyek.index')
                ->with('error', 'Kamu belum memiliki proyek KKN aktif.');
        }

        $proyek->load('penilaianLrk', 'penilaianKinerja', 'penilaianLpk', 'nilaiAkhir');

        return view('mahasiswa.nilai.index', compact('proyek'));
    }
}