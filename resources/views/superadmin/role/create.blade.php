<form action="{{ url('superadmin/role/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Role Code</label>
                    <input value="" type="text" name="role_kode" id="role_kode" class="form-control" required>
                    <small id="error-role_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Role Name</label>
                    <input value="" type="text" name="role_name" id="role_name" class="form-control" required>
                    <small id="error-role_name" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $('.close, .btn-warning').on('click', function() {
        $('#myModal').modal('hide');
    });

    $(document).ready(function() {
        $("#form-tambah").validate({
            rules: {
                role_kode: {
                    required: true,
                    minlength: 5,
                    maxlength: 100
                },
                role_name: {
                    required: true,
                    minlength: 5,
                    maxlength: 20
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            swal("Berhasil", response.message, {
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        className: "btn btn-success"
                                    }
                                }
                            });
                            dataRole.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            swal("Terjadi Kesalahan", response.message, {
                                icon: "error",
                                buttons: {
                                    confirm: {
                                        className: "btn btn-danger"
                                    }
                                }
                            });
                        }
                    }
                });
                return false;
            },
            error: function(xhr, status, error) {
                // Debugging AJAX error
                console.log("AJAX Error: " + error);
                console.log("Response: " + xhr.responseText);
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
