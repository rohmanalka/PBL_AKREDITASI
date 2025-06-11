@extends('layouts.template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6> {{ __('direktur.title') }}</h6>
                    </div>
                    <div class="card-body px-4 pt-3 pb-2">
                        <div class="mb-3">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                        </div>

                        <form>
                            <div class="row align-items-center">
                                <div class="col-sm-4">
                                    <select name="id_pengisian" id="id_pengisian" class="form-select">
                                        <option value="">- {{ __('direktur.pilih_batch') }} -</option>
                                        @foreach ($pengisian as $item)
                                            <option value="{{ $item->id_pengisian }}">{{ $item->nama_pengisian }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive mt-4 p-0">
                            <table class="table align-items-center mb-0" id="table_pengisian">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                            {{ __('direktur.no') }}
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            {{ __('direktur.nama_bagian') }}
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            {{ __('direktur.status') }}
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                            {{ __('direktur.aksi') }}
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true" style="display: none;">
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        const base_url = "{{ url('validasi-dir') }}";

        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function() {
            let dataDetail;

            function initDataTable(id_pengisian) {
                dataDetail = $('#table_pengisian').DataTable({
                    serverSide: true,
                    processing: true,
                    destroy: true,
                    ajax: {
                        url: "{{ url('validasi-dir/list') }}",
                        type: "POST",
                        data: function(d) {
                            d.id_pengisian = id_pengisian;
                        }
                    },
                    columns: [{
                            data: "DT_RowIndex",
                            className: "text-center text-sm",
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: "nama_pengisian",
                            className: "text-sm",
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: "detail",
                            className: "text-sm",
                            render: function(details) {
                                const statusGabungan = getStatusGabungan(details);
                                const badgeMap = {
                                    save: 'bg-secondary',
                                    submitted: 'bg-primary',
                                    revisi: 'bg-warning text-dark',
                                    divalidasi_kajur: 'bg-success',
                                    tervalidasi: 'bg-info',
                                    'belum lengkap': 'bg-danger'
                                };
                                const badgeClass = badgeMap[statusGabungan] || 'bg-secondary';

                                return `<span class="badge ${badgeClass}">${statusGabungan}</span>`;
                            }
                        },
                        {
                            data: "detail",
                            className: "text-center text-xs",
                            orderable: false,
                            searchable: false,
                            render: function(details, type, row) {
                                const statusGabungan = getStatusGabungan(details);
                                const disabled = (statusGabungan === 'revisi' || statusGabungan ===
                                    '');
                                const btnClass = disabled ? 'btn-secondary' : 'btn-info';
                                const btnAttr = disabled ? 'disabled' : '';

                                return `
                                <button class="btn ${btnClass} btn-xs mt-3"
                                    onclick="modalAction('${base_url}/${row.id_pengisian}/show')"
                                    ${btnAttr}>
                                    Validasi
                                </button>`;
                            }
                        }
                    ]
                });
            }

            // Fungsi bantu untuk menentukan status gabungan
            function getStatusGabungan(details) {
                const statuses = (Array.isArray(details) ? details : [])
                    .filter(item => item.id_kriteria >= 1 && item.id_kriteria <= 9)
                    .map(item => item.status);

                if (statuses.length < 9) return 'belum lengkap';
                if (statuses.includes('revisi')) return 'revisi';
                if (statuses.includes('submitted')) return 'submitted';
                if (statuses.includes('save')) return 'save';
                if (statuses.every(s => s === 'divalidasi_kajur')) return 'divalidasi_kajur';
                return 'belum lengkap';
            }

            $('#id_pengisian').on('change', function() {
                let selectedId = $(this).val();
                if (selectedId) {
                    if ($.fn.DataTable.isDataTable('#table_pengisian')) {
                        dataDetail.destroy();
                    }
                    initDataTable(selectedId);
                } else {
                    if ($.fn.DataTable.isDataTable('#table_pengisian')) {
                        dataDetail.clear().draw();
                    }
                }
            });
        });
    </script>
@endpush
