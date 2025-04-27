{{-- resources/views/user.blade.php --}}
@extends('layouts.app')

@section('title', 'User Profile')

@section('content')

    <h2>Data User</h2>

    <div class="container-fluid">

        {{-- Card Utama --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header">
                <div class="card-tools float-end">
                    <a href="{{ url('user/tambah') }}" class="btn btn-primary me-2">
                        <i class="fas fa-plus me-1"></i> Tambah User
                    </a>
                    <a href="{{ url('user/count') }}" class="btn btn-info me-2">
                        <i class="fas fa-chart-bar me-1"></i> Count
                    </a>
                    <button onclick="modalAction('{{ url('/user/create_ajax') }}')" class="btn btn-success">
                        <i class="fas fa-plus-circle me-1"></i> Tambah via Ajax
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

                {{-- Filter --}}
                <div class="row align-items-center mb-3">
                    <label class="col-md-1 col-form-label">Filter:</label>
                    <div class="col-md-3">
                        <select class="form-select" name="level_id" id="level_id" required>
                            <option value="">-- Semua --</option>
                            @foreach ($level_id as $item)
                                <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Table User --}}
                <div class="table-responsive">
                    <table id="table_user" class="table table-bordered table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Level</th>
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
            }).fail(function() {
                alert('Gagal memuat modal.');
            });
        }

        var dataUser;
        $(document).ready(function() {
            dataUser = $('#table_user').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('user.getUsers') }}",
                    type: "GET",
                    data: function(d) {
                        d.level_id = $('#level_id').val();
                    }
                },
                columns: [{
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'level_nama',
                        name: 'level_nama'
                    },
                    {
                        data: null,
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let url_edit = `{{ route('user.edit_ajax', ['id' => ':id']) }}`.replace(
                                ':id', row.user_id);
                            let url_hapus = `{{ route('user.confirm_ajax', ['id' => ':id']) }}`
                                .replace(':id', row.user_id);

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

            $('#level_id').change(function() {
                dataUser.ajax.reload();
            });
        });
    </script>
@endpush
