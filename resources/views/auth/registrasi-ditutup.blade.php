<x-guest-layout>
    <div class="text-center py-8">
        <div class="w-14 h-14 rounded-full bg-role-admin-soft flex items-center justify-center mx-auto mb-4">
            <span class="text-2xl">🔒</span>
        </div>
        <h2 class="font-display text-xl font-semibold text-ink mb-2">Registrasi Ditutup</h2>
        <p class="text-sm text-ink/60 max-w-sm mx-auto mb-6">
            Akun untuk Sistem KKN hanya dibuat oleh Super Admin. Silakan hubungi Panitia KKN atau Super Admin untuk mendapatkan akun.
        </p>
        <a href="{{ route('login') }}"
           class="inline-block px-5 py-2.5 rounded-2xl bg-brand text-white text-sm font-medium hover:bg-brand/90 transition">
            Kembali ke Halaman Login
        </a>
    </div>
</x-guest-layout>