{{-- resources/views/products.blade.php --}}
@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <h1>Daftar Kategori Produk</h1>
    <ul>
        <li><a href="{{ url('/category/food-beverage') }}">Food & Beverage</a></li>
        <li><a href="{{ url('/category/beauty-health') }}">Beauty & Health</a></li>
        <li><a href="{{ url('/category/home-care') }}">Home Care</a></li>
        <li><a href="{{ url('/category/baby-kid') }}">Baby & Kid</a></li>
    </ul>
@endsection
