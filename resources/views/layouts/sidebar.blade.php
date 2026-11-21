@php($isAdmin = Auth::check() && Auth::user()->isAdmin())

<div class="flex h-full w-full flex-col bg-sign text-sign-ink">
    <div class="flex h-14 shrink-0 items-center gap-3 border-b border-white/10 px-5">
        <span class="brand-mark" aria-hidden="true"></span>
        <div class="min-w-0 leading-tight">
            <span class="block text-[15px] font-semibold tracking-wide text-white">Labra</span>
            <span class="block truncate text-[11px] text-sign-muted">Pengaduan Fasilitas Kampus</span>
        </div>
        @if ($mobile)
            <button type="button" @click="sidebarOpen = false" class="-mr-2 ml-auto rounded-md p-2 text-sign-muted transition-colors duration-150 hover:bg-white/5 hover:text-white" aria-label="Tutup menu navigasi">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-6" aria-label="Navigasi utama">
        <p class="nav-label">{{ $isAdmin ? 'Admin Sarpras' : 'Mahasiswa' }}</p>
        <ul role="list" class="space-y-0.5">
            @include('layouts.sidebar-links')
        </ul>
    </nav>

    @auth
        <div class="shrink-0 border-t border-white/10 px-5 py-4">
            <p class="truncate text-sm font-medium text-white">{{ Auth::user()->name }}</p>
            <p class="num truncate text-xs text-sign-muted">{{ $isAdmin ? 'Administrator' : (Auth::user()->nim ?? Auth::user()->email) }}</p>
        </div>
    @endauth
</div>
