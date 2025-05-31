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
            <form method="POST" action="{{ url('validasi-dir/' . $id_pengisian . '/update') }}">
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

                    <div class="mb-3">
                        <strong>Status Validasi:</strong>
                        <div class="mt-2 ms-2">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="status_validasi" id="acc1"
                                    value="tervalidasi">
                                <label class="form-check-label text-success fw-bold" for="acc1">
                                    <i class="fas fa-check-circle me-2"></i>Diterima
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="status_validasi" id="revisi"
                                    value="revisi">
                                <label class="form-check-label text-danger fw-bold" for="revisi">
                                    <i class="fas fa-times-circle me-2"></i>Revisi
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Kriteria Revisi Section -->
                    <div id="kriteria-revisi-section" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark mb-2">
                                <i class="fas fa-list-check me-2"></i>Pilih Kriteria yang Perlu Revisi
                            </label>
                            <div class="border p-3 rounded">
                                @foreach ($pengisian->detail as $detail)
                                    <div class="mb-3 kriteria-item">
                                        <div class="form-check">
                                            <input class="form-check-input kriteria-checkbox" type="checkbox"
                                                name="detail[{{ $detail->id_detail_kriteria }}][revisi]" value="1"
                                                id="kriteria_{{ $detail->id_detail_kriteria }}"
                                                data-detail="{{ $detail->id_detail_kriteria }}"
                                                @if ($detail->status == 'revisi') checked @endif>
                                            <label class="form-check-label"
                                                for="kriteria_{{ $detail->id_detail_kriteria }}">
                                                <strong>Kriteria {{ $detail->id_kriteria }}:</strong>
                                                {{ $detail->kriteria->nama_kriteria ?? '-' }}
                                                @if ($detail->status == 'revisi')
                                                    <span class="badge bg-danger ms-2">Perlu Revisi</span>
                                                @endif
                                            </label>
                                        </div>
                                        <div class="catatan-kriteria ms-4 mt-2"
                                            id="catatan_kriteria_{{ $detail->id_detail_kriteria }}"
                                            style="display: {{ $detail->status == 'revisi' ? 'block' : 'none' }};">
                                            <label for="catatan_{{ $detail->id_detail_kriteria }}"
                                                class="form-label small text-muted">
                                                Catatan untuk kriteria ini:
                                            </label>
                                            <textarea class="form-control catatan-field" id="catatan_{{ $detail->id_detail_kriteria }}"
                                                name="detail[{{ $detail->id_detail_kriteria }}][komentar]" rows="2">{{ $detail->komentar->komentar ?? '' }}</textarea>
                                        </div>
                                    </div>
                                @endforeach
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
                    <button type="submit" class="btn btn-primary">Simpan Validasi</button>
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
            // Toggle kriteria revisi section berdasarkan status validasi
            $('input[name="status_validasi"]').change(function() {
                if ($(this).val() === 'revisi') {
                    $('#kriteria-revisi-section').show();
                } else {
                    $('#kriteria-revisi-section').hide();
                    // Uncheck all ketika pindah ke status ACC
                    $('.kriteria-checkbox').prop('checked', false).trigger('change');
                }
            });

            // Inisialisasi status awal
            @if ($pengisian->detail->where('status', 'revisi')->count() > 0)
                $('input[name="status_validasi"][value="revisi"]').prop('checked', true).trigger('change');
            @else
                $('input[name="status_validasi"][value="tervalidasi"]').prop('checked', true);
            @endif

            // Toggle catatan untuk kriteria yang dipilih
            $(document).on('change', '.kriteria-checkbox', function() {
                const detailId = $(this).data('detail');
                const catatanDiv = $('#catatan_kriteria_' + detailId);

                if ($(this).is(':checked')) {
                    catatanDiv.show();
                } else {
                    catatanDiv.hide();
                }
            });

            // Validasi sebelum submit
            $('form').on('submit', function(e) {
                const status = $('input[name="status_validasi"]:checked').val();

                if (!status) {
                    e.preventDefault();
                    alert('Pilih status validasi terlebih dahulu!');
                    return;
                }

                if (status === 'revisi') {
                    const checkedKriteria = $('.kriteria-checkbox:checked').length;

                    if (checkedKriteria === 0) {
                        e.preventDefault();
                        alert('Pilih minimal satu kriteria yang perlu direvisi!');
                        return;
                    }

                    // Validasi catatan untuk setiap kriteria yang dipilih
                    let isValid = true;
                    $('.kriteria-checkbox:checked').each(function() {
                        const detailId = $(this).data('detail');
                        const catatan = $('#catatan_' + detailId).val().trim();

                        if (catatan === '') {
                            isValid = false;
                            $('#catatan_' + detailId).addClass('is-invalid');
                        } else {
                            $('#catatan_' + detailId).removeClass('is-invalid');
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        alert('Harap isi catatan untuk kriteria yang dipilih!');
                        return;
                    }
                }
            });

            $('.close, .btn-secondary').on('click', function() {
                $('#myModal').modal('hide');
            });
        });
    </script>
@endempty
