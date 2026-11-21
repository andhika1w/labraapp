<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#17332f">

    <title>Masuk · {{ config('app.name', 'Labra') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=ibm-plex-mono:500|ibm-plex-sans:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh bg-paper font-sans text-ink antialiased">
    <div class="grid min-h-dvh lg:grid-cols-[minmax(0,1fr)_minmax(0,1.15fr)]">

        {{-- Panel informasi: seperti papan penunjuk di lobi gedung --}}
        <aside class="hidden flex-col justify-between bg-sign px-12 py-10 text-sign-ink lg:flex xl:px-16">
            <div class="flex items-center gap-3">
                <span class="brand-mark" aria-hidden="true"></span>
                <span class="text-[15px] font-semibold tracking-wide text-white">Labra</span>
            </div>

            <div class="max-w-md">
                <p class="text-sm text-sign-muted">Sistem Informasi Pengaduan Fasilitas Kampus</p>
                <h2 class="mt-3 text-[2rem] font-semibold leading-tight text-white text-balance">
                    Lapor fasilitas rusak, pantau sampai beres.
                </h2>

                <div class="ticket-sample mt-10" aria-hidden="true">
                    <div class="flex items-center justify-between gap-3">
                        <span class="code">REP-20261118-K7Q2M</span>
                        <x-badge status="Diproses" />
                    </div>
                    <p class="mt-6 font-semibold">Proyektor Ruang 203 tidak menyala</p>
                    <p class="mt-1 text-sm text-ink-3">Gedung A, Lantai 2 · Proyektor</p>
                    <x-status-track status="Diproses" class="mt-4 w-full" />
                </div>

                <dl class="mt-10 grid grid-cols-[auto_1fr] gap-x-4 gap-y-2.5 text-sm">
                    <dt class="num text-sign-muted">01</dt><dd><span class="font-medium text-white">Menunggu</span> <span class="text-sign-muted">— laporan masuk ke admin</span></dd>
                    <dt class="num text-sign-muted">02</dt><dd><span class="font-medium text-white">Diverifikasi</span> <span class="text-sign-muted">— admin memastikan laporan valid</span></dd>
                    <dt class="num text-sign-muted">03</dt><dd><span class="font-medium text-white">Diproses</span> <span class="text-sign-muted">— petugas sarpras menangani</span></dd>
                    <dt class="num text-sign-muted">04</dt><dd><span class="font-medium text-white">Selesai</span> <span class="text-sign-muted">— fasilitas bisa dipakai lagi</span></dd>
                </dl>
            </div>

            <p class="text-xs text-sign-muted">Akun mahasiswa dibuat oleh admin kampus.</p>
        </aside>

        <main class="flex items-center justify-center px-5 py-12 sm:px-8">
            <div class="w-full max-w-sm">
                <div class="mb-10 flex items-center gap-3 lg:hidden">
                    <span class="brand-mark" aria-hidden="true"></span>
                    <div class="leading-tight">
                        <span class="block text-[15px] font-semibold">Labra</span>
                        <span class="block text-xs text-ink-3">Pengaduan Fasilitas Kampus</span>
                    </div>
                </div>

                @if (session('error'))
                    <div class="flash flash-err" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
