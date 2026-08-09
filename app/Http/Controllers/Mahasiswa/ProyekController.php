<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\ProyekKkn;
use App\Models\TimKkn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProyekController extends Controller
{
    // List semua proyek yang diikuti mahasiswa (sbg pengaju/anggota)
    public function index()
    {
        $user = Auth::user();

        $timList = TimKkn::with('proyek.dosen')
            ->where('mahasiswa_id', $user->id)
            ->get();

        return view('mahasiswa.proyek.index', compact('timList'));
    }

    // Form submit proyek baru
    public function create()
    {
        $user = Auth::user();

        // Cegah submit kalau masih punya proyek aktif
        if ($user->proyek_aktif) {
            return redirect()->route('mahasiswa.proyek.index')
                ->with('error', 'Kamu masih memiliki proyek aktif. Tidak bisa mengajukan proyek baru.');
        }

        return view('mahasiswa.proyek.create');
    }

    // Simpan proyek baru
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->proyek_aktif) {
            return redirect()->route('mahasiswa.proyek.index')
                ->with('error', 'Kamu masih memiliki proyek aktif.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'kuota_tim' => 'required|integer|min:1|max:10',
        ]);

        DB::transaction(function () use ($validated, $user) {
            $proyek = ProyekKkn::create([
                'mahasiswa_id' => $user->id,
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'lokasi' => $validated['lokasi'],
                'kuota_tim' => $validated['kuota_tim'],
                'status' => 'diajukan',
            ]);

            TimKkn::create([
                'proyek_kkn_id' => $proyek->id,
                'mahasiswa_id' => $user->id,
                'peran' => 'pengaju',
            ]);
        });

        return redirect()->route('mahasiswa.proyek.index')
            ->with('success', 'Proyek KKN berhasil diajukan, menunggu validasi panitia.');
    }

    // Detail 1 proyek
    public function show(ProyekKkn $proyek)
    {
        $user = Auth::user();

        // Pastikan mahasiswa ini bagian dari tim proyek tsb
        $isMember = $proyek->timKkn()->where('mahasiswa_id', $user->id)->exists();
        if (!$isMember) {
            abort(403);
        }

        $proyek->load('timKkn.mahasiswa', 'dosen');

        return view('mahasiswa.proyek.show', compact('proyek'));
    }
}