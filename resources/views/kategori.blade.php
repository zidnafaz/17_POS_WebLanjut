{{-- resources/views/level.blade.php --}}
@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
    <div class="container">
        <h2>Kategori</h2>

        @if(isset($message))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Kode Level</th>
                        <th>Nama Level</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $d->kategori_id }}</td>
                            <td>{{ $d->kategori_kode }}</td>
                            <td>{{ $d->kategori_nama }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
