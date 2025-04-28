@extends('layouts.app')

@section('title', 'User')
@section('subtitle', 'User')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .card-header {
            padding: 0.75rem 1.25rem;
            font-weight: 600;
        }

        .table thead th {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content_header')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active">User</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Manajemen User</h2>
            <button onclick="modalAction('{{ route('user.create_ajax') }}')" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah User
            </button>
        </div>



        {{-- Main Card --}}
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Daftar User</h3>
            </div>

            <div class="card-body">
                {{-- Filter --}}
                <div class="mb-3">
                    <label for="level_id" class="form-label">Filter Level:</label>
                    <select class="form-select" name="level_id" id="level_id" required>
                        <option value="">-- Semua Level --</option>
                        @foreach ($level_id as $item)
                            <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="table-responsive">
                    {{ $dataTable->table([
                        'id' => 'user-table',
                        'class' => 'table table-hover table-bordered table-striped',
                        'style' => 'width:100%',
                    ]) }}
                </div>
            </div>
        </div>
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script>
        function modalAction(url) {
            $.get(url, function(response) {
                $('#myModal').html(response);
                $('#myModal').modal('show');
            }).fail(function() {
                alert('Gagal memuat modal.');
            });
        }

        $(document).ready(function() {
            // Add margin to DataTable buttons
            $('.dt-buttons').addClass('mb-3');

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Reload DataTable on level filter change
            $('#level_id').change(function() {
                window.LaravelDataTables["user-table"].draw();
            });
        });
    </script>
@endpush
