@extends('layouts.app')

@section('title', 'Jumlah Pengguna Berdasarkan Level')

@section('content')
    <h2>Jumlah Pengguna Berdasarkan Level</h2>

    <a href="{{ url('user') }}" class="btn btn-secondary mb-3">Kembali</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID Level</th>
                    <th>Nama Level</th>
                    <th>Jumlah Pengguna</th>
                </tr>
            </thead>
            <tbody>
                @foreach($userCounts as $count)
                <tr>
                    <td>{{ $count->level_id }}</td>
                    <td>{{ $count->level_nama }}</td>
                    <td>{{ $count->total }}</td>
                </tr>
                @endforeach
            </tbody>
            @if($userCounts->isNotEmpty())
            <tfoot>
                <tr class="table-info">
                    <td colspan="2"><strong>Total Semua Level</strong></td>
                    <td><strong>{{ $userCounts->sum('total') }}</strong></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
@endsection
