@props(['report'])

@php
    $rejected = $report->status === 'Ditolak';
    $steps = $rejected ? ['Menunggu', 'Ditolak'] : ['Menunggu', 'Diverifikasi', 'Diproses', 'Selesai'];
    $current = array_search($report->status, $steps, true);
    if ($report->status === 'Selesai') {
        $current = count($steps);
    }

    $dates = ['Menunggu' => $report->created_at];
    foreach ($report->updates ?? [] as $update) {
        $dates[$update->status] ??= $update->created_at;
    }
@endphp

<ol {{ $attributes->class(['steps']) }}>
    @foreach ($steps as $i => $step)
        @php($state = $i < $current ? 'done' : ($i === $current ? 'current' : 'todo'))
        <li @class(['step', "step-{$state}", 'step-reject' => $step === 'Ditolak']) @if ($state === 'current') aria-current="step" @endif>
            <span class="step-dot" aria-hidden="true">
                @if ($state === 'done')
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" /></svg>
                @elseif ($step === 'Ditolak')
                    &times;
                @else
                    {{ $i + 1 }}
                @endif
            </span>
            <span class="step-label">{{ $step }}</span>
            <span class="step-date">{{ isset($dates[$step]) ? $dates[$step]->format('d M, H:i') : '—' }}</span>
        </li>
    @endforeach
</ol>
