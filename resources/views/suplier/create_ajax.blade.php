<div class="modal-dialog" role="document">
    <form id="formCreateSuplier" method="POST" action="{{ route('suplier.store_ajax') }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Suplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="kode_suplier" class="form-label">Kode Suplier</label>
                    <input type="text" class="form-control" id="kode_suplier" name="kode_suplier" required
                        maxlength="10">
                </div>
                <div class="mb-3">
                    <label for="nama_suplier" class="form-label">Nama Suplier</label>
                    <input type="text" class="form-control" id="nama_suplier" name="nama_suplier" required
                        maxlength="100">
                </div>
                <div class="mb-3">
                    <label for="no_telepon" class="form-label">No Telepon</label>
                    <input type="text" class="form-control" id="no_telepon" name="no_telepon" maxlength="15">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
</div>

@push('js')
<script>
    $('#formCreateSuplier').submit(function(e) {
        e.preventDefault();
        let form = $(this);
        let formData = form.serializeArray();

        // Tambahkan _method jika belum ada
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
                    window.LaravelDataTables["suplier-table"].ajax.reload(); // sesuaikan ID datatable
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    // Reset feedback
                    let fields = ['kode_suplier', 'nama_suplier', 'no_telepon', 'alamat'];
                    fields.forEach(field => {
                        $('#' + field).removeClass('is-invalid');
                        $('#error_' + field).text('');
                    });

                    // Tampilkan error
                    if (response.msgField) {
                        for (const field in response.msgField) {
                            $('#' + field).addClass('is-invalid');
                            $('#error_' + field).text(response.msgField[field][0]);
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
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan saat memproses data.',
                });
            }
        });
    });
</script>
@endpush
