{{-- resources/views/level/create_ajax.blade.php --}}
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="formCreateLevel" method="POST" action="{{ route('level.store_ajax') }}">
            @csrf
            <div class="modal-header">
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
        </form>
    </div>
</div>

@push('js')
<script>
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
                    alert(response.message);
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
                        alert(response.message);
                    }
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menyimpan data.');
            }
        });
    });
</script>
@endpush
