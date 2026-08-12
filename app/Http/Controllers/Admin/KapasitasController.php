<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeKkn;
use App\Models\ProyekKkn;
use Illuminate\Http\Request;

class KapasitasController extends Controller
{
    public function index(PeriodeKkn $periode)
    {
        $menungguRilis = $periode->proyekKkn()
            ->where('status', 'menunggu_rilis')
            ->with('mahasiswa', 'dosen')
            ->get();

        $sudahDirilis = $periode->proyekKkn()
            ->whereIn('status', ['tersedia', 'penuh'])
            ->with('mahasiswa', 'dosen')
            ->get();

        $jumlahMahasiswa = $periode->mahasiswaList()->count();

        return view('admin.periode.kapasitas', compact('periode', 'menungguRilis', 'sudahDirilis', 'jumlahMahasiswa'));
    }

    public function updateKuota(Request $request, PeriodeKkn $periode, ProyekKkn $proyek)
    {
        if ($proyek->periode_id !== $periode->id) {
            abort(404);
        }

        $validated = $request->validate([
            'kuota_tim' => 'required|integer|min:' . $proyek->jumlah_anggota,
        ]);

        $proyek->update($validated);

        return redirect()->route('admin.periode.kapasitas.index', $periode)
            ->with('success', 'Kuota tim berhasil diperbarui.');
    }

    public function rilis(PeriodeKkn $periode, ProyekKkn $proyek)
    {
        if ($proyek->periode_id !== $periode->id) {
            abort(404);
        }

        if ($proyek->status !== 'menunggu_rilis') {
            return redirect()->route('admin.periode.kapasitas.index', $periode)
                ->with('error', 'Proyek ini tidak dalam status menunggu rilis.');
        }

        $statusBaru = $proyek->jumlah_anggota >= $proyek->kuota_tim ? 'penuh' : 'tersedia';
        $proyek->update(['status' => $statusBaru]);

        return redirect()->route('admin.periode.kapasitas.index', $periode)
            ->with('success', "Proyek \"{$proyek->judul}\" berhasil dirilis ke War.");
    }
}