@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')
@section('back', route('admin.mahasiswa.index'))
@section('back_label', 'Data mahasiswa')

@section('content')
    @include('admin.mahasiswa.form', [
        'action' => route('admin.mahasiswa.store'),
        'user' => null,
        'submit' => 'Buat akun',
    ])
@endsection
