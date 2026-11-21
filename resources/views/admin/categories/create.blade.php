@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('back', '/admin/kategori')
@section('back_label', 'Kategori')

@section('content')
    @include('admin.categories.form', [
        'action' => '/admin/kategori/tambah',
        'category' => null,
        'submit' => 'Simpan kategori',
    ])
@endsection
