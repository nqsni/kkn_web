<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Verifikasi kredensial email/password
        $request->authenticate();

        // 2. Amankan sesi
        $request->session()->regenerate();

        // 3. Ambil data user yang baru saja berhasil login
        $user = auth()->user();

        // 4. Logika Pengalihan berdasarkan Role Spatie
        if ($user->hasRole('mahasiswa')) {
            return redirect()->route('mahasiswa.dashboard');
        } elseif ($user->hasRole('dosen_pembimbing')) {
            return redirect()->route('dosen.dashboard');
        } elseif ($user->hasRole('panitia_kkn')) {
            return redirect()->route('panitia.dashboard'); // Pastikan route ini sudah dibuat nanti
        } elseif ($user->hasRole('super_admin')) {
            return redirect()->route('admin.dashboard');   // Pastikan route ini sudah dibuat nanti
        }

        // 5. Fallback jika user tidak punya role sama sekali (keamanan ekstra)
        return redirect()->intended('/');
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
