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
                <a href="{{ url('validasi-dir/') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header position-relative">
                <h5 class="modal-title w-100 text-center">Preview Dokumen Finalisasi</h5>
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

                <div class="mb-3">
                    <strong>Kriteria Perlu Revisi:</strong>
                    <div class="mt-2 ms-2">
                        <div class="border p-3 rounded">
                            @foreach ($pengisian->detail->where('status', 'revisi') as $detail)
                                <div class="mb-3 kriteria-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" disabled checked>
                                        <label class="form-check-label">
                                            <strong>Kriteria {{ $detail->id_kriteria }}:</strong>
                                            {{ $detail->kriteria->nama_kriteria ?? '-' }}
                                            <span class="badge bg-danger ms-2">Perlu Revisi</span>
                                        </label>
                                    </div>
                                    <div class="catatan-kriteria ms-4 mt-2">
                                        <label class="form-label small text-muted">
                                            Catatan:
                                        </label>
                                        <textarea class="form-control" rows="2" readonly disabled>{{ $detail->komentar->komentar ?? '-' }}</textarea>
                                    </div>
                                </div>
                            @endforeach

                            @if ($pengisian->detail->where('status', 'revisi')->count() == 0)
                                <p class="text-muted fst-italic">Tidak ada kriteria yang perlu revisi.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <iframe src="{{ url('/validasi-dir/export-pdf/' . $id_pengisian) }}" width="100%" height="400px"
                        style="border: 1px solid #ccc; border-radius: 4px;">
                    </iframe>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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
