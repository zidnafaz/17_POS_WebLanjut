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
        <button class="btn btn-primary" onclick="modalAction('{{ route('products.create_ajax') }}')">
            <i class="fas fa-plus"></i> Tambah Produk
        </button>
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
                    'style' => 'width:100%'
                ]) }}
            </div>
        </div>
    </div>

    {{-- Modal --}}
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

                    // Initialize Bootstrap 5 modal
                    var modal = new bootstrap.Modal(document.getElementById('myModal'));
                    modal.show();

                    // Reset form event listener first
                    $(document).off('submit', '#formCreateProduct, #formEditProduct');

                    // Handle form submit (both create & edit)
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
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: 'Produk berhasil disimpan.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', xhr.responseJSON?.message || 'Gagal menyimpan data.', 'error');
                            }
                        });
                    });
                })
                .fail(function(xhr) {
                    Swal.fire('Error!', 'Gagal memuat form: ' + xhr.statusText, 'error');
                });
        }

        function editModal(id) {
            modalAction('{{ url('products') }}/' + id + '/edit-ajax');
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
