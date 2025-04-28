<form id="formEditProduct" action="{{ route('products.update_ajax', $product->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori_id" name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->kategori_id }}" {{ $product->kategori_id == $category->kategori_id ? 'selected' : '' }}>
                                {{ $category->kategori_nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="barang_kode" class="form-label">Kode Produk</label>
                    <input type="text" class="form-control" id="barang_kode" name="barang_kode" value="{{ $product->barang_kode }}" required>
                </div>
                <div class="mb-3">
                    <label for="barang_nama" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" id="barang_nama" name="barang_nama" value="{{ $product->barang_nama }}" required>
                </div>
                <div class="mb-3">
                    <label for="harga_beli" class="form-label">Harga Beli</label>
                    <input type="number" class="form-control" id="harga_beli" name="harga_beli" value="{{ $product->harga_beli }}" required>
                </div>
                <div class="mb-3">
                    <label for="harga_jual" class="form-label">Harga Jual</label>
                    <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="{{ $product->harga_jual }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update Produk</button>
            </div>
        </div>
    </div>
</form>
