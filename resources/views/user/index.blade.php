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
            <div>
                <a class="btn btn-primary me-2" href="{{ route('user.export_pdf') }}">
                    <i class="fa-solid fa-file-pdf"></i> Export User - PDF
                </a>
                <a class="btn btn-primary me-2" href="{{ route('user.export_excel') }}">
                    <i class="fa-solid fa-file-excel"></i> Export User - Excel
                </a>
                <button class="btn btn-primary me-2" onclick="modalAction('{{ route('user.import') }}')">
                    <i class="fa-solid fa-file-arrow-up"></i> Import User
                </button>
                <button onclick="modalAction('{{ route('user.create_ajax') }}')" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah User
                </button>
            </div>
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

        {{-- Di bagian bawah sebelum penutup scripts --}}
        <div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Konten modal akan diisi secara dinamis -->
                </div>
            </div>
        </div>
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
                    $(document).off('submit', '#formCreateUser, #formEditUser, #form-import');

                    // Handle create/edit form submit
                    $(document).on('submit', '#formCreateUser, #formEditUser', function(e) {
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
                                window.LaravelDataTables["user-table"].ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: 'User berhasil disimpan.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', xhr.responseJSON?.message ||
                                    'Gagal menyimpan data.', 'error');
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
                                    window.LaravelDataTables["user-table"].ajax.reload();
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
                                    text: xhr.responseJSON?.message ||
                                        'Gagal mengimport data'
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

            // Reload DataTable on level filter change
            $('#level_id').change(function() {
                window.LaravelDataTables["user-table"].draw();
            });
        });
    </script>
@endpush
