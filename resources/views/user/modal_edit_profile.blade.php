<div class="modal fade" id="modal-edit-profile">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">Edit Profil Pengguna</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-edit-profile" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="row">
                        <!-- Foto Profil -->
                        <div
                            class="col-md-4 mb-3 border-md-right pr-md-4 text-center d-flex flex-column align-items-center justify-content-center">
                            <img id="profile-preview" class="img-fluid img-circle mb-3 shadow"
                                src="{{ $user->profile_picture ? asset('storage/profile_pictures/' . $user->profile_picture) : asset('vendor/adminlte/dist/img/avatar.png') }}"
                                alt="Profile Picture"
                                style="width: 180px; height: 180px; object-fit: cover; border: 3px solid #dee2e6;">

                            <div class="custom-file w-100">
                                <input type="file" class="custom-file-input" id="profile_picture"
                                    name="profile_picture" accept="image/*">
                                <label class="custom-file-label" for="profile_picture">Pilih foto...</label>
                            </div>
                            <small class="text-muted mt-2">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                        </div>

                        <!-- Form Input -->
                        <div class="col-md-8 mt-4 mt-md-0">
                            <div class="form-group">
                                <label for="edit-nama">Nama Lengkap</label>
                                <input type="text" class="form-control" id="edit-nama" name="nama"
                                    value="{{ $user->nama }}" required>
                            </div>

                            <div class="form-group">
                                <label for="edit-username">Username</label>
                                <input type="text" class="form-control" id="edit-username" name="username"
                                    value="{{ $user->username }}" required>
                            </div>

                            <div class="form-group">
                                <label for="edit-level">Level</label>
                                <select class="form-control" id="edit-level" name="level_id" required>
                                    @foreach ($levels as $level)
                                        <option value="{{ $level->level_id }}"
                                            {{ $user->level_id == $level->level_id ? 'selected' : '' }}>
                                            {{ $level->level_nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="edit-password">Password <small class="text-muted">(Kosongkan jika tidak
                                        ingin mengubah)</small></label>
                                <input type="password" class="form-control" id="edit-password" name="password"
                                    minlength="6">
                                <small class="text-muted">Minimal 6 karakter</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-save">
                        <span id="btn-save-text">Simpan Perubahan</span>
                        <span id="btn-save-spinner" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(function() {
            // Preview image before upload
            $('#profile_picture').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#profile-preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);

                    // Update the label with the file name
                    $(this).next('.custom-file-label').html(file.name);
                }
            });

            // BS Custom File Input
            bsCustomFileInput.init();

            // AJAX Form Submission
            $('#form-edit-profile').on('submit', function(e) {
                e.preventDefault();

                // Show loading state
                $('#btn-save').prop('disabled', true);
                $('#btn-save-text').addClass('d-none');
                $('#btn-save-spinner').removeClass('d-none');

                // Create FormData object
                let formData = new FormData(this);

                // Gunakan route yang benar untuk update
                let url = "{{ route('user.update_profile', $user->user_id) }}";

                // Tambahkan _method PUT ke FormData
                formData.append('_method', 'PUT');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Hide modal
                        $('#modal-edit-profile').modal('hide');

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message || 'Profil berhasil diperbarui',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Update profile picture preview in main page if changed
                        if (response.profile_picture) {
                            $('.profile-user-img').attr('src',
                                "{{ asset('storage/profile_pictures') }}/" + response
                                .profile_picture);
                            $('#profile-preview').attr('src',
                                "{{ asset('storage/profile_pictures') }}/" + response
                                .profile_picture);
                        }

                        // Update other user info in main page
                        $('.profile-username').text(response.nama || "{{ $user->nama }}");
                        $('.info-box-number:eq(0)').text(response.nama ||
                            "{{ $user->nama }}");
                        $('.info-box-number:eq(1)').text(response.username ||
                            "{{ $user->username }}");
                        $('.info-box-number:eq(2)').text(response.level_nama ||
                            "{{ $user->level->level_nama ?? 'Tanpa Level' }}");
                    },
                    error: function(xhr) {
                        let errorMessage = 'Terjadi kesalahan saat menyimpan perubahan';

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            errorMessage = '';

                            $.each(errors, function(key, value) {
                                errorMessage += value + '<br>';
                            });
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            html: errorMessage
                        });
                    },
                    complete: function() {
                        // Reset button state
                        $('#btn-save').prop('disabled', false);
                        $('#btn-save-text').removeClass('d-none');
                        $('#btn-save-spinner').addClass('d-none');
                    }
                });
            });
        });
    </script>
@endpush
