@extends('adminlte::page')

@section('subtitle', 'Kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Edit')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endpush

@section('content')
<form action="{{ route('kategori.update', ['id' => $kategori->kategori_id]) }}" method="POST">
    @csrf
    @method('PUT')

        <div class="mb-3">
            <label for="kategori_kode" class="form-label">Kode Kategori</label>
            <input type="text" name="kategori_kode" class="form-control" value="{{ old('kategori_kode', $kategori->kategori_kode) }}" required>
        </div>

        <div class="mb-3">
            <label for="kategori_nama" class="form-label">Nama Kategori</label>
            <input type="text" name="kategori_nama" class="form-control" value="{{ old('kategori_nama', $kategori->kategori_nama) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@stop
