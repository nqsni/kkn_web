<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\ProyekKkn;
use App\Models\TimKkn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProyekController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $timList = TimKkn::with('proyek.dosen')
            ->where('mahasiswa_id', $user->id)
            ->get();

        return view('mahasiswa.proyek.index', compact('timList'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->proyek_aktif) {
            return redirect()->route('mahasiswa.proyek.index')
                ->with('error', 'Kamu masih memiliki proyek aktif. Tidak bisa mengajukan proyek baru.');
        }

        $periode = $user->periodeList()->where('periode_kkn.status', 'aktif')->first();

        if (!$periode) {
            return redirect()->route('mahasiswa.proyek.index')
                ->with('error', 'Kamu belum terdaftar di periode KKN aktif. Hubungi Super Admin.');
        }

        // Mahasiswa lain di periode yang sama & belum punya proyek aktif
        $mahasiswaTersedia = $periode->mahasiswaList()
            ->where('users.id', '!=', $user->id)
            ->get()
            ->reject(fn($m) => $m->proyek_aktif)
            ->values();

        return view('mahasiswa.proyek.create', compact('periode', 'mahasiswaTersedia'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->proyek_aktif) {
            return redirect()->route('mahasiswa.proyek.index')
                ->with('error', 'Kamu masih memiliki proyek aktif.');
        }

        $periode = $user->periodeList()->where('periode_kkn.status', 'aktif')->first();

        if (!$periode) {
            return redirect()->route('mahasiswa.proyek.index')
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

        if (count($anggotaIds) + 1 > $validated['kuota_tim']) {
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
                'pengaju_type' => 'mahasiswa',
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

            foreach ($mahasiswaValid as $m) {
                TimKkn::create([
                    'proyek_kkn_id' => $proyek->id,
                    'mahasiswa_id' => $m->id,
                    'peran' => 'anggota',
                ]);
            }
        });

        return redirect()->route('mahasiswa.proyek.index')
            ->with('success', 'Proyek KKN berhasil diajukan, menunggu validasi panitia.');
    }

    public function show(ProyekKkn $proyek)
    {
        $user = Auth::user();

        $isMember = $proyek->timKkn()->where('mahasiswa_id', $user->id)->exists();
        if (!$isMember) {
            abort(403);
        }

        $proyek->load('timKkn.mahasiswa', 'dosen');

        return view('mahasiswa.proyek.show', compact('proyek'));
    }

    public function destroy(ProyekKkn $proyek)
    {
        $user = Auth::user();

        $tim = $proyek->timKkn()->where('mahasiswa_id', $user->id)->first();

        if (!$tim || $tim->peran !== 'pengaju') {
            abort(403, 'Hanya pengaju yang bisa membatalkan proyek ini.');
        }

        if ($proyek->status !== 'diajukan') {
            return redirect()->route('mahasiswa.proyek.index')
                ->with('error', 'Proyek yang sudah divalidasi panitia tidak bisa dibatalkan.');
        }

        $judul = $proyek->judul;
        $proyek->delete(); // tim_kkn ikut terhapus otomatis (cascade)

        return redirect()->route('mahasiswa.proyek.index')
            ->with('success', 'Proyek "' . $judul . '" berhasil dibatalkan. Kamu bisa mengajukan proyek baru sekarang.');
    }
}