@extends('layouts.template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>{{ __('spi.title') }}</h6>
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
                                        <option value="">- {{ __('kpskjr.pilih_batch') }} -</option>
                                        @foreach ($pengisian as $item)
                                            <option value="{{ $item->id_pengisian }}">{{ $item->nama_pengisian }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive mt-4 p-0">
                            <table class="table align-items-center mb-0" id="table_detail_kriteria">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">{{ __('spi.no') }}</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">{{ __('spi.nama_bagian') }}</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">{{ __('spi.status') }}</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">{{ __('spi.aksi') }}</th>
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
    
@push('js')
    <script>
        const base_url = "{{ url('preview') }}";

        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function() {
            let dataDetail;

            function initDataTable(id_pengisian) {
                dataDetail = $('#table_detail_kriteria').DataTable({
                    serverSide: true,
                    processing: true,
                    destroy: true,
                    ajax: {
                        url: "{{ url('/list') }}",
                        type: "POST",
                        data: function(d) {
                            d.id_pengisian = id_pengisian;
                        }
                    },
                    columns: [
                        {
                            data: "DT_RowIndex",
                            className: "text-center text-sm",
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: "bagian.nama_bagian",
                            className: "text-sm",
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: "status",
                            className: "text-sm",
                            render: function(data) {
                                let badgeClass = 'bg-secondary';
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
                            render: function(data, type, row) {
                                return `
                                    <button class="btn btn-info btn-xs mt-3"
                                        onclick="modalAction('${base_url}/${row.id_pengisian}/${row.id_bagian}/preview')">
                                        Preview
                                    </button>`;
                            }
                        }
                    ]
                });
            }

            $('#id_pengisian').on('change', function() {
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
