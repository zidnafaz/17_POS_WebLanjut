<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header bg-info text-white">
            <h5 class="modal-title">Detail Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th>Kategori</th>
                    <td>{{ $product->kategori->kategori_nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Barang ID</th>
                    <td>{{ $product->barang_id }}</td>
                </tr>
                <tr>
                    <th>Kode</th>
                    <td>{{ $product->barang_kode }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $product->barang_nama }}</td>
                </tr>
                <tr>
                    <th>Harga Beli</th>
                    <td>{{ number_format($product->harga_beli, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Harga Jual</th>
                    <td>{{ number_format($product->harga_jual, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $product->created_at ? $product->created_at->format('d M Y H:i:s') : '-' }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $product->updated_at ? $product->updated_at->format('d M Y H:i:s') : '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
