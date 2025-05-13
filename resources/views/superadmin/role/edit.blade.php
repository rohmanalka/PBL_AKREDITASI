@empty($role)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria- label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('superadmin/role') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/superadmin/role/' . $role->id_role . '/update') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria- label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kriteria</label>
                        <select name="id_kriteria" id="id_kriteria" class="form-control" required>
                            <option value="">- Pilih Kriteria -</option>
                            @foreach ($kriteria as $r)
                                <option {{ $r->id_kriteria == $user->id_kriteria ? 'selected' : '' }} value="{{ $r->id_kriteria }}">
                                    {{ $r->nama_kriteria }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_role" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Role Kode</label>
                        <input value="{{ $role->role_kode }}" type="text" name="role_kode" id="role_kode"
                            class="form-control" required>
                        <small id="error-role_kode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Role Name</label>
                        <input value="{{ $role->role_name }}" type="text" name="role_name" id="role_name"
                            class="form-control" required>
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
            $("#form-edit").validate({
                rules: {
                    role_kode: {
                        required: true,
                        minlength: 5,
                        maxlength: 100
                    },
                    role_name: {
                        required: true,
                        minlength: 5,
                        maxlength: 100
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
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataRole.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
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
@endempty
