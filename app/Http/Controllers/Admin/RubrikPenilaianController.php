<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RubrikPenilaian;
use Illuminate\Http\Request;

class RubrikPenilaianController extends Controller
{
    public function index()
    {
        $rubrikList = RubrikPenilaian::orderBy('komponen')->get();

        return view('admin.rubrik-penilaian.index', compact('rubrikList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'komponen' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100',
        ]);

        RubrikPenilaian::create($validated);

        return redirect()->route('admin.rubrik-penilaian.index')
            ->with('success', 'Rubrik penilaian berhasil ditambahkan.');
    }

    public function update(Request $request, RubrikPenilaian $rubrikPenilaian)
    {
        $validated = $request->validate([
            'bobot' => 'required|numeric|min:0|max:100',
        ]);

        $rubrikPenilaian->update($validated);

        return redirect()->route('admin.rubrik-penilaian.index')
            ->with('success', 'Bobot berhasil diperbarui.');
    }

    public function destroy(RubrikPenilaian $rubrikPenilaian)
    {
        $rubrikPenilaian->delete();

        return redirect()->route('admin.rubrik-penilaian.index')
            ->with('success', 'Rubrik penilaian berhasil dihapus.');
    }
}