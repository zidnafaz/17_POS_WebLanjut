{{-- resources/views/products-category.blade.php --}}

@extends('layouts.app')

@section('title', 'Products - ' . ucfirst(str_replace('-', ' ', $category)))

@section('content')
    <h1>Produk dalam Kategori: {{ ucfirst(str_replace('-', ' ', $category)) }}</h1>
    <a href="{{ url('/product') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Kategori</a>

    @if ($products->isEmpty())
        <p>Tidak ada produk dalam kategori ini.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->nama_barang ?? 'N/A' }}</td>
                        <td>{{ $product->kategori->kategori_nama ?? 'N/A' }}</td>
                        <td>{{ number_format($product->harga ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $product->stok ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        .btn-secondary {
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            color: white;
        }
    </style>
@endsection
