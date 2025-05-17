@extends('adminlte::page')

@section('title', 'Profil Pengguna')

@section('content_header')
    <h1 class="m-0 text-dark">Profil Pengguna</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Card -->
            <div class="card card-outline">
                <div class="card-body box-profile text-center">
                    <img class="profile-user-img img-fluid img-circle shadow"
                        src="{{ $user->profile_picture ? asset('storage/profile_pictures/' . $user->profile_picture) : asset('vendor/adminlte/dist/img/avatar.png') }}"
                        alt="User profile picture">

                    <h3 class="profile-username mt-3 mb-1">{{ $user->nama }}</h3>
                    <p class="text-muted mb-3">
                        <span class="badge badge-primary">{{ $user->level->level_nama ?? 'Tanpa Level' }}</span>
                    </p>

                    <div class="list-group list-group-unbordered text-left mb-3">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <b>Username</b>
                            <span>{{ $user->username }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <b>Bergabung</b>
                            <span>{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <b>Terakhir Diubah</b>
                            <span>{{ $user->updated_at ? $user->updated_at->format('d M Y H:i') : '-' }}</span>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 mt-2" data-toggle="modal" data-target="#modal-edit-profile">
                        <i class="fas fa-edit mr-2"></i>Edit Profil
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Profile Details -->
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">
                        <i class="fas fa-info-circle mr-2"></i>Detail Profil
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-primary"><i class="fas fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Nama Lengkap</span>
                                    <span class="info-box-number">{{ $user->nama }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-primary"><i class="fas fa-at"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Username</span>
                                    <span class="info-box-number">{{ $user->username }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-primary"><i class="fas fa-shield-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Level</span>
                                    <span class="info-box-number">{{ $user->level->level_nama ?? 'Tanpa Level' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-primary"><i class="fas fa-calendar-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Bergabung</span>
                                    <span
                                        class="info-box-number">{{ $user->created_at ? $user->created_at->format('d F Y') : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.modal_edit_profile')
@stop

@section('css')
    <style>
        .profile-user-img {
            border: 2px solid #f0f0f0;
            margin: 0 auto;
            width: 140px;
            height: 140px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .profile-user-img:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            border-radius: 12px;
        }

        .card-header.bg-primary {
            border-radius: 12px 12px 0 0;
            background-color: #0069d9 !important;
        }

        .card-title {
            font-weight: 500;
            font-size: 18px;
        }

        .info-box {
            background: #ffffff !important;
            border: 1px solid #f1f1f1;
            border-radius: 10px;
            box-shadow: none;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .info-box-icon {
            background-color: #e9ecef !important;
            border-radius: 10px;
            height: 50px !important;
            width: 50px !important;
            line-height: 50px;
            text-align: center;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-box-content {
            margin-left: 12px;
        }

        .list-group-item {
            border: none;
            padding: 10px 0;
            font-size: 14px;
        }

        .badge-primary {
            background-color: #007bff;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 13px;
        }
    </style>
@stop
