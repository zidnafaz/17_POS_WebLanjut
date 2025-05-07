<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Pengguna</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            max-width: 450px;
            width: 100%;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .register-container:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .register-header {
            background: var(--primary-color);
            color: white;
            padding: 25px;
            text-align: center;
        }

        .register-header h3 {
            font-weight: 600;
            margin: 0;
        }

        .register-body {
            padding: 30px;
        }

        .form-control {
            height: 50px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding-left: 45px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }

        .input-group-text {
            position: absolute;
            z-index: 5;
            height: 50px;
            background: transparent;
            border: none;
            color: #6c757d;
        }

        .btn-register {
            background: var(--primary-color);
            border: none;
            height: 50px;
            border-radius: 8px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-register:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
        }

        .login-link a {
            color: var(--primary-color);
            font-weight: 500;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error-text {
            font-size: 0.8rem;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-header">
            <h3> Create Account</h3>
        </div>

        <div class="register-body">
            <form action="{{ url('register') }}" method="POST" id="form-register">
                @csrf

                <div class="mb-3 position-relative">
                    <label for="username" class="form-label">Username</label>
                    <div class="position-relative">
                        <input type="text" name="username" id="username" class="form-control ps-4"
                               placeholder="Enter your username">
                    </div>
                    <small id="error-username" class="text-danger error-text"></small>
                </div>

                <div class="mb-3 position-relative">
                    <label for="nama" class="form-label">Nama</label>
                    <div class="position-relative">
                        <input type="text" name="nama" id="nama" class="form-control ps-4"
                               placeholder="Enter your full name">
                    </div>
                    <small id="error-nama" class="text-danger error-text"></small>
                </div>

                <div class="mb-3 position-relative">
                    <label for="level_id" class="form-label">Level</label>
                    <select class="form-select" id="level_id" name="level_id" required>
                        <option value="">-- Pilih Level --</option>
                        @foreach ($level as $item)
                            <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-level_id" class="text-danger error-text"></small>
                </div>

                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Password</label>
                    <div class="position-relative">
                        <input type="password" name="password" id="password" class="form-control ps-4"
                               placeholder="Enter your password">
                    </div>
                    <small id="error-password" class="text-danger error-text"></small>
                </div>

                <div class="mb-3 position-relative">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="position-relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control ps-4"
                               placeholder="Confirm your password">
                    </div>
                    <small id="error-password_confirmation" class="text-danger error-text"></small>
                </div>

                <button type="submit" class="btn btn-primary btn-register w-100 mb-3">
                    <i class="fas fa-user-plus me-2"></i> Sign Up
                </button>

                <div class="login-link">
                    Already have an account? <a href="{{ url('login') }}">Sign in</a>
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $("#form-register").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    username: {
                        required: "Username is required",
                        minlength: "Minimum 4 characters",
                        maxlength: "Maximum 20 characters"
                    },
                    password: {
                        required: "Password is required",
                        minlength: "Minimum 6 characters",
                        maxlength: "Maximum 20 characters"
                    },
                    password_confirmation: {
                        required: "Please confirm your password",
                        equalTo: "Passwords do not match"
                    }
                },
                errorElement: 'span',
                errorClass: 'text-danger',
                errorPlacement: function(error, element) {
                    error.addClass('error-text');
                    element.closest('.mb-3').append(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        method: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Registration Successful',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.href = response.redirect;
                                });
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(field, message) {
                                    $('#error-' + field).text(message[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Registration Failed',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            let response = xhr.responseJSON;
                            if(response && response.msgField) {
                                $('.error-text').text('');
                                $.each(response.msgField, function(field, message) {
                                    $('#error-' + field).text(message[0]);
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Registration Failed',
                                    text: response && response.message ? response.message : 'An unexpected error occurred. Please try again later.'
                                });
                            }
                        }
                    });
                    return false;
                }
            });
        });
    </script>
</body>

</html>
