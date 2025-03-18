@extends('adminlte::page')

@section('subtitle', 'Kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Edit')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .card {
        border-radius: 10px;
        box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.1);
    }
    .btn-primary {
        transition: 0.3s;
        font-weight: bold;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-edit"></i> Edit Kategori
                </div>
                <div class="card-body">
                    <form action="{{ route('kategori.update', ['id' => $kategori->kategori_id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="kategori_kode" class="form-label">Kode Kategori</label>
                            <input type="text" name="kategori_kode" class="form-control @error('kategori_kode') is-invalid @enderror"
                                   value="{{ old('kategori_kode', $kategori->kategori_kode) }}" required autofocus
                                   placeholder="Masukkan kode kategori">
                            @error('kategori_kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori_nama" class="form-label">Nama Kategori</label>
                            <input type="text" name="kategori_nama" class="form-control @error('kategori_nama') is-invalid @enderror"
                                   value="{{ old('kategori_nama', $kategori->kategori_nama) }}" required
                                   placeholder="Masukkan nama kategori">
                            @error('kategori_nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
