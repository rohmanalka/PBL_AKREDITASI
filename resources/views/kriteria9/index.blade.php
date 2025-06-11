@extends('layouts.template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>{{ $page->title }}</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="px-3 mt-3">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="table_detail_kriteria">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                            ID
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            {{ __('kriteria.nmkrit') }}
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            {{ __('kriteria.bagian') }}
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
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
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        var dataDetail;
        const base_url = "{{ url('kriteria9') }}";

        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function() {
            dataDetail = $('#table_detail_kriteria').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('kriteria9/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.id_detail_kriteria = $('#id_detail_kriteria').val();
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center text-sm",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "kriteria.nama_kriteria",
                        className: "text-sm",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "pengisian.nama_pengisian",
                        className: "text-sm",
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row, meta) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: "status",
                        className: "text-sm",
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row, meta) {
                            let badgeClass = 'bg-secondary'; // default

                            switch (data) {
                                case 'save':
                                    badgeClass = 'bg-secondary';
                                    break;
                                case 'submitted':
                                    badgeClass = 'bg-primary';
                                    break;
                                case 'revisi':
                                    badgeClass = 'bg-warning text-dark';
                                    break;
                                case 'divalidasi_kajur':
                                    badgeClass = 'bg-success';
                                    break;
                                case 'tervalidasi':
                                    badgeClass = 'bg-info';
                                    break;
                            }

                            return `<span class="badge ${badgeClass}">${data}</span>`;
                        }
                    },
                    {
                        data: "aksi",
                        className: "text-center text-xs",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            let id = row.id_detail_kriteria;
                            let status = row.status;
                            let detailBtn =
                                `<button class="btn btn-info btn-xs mt-3" onclick="modalAction('${base_url}/${id}/show')">{{ __('kriteria.detail') }}</button>`;
                            // Jika status submit, disable tombol edit
                            let editBtn = '';

                            if (status === 'submitted' || status === 'divalidasi_kajur' ||
                                status === 'tervalidasi') {
                                editBtn =
                                    `<a class="btn btn-secondary btn-xs disabled mt-3" href="#">{{ __('kriteria.edit') }}</a>`;
                            } else {
                                editBtn =
                                    `<a class="btn btn-warning btn-xs mt-3" href="${base_url}/${id}/edit">{{ __('kriteria.edit') }}</a>`;
                            }

                            let deleteBtn =
                                `<button class="btn btn-danger btn-xs mt-3" onclick="modalAction('${base_url}/${id}/delete')">{{ __('kriteria.delete') }}</button>`;
                            return `${detailBtn} ${editBtn} ${deleteBtn}`;
                        }

                    }
                ]
            });

            $('#id_detail_kriteria').on('change', function() {
                dataDetail.ajax.reload();
            });
        });
    </script>
@endpush
