<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Konfirmasi Hapus Suplier</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus suplier <strong>{{ $suplier->nama_suplier }}</strong>?</p>
        </div>
        <div class="modal-footer">
            <button id="btnDeleteSuplier" class="btn btn-danger">Hapus</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#btnDeleteSuplier').click(function() {
            $.ajax({
                url: "{{ route('suplier.delete_ajax', $suplier->suplier_id) }}",
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data suplier berhasil dihapus',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        window.LaravelDataTables["suplier-table"].ajax.reload();
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal menghapus data suplier',
                    });
                }
            });
        });
    });
</script>
