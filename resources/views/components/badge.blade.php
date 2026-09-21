@props(['status'])

@php
    $classes = match($status) {
        'Menunggu' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20',
        'Diverifikasi' => 'bg-blue-50 text-blue-700 ring-blue-700/10',
        'Diproses' => 'bg-indigo-50 text-indigo-700 ring-indigo-700/10',
        'Selesai' => 'bg-green-50 text-green-700 ring-green-600/20',
        'Ditolak' => 'bg-red-50 text-red-700 ring-red-600/10',
        default => 'bg-gray-50 text-gray-600 ring-gray-500/10',
    };
@endphp

<span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $classes }}">
    {{ $status }}
</span>
