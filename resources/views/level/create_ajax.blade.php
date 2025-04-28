{{-- resources/views/level/create_ajax.blade.php --}}
<form id="formCreateLevel" method="POST" action="{{ route('level.store_ajax') }}">
    @csrf
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Level</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="level_kode" class="form-label">Kode Level</label>
                    <input type="text" class="form-control" id="level_kode" name="level_kode" required>
                    <div class="invalid-feedback" id="error_level_kode"></div>
                </div>
                <div class="mb-3">
                    <label for="level_nama" class="form-label">Nama Level</label>
                    <input type="text" class="form-control" id="level_nama" name="level_nama" required>
                    <div class="invalid-feedback" id="error_level_nama"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

@push('js')
<script>
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
</script>
@endpush
