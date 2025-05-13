<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Import Data Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="form-import" action="{{ route('products.import_ajax') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Pastikan file Excel mengikuti format template yang disediakan.
                </div>

                <div class="mb-3">
                    <label class="form-label">Download Template</label>
                    <div>
                        <a href="{{ asset('template_produk.xlsx') }}" class="btn btn-info btn-sm" download>
                            <i class="fas fa-file-excel me-1"></i> Download Template
                        </a>
                    </div>
                    <small class="text-muted">Format: .xlsx (Excel)</small>
                </div>

                <div class="mb-3">
                    <label for="file_barang" class="form-label">Pilih File Excel</label>
                    <input type="file" class="form-control" id="file_barang" name="file_barang" required
                        accept=".xlsx,.xls">
                    <div id="error-file_barang" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload me-1"></i> Upload
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi modal
        const importModal = new bootstrap.Modal(document.getElementById('myModal'));

        // Inisialisasi validasi form
        $("#form-import").validate({
            rules: {
                file_barang: {
                    required: true,
                    extension: "xlsx|xls",
                    filesize: 2048 // 2MB
                }
            },
            messages: {
                file_barang: {
                    required: "File harus diupload",
                    extension: "Hanya file Excel (.xlsx, .xls) yang diperbolehkan",
                    filesize: "Ukuran file maksimal 2MB"
                }
            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.mb-3').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form, event) {
                event.preventDefault();
                handleImportSubmit(form);
            }
        });

        // Custom validator untuk ukuran file
        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1024);
        });

        // Fungsi untuk handle submit
        function handleImportSubmit(form) {
            const formData = new FormData(form);
            const submitBtn = $(form).find('button[type="submit"]');
            const originalBtnText = submitBtn.html();

            // Tampilkan loading state
            submitBtn.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin me-1"></i> Memproses...');

            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        // Tutup modal
                        importModal.hide();

                        // Tampilkan SweetAlert sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            didClose: () => {
                                // Refresh datatable setelah alert ditutup
                                if (window.LaravelDataTables && window
                                    .LaravelDataTables["product-table"]) {
                                    window.LaravelDataTables["product-table"].ajax
                                        .reload(null, false);
                                }
                            }
                        });
                    } else {
                        // Reset error messages
                        $('.invalid-feedback').text('');
                        $('.is-invalid').removeClass('is-invalid');

                        // Tampilkan error field jika ada
                        if (response.msgField) {
                            $.each(response.msgField, function(prefix, errors) {
                                const errorField = $(`#error-${prefix}`);
                                const inputField = $(`#${prefix}`);

                                errorField.text(errors[0]);
                                inputField.addClass('is-invalid');
                            });
                        }

                        // Tampilkan SweetAlert error
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message ||
                                'Terjadi kesalahan saat mengimport data',
                            confirmButtonText: 'Tutup'
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan saat mengimport data';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.statusText) {
                        errorMessage = xhr.statusText;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage,
                        confirmButtonText: 'Tutup'
                    });
                },
                complete: function() {
                    // Kembalikan tombol ke state semula
                    submitBtn.prop('disabled', false).html(originalBtnText);
                }
            });
        }

        // Reset form ketika modal ditutup
        $('#myModal').on('hidden.bs.modal', function() {
            const form = document.getElementById('form-import');
            form.reset();
            $('.invalid-feedback').text('');
            $('.is-invalid').removeClass('is-invalid');
        });
    });
</script>
