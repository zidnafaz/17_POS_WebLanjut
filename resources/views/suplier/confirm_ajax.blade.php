{{-- resources/views/level/confirm_ajax.blade.php --}}
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="formDeleteSuplier" method="POST" action="{{ route('suplier.delete_ajax', ['id' => $suplier->id_suplier]) }}">
            @csrf
            @method('DELETE')
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus Suplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus level dengan kode <strong>{{ $suplier->kode_suplier }}</strong> dan
                    nama <strong>{{ $suplier->nama_suplier }}</strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>
