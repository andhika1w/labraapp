@extends('layouts.app')

@section('title', 'Riwayat Pengaduan')
@section('subtitle', 'Semua pengaduan fasilitas yang sudah Anda kirim, dari yang terbaru.')

@section('actions')
    <a href="/pengaduan/buat" class="btn btn-tag">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
        Buat Pengaduan
    </a>
@endsection

@section('content')
<div class="panel">
    @forelse ($reports ?? [] as $report)
        <a href="/pengaduan/detail/{{ $report->id }}" class="ticket-row">
            <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                    <span class="code">{{ $report->report_code }}</span>
                    <time datetime="{{ $report->created_at->toIso8601String() }}" class="num text-xs text-ink-3">{{ $report->created_at->format('d/m/Y H:i') }}</time>
                </div>
                <p class="mt-2 truncate font-medium text-ink">{{ $report->title }}</p>
                <p class="cell-sub truncate">{{ $report->location }}</p>
            </div>
            <div class="ticket-meta">
                <x-badge :status="$report->status" />
                <x-status-track :status="$report->status" />
            </div>
        </a>
    @empty
        <div class="empty">
            <p class="empty-title">Anda belum pernah membuat pengaduan</p>
            <p class="empty-text">Setiap laporan yang Anda kirim akan tercatat di sini lengkap dengan tahap penanganannya.</p>
            <a href="/pengaduan/buat" class="btn btn-ghost mt-5">Buat pengaduan</a>
        </div>
    @endforelse
</div>

@if ($reports instanceof \Illuminate\Contracts\Pagination\Paginator)
    <div class="mt-6">{{ $reports->links() }}</div>
@endif
@endsection
