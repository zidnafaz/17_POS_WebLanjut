{{-- resources/views/user.blade.php --}}
@extends('layouts.app')
@section('title', 'User Profile')
@section('content')
    <h1>Profil Pengguna</h1>
    <p>ID: {{ $id }}</p>
    <p>Nama: {{ $name }}</p>
@endsection
