@extends('layouts.app')

@section('title', 'Detail Pengaduan ' . $report->report_code)
@section('heading', $report->title)
@section('back', '/pengaduan/riwayat')
@section('back_label', 'Riwayat pengaduan')

@section('eyebrow')
    <div class="flex flex-wrap items-center gap-2">
        <span class="code">{{ $report->report_code }}</span>
        <x-badge :status="$report->status" />
    </div>
@endsection

@section('content')
<div class="grid items-start gap-6 lg:grid-cols-[minmax(0,1fr)_20rem]">
    <div class="space-y-6">
        {{-- Progres penanganan --}}
        <section class="panel" aria-labelledby="tahap-user">
            <div class="panel-head">
                <h2 id="tahap-user" class="panel-title">Tahap penanganan</h2>
            </div>
            <div class="panel-body">
                <x-status-steps :report="$report" />
            </div>
        </section>

        {{-- Isi rincian aduan --}}
        <section class="panel" aria-labelledby="laporan-user">
            <div class="panel-head">
                <h2 id="laporan-user" class="panel-title">Rincian laporan</h2>
            </div>
            <div class="panel-body">
                <dl class="grid gap-x-6 gap-y-5 sm:grid-cols-3">
                    <div>
                        <dt class="section-label">Kategori</dt>
                        <dd class="mt-1 text-sm font-medium text-ink">{{ $report->category->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="section-label">Lokasi</dt>
                        <dd class="mt-1 text-sm font-medium text-ink">{{ $report->location }}</dd>
                    </div>
                    <div>
                        <dt class="section-label">Waktu kirim</dt>
                        <dd class="num mt-1 text-[13px] text-ink-3">{{ $report->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                    <div class="sm:col-span-3">
                        <dt class="section-label">Deskripsi kerusakan</dt>
                        <dd class="mt-1.5 max-w-prose whitespace-pre-line text-[15px] leading-relaxed text-ink-2">{{ $report->description }}</dd>
                    </div>
                </dl>

                <h3 class="section-label mt-8">Foto bukti yang dikirim</h3>
                @if ($report->images->isEmpty())
                    <p class="mt-2 text-sm text-ink-3">Tidak ada foto bukti.</p>
                @else
                    <ul role="list" class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-3">
                        @foreach ($report->images as $image)
                            <li>
                                <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank" rel="noopener"
                                   class="group block overflow-hidden rounded-md border border-line bg-sunken">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" loading="lazy"
                                         alt="Foto bukti {{ $loop->iteration }}: {{ $report->title }}"
                                         class="aspect-[4/3] w-full object-cover transition-transform duration-300 ease-out-soft group-hover:scale-[1.03]">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </section>

        {{-- Catatan & riwayat dari petugas --}}
        <section class="panel" aria-labelledby="riwayat-user">
            <div class="panel-head">
                <h2 id="riwayat-user" class="panel-title">Catatan proses & riwayat</h2>
            </div>
            <div class="panel-body">
                <ol class="timeline">
                    @foreach ($report->updates->sortByDesc('created_at') as $update)
                        <li>
                            <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1">
                                <p class="text-sm text-ink-2">
                                    Status diubah menjadi <x-badge :status="$update->status" class="ml-0.5" />
                                    <span class="text-xs text-ink-3">oleh {{ $update->admin->name ?? 'Admin Sarpras' }}</span>
                                </p>
                                <time datetime="{{ $update->created_at->toIso8601String() }}" class="num text-xs text-ink-3">{{ $update->created_at->format('d M Y, H:i') }}</time>
                            </div>
                            @if ($update->note)
                                <div class="mt-2 rounded-md border border-line bg-sunken px-3.5 py-2.5 text-sm text-ink">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-ink-3">Pesan dari admin</p>
                                    <p class="mt-1 whitespace-pre-line">{{ $update->note }}</p>
                                </div>
                            @endif
                        </li>
                    @endforeach
                    <li>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1">
                            <p class="text-sm text-ink-2">Pengaduan Anda terdaftar dalam sistem</p>
                            <time datetime="{{ $report->created_at->toIso8601String() }}" class="num text-xs text-ink-3">{{ $report->created_at->format('d M Y, H:i') }}</time>
                        </div>
                    </li>
                </ol>
            </div>
        </section>
    </div>

    {{-- Kolom info pendukung --}}
    <aside class="space-y-6 lg:sticky lg:top-20">
        <section class="panel" aria-labelledby="status-panduan">
            <div class="panel-head"><h2 id="status-panduan" class="panel-title">Status saat ini</h2></div>
            <div class="panel-body space-y-3">
                <div class="flex items-center gap-2">
                    <x-badge :status="$report->status" />
                    <x-status-track :status="$report->status" class="ml-auto" />
                </div>
                
                <p class="text-[13px] leading-relaxed text-ink-2">
                    @if ($report->status === 'Menunggu')
                        Laporan Anda sedang berada dalam antrean peninjauan oleh tim admin sarana prasarana.
                    @elseif ($report->status === 'Diverifikasi')
                        Laporan telah dinyatakan valid dan surat tugas perbaikan sedang dijadwalkan ke teknisi sarpras.
                    @elseif ($report->status === 'Diproses')
                        Teknisi/petugas sarpras sedang menangani perbaikan fasilitas di lokasi.
                    @elseif ($report->status === 'Selesai')
                        Fasilitas sudah selesai diperbaiki dan siap digunakan kembali untuk aktivitas perkuliahan.
                    @elseif ($report->status === 'Ditolak')
                        Laporan ditolak. Silakan periksa catatan dari admin pada riwayat proses untuk alasan penolakan.
                    @endif
                </p>
            </div>
        </section>

        <section class="panel" aria-labelledby="kontak-sarpras">
            <div class="panel-head"><h2 id="kontak-sarpras" class="panel-title">Bantuan Sarpras</h2></div>
            <div class="panel-body text-xs leading-relaxed text-ink-2 space-y-2">
                <p>Butuh koordinasi darurat terkait fasilitas yang membahayakan keselamatan kampus?</p>
                <div class="rounded border border-line bg-sunken p-2.5 space-y-1">
                    <p class="font-semibold text-ink">Biro Sarana & Prasarana</p>
                    <p>Gedung Rektorat Lt. 1, Ruang 104</p>
                    <p class="num text-ink-3">Jam kerja: 08.00 - 16.00 WIB</p>
                </div>
            </div>
        </section>
    </aside>
</div>
@endsection
