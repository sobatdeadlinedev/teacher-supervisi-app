@extends('guru.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Jurnal Harian Siswa</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('guru.dashboard.index') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Jurnal Harian Siswa</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3>Daftar Siswa</h3>
                    </div>
                </div>

                <div class="card-body pt-0">
                    @if ($students->isEmpty())
                        <div class="text-center py-15">
                            <div class="mb-4">
                                <i class="ki-outline ki-information fs-4x text-muted"></i>
                            </div>
                            <h4 class="fw-semibold text-gray-800 mb-2">Belum Ada Data</h4>
                            <p class="text-gray-600 mb-6">Belum ada siswa yang mengisi jurnal harian</p>
                        </div>
                    @else
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-200px">Nama Siswa</th>
                                    <th class="min-w-100px text-center">Total Jurnal</th>
                                    <th class="min-w-100px text-center">Bangun Pagi</th>
                                    <th class="min-w-100px text-center">Beribadah</th>
                                    <th class="min-w-100px text-center">Olahraga</th>
                                    <th class="min-w-100px text-center">Makan Sehat</th>
                                    <th class="min-w-100px text-center">Belajar</th>
                                    <th class="min-w-100px text-center">Bermasyarakat</th>
                                    <th class="min-w-100px text-center">Tidur Cepat</th>
                                    <th class="text-end min-w-100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($students as $student)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px me-3">
                                                    <div class="symbol-label bg-light-primary">
                                                        <i class="ki-outline ki-user fs-2x text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-800 fw-bold">{{ $student->name }}</span>
                                                    <span class="text-gray-600 fs-7">{{ $student->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-light-primary fs-6">{{ $student->total_journals }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if ($student->bangun_pagi_count > 0)
                                                <span
                                                    class="badge badge-light-info fs-6">{{ $student->bangun_pagi_count }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($student->beribadah_count > 0)
                                                <span
                                                    class="badge badge-light-success fs-6">{{ $student->beribadah_count }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($student->olahraga_count > 0)
                                                <span
                                                    class="badge badge-light-warning fs-6">{{ $student->olahraga_count }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($student->makan_sehat_count > 0)
                                                <span
                                                    class="badge badge-light-danger fs-6">{{ $student->makan_sehat_count }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($student->belajar_count > 0)
                                                <span
                                                    class="badge badge-light-primary fs-6">{{ $student->belajar_count }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($student->bermasyarakat_count > 0)
                                                <span
                                                    class="badge badge-light-success fs-6">{{ $student->bermasyarakat_count }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($student->tidur_cepat_count > 0)
                                                <span
                                                    class="badge badge-light-info fs-6">{{ $student->tidur_cepat_count }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('guru.student-journal.show', $student->id) }}"
                                                class="btn btn-light btn-active-light-primary btn-sm">
                                                Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Content-->
@endsection
