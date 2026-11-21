@extends('layouts.app')

@section('title', 'Pengaduan')
@section('heading', 'Pengaduan mahasiswa')
@section('subtitle', 'Semua laporan yang masuk. Saring berdasarkan status untuk fokus pada antrean tertentu.')

@php
    $list = collect($reports instanceof \Illuminate\Contracts\Pagination\Paginator ? $reports->items() : ($reports ?? []));
    $statuses = ['Menunggu', 'Diverifikasi', 'Diproses', 'Selesai', 'Ditolak'];
    $counts = collect($statuses)->mapWithKeys(fn ($s) => [$s => $list->where('status', $s)->count()])->all();
@endphp

@section('content')
<div x-data="{
        f: new URLSearchParams(location.search).get('status') || 'Semua',
        counts: @js($counts),
     }">
    <div class="chips mb-4" role="toolbar" aria-label="Saring berdasarkan status">
        <button type="button" class="chip" :aria-pressed="(f === 'Semua').toString()" @click="f = 'Semua'">
            Semua <span class="chip-count">{{ $list->count() }}</span>
        </button>
        @foreach ($counts as $status => $n)
            <button type="button" class="chip" :aria-pressed="(f === '{{ $status }}').toString()" @click="f = '{{ $status }}'">
                {{ $status }} <span class="chip-count">{{ $n }}</span>
            </button>
        @endforeach
    </div>

    <div class="panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Kode</th>
                        <th scope="col">Pelapor</th>
                        <th scope="col">Aduan</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                        <th scope="col"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $report)
                        <tr x-show="f === 'Semua' || f === '{{ $report->status }}'">
                            <td data-label="Kode"><span class="code">{{ $report->report_code }}</span></td>
                            <td data-label="Pelapor" class="sm:whitespace-nowrap">
                                <div>
                                    <p class="cell-strong">{{ $report->user->name ?? 'Tidak diketahui' }}</p>
                                    <p class="cell-sub num">{{ $report->user->nim ?? '-' }}</p>
                                </div>
                            </td>
                            <td data-label="Aduan" class="sm:min-w-56">
                                <div>
                                    <p class="cell-strong">{{ $report->title }}</p>
                                    <p class="cell-sub">{{ $report->category->name ?? '-' }}</p>
                                </div>
                            </td>
                            <td data-label="Tanggal" class="num sm:whitespace-nowrap text-[13px]">{{ $report->created_at->format('d M Y') }}</td>
                            <td data-label="Status"><x-badge :status="$report->status" /></td>
                            <td class="cell-actions text-right">
                                <a href="/admin/pengaduan/detail/{{ $report->id }}" class="btn btn-ghost min-h-9 sm:min-h-8 px-3 text-[13px]">Buka</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty">
                                    <p class="empty-title">Belum ada pengaduan</p>
                                    <p class="empty-text">Laporan dari mahasiswa akan muncul di sini begitu dikirim.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    @if ($list->isNotEmpty())
                        <tr x-cloak x-show="f !== 'Semua' && !counts[f]">
                            <td colspan="6">
                                <div class="empty">
                                    <p class="empty-title">Tidak ada pengaduan berstatus <span x-text="f"></span></p>
                                    <button type="button" class="link-action mt-2" @click="f = 'Semua'">Tampilkan semua</button>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@if ($reports instanceof \Illuminate\Contracts\Pagination\Paginator)
    <div class="mt-6">{{ $reports->links() }}</div>
@endif
@endsection
