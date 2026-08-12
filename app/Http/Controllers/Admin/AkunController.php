<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeKkn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AkunController extends Controller
{
    public function index(PeriodeKkn $periode, Request $request)
    {
        $anggota = $periode->users()->orderBy('role_saat_itu')->get();

        $hasilPencarian = null;
        if ($request->filled('q')) {
            $sudahIdList = $anggota->pluck('id');
            $hasilPencarian = User::where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->q . '%')
                      ->orWhere('email', 'like', '%' . $request->q . '%');
                })
                ->whereNotIn('id', $sudahIdList)
                ->with('roles')
                ->limit(10)
                ->get();
        }

        return view('admin.periode.akun', compact('periode', 'anggota', 'hasilPencarian'));
    }

    // Buat akun baru sekaligus attach ke periode
    public function storeNew(Request $request, PeriodeKkn $periode)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'tanggal_lahir' => 'required|date',
            'role' => 'required|in:mahasiswa,dosen_pembimbing,panitia_kkn,super_admin',
        ]);

        $password = Carbon::parse($validated['tanggal_lahir'])->format('dmY');

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'password' => Hash::make($password),
        ]);

        $user->assignRole($validated['role']);

        $periode->users()->attach($user->id, ['role_saat_itu' => $validated['role']]);

        return redirect()->route('admin.periode.akun.index', $periode)
            ->with('success', "Akun {$user->name} berhasil dibuat. Password: {$password}");
    }

    // Tambahkan akun yang sudah ada ke periode ini
    public function storeExisting(Request $request, PeriodeKkn $periode)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($validated['user_id']);

        $sudahAda = $periode->users()->where('user_id', $user->id)->exists();
        if ($sudahAda) {
            return redirect()->route('admin.periode.akun.index', $periode)
                ->with('error', 'Akun ini sudah terdaftar di periode ini.');
        }

        $periode->users()->attach($user->id, ['role_saat_itu' => $user->getRoleNames()->first()]);

        return redirect()->route('admin.periode.akun.index', $periode)
            ->with('success', "{$user->name} berhasil ditambahkan ke periode ini.");
    }

    // Keluarkan akun dari periode (tidak hapus akunnya)
    public function destroy(PeriodeKkn $periode, User $user)
    {
        $periode->users()->detach($user->id);

        return redirect()->route('admin.periode.akun.index', $periode)
            ->with('success', "{$user->name} dikeluarkan dari periode ini.");
    }
}