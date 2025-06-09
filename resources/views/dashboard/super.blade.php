@extends('layouts.template')

@section('content')
<div style="min-height: 100vh; display: flex; flex-direction: column;">
    <main class="flex-grow-1">
        <div class="container-fluid py-4">
            <div class="row">
                <!-- Total Pengguna -->
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card border-0 shadow h-100" style="background-color: #ffffff;">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers text-black">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bolder">Total Pengguna</p>
                                        <h5 class="text-black" id="total-pengguna">
                                            {{ $total_pengguna }} Pengguna
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary text-white text-center rounded-circle shadow">
                                        <i class="fas fa-users text-lg" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Role -->
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card border-0 shadow" style="background-color: #ffffff;">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers text-black">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bolder">Total Role</p>
                                        <h5 class="text-black" id="total-role">
                                            {{ $total_role }} Role
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-danger text-white text-center rounded-circle shadow">
                                        <i class="fas fa-user-shield text-lg" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel -->
            <div class="row mt-4">
                <!-- Tabel Pengguna Teratas -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Pengguna</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-3">
                                <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">ID</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">Nama</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">Username</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id_user }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->role->role_name ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Role Teratas -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Role</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-3">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Role</th>
                                            <th>Jumlah Pengguna</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $role->id_role }}</td>
                                                <td>{{ $role->role_name }}</td>
                                                <td>{{ $role->users_count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection