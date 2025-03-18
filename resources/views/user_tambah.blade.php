{{-- resources/views/user_tambah.blade.php --}}
@extends('layouts.app')
@section('title', 'User Tambah')
@section('content')

    <h2>Form Tambah Data User</h2>

    <div class="card">
        <div class="card-body">
                <form method="post" action="/tambah_simpan">

                @csrf

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Level ID</label>
                    <input type="number" name="level_id" class="form-control" placeholder="Masukkan ID Level" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>

@endsection
