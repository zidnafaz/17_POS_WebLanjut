@extends('layouts.app')

@section('title', 'Products')
@section('subtitle', 'Products')

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
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Manajemen Produk</h2>
            <div>
                <a class="btn btn-primary me-2" href="{{ route('products.export_pdf') }}">
                    <i class="fa-solid fa-file-pdf"></i> Export Produk - PDF
                </a>
                <a class="btn btn-primary me-2" href="{{ route('products.export_excel') }}">
                    <i class="fas fa-file-excel"></i> Export Produk - Excel
                </a>
                <button class="btn btn-primary me-2" onclick="modalAction('{{ route('products.import') }}')">
                    <i class="fa-solid fa-file-arrow-up"></i> Import Produk
                </button>
                <button class="btn btn-primary" onclick="modalAction('{{ route('products.create_ajax') }}')">
                    <i class="fas fa-plus"></i> Tambah Produk
                </button>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Daftar Produk</h3>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Filter Kategori:</label>
                    <select id="kategori_id" class="form-select" aria-label="Filter Kategori">
                        <option value="">-- Semua Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->kategori_id }}">{{ $category->kategori_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="table-responsive">
                    {{ $dataTable->table([
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

                    // Reset semua event listener
                    $(document).off('submit', '#formCreateProduct, #formEditProduct, #form-import');

                    // Handle form submit biasa (create/edit)
                    $(document).on('submit', '#formCreateProduct, #formEditProduct', function(e) {
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
                                window.LaravelDataTables["product-table"].ajax.reload();
                                if (res.alert && res.message) {
                                    Swal.fire({
                                        icon: res.alert,
                                        title: res.alert === 'success' ? 'Sukses' : 'Error',
                                        text: res.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                            },
                            error: function(xhr) {
                                var modalEl = document.getElementById('myModal');
                                var modal = bootstrap.Modal.getInstance(modalEl);
                                modal.hide();
                                window.LaravelDataTables["product-table"].ajax.reload();
                                if (xhr.responseJSON && xhr.responseJSON.alert && xhr.responseJSON
                                    .message) {
                                    Swal.fire({
                                        icon: xhr.responseJSON.alert,
                                        title: xhr.responseJSON.alert === 'success' ?
                                            'Sukses' : 'Error',
                                        text: xhr.responseJSON.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire('Error!',
                                        'Gagal menyimpan data karena duplikat Barang Kode.',
                                        'error');
                                }
                            }
                        });
                    });

                    $(document).off('submit', '#form-import');

                    // Handle form import khusus
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

                                if (response.alert && response.message) {
                                    Swal.fire({
                                        icon: response.alert,
                                        title: response.alert === 'success' ? 'Sukses' :
                                            'Error',
                                        text: response.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        window.LaravelDataTables["product-table"].ajax
                                            .reload();
                                    });
                                }
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
                                if (xhr.responseJSON && xhr.responseJSON.alert && xhr.responseJSON
                                    .message) {
                                    Swal.fire({
                                        icon: xhr.responseJSON.alert,
                                        title: xhr.responseJSON.alert === 'success' ?
                                            'Sukses' : 'Error',
                                        text: xhr.responseJSON.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: xhr.responseJSON.message
                                    });
                                }
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
            // Tambah margin bawah pada tombol DataTable
            $('.dt-buttons').addClass('mb-3');

            // Aktifkan tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Reload datatable on category filter change
            $('#kategori_id').on('change', function() {
                window.LaravelDataTables["product-table"].ajax.reload();
            });
        });
    </script>
@endpush
