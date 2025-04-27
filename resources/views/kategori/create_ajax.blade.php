<div class="modal-dialog" role="document">
    <form id="formCreateKategori" method="POST" action="{{ route('kategori.store_ajax') }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="kategori_kode" class="form-label">Kode Kategori</label>
                    <input type="text" class="form-control" id="kategori_kode" name="kategori_kode" required>
                </div>
                <div class="mb-3">
                    <label for="kategori_nama" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" id="kategori_nama" name="kategori_nama" required>
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
        $('#formCreateKategori').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#myModal').modal('hide');
                    window.LaravelDataTables["kategori-table"].ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Kategori berhasil ditambahkan.',
                        timer: 2000,
                        showConfirmButton: false
                    });
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
