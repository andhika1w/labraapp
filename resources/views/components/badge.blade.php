@props(['status'])

@php
    $tone = match ($status) {
        'Menunggu' => 'wait',
        'Diverifikasi' => 'verify',
        'Diproses' => 'process',
        'Selesai', 'Aktif' => 'done',
        'Ditolak' => 'reject',
        default => 'muted',
    };
@endphp

<span {{ $attributes->class(['badge', "badge-{$tone}"]) }}>{{ $status }}</span>
