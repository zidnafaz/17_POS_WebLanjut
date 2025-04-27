@extends('layouts.app')

@section('title', 'Jumlah Pengguna Level 2')

@section('content')
    <h2>Jumlah Pengguna Berdasarkan Level</h2>

    <a href="{{ url('user') }}" class="btn btn-secondary mb-3">Kembali</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Id Level Pengguna</th>
                    <th>Jumlah Pengguna</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $levelId }}</td>
                    <td>{{ $userCount }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
