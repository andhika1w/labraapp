@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="mb-6">
    <a href="/admin/kategori" class="text-sm font-semibold leading-6 text-gray-900">&larr; Kembali ke Daftar Kategori</a>
</div>

<div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
    <form action="/admin/kategori/tambah" method="POST" class="px-4 py-4 sm:p-6">
        @csrf
        <div class="grid grid-cols-1 gap-x-6 gap-y-5">
            
            <div>
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nama Kategori</label>
                <div class="mt-2">
                    <input type="text" name="name" id="name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 px-3">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Deskripsi (Opsional)</label>
                <div class="mt-2">
                    <textarea id="description" name="description" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 px-3"></textarea>
                </div>
            </div>

            <div class="flex items-center gap-x-3">
                <input id="is_active" name="is_active" type="checkbox" checked value="1" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600">
                <label for="is_active" class="block text-sm font-medium leading-6 text-gray-900">Aktifkan Kategori</label>
            </div>
            
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="/admin/kategori" class="text-sm font-semibold leading-6 text-gray-900">Batal</a>
            <button type="submit" class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Simpan</button>
        </div>
    </form>
</div>
@endsection
