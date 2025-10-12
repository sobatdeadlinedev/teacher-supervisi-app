@extends('kepala-sekolah.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <!--begin::Toolbar wrapper-->
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Administrasi Pembelajaran</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('kepala-sekolah.dashboard.index') }}"
                                class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Administrasi Pembelajaran</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h3>Daftar Guru</h3>
                    </div>
                    <!--begin::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    @if ($teachers->isEmpty())
                        <!--begin::Empty state-->
                        <div class="text-center py-15">
                            <div class="mb-4">
                                <i class="ki-outline ki-information fs-4x text-muted"></i>
                            </div>
                            <h4 class="fw-semibold text-gray-800 mb-2">Belum Ada Data</h4>
                            <p class="text-gray-600 mb-6">Belum ada guru yang mengupload file administrasi</p>
                        </div>
                        <!--end::Empty state-->
                    @else
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-200px">Nama Guru</th>
                                    <th class="min-w-100px text-center">Total File</th>
                                    <th class="min-w-100px text-center">Menunggu</th>
                                    <th class="min-w-100px text-center">Disetujui</th>
                                    <th class="min-w-100px text-center">Revisi</th>
                                    <th class="min-w-100px text-center">Ditolak</th>
                                    <th class="text-end min-w-100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($teachers as $teacher)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px me-3">
                                                    <div class="symbol-label bg-light-primary">
                                                        <i class="ki-outline ki-user fs-2x text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-800 fw-bold">{{ $teacher->name }}</span>
                                                    <span class="text-gray-600 fs-7">{{ $teacher->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-light-primary fs-6">{{ $teacher->learning_administration_files_count }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if ($teacher->waiting_count > 0)
                                                <span
                                                    class="badge badge-light-warning fs-6">{{ $teacher->waiting_count }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($teacher->approved_count > 0)
                                                <span
                                                    class="badge badge-light-success fs-6">{{ $teacher->approved_count }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($teacher->revision_count > 0)
                                                <span
                                                    class="badge badge-light-info fs-6">{{ $teacher->revision_count }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($teacher->rejected_count > 0)
                                                <span
                                                    class="badge badge-light-danger fs-6">{{ $teacher->rejected_count }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('kepala-sekolah.administrasi.teacher-files', $teacher->id) }}"
                                                class="btn btn-light btn-active-light-primary btn-sm">
                                                Lihat File
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--end::Table-->
                    @endif
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
