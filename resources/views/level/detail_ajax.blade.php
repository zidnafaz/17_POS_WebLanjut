<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header bg-info text-white">
            <h5 class="modal-title">Detail Level</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $level->level_id }}</td>
                </tr>
                <tr>
                    <th>Kode Level</th>
                    <td>{{ $level->level_kode }}</td>
                </tr>
                <tr>
                    <th>Nama Level</th>
                    <td>{{ $level->level_nama }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $level->created_at ? $level->created_at->format('d M Y H:i:s') : '-' }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $level->updated_at ? $level->updated_at->format('d M Y H:i:s') : '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
