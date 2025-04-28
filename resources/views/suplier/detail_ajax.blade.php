<div class="modal-header">
    <h5 class="modal-title">Detail Suplier</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-bordered">
        <tr>
            <th>ID Suplier</th>
            <td>{{ $suplier->suplier_id }}</td>
        </tr>
        <tr>
            <th>Kode Suplier</th>
            <td>{{ $suplier->suplier_kode }}</td>
        </tr>
        <tr>
            <th>Nama Suplier</th>
            <td>{{ $suplier->suplier_nama }}</td>
        </tr>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
</div>
