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
                <p>Apakah Anda yakin ingin menghapus level dengan kode <strong>{{ $level->level_kode }}</strong> dan
                    nama <strong>{{ $level->level_nama }}</strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>
