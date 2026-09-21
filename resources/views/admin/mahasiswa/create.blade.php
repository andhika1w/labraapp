@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
            @csrf
            <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        
                        <!-- Nama Lengkap -->
                        <div class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nama Lengkap</label>
                            <div class="mt-2">
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" required>
                            </div>
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- NIM -->
                        <div class="sm:col-span-3">
                            <label for="nim" class="block text-sm font-medium leading-6 text-gray-900">NIM</label>
                            <div class="mt-2">
                                <input type="text" name="nim" id="nim" value="{{ old('nim') }}" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" required>
                            </div>
                            @error('nim') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Program Studi -->
                        <div class="sm:col-span-3">
                            <label for="program_studi" class="block text-sm font-medium leading-6 text-gray-900">Program Studi</label>
                            <div class="mt-2">
                                <input type="text" name="program_studi" id="program_studi" value="{{ old('program_studi') }}" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" required>
                            </div>
                            @error('program_studi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div class="sm:col-span-4">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email Address</label>
                            <div class="mt-2">
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" required>
                            </div>
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Phone -->
                        <div class="sm:col-span-3">
                            <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Nomor Telepon / WA</label>
                            <div class="mt-2">
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" required>
                            </div>
                            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-full border-t border-gray-900/10 pt-8 mt-4">
                            <h3 class="text-sm font-medium leading-6 text-gray-900">Pengaturan Keamanan</h3>
                            <p class="mt-1 text-sm leading-6 text-gray-500">Gunakan password yang kuat agar akun aman.</p>
                        </div>

                        <!-- Password -->
                        <div class="sm:col-span-3">
                            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                            <div class="mt-2">
                                <input type="password" name="password" id="password" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" required>
                            </div>
                            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="sm:col-span-3">
                            <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Konfirmasi Password</label>
                            <div class="mt-2">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" required>
                            </div>
                        </div>

                    </div>
                </div>
                
                <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8 bg-gray-50 rounded-b-xl">
                    <a href="{{ route('admin.mahasiswa.index') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">Batal</a>
                    <button type="submit" class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        Simpan Akun
                    </button>
                </div>
            </form>
    </div>
</div>
@endsection
