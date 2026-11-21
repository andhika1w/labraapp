@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Halo, ' . \Illuminate\Support\Str::of(Auth::user()->name ?? 'Mahasiswa')->before(' '))
@section('subtitle', 'Ringkasan pengaduan fasilitas yang pernah Anda kirim.')

@section('actions')
    <a href="/pengaduan/buat" class="btn btn-tag">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
        Buat Pengaduan
    </a>
@endsection

@section('content')
<section aria-label="Rekap pengaduan" class="ledger">
    <div class="ledger-cell">
        <p class="ledger-label">Total</p>
        <p class="ledger-value">{{ $total ?? 0 }}</p>
        <p class="ledger-note">laporan dikirim</p>
    </div>
    <div class="ledger-cell" style="--dot: var(--color-st-wait)">
        <p class="ledger-label">Menunggu</p>
        <p class="ledger-value">{{ $menunggu ?? 0 }}</p>
        <p class="ledger-note">belum dicek admin</p>
    </div>
    <div class="ledger-cell" style="--dot: var(--color-st-process)">
        <p class="ledger-label">Diproses</p>
        <p class="ledger-value">{{ $diproses ?? 0 }}</p>
        <p class="ledger-note">sedang ditangani</p>
    </div>
    <div class="ledger-cell" style="--dot: var(--color-st-done)">
        <p class="ledger-label">Selesai</p>
        <p class="ledger-value">{{ $selesai ?? 0 }}</p>
        <p class="ledger-note">sudah diperbaiki</p>
    </div>
</section>

<section class="panel mt-8" aria-labelledby="terbaru">
    <div class="panel-head">
        <h2 id="terbaru" class="panel-title">Pengaduan terbaru</h2>
        <a href="/pengaduan/riwayat" class="link-action">Lihat semua</a>
    </div>

    @forelse ($recentReports ?? [] as $report)
        <a href="/pengaduan/detail/{{ $report->id }}" class="ticket-row">
            <div class="min-w-0">
                <span class="code">{{ $report->report_code }}</span>
                <p class="mt-2 truncate font-medium text-ink">{{ $report->title }}</p>
                <p class="cell-sub">{{ $report->category->name ?? 'Tanpa kategori' }} · {{ $report->created_at->translatedFormat('d M Y') }}</p>
            </div>
            <div class="ticket-meta">
                <x-badge :status="$report->status" />
                <x-status-track :status="$report->status" />
            </div>
        </a>
    @empty
        <div class="empty">
            <p class="empty-title">Belum ada pengaduan</p>
            <p class="empty-text">Lihat AC mati, kursi patah, atau WiFi putus di kampus? Kirim laporan beserta fotonya, lalu pantau tahapnya dari sini.</p>
            <a href="/pengaduan/buat" class="btn btn-ghost mt-5">Buat pengaduan pertama</a>
        </div>
    @endforelse
</section>
@endsection
