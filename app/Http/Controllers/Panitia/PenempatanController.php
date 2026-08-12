<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\ProyekKkn;
use App\Models\User;
use Illuminate\Http\Request;

class PenempatanController extends Controller
{
    public function index()
    {
        $proyekBelumAdaDosen = ProyekKkn::whereIn('status', ['menunggu_rilis', 'tersedia', 'penuh'])
            ->whereNull('dosen_id')
            ->with('mahasiswa')
            ->latest()
            ->get();

        $proyekSudahAdaDosen = ProyekKkn::whereIn('status', ['menunggu_rilis', 'tersedia', 'penuh'])
            ->whereNotNull('dosen_id')
            ->with('mahasiswa', 'dosen')
            ->latest()
            ->get();

        $dosenList = User::role('dosen_pembimbing')->get();

        return view('panitia.penempatan.index', compact('proyekBelumAdaDosen', 'proyekSudahAdaDosen', 'dosenList'));
    }

    public function assign(Request $request, ProyekKkn $proyek)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:users,id',
        ]);

        $proyek->update(['dosen_id' => $validated['dosen_id']]);

        return redirect()->route('panitia.penempatan.index')
            ->with('success', 'Dosen pembimbing berhasil ditetapkan untuk proyek "' . $proyek->judul . '".');
    }

    public function reassign(Request $request, ProyekKkn $proyek)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:users,id',
        ]);

        $proyek->update(['dosen_id' => $validated['dosen_id']]);

        return redirect()->route('panitia.penempatan.index')
            ->with('success', 'Dosen pembimbing berhasil diperbarui.');
    }
}