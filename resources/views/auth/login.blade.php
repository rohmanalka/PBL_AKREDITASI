<form action="{{ url('login') }}" method="POST" id="form-login">
    @csrf
    <div id="modal-master" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-header pb-0 text-center">
                            <h3 class="font-weight-bolder text-info text-gradient">Sistem Akreditasi</h3>
                            <p class="mb-0">Enter username and password to sign in</p>
                        </div>
                        <div class="card-body">
                            <form role="form text-left">
                                <label>Username</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="username" id="username" class="form-control"
                                        aria-label="username" aria-describedby="username-addon" required>
                                    <small id="error-username" class="error-text form-text text-danger"></small>
                                </div>
                                <label>Password</label>
                                <div class="input-group mb-3">
                                    <input type="password" name="password" id="password" class="form-control"
                                        aria-label="Password" aria-describedby="password-addon" required>
                                    <small id="error-password" class="error-text form-text text-danger"></small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        checked="">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>

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
                    required: "Username/Email wajib diisi",
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
                        if (response.status) {
                            window.location.href = response.redirect;
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
