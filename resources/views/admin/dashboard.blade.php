@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('heading', 'Antrean pengaduan')
@section('subtitle', 'Mulai dari laporan yang menunggu verifikasi, lalu teruskan ke petugas.')

@section('content')
<section aria-label="Rekap status pengaduan" class="ledger">
    <a href="/admin/pengaduan?status=Menunggu" class="ledger-cell" style="--dot: var(--color-st-wait)">
        <p class="ledger-label">Menunggu</p>
        <p class="ledger-value">{{ $menunggu ?? 0 }}</p>
        <p class="ledger-note">perlu diverifikasi</p>
    </a>
    <a href="/admin/pengaduan?status=Diverifikasi" class="ledger-cell" style="--dot: var(--color-st-verify)">
        <p class="ledger-label">Diverifikasi</p>
        <p class="ledger-value">{{ $diverifikasi ?? 0 }}</p>
        <p class="ledger-note">siap diteruskan</p>
    </a>
    <a href="/admin/pengaduan?status=Diproses" class="ledger-cell" style="--dot: var(--color-st-process)">
        <p class="ledger-label">Diproses</p>
        <p class="ledger-value">{{ $diproses ?? 0 }}</p>
        <p class="ledger-note">sedang ditangani</p>
    </a>
    <a href="/admin/pengaduan?status=Selesai" class="ledger-cell" style="--dot: var(--color-st-done)">
        <p class="ledger-label">Selesai</p>
        <p class="ledger-value">{{ $selesai ?? 0 }}</p>
        <p class="ledger-note">sudah diperbaiki</p>
    </a>
</section>

<section class="panel mt-8" aria-labelledby="terbaru">
    <div class="panel-head">
        <h2 id="terbaru" class="panel-title">Masuk terakhir</h2>
        <a href="/admin/pengaduan" class="link-action">Semua pengaduan</a>
    </div>
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
                @forelse ($recentReports ?? [] as $report)
                    <tr>
                        <td><span class="code">{{ $report->report_code }}</span></td>
                        <td class="whitespace-nowrap">
                            <p class="cell-strong">{{ $report->user->name ?? 'Tidak diketahui' }}</p>
                            <p class="cell-sub num">{{ $report->user->nim ?? '-' }}</p>
                        </td>
                        <td class="min-w-56">
                            <p class="cell-strong">{{ $report->title }}</p>
                            <p class="cell-sub">{{ $report->category->name ?? '-' }}</p>
                        </td>
                        <td class="num whitespace-nowrap text-[13px]">{{ $report->created_at->format('d M Y') }}</td>
                        <td><x-badge :status="$report->status" /></td>
                        <td class="text-right">
                            <a href="/admin/pengaduan/detail/{{ $report->id }}" class="btn btn-ghost min-h-8 px-3 text-[13px]">Proses</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty">
                                <p class="empty-title">Belum ada pengaduan masuk</p>
                                <p class="empty-text">Laporan dari mahasiswa akan muncul di sini begitu dikirim.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
