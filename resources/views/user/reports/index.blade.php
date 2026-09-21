@extends('layouts.app')

@section('title', 'Riwayat Pengaduan')

@section('content')
<div class="sm:flex sm:items-center mb-6">
    <div class="sm:flex-auto">
        <p class="mt-2 text-sm text-gray-700">Daftar semua pengaduan fasilitas yang telah Anda kirimkan.</p>
    </div>
    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <a href="/pengaduan/buat" class="block rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Buat Pengaduan</a>
    </div>
</div>

<div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Kode</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Judul & Lokasi</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                        <span class="sr-only">Aksi</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($reports ?? [] as $report)
                <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $report->report_code }}</td>
                    <td class="px-3 py-4 text-sm text-gray-500">
                        <div class="font-medium text-gray-900">{{ $report->title }}</div>
                        <div class="text-xs">{{ $report->location }}</div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $report->created_at->format('d/m/Y H:i') }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        <x-badge :status="$report->status" />
                    </td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                        <a href="/pengaduan/detail/{{ $report->id }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-10 text-center text-gray-500 text-sm">
                        Anda belum pernah membuat pengaduan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
