@extends('layouts.app')

@section('title', 'Edit Mahasiswa')
@section('heading', 'Edit: ' . $user->name)
@section('back', route('admin.mahasiswa.index'))
@section('back_label', 'Data mahasiswa')

@section('content')
    @include('admin.mahasiswa.form', [
        'action' => route('admin.mahasiswa.update', $user->id),
        'user' => $user,
        'submit' => 'Simpan perubahan',
    ])
@endsection
