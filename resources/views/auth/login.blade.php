<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Automation Assessment System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased min-h-screen flex bg-white">

    <!-- Panel Kiri (Hijau) -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-emerald-400 to-emerald-600 flex-col justify-center items-center p-12 text-center relative overflow-hidden">
        <!-- Background Ornaments (Opsional/Sederhana) -->
        <div class="absolute top-10 left-10 opacity-10">
            <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 22h20L12 2z"/></svg>
        </div>

        <!-- Logo Kustom -->
        <div class="bg-emerald-800/20 p-6 rounded-3xl backdrop-blur-sm mb-8 shadow-lg border border-emerald-400/30">
            <div class="w-24 h-24 flex items-center justify-center">
                <!-- Ganti dengan tag <img> logomu yang asli jika sudah ada -->
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
        </div>

        <h1 class="text-4xl font-extrabold text-white mb-2 tracking-wide">Automation Assesment System</h1>
        <p class="text-emerald-100 font-medium tracking-widest text-sm mb-8 uppercase">Automation Engineering</p>
        
        <p class="text-emerald-50 max-w-md text-sm leading-relaxed opacity-90">
            Integrated Community Service Program Management System. Empowering the next generation of mechatronics and automation experts through academic excellence and technical innovation.
        </p>
    </div>

    <!-- Panel Kanan (Form Login) -->
    <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 md:px-24 xl:px-32 relative">
        <div class="max-w-md w-full mx-auto">
            
            <div class="mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
                <p class="text-gray-500 text-sm">Silakan masuk ke akun Akademik Anda</p>
            </div>

            <!-- Pesan Error (Jika kredensial salah) -->
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Input NIM / NIP -->
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-400 tracking-wider mb-2 uppercase">NIM / NIP</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <!-- Catatan Backend: name="email" tetap dipertahankan agar sistem Breeze bawaan tidak rusak. Di mata sistem ini tetap email, tapi di UI tertulis NIM/NIP -->
                        <input id="email" type="email" name="email" required autofocus placeholder="Masukkan nomor identitas" 
                            class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-transparent rounded-xl text-sm focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-colors">
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-gray-400 tracking-wider mb-2 uppercase">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input id="password" type="password" name="password" required placeholder="••••••••" 
                            class="block w-full pl-11 pr-11 py-3 bg-gray-50 border-transparent rounded-xl text-sm focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-colors">
                        
                        <!-- Toggle Password (UI Only - butuh JS tambahan untuk berfungsi penuh) -->
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer">
                            <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="ml-2 text-sm text-gray-600 font-medium">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm font-bold text-emerald-700 hover:text-emerald-800 transition">Lupa Kata Sandi?</a>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-[#006d5b] hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                    MASUK SEKARANG
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">Butuh bantuan akses? <a href="#" class="font-bold text-[#006d5b] hover:underline">Hubungi Admin</a></p>
            </div>
            
        </div>
        
        <!-- Footer -->
        <div class="absolute bottom-8 left-0 right-0 text-center flex justify-center gap-6 text-[10px] font-bold text-gray-400 tracking-wider uppercase">
            <span>© 2026 KKN PORTAL AE POLMAN</span>
            <a href="#" class="hover:text-gray-600">PRIVASI</a>
            <a href="#" class="hover:text-gray-600">SYARAT</a>
            <a href="#" class="hover:text-gray-600">SUPPORT</a>
        </div>
    </div>

</body>
</html>