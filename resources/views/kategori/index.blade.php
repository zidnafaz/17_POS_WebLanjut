@extends('layouts.app')

@section('subtitle', 'Kategori')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Kategori')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Manage Kategori</h2>
            {{-- <a href="{{ url('/kategori/create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kategori
            </a> --}}
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">Daftar Kategori</div>
            <div class="card-body">
                {{ $dataTable->table(['class' => 'table table-striped table-bordered']) }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
