{{-- resources/views/level/level.blade.php --}}
@extends('layouts.app')

@section('title', 'Level')
@section('subtitle', 'Level')

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
                <li class="breadcrumb-item active">Level</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Manajemen Level</h2>
            <button onclick="modalAction('{{ url('/level/create_ajax') }}')" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah Level
            </button>
        </div>

        {{-- Main Card --}}
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Daftar Level</h3>
            </div>

            <div class="card-body">
                {{-- Alert --}}
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        @if(session('success'))
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: '{{ session('success') }}',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        @endif
                        @if(session('error'))
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: '{{ session('error') }}',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        @endif
                    });
                </script>

                {{-- Table Level --}}
                <div class="table-responsive">
                    {!! $dataTable->table([
                        'id' => 'level-table',
                        'class' => 'table table-hover table-bordered table-striped',
                        'style' => 'width:100%',
                    ]) !!}
                </div>
            </div>
        </div>

        {{-- Modal --}}
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>

    </div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
    <script>
        function modalAction(url) {
            $.get(url, function(response) {
                $('#myModal').html(response);
                $('#myModal').modal('show');

                // Rebind form submit handler for dynamically loaded create modal content
                $('#formCreateLevel').submit(function(e) {
                    e.preventDefault();
                    let form = $(this);
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        data: form.serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                window.LaravelDataTables["level-table"].ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                if (response.msgField) {
                                    if (response.msgField.level_kode) {
                                        $('#level_kode').addClass('is-invalid');
                                        $('#error_level_kode').text(response.msgField.level_kode[0]);
                                    } else {
                                        $('#level_kode').removeClass('is-invalid');
                                        $('#error_level_kode').text('');
                                    }
                                    if (response.msgField.level_nama) {
                                        $('#level_nama').addClass('is-invalid');
                                        $('#error_level_nama').text(response.msgField.level_nama[0]);
                                    } else {
                                        $('#level_nama').removeClass('is-invalid');
                                        $('#error_level_nama').text('');
                                    }
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message,
                                    });
                                }
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menyimpan data.',
                            });
                        }
                    });
                });

                // Rebind form submit handler for dynamically loaded edit modal content
                $('#formEditLevel').submit(function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = form.serializeArray();

                    // Ensure _method=PUT is included for Laravel method spoofing
                    if (!formData.some(field => field.name === '_method')) {
                        formData.push({ name: '_method', value: 'PUT' });
                    }

                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: $.param(formData),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                window.LaravelDataTables["level-table"].ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                if (response.msgField) {
                                    if (response.msgField.level_kode) {
                                        $('#level_kode').addClass('is-invalid');
                                        $('#error_level_kode').text(response.msgField.level_kode[0]);
                                    } else {
                                        $('#level_kode').removeClass('is-invalid');
                                        $('#error_level_kode').text('');
                                    }
                                    if (response.msgField.level_nama) {
                                        $('#level_nama').addClass('is-invalid');
                                        $('#error_level_nama').text(response.msgField.level_nama[0]);
                                    } else {
                                        $('#level_nama').removeClass('is-invalid');
                                        $('#error_level_nama').text('');
                                    }
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message,
                                    });
                                }
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat mengupdate data.',
                            });
                        }
                    });
                });

                // Rebind form submit handler for dynamically loaded delete modal content
                $('#formDeleteLevel').submit(function(e) {
                    e.preventDefault();
                    let form = $(this);
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                window.LaravelDataTables["level-table"].ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menghapus data.',
                            });
                        }
                    });
                });

            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal memuat modal.',
                });
            });
        }

        $(document).ready(function() {
            // Add margin to DataTable buttons
            $('.dt-buttons').addClass('mb-3');

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
