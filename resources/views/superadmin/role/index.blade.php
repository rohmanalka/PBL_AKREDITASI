@extends('layouts.template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>{{ $page->title }}</h6>
                        <button onclick="modalAction('{{ url('superadmin/role/create') }}')" class="btn btn-sm btn-success">
                            Tambah Data
                        </button>
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
                            <table class="table align-items-center mb-0" id="table_role">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                            ID
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Role Code
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            Role Name
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
        var dataRole;
        const base_url = "{{ url('superadmin/role') }}";

        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function() {
            dataRole = $('#table_role').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('superadmin/role/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.id_role = $('#id_role').val();
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center text-sm",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "role_kode",
                        className: "text-sm",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "role_name",
                        className: "text-sm",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "text-center text-xs",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            let id = row.id_role;
                            return `
                                <button class="btn btn-info btn-xs" onclick="modalAction('${base_url}/${id}/show')">Detail</button>
                                <button class="btn btn-warning btn-xs" onclick="modalAction('${base_url}/${id}/edit')">Edit</button>
                                <button class="btn btn-danger btn-xs" onclick="modalAction('${base_url}/${id}/delete')">Hapus</button>
                            `;
                        }

                    }
                ]
            });

            $('#id_role').on('change', function() {
                dataRole.ajax.reload();
            });
        });
    </script>
@endpush
