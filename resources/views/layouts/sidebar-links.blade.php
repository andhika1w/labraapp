@php
    $icons = [
        'home' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
        'doc' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z',
        'tag' => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3zM6 6h.008v.008H6V6z',
        'users' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
        'chart' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
        'plus' => 'M12 4.5v15m7.5-7.5h-15',
        'clock' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
    ];

    $links = [];

    if (Auth::check() && Auth::user()->isAdmin()) {
        $links = [
            ['href' => '/admin/dashboard', 'label' => 'Dashboard', 'icon' => 'home', 'active' => request()->is('admin/dashboard')],
            ['href' => '/admin/pengaduan', 'label' => 'Pengaduan', 'icon' => 'doc', 'active' => request()->is('admin/pengaduan*')],
            ['href' => '/admin/kategori', 'label' => 'Kategori', 'icon' => 'tag', 'active' => request()->is('admin/kategori*')],
            ['href' => '/admin/mahasiswa', 'label' => 'Data Mahasiswa', 'icon' => 'users', 'active' => request()->is('admin/mahasiswa*')],
            ['href' => '/admin/statistik', 'label' => 'Statistik', 'icon' => 'chart', 'active' => request()->is('admin/statistik*')],
        ];
    } elseif (Auth::check()) {
        $links = [
            ['href' => '/dashboard', 'label' => 'Dashboard', 'icon' => 'home', 'active' => request()->is('dashboard')],
            ['href' => '/pengaduan/buat', 'label' => 'Buat Pengaduan', 'icon' => 'plus', 'active' => request()->is('pengaduan/buat')],
            ['href' => '/pengaduan/riwayat', 'label' => 'Riwayat Pengaduan', 'icon' => 'clock', 'active' => request()->is('pengaduan/riwayat') || request()->is('pengaduan/detail/*')],
        ];
    }
@endphp

@foreach ($links as $link)
    <li>
        <a href="{{ $link['href'] }}" @class(['nav-link', 'is-active' => $link['active']]) @if ($link['active']) aria-current="page" @endif>
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$link['icon']] }}" />
            </svg>
            {{ $link['label'] }}
        </a>
    </li>
@endforeach
