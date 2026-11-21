@extends('layouts.app')

@section('title', 'Data Mahasiswa')
@section('subtitle', 'Akun mahasiswa yang bisa masuk dan mengirim pengaduan.')

@section('actions')
    <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
        Tambah Mahasiswa
    </a>
@endsection

@section('content')
<div x-data="{ q: '' }">
    @if ($mahasiswa->isNotEmpty())
        <div class="relative mb-4 sm:max-w-sm">
            <label for="cari" class="sr-only">Cari mahasiswa</label>
            <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-3" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
            </svg>
            <input id="cari" type="search" x-model.debounce.150ms="q" class="input pl-9" placeholder="Cari nama, NIM, atau prodi">
        </div>
    @endif

    <div class="panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Mahasiswa</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Program Studi</th>
                        <th scope="col">Status</th>
                        <th scope="col"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswa as $m)
                        <tr data-search="{{ mb_strtolower($m->name . ' ' . $m->nim . ' ' . $m->program_studi) }}"
                            x-show="!q || $el.dataset.search.includes(q.toLowerCase())">
                            <td data-label="Mahasiswa" class="sm:whitespace-nowrap">
                                <div>
                                    <p class="cell-strong">{{ $m->name }}</p>
                                    <p class="cell-sub">{{ $m->email }}</p>
                                </div>
                            </td>
                            <td data-label="NIM" class="num sm:whitespace-nowrap text-[13px]">{{ $m->nim }}</td>
                            <td data-label="Program Studi" class="sm:whitespace-nowrap">{{ $m->program_studi }}</td>
                            <td data-label="Status"><x-badge :status="$m->is_active ? 'Aktif' : 'Nonaktif'" /></td>
                            <td class="cell-actions sm:whitespace-nowrap text-right">
                                <div class="inline-flex items-center gap-4">
                                    <a href="{{ route('admin.mahasiswa.edit', $m->id) }}" class="link-action">Edit<span class="sr-only"> {{ $m->name }}</span></a>
                                    <form action="{{ route('admin.mahasiswa.destroy', $m->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus akun {{ $m->name }}? Pengaduan yang terkait mungkin ikut terpengaruh.');">
                                        @csrf
                                        <button type="submit" class="link-action link-danger">Hapus<span class="sr-only"> {{ $m->name }}</span></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty">
                                    <p class="empty-title">Belum ada akun mahasiswa</p>
                                    <p class="empty-text">Buat akun agar mahasiswa bisa masuk dan melaporkan kerusakan fasilitas.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
