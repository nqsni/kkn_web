<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function dashboard()
    {
        // Catatan: Dashboard terbagi menjadi sebelum KKN dan setelah KKN
        return view('dosen.dashboard');
    }

    public function pengajuanProyek()
    {
        // Sub-page untuk dosen mengajukan proyek dan tim KKN
        return view('dosen.pengajuan-proyek');
    }

    public function validasiProposal()
    {
        // Sub-page untuk memvalidasi atau menolak proposal mahasiswa
        return view('dosen.validasi-proposal');
    }

    public function penilaian()
    {
        // Dosen memberikan nilai logbook, laporan akhir, dan nilai akhir
        return view('dosen.penilaian');
    }

    public function profile()
    {
        // Halaman biodata
        return view('dosen.profile');
    }
}