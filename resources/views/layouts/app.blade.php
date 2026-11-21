<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#17332f">

    <title>@yield('title', 'Dashboard') · {{ config('app.name', 'Labra') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=ibm-plex-mono:500|ibm-plex-sans:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh bg-paper font-sans text-ink antialiased" x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">
    <a href="#konten" class="skip-link">Lewati ke konten</a>

    {{-- Laci navigasi untuk layar kecil --}}
    <div x-cloak x-show="sidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true" aria-label="Menu navigasi">
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity duration-200 ease-out"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity duration-150 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-ink/50"
             @click="sidebarOpen = false"></div>

        <div x-show="sidebarOpen"
             x-transition:enter="transition-transform duration-300 ease-out-soft"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition-transform duration-200 ease-in"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 flex w-72 max-w-[85%]">
            @include('layouts.sidebar', ['mobile' => true])
        </div>
    </div>

    {{-- Navigasi tetap untuk desktop --}}
    <aside class="hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:w-64">
        @include('layouts.sidebar', ['mobile' => false])
    </aside>

    <div class="lg:pl-64">
        <header class="sticky top-0 z-30 flex h-14 items-center gap-3 border-b border-line bg-paper px-4 sm:px-6 lg:px-10">
            <button @click="sidebarOpen = true" type="button" class="btn btn-quiet -ml-2 px-2 lg:hidden" aria-label="Buka menu navigasi">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
            <a href="{{ Auth::user()?->isAdmin() ? '/admin/dashboard' : '/dashboard' }}" class="flex items-center gap-2 font-semibold lg:hidden">
                <span class="brand-mark" aria-hidden="true"></span> Labra
            </a>

            <p class="hidden text-sm text-ink-3 lg:block">{{ now()->translatedFormat('l, d F Y') }}</p>

            <div class="relative ml-auto" x-data="{ open: false }" @keydown.escape.stop="open = false">
                <button @click="open = !open" @click.outside="open = false" type="button"
                        class="flex items-center gap-2.5 rounded-full py-1 pl-1 pr-2 transition-colors duration-150 hover:bg-ink/5"
                        :aria-expanded="open.toString()" aria-haspopup="menu">
                    <span class="avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr(Auth::user()->name ?? 'U', 0, 1)) }}</span>
                    <span class="hidden max-w-40 truncate text-sm font-medium sm:block">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                    <svg class="h-4 w-4 text-ink-3 transition-transform duration-200" :class="open && 'rotate-180'" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Menu akun</span>
                </button>

                <div x-cloak x-show="open"
                     x-transition:enter="transition duration-150 ease-out"
                     x-transition:enter-start="opacity-0 -translate-y-1 scale-[.98]"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition duration-100 ease-in"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="menu" role="menu">
                    <div class="border-b border-line px-3 pb-2.5 pt-2">
                        <p class="truncate text-sm font-medium">{{ Auth::user()->name ?? 'Pengguna' }}</p>
                        <p class="truncate text-xs text-ink-3">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                    <div class="pt-1">
                        <a href="{{ Auth::user()?->isAdmin() ? '/admin/profil' : '/profil' }}" class="menu-item" role="menuitem">Profil</a>
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="menu-item" role="menuitem">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main id="konten" class="app-main px-4 py-6 sm:px-6 sm:py-8 lg:px-10 lg:py-10">
            <div class="mx-auto max-w-6xl">
                <div class="page-head">
                    <div class="min-w-0">
                        @hasSection('back')
                            <a href="@yield('back')" class="back-link">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                                </svg>
                                @yield('back_label', 'Kembali')
                            </a>
                        @endif
                        @hasSection('eyebrow')
                            <div class="mb-2">@yield('eyebrow')</div>
                        @endif
                        <h1 class="page-title">@hasSection('heading')@yield('heading')@else@yield('title')@endif</h1>
                        @hasSection('subtitle')
                            <p class="page-sub">@yield('subtitle')</p>
                        @endif
                    </div>
                    @hasSection('actions')
                        <div class="flex flex-wrap items-center gap-2">@yield('actions')</div>
                    @endif
                </div>

                @if (session('success'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 6000)" x-show="show"
                         x-transition:leave="transition-opacity duration-300 ease-in" x-transition:leave-end="opacity-0"
                         class="flash flash-ok" role="status">
                        <svg class="mt-0.5 h-4 w-4 flex-none" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                        <p>{{ session('success') }}</p>
                        <button type="button" class="flash-close" @click="show = false" aria-label="Tutup pesan">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" class="flash flash-err" role="alert">
                        <svg class="mt-0.5 h-4 w-4 flex-none" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                        <p>{{ session('error') }}</p>
                        <button type="button" class="flash-close" @click="show = false" aria-label="Tutup pesan">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
