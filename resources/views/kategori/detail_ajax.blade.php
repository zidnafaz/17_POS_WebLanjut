<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header bg-info text-white">
            <h5 class="modal-title">Detail Kategori</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th>Kategori ID</th>
                    <td>{{ $kategori->kategori_id }}</td>
                </tr>
                <tr>
                    <th>Kode</th>
                    <td>{{ $kategori->kategori_kode }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $kategori->kategori_nama }}</td>
                </tr>
                <tr>
                    <th>Jumlah Produk</th>
                    <td>{{ $jumlahProduk }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $kategori->created_at ? $kategori->created_at->format('d M Y H:i:s') : '-' }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $kategori->updated_at ? $kategori->updated_at->format('d M Y H:i:s') : '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
