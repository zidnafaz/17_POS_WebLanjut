{{-- resources/views/level/level.blade.php --}}
@extends('layouts.app')

@section('title', 'Level Management')

@section('content')
    <div class="container-fluid">

        {{-- Card Utama --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Data Level</h3>
                <div>
                    <button onclick="modalAction('{{ url('/level/create_ajax') }}')" class="btn btn-success" style="margin-left: 5px;">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Level
                    </button>
                </div>
            </div>

            <div class="card-body">
                {{-- Alert --}}
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- Table Level --}}
                <div class="table-responsive">
                    <table id="table_level" class="table table-bordered table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>Kode Level</th>
                                <th>Nama Level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody> {{-- diisi ajax --}}
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal --}}
        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" data-width="75%" aria-hidden="true">
        </div>

    </div>
@endsection

@push('js')
    <script>
        function modalAction(url) {
            $.get(url, function(response) {
                $('#myModal').html(response);
                $('#myModal').modal('show');

                // Bind submit event for create form
                $('#formCreateLevel').submit(function(e) {
                    e.preventDefault();
                    let form = $(this);
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                $('#table_level').DataTable().ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.message,
                                    confirmButtonText: 'OK'
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
                                        confirmButtonText: 'OK'
                                    });
                                }
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menyimpan data.',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });

                // Bind submit event for edit form
                $('#formEditLevel').submit(function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = form.serializeArray();

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
                                $('#table_level').DataTable().ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.message,
                                    confirmButtonText: 'OK'
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
                                        confirmButtonText: 'OK'
                                    });
                                }
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat mengupdate data.',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });

                // Bind submit event for delete form
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
                                $('#table_level').DataTable().ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });

            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal memuat modal.',
                    confirmButtonText: 'OK'
                });
            });
        }

        var dataLevel;
        $(document).ready(function() {
            dataLevel = $('#table_level').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('level.getLevels') }}",
                    type: "GET"
                },
                columns: [
                    { data: 'level_kode', name: 'level_kode' },
                    { data: 'level_nama', name: 'level_nama' },
                    {
                        data: null,
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            let url_edit = `{{ route('level.edit_ajax', ['id' => ':id']) }}`.replace(':id', row.level_id);
                            let url_hapus = `{{ route('level.confirm_ajax', ['id' => ':id']) }}`.replace(':id', row.level_id);

                            return `
                                <div class="d-flex justify-content-center gap-2">
                                    <button onclick="modalAction('${url_edit}')" class="btn btn-sm btn-primary" style="margin-left: 5px;">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button onclick="modalAction('${url_hapus}')" class="btn btn-sm btn-danger" style="margin-left: 5px;">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            `;
                        }
                    }
                ]
            });
        });
    </script>
@endpush
