<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeKkn;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodeList = PeriodeKkn::withCount('proyekKkn')->latest()->get();

        return view('admin.periode.index', compact('periodeList'));
    }

    public function create()
    {
        return view('admin.periode.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ]);

        $validated['status'] = 'draft';

        PeriodeKkn::create($validated);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode KKN berhasil dibuat.');
    }

    public function updateStatus(Request $request, PeriodeKkn $periode)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,aktif,selesai',
        ]);

        $periode->update($validated);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Status periode berhasil diperbarui.');
    }
}