<div class="modal-dialog" role="document">
    <form id="formCreateUser" method="POST" action="{{ route('user.store_ajax') }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="level_id" class="form-label">Level</label>
                    <select class="form-select" id="level_id" name="level_id" required>
                        <option value="">-- Pilih Level --</option>
                        @foreach ($level as $item)
                            <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 huruf" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#formCreateUser').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        window.LaravelDataTables["user-table"].ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'User berhasil ditambahkan.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        if (response.msgField) {
                            if (response.msgField.username) {
                                $('#username').addClass('is-invalid');
                                $('#error_username').text(response.msgField.username[0]);
                            } else {
                                $('#username').removeClass('is-invalid');
                                $('#error_username').text('');
                            }
                            if (response.msgField.nama) {
                                $('#nama').addClass('is-invalid');
                                $('#error_nama').text(response.msgField.nama[0]);
                            } else {
                                $('#nama').removeClass('is-invalid');
                                $('#error_nama').text('');
                            }
                            if (response.msgField.level_id) {
                                $('#level_id').addClass('is-invalid');
                                $('#error_level_id').text(response.msgField.level_id[0]);
                            } else {
                                $('#level_id').removeClass('is-invalid');
                                $('#error_level_id').text('');
                            }
                            if (response.msgField.password) {
                                $('#password').addClass('is-invalid');
                                $('#error_password').text(response.msgField.password[0]);
                            } else {
                                $('#password').removeClass('is-invalid');
                                $('#error_password').text('');
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat menyimpan data.'
                    });
                }
            });
        });
    });
</script>
