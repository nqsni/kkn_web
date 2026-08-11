<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataMaster;
use Illuminate\Http\Request;

class DataMasterController extends Controller
{
    public function index()
    {
        $lokasiList = DataMaster::where('jenis', 'lokasi')->latest()->get();
        $periodeList = DataMaster::where('jenis', 'periode')->latest()->get();

        return view('admin.data-master.index', compact('lokasiList', 'periodeList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis' => 'required|in:lokasi,periode',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        DataMaster::create($validated);

        return redirect()->route('admin.data-master.index')
            ->with('success', 'Data master berhasil ditambahkan.');
    }

    public function destroy(DataMaster $dataMaster)
    {
        $dataMaster->delete();

        return redirect()->route('admin.data-master.index')
            ->with('success', 'Data master berhasil dihapus.');
    }
}