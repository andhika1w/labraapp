@extends('layouts.app')

@section('title', 'Statistik')
@section('heading', 'Statistik & Analisis Sarpras')
@section('subtitle', 'Ikhtisar data kerusakan fasilitas kampus untuk perencanaan perawatan berkala.')

@section('content')
<section aria-label="Ringkasan metrik sarpras" class="ledger">
    <div class="ledger-cell">
        <p class="ledger-label">Total Pengaduan</p>
        <p class="ledger-value">{{ $total }}</p>
        <p class="ledger-note">seluruh waktu</p>
    </div>
    <div class="ledger-cell" style="--dot: var(--color-st-done)">
        <p class="ledger-label">Tingkat Penyelesaian</p>
        <p class="ledger-value">{{ $rate }}%</p>
        <p class="ledger-note">{{ $selesai }} terselesaikan</p>
    </div>
    <div class="ledger-cell" style="--dot: var(--color-st-process)">
        <p class="ledger-label">Sedang Berjalan</p>
        <p class="ledger-value">{{ $menunggu + $diverifikasi + $diproses }}</p>
        <p class="ledger-note">dalam antrean penanganan</p>
    </div>
    <div class="ledger-cell" style="--dot: var(--color-st-reject)">
        <p class="ledger-label">Ditolak</p>
        <p class="ledger-value">{{ $ditolak }}</p>
        <p class="ledger-note">tidak valid / duplikat</p>
    </div>
</section>

<div class="mt-6 grid gap-6 sm:mt-8 lg:grid-cols-2">
    {{-- Distribusi status laporan --}}
    <section class="panel" aria-labelledby="status-dist">
        <div class="panel-head">
            <h2 id="status-dist" class="panel-title">Distribusi Status Pengaduan</h2>
        </div>
        <div class="panel-body space-y-4">
            @php
                $statusItems = [
                    ['label' => 'Menunggu', 'count' => $menunggu, 'bg' => 'bg-amber-500', 'badge' => 'Menunggu'],
                    ['label' => 'Diverifikasi', 'count' => $diverifikasi, 'bg' => 'bg-sky-600', 'badge' => 'Diverifikasi'],
                    ['label' => 'Diproses', 'count' => $diproses, 'bg' => 'bg-purple-600', 'badge' => 'Diproses'],
                    ['label' => 'Selesai', 'count' => $selesai, 'bg' => 'bg-emerald-600', 'badge' => 'Selesai'],
                    ['label' => 'Ditolak', 'count' => $ditolak, 'bg' => 'bg-rose-600', 'badge' => 'Ditolak'],
                ];
            @endphp

            @foreach ($statusItems as $item)
                @php($pct = $total > 0 ? round(($item['count'] / $total) * 100, 1) : 0)
                <div class="space-y-1.5">
                    <div class="flex flex-wrap items-center justify-between gap-2 text-sm">
                        <span class="flex items-center gap-2">
                            <x-badge :status="$item['badge']" />
                        </span>
                        <span class="num text-xs text-ink-2">
                            <span class="font-medium text-ink">{{ $item['count'] }}</span> laporan ({{ $pct }}%)
                        </span>
                    </div>
                    <div class="h-2 w-full overflow-hidden rounded-full bg-sunken border border-line">
                        <div class="h-full {{ $item['bg'] }} transition-all duration-500" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- 5 Lokasi paling sering dilaporkan --}}
    <section class="panel" aria-labelledby="top-loc">
        <div class="panel-head">
            <h2 id="top-loc" class="panel-title">5 Lokasi Paling Sering Dilaporkan</h2>
        </div>
        <div class="panel-body">
            @if ($topLocations->isEmpty())
                <p class="text-sm text-ink-3">Belum ada data lokasi pengaduan.</p>
            @else
                <ol class="space-y-3">
                    @foreach ($topLocations as $loc)
                        <li class="flex flex-wrap items-center justify-between gap-2 rounded-md border border-line bg-sunken p-3">
                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                <span class="num flex h-6 w-6 flex-none items-center justify-center rounded-full bg-paper text-xs font-semibold text-ink-2 border border-line">
                                    {{ $loop->iteration }}
                                </span>
                                <span class="truncate text-sm font-medium text-ink">{{ $loc->location }}</span>
                            </div>
                            <span class="num whitespace-nowrap text-xs font-semibold text-tag">
                                {{ $loc->count }} laporan
                            </span>
                        </li>
                    @endforeach
                </ol>
            @endif
        </div>
    </section>
</div>

{{-- Breakdown per kategori fasilitas --}}
<section class="panel mt-6 sm:mt-8" aria-labelledby="kat-dist">
    <div class="panel-head">
        <h2 id="kat-dist" class="panel-title">Pengaduan Berdasarkan Kategori Fasilitas</h2>
        <span class="num text-xs text-ink-3">{{ $categories->count() }} kategori terdaftar</span>
    </div>
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Kategori</th>
                    <th scope="col">Status Kategori</th>
                    <th scope="col">Jumlah Laporan</th>
                    <th scope="col">Proporsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $cat)
                    @php($catPct = $total > 0 ? round(($cat->reports_count / $total) * 100, 1) : 0)
                    <tr>
                        <td data-label="Kategori" class="cell-strong sm:whitespace-nowrap">{{ $cat->name }}</td>
                        <td data-label="Status"><x-badge :status="$cat->is_active ? 'Aktif' : 'Nonaktif'" /></td>
                        <td data-label="Jumlah" class="num sm:whitespace-nowrap font-medium text-ink">{{ $cat->reports_count }} aduan</td>
                        <td data-label="Proporsi" class="sm:min-w-44">
                            <div class="flex items-center justify-end gap-3 sm:justify-start">
                                <div class="h-2 w-24 sm:w-full sm:max-w-32 overflow-hidden rounded-full bg-sunken border border-line">
                                    <div class="h-full bg-sign transition-all duration-500" style="width: {{ $catPct }}%"></div>
                                </div>
                                <span class="num text-xs text-ink-3">{{ $catPct }}%</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-sm text-ink-3">Belum ada kategori fasilitas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
