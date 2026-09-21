@extends('layouts.app')

@section('title', 'Buat Pengaduan Baru')

@section('content')
<div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
    <form action="/pengaduan/buat" method="POST" enctype="multipart/form-data" class="px-4 py-4 sm:p-6">
        @csrf
        <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
            
            <div class="sm:col-span-1">
                <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Judul Pengaduan</label>
                <div class="mt-2">
                    <input type="text" name="title" id="title" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 px-3">
                </div>
            </div>

            <div class="sm:col-span-1">
                <label for="category_id" class="block text-sm font-medium leading-6 text-gray-900">Kategori</label>
                <div class="mt-2">
                    <select id="category_id" name="category_id" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 px-3">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="sm:col-span-1">
                <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Lokasi</label>
                <div class="mt-2">
                    <input type="text" name="location" id="location" placeholder="Contoh: Gedung A Lantai 2 Ruang 203" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 px-3">
                </div>
            </div>

            <div class="sm:col-span-1">
                <label for="images" class="block text-sm font-medium leading-6 text-gray-900">Foto Bukti (Maks. 3 foto)</label>
                <div class="mt-2">
                    <input type="file" name="images[]" id="images" multiple accept="image/jpeg,image/png,image/jpg" required class="block w-full text-sm text-gray-900 file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Deskripsi Lengkap</label>
                <div class="mt-2">
                    <textarea id="description" name="description" rows="3" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 px-3"></textarea>
                </div>
                <p class="mt-1 text-sm leading-6 text-gray-500">Jelaskan kerusakan atau masalah yang terjadi secara detail.</p>
            </div>

        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6 border-t border-gray-900/10 pt-4">
            <button type="button" onclick="window.history.back()" class="text-sm font-semibold leading-6 text-gray-900">Batal</button>
            <button type="submit" class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Kirim Pengaduan</button>
        </div>
    </form>
</div>
@endsection
