<form action="{{ url('login') }}" method="POST" id="form-login">
    @csrf
    <div id="modal-master" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content shadow-lg glass-effect border-0 p-4">
                <div class="text-center mb-4">
                    <h4 class="text-white fw-bold">🔐 Sistem Akreditasi</h4>
                    <p class="text-light mb-0">Silakan masuk untuk melanjutkan</p>
                </div>

                <div class="form-group mb-4 position-relative floating-label-group">
                    <input type="text" name="username" id="username" class="form-control text-white" placeholder=" "
                        required>
                    <label for="username" class="floating-label">Username</label>
                    <small id="error-username" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group mb-4 position-relative floating-label-group">
                    <input type="password" name="password" id="password" class="form-control text-white"
                        placeholder=" " required>
                    <label for="password" class="floating-label">Password</label>
                    <small id="error-password" class="error-text form-text text-danger"></small>
                </div>


                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                    <label class="form-check-label text-light" for="remember">Remember me</label>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-outline-danger me-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Login</button>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    .glass-effect {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    #modal-master input {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }

    #modal-master input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    #modal-master .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        background-color: rgba(255, 255, 255, 0.15);
    }

    #modal-master .btn-info {
        background-color: #00bcd4;
        border: none;
    }

    #modal-master .btn-info:hover {
        background-color: #0097a7;
    }

    .floating-label-group {
        position: relative;
        margin-top: 0.5rem;
    }

    .floating-label-group input {
        padding: 10px 10px;
        font-size: 0.95rem;
        height: auto;
        line-height: 1.2;
    }

    .floating-label {
        position: absolute;
        left: 0.75rem;
        top: 0.7rem;
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.7);
        transition: all 0.2s ease;
        pointer-events: none;
        z-index: 2;
    }

    .floating-label-group input:focus+.floating-label,
    .floating-label-group input:not(:placeholder-shown)+.floating-label {
        top: -0.85rem;
        left: 0.6rem;
        font-size: 0.75rem;
        color: #00bcd4;
        background-color: rgba(0, 0, 0, 0.8);
        padding: 0 0.4rem;
        border-radius: 6px;
    }
</style>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $("#form-login").validate({
            rules: {
                username: {
                    required: true,
                    minlength: 3
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                username: {
                    required: "Username wajib diisi",
                    minlength: "Minimal 3 karakter"
                },
                password: {
                    required: "Password wajib diisi",
                    minlength: "Minimal 6 karakter"
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) { // jika sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                            }).then(function() {
                                window.location = response.redirect;
                            });
                        } else {
                            $('.error-text').text('');
                            if (response.errors) {
                                $.each(response.errors, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server'
                        });
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
