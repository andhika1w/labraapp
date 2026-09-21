@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="sm:flex sm:items-center mb-6">
    <div class="sm:flex-auto">
        <h1 class="text-base font-semibold leading-6 text-gray-900">Kategori Pengaduan</h1>
        <p class="mt-2 text-sm text-gray-700">Daftar kategori untuk klasifikasi laporan pengaduan mahasiswa.</p>
    </div>
    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <a href="/admin/kategori/tambah" class="block rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Tambah Kategori</a>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 rounded-md bg-green-50 p-4">
        <div class="flex">
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

<div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl p-4 sm:p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Nama Kategori</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Deskripsi</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                        <span class="sr-only">Aksi</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($categories as $category)
                <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $category->name }}</td>
                    <td class="px-3 py-4 text-sm text-gray-500">{{ $category->description ?? '-' }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        @if($category->is_active)
                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset bg-green-50 text-green-700 ring-green-600/20">Aktif</span>
                        @else
                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset bg-gray-50 text-gray-600 ring-gray-500/10">Nonaktif</span>
                        @endif
                    </td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                        <div class="flex items-center justify-end gap-2">
                            <a href="/admin/kategori/edit/{{ $category->id }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                            <form action="/admin/kategori/hapus/{{ $category->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-10 text-center text-gray-500 text-sm">
                        Belum ada data kategori.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
