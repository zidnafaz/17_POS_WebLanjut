{{-- resources/views/level.blade.php --}}
@extends('layouts.app')

@section('title', 'Level')

@section('content')
    <div class="container">
        <h2>Level Management</h2>

        @if(isset($message))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        {{-- <div class="table-responsive">
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
                            <td>{{ $d->level_id }}</td>
                            <td>{{ $d->level_kode }}</td>
                            <td>{{ $d->level_nama }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}
    </div>
@endsection
