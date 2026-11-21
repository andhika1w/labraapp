@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('heading', 'Edit: ' . $category->name)
@section('back', '/admin/kategori')
@section('back_label', 'Kategori')

@section('content')
    @include('admin.categories.form', [
        'action' => '/admin/kategori/edit/' . $category->id,
        'category' => $category,
        'submit' => 'Simpan perubahan',
    ])
@endsection
