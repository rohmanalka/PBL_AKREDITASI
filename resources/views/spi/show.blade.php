@empty($pengisian)
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
                    Data dokumen tidak ditemukan.
                </div>
                <a href="{{ url('preview/') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('preview/' . $id_pengisian . '/update') }}">
                @csrf
                @method('PUT')

                <div class="modal-header position-relative">
                    <h5 class="modal-title w-100 text-center">Validasi Dokumen Finalisasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info-circle"></i> Informasi</h5>
                        Berikut adalah detail dokumen final:
                    </div>

                    <p><strong>Nama Batch:</strong> {{ $pengisian->nama_pengisian ?? '-' }}</p>
                    <p><strong>Tanggal Batch:</strong>
                        {{ $pengisian->created_at ? \Carbon\Carbon::parse($pengisian->created_at)->format('d/m/Y H:i') : '-' }}
                    </p>

                    <div class="mt-4">
                        <iframe src="{{ url('/preview/export-pdf/' . $id_pengisian) }}" width="100%" height="400px"
                            style="border: 1px solid #ccc; border-radius: 4px;">
                        </iframe>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
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
        $(document).ready(function() {
            $('.close, .btn-secondary').on('click', function() {
                $('#myModal').modal('hide');
            });
        });
    </script>
@endempty
