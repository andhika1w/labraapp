@extends('layouts.app')

@section('title', 'Pengaduan ' . $report->report_code)
@section('heading', $report->title)
@section('back', '/admin/pengaduan')
@section('back_label', 'Daftar pengaduan')

@section('eyebrow')
    <div class="flex flex-wrap items-center gap-2">
        <span class="code">{{ $report->report_code }}</span>
        <x-badge :status="$report->status" />
    </div>
@endsection

@php
    $nextStatuses = $report->getValidNextStatuses();
    $hints = [
        'Diverifikasi' => 'Laporan valid dan siap diteruskan ke petugas.',
        'Ditolak' => 'Laporan tidak valid atau duplikat. Tulis alasannya di catatan.',
        'Diproses' => 'Petugas sarpras mulai menangani kerusakan.',
        'Selesai' => 'Perbaikan tuntas, fasilitas bisa dipakai lagi.',
    ];
@endphp

@section('content')
<div class="grid items-start gap-6 lg:grid-cols-[minmax(0,1fr)_20rem]">
    <div class="space-y-6">
        <section class="panel" aria-labelledby="tahap">
            <div class="panel-head"><h2 id="tahap" class="panel-title">Tahap penanganan</h2></div>
            <div class="panel-body">
                <x-status-steps :report="$report" />
            </div>
        </section>

        <section class="panel" aria-labelledby="laporan">
            <div class="panel-head"><h2 id="laporan" class="panel-title">Isi laporan</h2></div>
            <div class="panel-body">
                <dl class="grid gap-x-6 gap-y-5 sm:grid-cols-3">
                    <div>
                        <dt class="section-label">Kategori</dt>
                        <dd class="mt-1 text-sm">{{ $report->category->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="section-label">Lokasi</dt>
                        <dd class="mt-1 text-sm">{{ $report->location }}</dd>
                    </div>
                    <div>
                        <dt class="section-label">Dikirim</dt>
                        <dd class="num mt-1 text-[13px]">{{ $report->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                    <div class="sm:col-span-3">
                        <dt class="section-label">Deskripsi</dt>
                        <dd class="mt-1.5 max-w-prose whitespace-pre-line text-[15px] leading-relaxed text-ink-2">{{ $report->description }}</dd>
                    </div>
                </dl>

                <h3 class="section-label mt-8">Foto bukti</h3>
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

        <section class="panel" aria-labelledby="riwayat">
            <div class="panel-head"><h2 id="riwayat" class="panel-title">Riwayat proses</h2></div>
            <div class="panel-body">
                <ol class="timeline">
                    @foreach ($report->updates->sortByDesc('created_at') as $update)
                        <li>
                            <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1">
                                <p class="text-sm text-ink-2">
                                    <span class="font-medium text-ink">{{ $update->admin->name ?? 'Admin' }}</span>
                                    mengubah status ke <x-badge :status="$update->status" class="ml-0.5" />
                                </p>
                                <time datetime="{{ $update->created_at->toIso8601String() }}" class="num text-xs text-ink-3">{{ $update->created_at->format('d M Y, H:i') }}</time>
                            </div>
                            @if ($update->note)
                                <p class="mt-2 rounded-md border border-line bg-sunken px-3 py-2 text-sm text-ink-2">{{ $update->note }}</p>
                            @endif
                        </li>
                    @endforeach
                    <li>
                        <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1">
                            <p class="text-sm text-ink-2"><span class="font-medium text-ink">{{ $report->user->name ?? 'Mahasiswa' }}</span> mengirim laporan</p>
                            <time datetime="{{ $report->created_at->toIso8601String() }}" class="num text-xs text-ink-3">{{ $report->created_at->format('d M Y, H:i') }}</time>
                        </div>
                    </li>
                </ol>
            </div>
        </section>
    </div>

    <aside class="space-y-6 lg:sticky lg:top-20">
        <section class="panel" aria-labelledby="proses">
            <div class="panel-head"><h2 id="proses" class="panel-title">Tindak lanjut</h2></div>

            @if (count($nextStatuses) > 0)
                <form action="/admin/pengaduan/detail/{{ $report->id }}/status" method="POST" x-data="{ busy: false }" @submit="busy = true">
                    @csrf
                    <div class="panel-body space-y-5">
                        <fieldset>
                            <legend class="label">Ubah status ke</legend>
                            <div class="mt-1 space-y-2">
                                @foreach ($nextStatuses as $status)
                                    <label class="choice">
                                        <input type="radio" name="status" value="{{ $status }}" required @checked($loop->first && count($nextStatuses) === 1)>
                                        <span>
                                            <x-badge :status="$status" />
                                            <span class="mt-1.5 block text-[13px] leading-snug text-ink-3">{{ $hints[$status] ?? '' }}</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            @error('status') <p class="field-error">{{ $message }}</p> @enderror
                        </fieldset>

                        <div>
                            <label for="note" class="label">Catatan <span class="label-opt">(opsional)</span></label>
                            <textarea id="note" name="note" rows="3" class="input" placeholder="Terlihat oleh mahasiswa pelapor">{{ old('note') }}</textarea>
                        </div>
                    </div>
                    <div class="panel-foot">
                        <button type="submit" class="btn btn-primary w-full" :disabled="busy">
                            <span x-cloak x-show="busy" class="spinner" aria-hidden="true"></span>
                            <span x-text="busy ? 'Menyimpan…' : 'Simpan status'">Simpan status</span>
                        </button>
                    </div>
                </form>
            @else
                <div class="panel-body">
                    <p class="text-sm text-ink-2">Pengaduan ini sudah <strong class="font-semibold">{{ strtolower($report->status) }}</strong>. Tidak ada tindak lanjut lagi.</p>
                </div>
            @endif
        </section>

        <section class="panel" aria-labelledby="pelapor">
            <div class="panel-head"><h2 id="pelapor" class="panel-title">Pelapor</h2></div>
            <div class="panel-body flex items-start gap-3">
                <span class="avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($report->user->name ?? '?', 0, 1)) }}</span>
                <div class="min-w-0 text-sm">
                    <p class="font-medium">{{ $report->user->name ?? 'Tidak diketahui' }}</p>
                    <p class="num mt-0.5 text-xs text-ink-3">{{ $report->user->nim ?? '-' }}</p>
                    @if ($report->user?->email)
                        <a href="mailto:{{ $report->user->email }}" class="link-action mt-2 inline-block break-all">{{ $report->user->email }}</a>
                    @endif
                </div>
            </div>
        </section>
    </aside>
</div>
@endsection
