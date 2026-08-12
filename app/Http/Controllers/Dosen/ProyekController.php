<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ProyekKkn;
use App\Models\TimKkn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProyekController extends Controller
{
    // List proyek yang diajukan dosen ini sendiri
    public function index()
    {
        $dosenId = Auth::id();

        $proyekList = ProyekKkn::where('pengaju_type', 'dosen')
            ->where('dosen_id', $dosenId)
            ->with('timKkn.mahasiswa')
            ->latest()
            ->get();

        return view('dosen.proyek.index', compact('proyekList'));
    }

    public function create()
    {
        $user = Auth::user();

        $periode = $user->periodeList()->where('periode_kkn.status', 'aktif')->first();

        if (!$periode) {
            return redirect()->route('dosen.proyek.index')
                ->with('error', 'Kamu belum terdaftar di periode KKN aktif. Hubungi Super Admin.');
        }

        $mahasiswaTersedia = $periode->mahasiswaList()->get()
            ->reject(fn($m) => $m->proyek_aktif)
            ->values();

        return view('dosen.proyek.create', compact('periode', 'mahasiswaTersedia'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $periode = $user->periodeList()->where('periode_kkn.status', 'aktif')->first();

        if (!$periode) {
            return redirect()->route('dosen.proyek.index')
                ->with('error', 'Kamu belum terdaftar di periode KKN aktif.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'kuota_tim' => 'required|integer|min:1|max:10',
            'anggota' => 'nullable|array',
            'anggota.*' => 'exists:users,id',
        ]);

        $anggotaIds = $validated['anggota'] ?? [];

        if (count($anggotaIds) > $validated['kuota_tim']) {
            return back()->withErrors(['anggota' => 'Jumlah anggota yang dipilih melebihi kuota tim.'])->withInput();
        }

        $mahasiswaValid = $periode->mahasiswaList()->whereIn('users.id', $anggotaIds)->get();

        foreach ($mahasiswaValid as $m) {
            if ($m->proyek_aktif) {
                return back()->withErrors(['anggota' => $m->name . ' sudah tergabung di proyek lain.'])->withInput();
            }
        }

        DB::transaction(function () use ($validated, $user, $periode, $mahasiswaValid) {
            $proyek = ProyekKkn::create([
                'periode_id' => $periode->id,
                'pengaju_type' => 'dosen',
                'dosen_id' => $user->id,
                'mahasiswa_id' => null,
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'lokasi' => $validated['lokasi'],
                'kuota_tim' => $validated['kuota_tim'],
                'status' => 'diajukan',
            ]);

            foreach ($mahasiswaValid as $m) {
                TimKkn::create([
                    'proyek_kkn_id' => $proyek->id,
                    'mahasiswa_id' => $m->id,
                    'peran' => 'anggota',
                ]);
            }
        });

        return redirect()->route('dosen.proyek.index')
            ->with('success', 'Proyek KKN berhasil diajukan, menunggu validasi panitia.');
    }

    public function show(ProyekKkn $proyek)
    {
        if ($proyek->dosen_id !== Auth::id() || $proyek->pengaju_type !== 'dosen') {
            abort(403);
        }

        $proyek->load('timKkn.mahasiswa');

        return view('dosen.proyek.show', compact('proyek'));
    }
}