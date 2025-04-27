@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Manajemen Kategori</h2>
            <button onclick="modalAction('{{ route('kategori.create_ajax') }}')" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah Kategori
            </button>
        </div>
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Daftar Kategori</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{ $dataTable->table([
                        'class' => 'table table-hover table-bordered table-striped',
                        'style' => 'width:100%'
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
        });
    </script>
@endpush
