<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\ProyekKkn;
use App\Models\TimKkn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->proyek_aktif) {
            return redirect()->route('mahasiswa.proyek.index')
                ->with('error', 'Kamu sudah tergabung dalam proyek. Tidak bisa mengikuti War.');
        }

        $periode = $user->periodeList()->where('periode_kkn.status', 'aktif')->first();

        if (!$periode) {
            return redirect()->route('mahasiswa.proyek.index')
                ->with('error', 'Kamu belum terdaftar di periode KKN aktif.');
        }

        $proyekTersedia = ProyekKkn::where('periode_id', $periode->id)
            ->where('status', 'tersedia')
            ->whereColumn('kuota_tim', '>', DB::raw('(select count(*) from tim_kkn where tim_kkn.proyek_kkn_id = proyek_kkn.id)'))
            ->with('dosen')
            ->latest()
            ->get();

        return view('mahasiswa.war.index', compact('proyekTersedia'));
    }

    public function join(ProyekKkn $proyek)
    {
        $user = Auth::user();

        if ($user->proyek_aktif) {
            return redirect()->route('mahasiswa.proyek.index')
                ->with('error', 'Kamu sudah tergabung dalam proyek lain.');
        }

        try {
            DB::transaction(function () use ($proyek, $user) {
                $proyekLocked = ProyekKkn::where('id', $proyek->id)->lockForUpdate()->first();

                if ($proyekLocked->status !== 'tersedia') {
                    throw new \Exception('Proyek ini sudah tidak tersedia.');
                }

                $jumlahAnggota = TimKkn::where('proyek_kkn_id', $proyekLocked->id)->count();

                if ($jumlahAnggota >= $proyekLocked->kuota_tim) {
                    throw new \Exception('Slot proyek ini baru saja penuh. Coba proyek lain.');
                }

                $sudahJoin = TimKkn::where('proyek_kkn_id', $proyekLocked->id)
                    ->where('mahasiswa_id', $user->id)
                    ->exists();

                if ($sudahJoin) {
                    throw new \Exception('Kamu sudah tergabung di proyek ini.');
                }

                TimKkn::create([
                    'proyek_kkn_id' => $proyekLocked->id,
                    'mahasiswa_id' => $user->id,
                    'peran' => 'anggota',
                ]);

                if ($jumlahAnggota + 1 >= $proyekLocked->kuota_tim) {
                    $proyekLocked->update(['status' => 'penuh']);
                }
            });
        } catch (\Exception $e) {
            return redirect()->route('mahasiswa.war.index')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('mahasiswa.proyek.show', $proyek)
            ->with('success', 'Berhasil bergabung ke proyek ini!');
    }
}