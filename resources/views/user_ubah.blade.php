@extends('layouts.app')
@section('title', 'Ubah User')
@section('content')

    <h2>Form Ubah Data User</h2>
    <a href="/user" class="btn btn-secondary mb-3">Kembali</a>

    <form method="POST" action="/POS/public/user/ubah_simpan/{{ $data->user_id }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan Username" value="{{ $data->username }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama" value="{{ $data->nama }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan Password">
        </div>

        <div class="mb-3">
            <label class="form-label">Level ID</label>
            <input type="number" name="level_id" class="form-control" placeholder="Masukkan ID Level" value="{{ $data->level_id }}">
        </div>

        <button type="submit" class="btn btn-success">Ubah</button>
    </form>

@endsection
