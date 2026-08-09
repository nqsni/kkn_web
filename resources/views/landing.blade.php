<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal KKN</title>
    <!-- Memanggil Tailwind CSS dan Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-emerald-50 flex items-center justify-center min-h-screen font-sans selection:bg-emerald-500 selection:text-white">

    <div class="text-center max-w-3xl px-6 py-12 bg-white rounded-3xl shadow-xl border border-gray-100">
        
        <!-- Ikon / Logo Ilustrasi -->
        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner rotate-3">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>

        <!-- Judul dan Deskripsi -->
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6 tracking-tight leading-tight">
            Sistem Informasi terpadu <br />
            <span class="text-emerald-600">Kuliah Kerja Nyata</span>
        </h1>
        
        <p class="text-lg text-gray-500 mb-10 leading-relaxed max-w-2xl mx-auto">
            Portal resmi untuk pengelolaan, pendaftaran, serta pemantauan kegiatan KKN. Silakan masuk untuk mengakses halaman Mahasiswa, Dosen, Panitia, atau Admin.
        </p>

        <!-- Tombol Aksi -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <!-- Tombol Login yang mengarah otomatis ke route auth bawaan laravel -->
            <a href="{{ route('login') }}" class="px-8 py-3.5 text-base font-semibold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                <span>Masuk ke Sistem</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

    </div>

    <!-- Hiasan Background (Opsional) -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-emerald-200/30 blur-3xl"></div>
        <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-teal-200/20 blur-3xl"></div>
    </div>

</body>
</html>