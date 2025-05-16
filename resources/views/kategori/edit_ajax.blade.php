<div class="modal-dialog" role="document">
    <form id="formEditKategori" method="POST" action="{{ route('kategori.update_ajax', $kategori->kategori_id) }}">
        @csrf
        @method('PUT')
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Ubah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="kategori_kode" class="form-label">Kode Kategori</label>
                    <input type="text" class="form-control" id="kategori_kode" name="kategori_kode"
                        value="{{ $kategori->kategori_kode }}" required>
                    <div class="invalid-feedback" id="error_kategori_kode"></div>
                </div>
                <div class="mb-3">
                    <label for="kategori_nama" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" id="kategori_nama" name="kategori_nama"
                        value="{{ $kategori->kategori_nama }}" required>
                    <div class="invalid-feedback" id="error_kategori_nama"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>

@push('js')
    <script>
        $('#formEditKategori').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serializeArray();

            // Ensure _method=PUT is included for Laravel method spoofing
            if (!formData.some(field => field.name === '_method')) {
                formData.push({
                    name: '_method',
                    value: 'PUT'
                });
            }

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: $.param(formData),
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        window.LaravelDataTables["kategori-table"].ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        if (response.msgField) {
                            if (response.msgField.kategori_kode) {
                                $('#kategori_kode').addClass('is-invalid');
                                $('#error_kategori_kode').text(response.msgField.kategori_kode[0]);
                            } else {
                                $('#kategori_kode').removeClass('is-invalid');
                                $('#error_kategori_kode').text('');
                            }
                            if (response.msgField.kategori_nama) {
                                $('#kategori_nama').addClass('is-invalid');
                                $('#error_kategori_nama').text(response.msgField.kategori_nama[0]);
                            } else {
                                $('#kategori_nama').removeClass('is-invalid');
                                $('#error_kategori_nama').text('');
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
                        text: response.message,
                        showConfirmButton: true,
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>
