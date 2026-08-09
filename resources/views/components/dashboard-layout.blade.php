@php
    $role = auth()->user()->getRoleNames()->first();

    $roleConfig = [
        'mahasiswa' => ['label' => 'Mahasiswa', 'color' => 'accent-yellow', 'soft' => 'role-mahasiswa-soft', 'text' => 'ink'],
        'dosen_pembimbing' => ['label' => 'Dosen Pembimbing', 'color' => 'role-dosen', 'soft' => 'role-dosen-soft', 'text' => 'white'],
        'panitia_kkn' => ['label' => 'Panitia KKN', 'color' => 'role-panitia', 'soft' => 'role-panitia-soft', 'text' => 'white'],
        'super_admin' => ['label' => 'Super Admin', 'color' => 'role-admin', 'soft' => 'role-admin-soft', 'text' => 'white'],
    ];

    $current = $roleConfig[$role] ?? ['label' => 'User', 'color' => 'ink', 'soft' => 'paper', 'text' => 'white'];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} — Sistem KKN</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|fredoka:500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-paper text-ink">
    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside class="w-64 shrink-0 bg-ink text-white flex flex-col relative overflow-hidden">
            {{-- aksen blob dekoratif --}}
            <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-accent-yellow/15"></div>
            <div class="absolute top-24 -left-8 w-20 h-20 rounded-full bg-accent-tomato/10"></div>
            <div class="absolute bottom-32 -right-6 w-16 h-16 rounded-full bg-lime/10"></div>

            <div class="px-6 py-6 border-b border-white/10 relative">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-2xl bg-lime flex items-center justify-center shrink-0">
                        <span class="font-display text-ink text-base font-semibold">K</span>
                    </div>
                    <div>
                        <p class="font-display text-lg font-semibold tracking-tight leading-none">Sistem KKN</p>
                        <p class="text-xs text-white/50 mt-1">Kuliah Kerja Nyata</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 relative">
                {{ $sidebar ?? '' }}
            </nav>

            <div class="px-3 py-4 border-t border-white/10 relative">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2.5 rounded-2xl text-sm text-white/70 hover:bg-white/10 hover:text-white transition">
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- TOPBAR --}}
            <header class="h-20 border-b border-border bg-white flex items-center justify-between px-8 shrink-0">
                <div>
                    <h1 class="font-display text-xl font-semibold leading-none text-ink">{{ $title ?? 'Dashboard' }}</h1>
                </div>

                <div class="flex items-center gap-3">
                    {{-- badge role bergaya pil warna --}}
                    <div class="flex items-center gap-2 pl-1.5 pr-4 py-1.5 rounded-full bg-{{ $current['soft'] }}">
                        <span class="w-7 h-7 rounded-full bg-{{ $current['color'] }} flex items-center justify-center text-xs font-display font-semibold text-{{ $current['text'] }}">
                            {{ strtoupper(substr($current['label'], 0, 1)) }}
                        </span>
                        <span class="text-xs font-semibold text-{{ $current['color'] }}">{{ $current['label'] }}</span>
                    </div>

                    <div class="text-sm text-right leading-tight">
                        <p class="font-medium text-ink">{{ auth()->user()->name }}</p>
                    </div>
                </div>
            </header>

            {{-- CONTENT --}}
            <main class="flex-1 p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>