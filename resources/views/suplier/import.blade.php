<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Import Data Suplier</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="form-import" action="{{ route('suplier.import_ajax') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Pastikan file Excel mengikuti format template yang disediakan.
                </div>

                <div class="mb-3">
                    <label class="form-label">Download Template</label>
                    <div>
                        <a href="{{ asset('template_suplier.xlsx') }}" class="btn btn-info btn-sm" download>
                            <i class="fas fa-file-excel me-1"></i> Download Template
                        </a>
                    </div>
                    <small class="text-muted">Format: .xlsx (Excel)</small>
                </div>

                <div class="mb-3">
                    <label for="file_suplier" class="form-label">Pilih File Excel</label>
                    <input type="file" class="form-control" id="file_suplier" name="file_suplier" required
                        accept=".xlsx,.xls">
                    <div id="error-file_suplier" class="invalid-feedback"></div>
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
