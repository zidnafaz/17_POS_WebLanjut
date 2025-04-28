<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header bg-info text-white">
            <h5 class="modal-title">Detail Suplier</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID Suplier</th>
                    <td>{{ $suplier->id_suplier }}</td>
                </tr>
                <tr>
                    <th>Kode Suplier</th>
                    <td>{{ $suplier->kode_suplier }}</td>
                </tr>
                <tr>
                    <th>Nama Suplier</th>
                    <td>{{ $suplier->nama_suplier }}</td>
                </tr>
                <tr>
                    <th>No Telepon</th>
                    <td>{{ $suplier->no_telepon }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $suplier->alamat }}</td>
                </tr>
                <tr>
                    <th>Dibuat Pada</th>
                    <td>{{ $suplier->created_at }}</td>
                </tr>
                <tr>
                    <th>Diperbarui Pada</th>
                    <td>{{ $suplier->updated_at }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
