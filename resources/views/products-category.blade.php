{{-- resources/views/products-category.blade.php --}}

@extends('layouts.app')

@section('title', 'Products - ' . ucfirst(str_replace('-', ' ', $category)))

@section('content')
    <h1>Produk dalam Kategori: {{ ucfirst(str_replace('-', ' ', $category)) }}</h1>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>

    <ul>
        @if ($category == 'food-beverage')
            <li>Minuman Segar</li>
            <li>Snack</li>
        @elseif ($category == 'beauty-health')
            <li>Skincare</li>
            <li>Vitamin</li>
        @elseif ($category == 'home-care')
            <li>Sabun Cuci</li>
            <li>Pengharum Ruangan</li>
        @elseif ($category == 'baby-kid')
            <li>Susu Bayi</li>
            <li>Mainan Anak</li>
        @else
            <li>Kategori tidak ditemukan.</li>
        @endif
    </ul>
@endsection
