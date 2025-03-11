{{-- resources/views/user.blade.php --}}
@extends('layouts.app')
@section('title', 'User Profile')
@section('content')
    {{-- <h1>Profil Pengguna</h1>
    <p>ID: {{ $id }}</p>
    <p>Nama: {{ $name }}</p> --}}

    <h2>Data User</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Id Level Pengguna</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data->user_id }}</td>
                    <td>{{ $data->username }}</td>
                    <td>{{ $data->nama }}</td>
                    <td>{{ $data->level_id }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
