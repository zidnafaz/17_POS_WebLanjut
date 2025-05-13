@extends('layouts.app')

@section('title', 'Kategori')
@section('subtitle', 'Kategori')

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
                <li class="breadcrumb-item active">Kategori</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Manajemen Kategori</h2>
        <div>
            <a class="btn btn-primary me-2" href="{{ route('kategori.export_pdf') }}">
                <i class="fas fa-file-excel"></i> Export Kategori - PDF
            </a>
            <a class="btn btn-primary me-2" href="{{ route('kategori.export_excel') }}">
                <i class="fas fa-file-excel"></i> Export Kategori - Excel
            </a>
            <button class="btn btn-primary me-2" onclick="modalAction('{{ route('kategori.import') }}')">
                <i class="fas fa-file-import"></i> Import Kategori
            </button>
            <button onclick="modalAction('{{ route('kategori.create_ajax') }}')" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Kategori
            </button>
        </div>
    </div>

    {{-- Main Card --}}
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
            $.get(url)
                .done(function(response) {
                    $('#myModal').html(response);
                    var modal = new bootstrap.Modal(document.getElementById('myModal'));
                    modal.show();

                    // Reset all event listeners
                    $(document).off('submit', '#formCreateKategori, #formEditKategori, #form-import');

                    // Handle create/edit form submit
                    $(document).on('submit', '#formCreateKategori, #formEditKategori', function(e) {
                        e.preventDefault();
                        var form = $(this);

                        $.ajax({
                            url: form.attr('action'),
                            method: form.find('input[name="_method"]').val() || form.attr('method'),
                            data: form.serialize(),
                            success: function(res) {
                                var modalEl = document.getElementById('myModal');
                                var modal = bootstrap.Modal.getInstance(modalEl);
                                modal.hide();
                                window.LaravelDataTables["kategori-table"].ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: 'Kategori berhasil disimpan.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal menyimpan data.', 'error');
                            }
                        });
                    });

                    // Handle import form submit
                    $(document).on('submit', '#form-import', function(e) {
                        e.preventDefault();
                        var form = $(this);
                        var formData = new FormData(form[0]);
                        var submitBtn = form.find('button[type="submit"]');

                        submitBtn.prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin me-1"></i> Memproses...');

                        $.ajax({
                            url: form.attr('action'),
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                var modalEl = document.getElementById('myModal');
                                var modal = bootstrap.Modal.getInstance(modalEl);
                                modal.hide();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.LaravelDataTables["kategori-table"].ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                var modalEl = document.getElementById('myModal');
                                var modal = bootstrap.Modal.getInstance(modalEl);
                                if (modal) {
                                    var activeElement = document.activeElement;
                                    modal.hide();
                                    if (activeElement && activeElement.blur) {
                                        activeElement.blur();
                                    }
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'Gagal mengimport data'
                                });
                            },
                            complete: function() {
                                submitBtn.prop('disabled', false).html(
                                    '<i class="fas fa-upload me-1"></i> Upload');
                            }
                        });
                    });
                })
                .fail(function(xhr) {
                    Swal.fire('Error!', 'Gagal memuat form: ' + xhr.statusText, 'error');
                });
        }

        $(document).ready(function() {
            // Add margin to DataTable buttons
            $('.dt-buttons').addClass('mb-3');

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Additional initialization if needed
        });
    </script>
@endpush
