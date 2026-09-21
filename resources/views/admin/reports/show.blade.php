@extends('layouts.app')

@section('title', 'Detail Pengaduan: ' . $report->report_code)

@section('content')
<div class="mb-6">
    <a href="/admin/pengaduan" class="text-sm font-semibold leading-6 text-gray-900">&larr; Kembali ke Daftar Pengaduan</a>
</div>

@if(session('success'))
    <div class="mb-4 rounded-md bg-green-50 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <!-- Check icon -->
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mb-4 rounded-md bg-red-50 p-4">
        <div class="flex">
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2 space-y-6">
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl p-4 sm:p-6">
            <h2 class="text-base font-semibold leading-7 text-gray-900 mb-4">Informasi Pengaduan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Judul</span>
                    <span class="block text-sm text-gray-900 mt-1">{{ $report->title }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Kategori</span>
                    <span class="block text-sm text-gray-900 mt-1">{{ $report->category->name }}</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Lokasi</span>
                    <span class="block text-sm text-gray-900 mt-1">{{ $report->location }}</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Deskripsi</span>
                    <span class="block text-sm text-gray-900 mt-1">{{ $report->description }}</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-sm font-medium text-gray-500 mb-2">Foto Bukti</span>
                    <ul role="list" class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                        @foreach($report->images as $image)
                        <li class="relative">
                            <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank" class="group block w-full overflow-hidden rounded-md bg-gray-100 ring-1 ring-gray-200">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Foto Bukti" class="w-full aspect-[4/3] object-cover group-hover:opacity-75">
                            </a>
                        </li>
                        @endforeach
                        @if($report->images->isEmpty())
                            <p class="text-sm text-gray-500 col-span-full">Tidak ada foto bukti.</p>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Riwayat Update -->
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl p-4 sm:p-6">
            <h2 class="text-base font-semibold leading-7 text-gray-900 mb-4">Riwayat Proses</h2>
            <ul role="list" class="space-y-4">
                @forelse($report->updates as $update)
                <li class="relative flex gap-x-4">
                    <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-4">
                        <div class="w-px bg-gray-200"></div>
                    </div>
                    <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                        <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
                    </div>
                    <div class="flex-auto py-0.5 text-sm leading-5">
                        <div class="flex justify-between gap-x-4">
                            <div class="py-0.5 text-xs leading-5 text-gray-500">
                                <span class="font-medium text-gray-900">{{ $update->admin->name ?? 'Admin' }}</span> mengubah status menjadi
                                <span class="font-medium text-gray-900">{{ $update->status }}</span>
                            </div>
                            <time datetime="{{ $update->created_at }}" class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ $update->created_at->format('d M Y H:i') }}</time>
                        </div>
                        @if($update->note)
                        <p class="text-sm leading-6 text-gray-500 mt-1 bg-gray-50 p-2 rounded-md">{{ $update->note }}</p>
                        @endif
                    </div>
                </li>
                @empty
                <p class="text-sm text-gray-500">Belum ada riwayat proses.</p>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Profil Pelapor -->
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl p-4 sm:p-6">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Pelapor</h2>
            <div class="mt-4 flex items-center gap-x-4">
                <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-medium leading-6 text-gray-900">{{ $report->user->name ?? 'Unknown' }}</h3>
                    <p class="text-xs text-gray-500">{{ $report->user->nim ?? '-' }}</p>
                    <p class="text-xs text-gray-500">{{ $report->user->email ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Form Update Status -->
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl p-4 sm:p-6">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Proses Pengaduan</h2>
            <div class="mt-2 mb-4 flex items-center gap-2">
                <span class="text-sm text-gray-500">Status Saat Ini:</span>
                <x-badge :status="$report->status" />
            </div>

            @php
                $nextStatuses = $report->getValidNextStatuses();
            @endphp

            @if(count($nextStatuses) > 0)
            <form action="/admin/pengaduan/detail/{{ $report->id }}/status" method="POST">
                @csrf
                <div>
                    <label for="status" class="block text-sm font-medium leading-6 text-gray-900">Ubah Status</label>
                    <select id="status" name="status" required class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                        <option value="">-- Pilih Status --</option>
                        @foreach($nextStatuses as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label for="note" class="block text-sm font-medium leading-6 text-gray-900">Catatan (Opsional)</label>
                    <textarea id="note" name="note" rows="3" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 px-3"></textarea>
                </div>

                <button type="submit" class="mt-4 w-full rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Simpan Perubahan</button>
            </form>
            @else
            <div class="rounded-md bg-blue-50 p-4 mt-4">
                <p class="text-sm text-blue-700">Pengaduan telah selesai diproses ({{ $report->status }}).</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
