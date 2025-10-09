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
                        Jurnal Pembelajaran - {{ $guru->name }}</h1>
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
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('kepala-sekolah.jurnal.index') }}"
                                class="text-muted text-hover-primary">Jurnal</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">{{ $guru->name }}</li>
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
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50px me-5">
                                <div class="symbol-label fs-2 bg-light-primary text-primary">
                                    {{ strtoupper(substr($guru->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="d-flex justify-content-start flex-column">
                                <span class="text-gray-900 fw-bold fs-4">{{ $guru->name }}</span>
                                <span class="text-muted fw-semibold d-block fs-7">Total {{ $jurnals->count() }}
                                    Jurnal</span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <a href="{{ route('kepala-sekolah.jurnal.index') }}" class="btn btn-light btn-sm">
                            <i class="ki-outline ki-left fs-2"></i>
                            Kembali
                        </a>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    @if ($jurnals->isEmpty())
                        <!--begin::Empty state-->
                        <div class="text-center py-15">
                            <div class="mb-4">
                                <i class="ki-outline ki-information fs-4x text-muted"></i>
                            </div>
                            <h4 class="fw-semibold text-gray-800 mb-2">Belum Ada Jurnal</h4>
                            <p class="text-gray-600 mb-6">Guru ini belum mengisi jurnal pembelajaran</p>
                        </div>
                        <!--end::Empty state-->
                    @else
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Tanggal</th>
                                    <th class="min-w-100px">Kelas</th>
                                    <th class="min-w-100px">Jam Ke</th>
                                    <th class="min-w-200px">Materi Pokok</th>
                                    <th class="min-w-200px">Kegiatan Pembelajaran</th>
                                    <th class="text-end min-w-100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($jurnals as $jurnal)
                                    <tr>
                                        <td>{{ $jurnal->hari_tanggal->format('d/m/Y') }}</td>
                                        <td>{{ $jurnal->kelas }}</td>
                                        <td>{{ $jurnal->jam_ke }}</td>
                                        <td>{{ Str::limit($jurnal->materi_pokok, 50) }}</td>
                                        <td>{{ Str::limit($jurnal->kegiatan_pembelajaran, 50) }}</td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-light btn-active-light-primary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#jurnalModal{{ $jurnal->id }}">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>

                                    <!--begin::Modal Detail-->
                                    <div class="modal fade" id="jurnalModal{{ $jurnal->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered mw-750px">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="fw-bold">Detail Jurnal</h2>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                                    <div class="mb-5">
                                                        <label class="form-label fw-bold text-gray-900">Tanggal</label>
                                                        <p class="text-gray-600">
                                                            {{ $jurnal->hari_tanggal->format('d F Y') }}</p>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold text-gray-900">Kelas</label>
                                                            <p class="text-gray-600">{{ $jurnal->kelas }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold text-gray-900">Jam Ke</label>
                                                            <p class="text-gray-600">{{ $jurnal->jam_ke }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="mb-5">
                                                        <label class="form-label fw-bold text-gray-900">Materi Pokok</label>
                                                        <p class="text-gray-600">{{ $jurnal->materi_pokok }}</p>
                                                    </div>
                                                    <div class="mb-5">
                                                        <label class="form-label fw-bold text-gray-900">Kegiatan
                                                            Pembelajaran</label>
                                                        <p class="text-gray-600">{{ $jurnal->kegiatan_pembelajaran }}</p>
                                                    </div>
                                                    <div class="mb-5">
                                                        <label class="form-label fw-bold text-gray-900">Penilaian
                                                            Pembelajaran</label>
                                                        <p class="text-gray-600">{{ $jurnal->penilaian_pembelajaran }}</p>
                                                    </div>
                                                    @if ($jurnal->kehadiran_peserta_didik)
                                                        <div class="mb-5">
                                                            <label class="form-label fw-bold text-gray-900">Kehadiran
                                                                Peserta Didik</label>
                                                            <div class="text-gray-600">
                                                                @foreach ($jurnal->kehadiran_peserta_didik as $kehadiran)
                                                                    <span
                                                                        class="badge badge-light-primary me-2 mb-2">{{ $kehadiran }}</span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Modal Detail-->
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
