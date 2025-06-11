@empty($details)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data tidak ditemukan.
                </div>
                <a href="{{ url('kriteria8') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/kriteria8/' . $details->id_detail_kriteria . '/delete') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header position-relative">
                    <h5 class="modal-title w-100 text-center"> {{ __('kriteria.hpsdata') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> {{ __('kriteria.perhatian') }}!</h5>
                        {{ __('kriteria.perhatiandet') }}:
                    </div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <table class="table table-sm table-bordered table-striped">
                                <tr>
                                    <th class="text-right col-4"> {{ __('kriteria.nmkrit') }}:</th>
                                    <td class="col-8">{{ $details->kriteria->nama_kriteria ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-right">Status:</th>
                                    <td>{{ ucfirst($details->status) }}</td>
                                </tr>
                                <tr>
                                    <th class="text-right"> {{ __('kriteria.komen') }}:</th>
                                    <td>{{ $details->komentar->komentar ?? 'Belum ada komentar' }}</td>
                                </tr>
                            </table>
                            <div>
                                <iframe src="{{ url('/kriteria8/preview/' . $id) }}" width="100%" height="400px"
                                    style="border: 1px solid #ccc; border-radius: 4px;">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">{{ __('kriteria.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('kriteria.hps') }}</button>
                </div>
            </div>
        </div>
    </form>

    <style>
        .close {
            position: absolute;
            top: 12px;
            right: 16px;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #aaa;
            cursor: pointer;
            transition: color 0.3s ease;
            z-index: 10;
        }

        .close:hover {
            color: #333;
        }
    </style>

    <script>
        $('.close, .btn-warning').on('click', function() {
            $('#myModal').modal('hide');
        });
        
        var dataDetail
        $(document).ready(function() {
            $("#form-delete").validate({
                rules: {},
                submitHandler: function(form) {
                    Swal.fire({
                        title: "{{ __('kriteria.yakin') }}?",
                        text: "{{ __('kriteria.datahps') }}.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: "{{ __('kriteria.hps') }}.",
                        cancelButtonText: "{{ __('kriteria.cancel') }}."
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: form.action,
                                type: form.method,
                                data: $(form).serialize(),
                                success: function(response) {
                                    if (response.status) {
                                        $('#myModal').modal('hide');
                                        Swal.fire({
                                            icon: 'success',
                                            title: "{{ __('kriteria.success') }}.",
                                            text: response.message
                                        });
                                        dataDetail.ajax.reload();
                                    } else {
                                        $('.error-text').text('');
                                        $.each(response.msgField, function(prefix,
                                            val) {
                                            $('#error-' + prefix).text(val[
                                                0]);
                                        });
                                        Swal.fire({
                                            icon: 'error',
                                            title: "{{ __('kriteria.kesalahan') }}.",
                                            text: response.message
                                        });
                                    }
                                }
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
@endempty
