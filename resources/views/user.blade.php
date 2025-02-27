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
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $d->user_id }}</td>
                        <td>{{ $d->username }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->level_id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
