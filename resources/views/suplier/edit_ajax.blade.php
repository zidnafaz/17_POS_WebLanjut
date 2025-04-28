<form id="formSuplierEdit" method="POST" action="{{ route('suplier.update_ajax', $suplier->suplier_id) }}">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title">Ubah Suplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="suplier_kode">Kode Suplier</label>
            <input type="text" class="form-control" id="suplier_kode" name="suplier_kode" value="{{ $suplier->suplier_kode }}" required>
        </div>
        <div class="form-group">
            <label for="suplier_nama">Nama Suplier</label>
            <input type="text" class="form-control" id="suplier_nama" name="suplier_nama" value="{{ $suplier->suplier_nama }}" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#formSuplierEdit').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data suplier berhasil diubah',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        window.LaravelDataTables["suplier-table"].ajax.reload();
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    $.each(errors, function(key, value) {
                        errorMessages += value + '\n';
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: errorMessages,
                    });
                }
            });
        });
    });
</script>
