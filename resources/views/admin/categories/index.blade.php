@extends('layouts.app')

@section('title', 'Kategori')
@section('heading', 'Kategori pengaduan')
@section('subtitle', 'Kategori yang aktif muncul sebagai pilihan saat mahasiswa membuat laporan.')

@section('actions')
    <a href="/admin/kategori/tambah" class="btn btn-primary">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
        Tambah Kategori
    </a>
@endsection

@section('content')
<div class="panel overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Status</th>
                    <th scope="col"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="cell-strong whitespace-nowrap">{{ $category->name }}</td>
                        <td class="min-w-48">{{ $category->description ?: '—' }}</td>
                        <td><x-badge :status="$category->is_active ? 'Aktif' : 'Nonaktif'" /></td>
                        <td class="whitespace-nowrap text-right">
                            <div class="inline-flex items-center gap-4">
                                <a href="/admin/kategori/edit/{{ $category->id }}" class="link-action">Edit<span class="sr-only"> {{ $category->name }}</span></a>
                                <form action="/admin/kategori/hapus/{{ $category->id }}" method="POST" onsubmit="return confirm('Hapus kategori &quot;{{ $category->name }}&quot;?');">
                                    @csrf
                                    <button type="submit" class="link-action link-danger">Hapus<span class="sr-only"> {{ $category->name }}</span></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty">
                                <p class="empty-title">Belum ada kategori</p>
                                <p class="empty-text">Tambahkan kategori seperti Ruang Kelas, Toilet, atau Internet/WiFi agar laporan mudah dikelompokkan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
