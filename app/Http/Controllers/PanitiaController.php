<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanitiaController extends Controller
{
    public function dashboard()
    {
        return view('panitia.dashboard');
    }

    public function validasiProyek()
    {
        return view('panitia.validasi-proyek');
    }

    public function validasiProposal()
    {
        return view('panitia.validasi-proposal');
    }

    public function lihatNilai()
    {
        return view('panitia.lihat-nilai');
    }

    public function profile()
    {
        return view('panitia.profile');
    }
}