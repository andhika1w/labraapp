@props(['status'])

@php
    $steps = ['Menunggu', 'Diverifikasi', 'Diproses', 'Selesai'];
    $rejected = $status === 'Ditolak';
    $position = $rejected ? 1 : ((int) array_search($status, $steps, true)) + 1;
@endphp

<div {{ $attributes->class(['track', 'is-rejected' => $rejected, 'is-done' => $status === 'Selesai']) }}
     role="img" aria-label="{{ $rejected ? 'Laporan ditolak' : "Tahap {$position} dari 4: {$status}" }}">
    @foreach ($steps as $i => $step)
        <span @class(['on' => $i < $position])></span>
    @endforeach
</div>
