{{-- resources/views/level/confirm_ajax.blade.php --}}
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="formDeleteLevel" method="POST" action="{{ route('level.delete_ajax', ['id' => $level->level_id]) }}">
            @csrf
            @method('DELETE')
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus Level</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus level dengan kode <strong>{{ $level->level_kode }}</strong> dan nama <strong>{{ $level->level_nama }}</strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>

@push('js')
<script>
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
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat menghapus data.',
                });
            }
        });
    });
</script>
@endpush
