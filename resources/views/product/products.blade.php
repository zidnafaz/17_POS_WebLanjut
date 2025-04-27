{{-- resources/views/products.blade.php --}}
@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <h1>Daftar Kategori Produk</h1>
    <div class="category-buttons">
        @foreach ($categories as $category)
            <a href="{{ url('products/' . $category->kategori_kode) }}" class="btn btn-primary m-1">
                {{ $category->kategori_nama }}
            </a>
        @endforeach
    </div>

    <style>
        .category-buttons {
            margin-bottom: 20px;
        }
        .category-buttons .btn {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
@endsection
