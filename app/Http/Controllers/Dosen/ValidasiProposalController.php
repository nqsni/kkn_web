<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ProposalKkn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidasiProposalController extends Controller
{
    public function index()
    {
        $dosenId = Auth::id();

        $menunggu = ProposalKkn::whereHas('proyek', function ($q) use ($dosenId) {
                $q->where('dosen_id', $dosenId);
            })
            ->where('status', 'diajukan')
            ->with('proyek.mahasiswa')
            ->latest()
            ->get();

        $riwayat = ProposalKkn::whereHas('proyek', function ($q) use ($dosenId) {
                $q->where('dosen_id', $dosenId);
            })
            ->whereIn('status', ['acc', 'ditolak'])
            ->with('proyek.mahasiswa')
            ->latest()
            ->get();

        return view('dosen.validasi-proposal.index', compact('menunggu', 'riwayat'));
    }

    public function show(ProposalKkn $proposal)
    {
        if ($proposal->proyek->dosen_id !== Auth::id()) {
            abort(403);
        }

        $proposal->load('proyek.mahasiswa', 'proyek.timKkn.mahasiswa');

        return view('dosen.validasi-proposal.show', compact('proposal'));
    }

    public function update(Request $request, ProposalKkn $proposal)
    {
        if ($proposal->proyek->dosen_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'keputusan' => 'required|in:acc,ditolak',
            'nilai' => 'nullable|numeric|min:0|max:100|required_if:keputusan,acc',
            'catatan_dosen' => 'nullable|string|required_if:keputusan,ditolak',
        ]);

        if ($proposal->status !== 'diajukan') {
            return redirect()->route('dosen.validasi-proposal.index')
                ->with('error', 'Proposal ini sudah divalidasi sebelumnya.');
        }

        $proposal->update([
            'status' => $validated['keputusan'],
            'nilai' => $validated['nilai'] ?? null,
            'catatan_dosen' => $validated['catatan_dosen'] ?? null,
        ]);

        $pesan = $validated['keputusan'] === 'acc'
            ? 'Proposal diterima. Mahasiswa dapat mulai upload logbook.'
            : 'Proposal ditolak.';

        return redirect()->route('dosen.validasi-proposal.index')->with('success', $pesan);
    }
}