@empty($role)
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
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('superadmin/role') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header position-relative">
                <h5 class="modal-title w-100 text-center"> {{ __('superadmin.role.showtit')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info-circle"></i> {{ __('superadmin.role.informasi')}}</h5>
                    {{ __('superadmin.role.informdet')}}
                </div>
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-3">{{ __('superadmin.role.role_kode')}} :</th>
                        <td class="col-9">{{ $role->role_kode }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">{{ __('superadmin.role.role_name')}} :</th>
                        <td class="col-9">{{ $role->role_name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">{{ __('superadmin.role.kriteria')}} :</th>
                        <td class="col-9">{{ $role->kriteria->nama_kriteria }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('superadmin.role.tutup')}}</button>
            </div>
        </div>
    </div>
    <script>
        $('.close, .btn-secondary').on('click', function() {
            $('#myModal').modal('hide');
        });
    </script>
@endempty

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
