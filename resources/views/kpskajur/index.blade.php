@extends('layouts.template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>{{ $page->title }}</h6>
                    </div>
                    <div class="card-body px-4 pt-3 pb-2"> {{-- padding kiri-kanan dibuat px-4 supaya lebih lega --}}
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
                                    <select name="id_kriteria" id="id_kriteria" class="form-select">
                                        <option value="">- Pilih Kriteria -</option>
                                        @foreach ($kriteria as $item)
                                            <option value="{{ $item->id_kriteria }}">{{ $item->nama_kriteria }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive mt-4 p-0">
                            <table class="table align-items-center mb-0" id="table_detail_kriteria">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                            ID
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            {{ __('messages.nmkrit') }}
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
@endsection

@push('css')
@endpush

@push('js')
    <script>
        const base_url = "{{ url('validasi') }}";

        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function() {
            let dataDetail;

            function initDataTable(id_kriteria) {
                dataDetail = $('#table_detail_kriteria').DataTable({
                    serverSide: true,
                    processing: true,
                    destroy: true,
                    ajax: {
                        url: "{{ url('validasi/list') }}",
                        type: "POST",
                        data: function(d) {
                            d.id_kriteria = id_kriteria;
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
                            data: "status",
                            className: "text-sm",
                            orderable: true,
                            searchable: true,
                            render: function(data) {
                                let badgeClass = 'bg-secondary';
                                switch (data) {
                                    case 'save':
                                        badgeClass = 'bg-secondary';
                                        break;
                                    case 'submit':
                                        badgeClass = 'bg-primary';
                                        break;
                                    case 'revisi':
                                        badgeClass = 'bg-warning text-dark';
                                        break;
                                    case 'acc1':
                                        badgeClass = 'bg-success';
                                        break;
                                    case 'acc2':
                                        badgeClass = 'bg-info';
                                        break;
                                }
                                return `<span class="badge ${badgeClass}">${data}</span>`;
                            }
                        },
                        {
                            data: "aksi",
                            className: "text-center text-xs ",
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                let id = row.id_detail_kriteria;
                                let status = row.status;
                                let disabled = (status === 'revisi' || status === 'acc1') ?
                                    'disabled' : '';
                                let detailBtn = `
                                    <button class="btn btn-info btn-xs mt-3" onclick="modalAction('${base_url}/${id}/show')" ${disabled}>
                                        Validasi
                                    </button>`;
                                return `${detailBtn}`;
                            }
                        }
                    ]
                });
            }

            $('#id_kriteria').on('change', function() {
                let selectedId = $(this).val();
                if (selectedId) {
                    if ($.fn.DataTable.isDataTable('#table_detail_kriteria')) {
                        dataDetail.destroy();
                    }
                    initDataTable(selectedId);
                } else {
                    if ($.fn.DataTable.isDataTable('#table_detail_kriteria')) {
                        dataDetail.clear().draw();
                    }
                }
            });
        });
    </script>
@endpush
