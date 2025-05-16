<form id="formCreateProduct" action="{{ route('products.store_ajax') }}" method="POST">
    @csrf
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori_id" name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->kategori_id }}">{{ $category->kategori_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="barang_kode" class="form-label">Kode Produk</label>
                    <input type="text" class="form-control" id="barang_kode" name="barang_kode" required>
                </div>
                <div class="mb-3">
                    <label for="barang_nama" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" id="barang_nama" name="barang_nama" required>
                </div>
                <div class="mb-3">
                    <label for="harga_beli" class="form-label">Harga Beli</label>
                    <input type="number" class="form-control" id="harga_beli" name="harga_beli" required>
                </div>
                <div class="mb-3">
                    <label for="harga_jual" class="form-label">Harga Jual</label>
                    <input type="number" class="form-control" id="harga_jual" name="harga_jual" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Produk</button>
            </div>
        </div>
    </div>
</form>

@push('js')
    <script>
        $('#formEditProduct').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serializeArray();

            // Pastikan _method PUT dikirim
            if (!formData.some(field => field.name === '_method')) {
                formData.push({
                    name: '_method',
                    value: 'PUT'
                });
            }

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: $.param(formData),
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        window.LaravelDataTables["product-table"].ajax
                    .reload(); // sesuaikan ID datatable
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        // Reset semua error feedback
                        let fields = ['kategori_id', 'barang_kode', 'barang_nama', 'harga_beli',
                            'harga_jual'
                        ];
                        fields.forEach(field => {
                            $('#' + field).removeClass('is-invalid');
                            $('#error_' + field).text('');
                        });

                        // Tampilkan pesan error validasi
                        if (response.msgField) {
                            for (const field in response.msgField) {
                                $('#' + field).addClass('is-invalid');
                                $('#error_' + field).text(response.msgField[field][0]);
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message ||
                            'Terjadi kesalahan saat memproses data.',
                        showConfirmButton: true
                    });
                }
            });
        });
    </script>
@endpush
