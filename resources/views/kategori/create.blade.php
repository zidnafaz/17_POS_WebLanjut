@extends('layouts.app')

@section('subtitle', 'Kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Create')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title mb-0">Buat Kategori Baru</h3>
            </div>

            <form method="POST" action="{{ url('/kategori') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="kodeKategori">Kode Kategori</label>
                        <input type="text" class="form-control @error('kategori_kode') is-invalid @enderror"
                            id="kodeKategori" name="kategori_kode" value="{{ old('kategori_kode') }}" placeholder="Masukkan kode kategori">
                        @error('kategori_kode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="namaKategori">Nama Kategori</label>
                        <input type="text" class="form-control @error('kategori_nama') is-invalid @enderror"
                            id="namaKategori" name="kategori_nama" value="{{ old('kategori_nama') }}" placeholder="Masukkan nama kategori">
                        @error('kategori_nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ url('/kategori') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
