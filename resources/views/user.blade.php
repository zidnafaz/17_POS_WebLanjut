{{-- resources/views/user.blade.php --}}
@extends('layouts.app')
@section('title', 'User Profile')
@section('content')

    <h2>Data User</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Id Level Pengguna</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td>{{ $d->user_id }}</td>
                    <td>{{ $d->username }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->level_id }}</td>
                    <td>
                        <a href="/POS/public/user/ubah/{{ $d->user_id }}" class="btn btn-warning btn-sm">Ubah</a>
                        <a href="/POS/public/user/hapus/{{ $d->user_id }}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna dengan username ' + '{{ $d->username }}')">Hapus</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
