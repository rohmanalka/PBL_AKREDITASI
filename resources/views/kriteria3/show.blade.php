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
                    Data detail tidak ditemukan.
                </div>
                <a href="{{ url('kriteria3') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header position-relative">
                <h5 class="modal-title w-100 text-center">{{ __('kriteria.detdata') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info-circle"></i> {{ __('kriteria.inform') }}</h5>
                    {{ __('kriteria.detinform') }}:
                </div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <table class="table table-sm table-bordered table-striped">
                            <tr>
                                <th class="text-right col-4">{{ __('kriteria.nmkrit') }}:</th>
                                <td class="col-8">{{ $details->kriteria->nama_kriteria ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">Status:</th>
                                <td>{{ ucfirst($details->status) }}</td>
                            </tr>
                            <tr>
                                <th class="text-right">{{ __('kriteria.komen') }}:</th>
                                <td>{{ $details->komentar->komentar ?? __('kriteria.komenbelum') }}</td>
                            </tr>
                        </table>
                        <div>
                            <iframe src="{{ url('/kriteria3/preview/' . $id) }}" width="100%" height="400px"
                                style="border: 1px solid #ccc; border-radius: 4px;">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('kriteria.tutup') }}</button>
            </div>
        </div>
    </div>

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
        $('.close, .btn-secondary').on('click', function() {
            $('#myModal').modal('hide');
        });
    </script>
@endempty
