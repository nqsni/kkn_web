<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\ProposalKkn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $proyek = $user->proyek_aktif;

        if (!$proyek) {
            return redirect()->route('mahasiswa.proyek.index')
                ->with('error', 'Kamu belum memiliki proyek KKN aktif.');
        }

        $proyek->load('proposal');

        $isMember = $proyek->timKkn()->where('mahasiswa_id', $user->id)->exists();

        return view('mahasiswa.proposal.index', compact('proyek', 'isMember'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $proyek = $user->proyek_aktif;

        if (!$proyek) {
            return redirect()->route('mahasiswa.proyek.index')
                ->with('error', 'Kamu belum memiliki proyek KKN aktif.');
        }

        $isMember = $proyek->timKkn()->where('mahasiswa_id', $user->id)->exists();
        if (!$isMember) {
            abort(403, 'Kamu bukan anggota tim proyek ini.');
        }

        if (!in_array($proyek->status, ['tersedia', 'penuh'])) {
            return redirect()->route('mahasiswa.proposal.index')
                ->with('error', 'Proyek belum lolos validasi, belum bisa mengajukan proposal.');
        }

        if ($proyek->proposal) {
            return redirect()->route('mahasiswa.proposal.index')
                ->with('error', 'Proposal untuk proyek ini sudah pernah diajukan.');
        }

        $request->validate([
            'file_proposal' => 'required|file|mimes:pdf|max:5120',
        ]);

        $path = $request->file('file_proposal')->store('proposal', 'public');

        ProposalKkn::create([
            'proyek_kkn_id' => $proyek->id,
            'file_proposal' => $path,
            'status' => 'diajukan',
        ]);

        return redirect()->route('mahasiswa.proposal.index')
            ->with('success', 'Proposal berhasil diajukan, menunggu ACC dosen pembimbing.');
    }
}