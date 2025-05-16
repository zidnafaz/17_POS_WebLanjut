<div class="modal-dialog" role="document">
    <form id="formEditSuplier" method="POST" action="{{ route('suplier.update_ajax', $suplier->id_suplier) }}">
        @csrf
        @method('PUT')
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Ubah Suplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="kode_suplier" class="form-label">Kode Suplier</label>
                    <input type="text" class="form-control" id="kode_suplier" name="kode_suplier"
                        value="{{ $suplier->kode_suplier }}" required maxlength="10">
                    <div class="invalid-feedback" id="error_kode_suplier"></div>
                </div>
                <div class="mb-3">
                    <label for="nama_suplier" class="form-label">Nama Suplier</label>
                    <input type="text" class="form-control" id="nama_suplier" name="nama_suplier"
                        value="{{ $suplier->nama_suplier }}" required maxlength="100">
                    <div class="invalid-feedback" id="error_nama_suplier"></div>
                </div>
                <div class="mb-3">
                    <label for="no_telepon" class="form-label">No Telepon</label>
                    <input type="text" class="form-control" id="no_telepon" name="no_telepon"
                        value="{{ $suplier->no_telepon }}" maxlength="15">
                    <div class="invalid-feedback" id="error_no_telepon"></div>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $suplier->alamat }}</textarea>
                    <div class="invalid-feedback" id="error_alamat"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>
