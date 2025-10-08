@extends('guru.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Riwayat Supervisi</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('guru.dashboard.index') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Riwayat Supervisi</li>
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
                        <h3>Riwayat Supervisi</h3>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @if ($supervisions->isEmpty())
                        <div class="text-center py-15">
                            <div class="mb-4">
                                <i class="ki-outline ki-information fs-4x text-muted"></i>
                            </div>
                            <h4 class="fw-semibold text-gray-800 mb-2">Belum Ada Riwayat</h4>
                            <p class="text-gray-600 mb-6">Riwayat supervisi akan muncul di sini</p>
                        </div>
                    @else
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Tanggal</th>
                                    <th class="min-w-100px">Waktu</th>
                                    <th class="min-w-150px">Supervisor</th>
                                    <th class="min-w-100px">Mata Pelajaran</th>
                                    <th class="min-w-100px">Kelas</th>
                                    <th class="min-w-100px">Status</th>
                                    <th class="min-w-100px">Assessment</th>
                                    <th class="min-w-100px">Feedback</th>
                                    <th class="text-end min-w-70px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($supervisions as $supervision)
                                    <tr>
                                        <td>{{ $supervision->schedule_date->format('d/m/Y') }}</td>
                                        <td>{{ $supervision->schedule_time ?? '-' }}</td>
                                        <td>{{ $supervision->supervisor->name }}</td>
                                        <td>{{ $supervision->mata_pelajaran }}</td>
                                        <td>{{ $supervision->kelas }}</td>
                                        <td>
                                            @if ($supervision->status == 'scheduled')
                                                <span class="badge badge-light-warning">Dijadwalkan</span>
                                            @elseif($supervision->status == 'completed')
                                                <span class="badge badge-light-success">Selesai</span>
                                            @else
                                                <span class="badge badge-light-danger">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($supervision->assessments->isNotEmpty())
                                                <span
                                                    class="badge badge-light-success">{{ $supervision->assessments->count() }}</span>
                                            @else
                                                <span class="badge badge-light">Belum ada</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($supervision->feedbacks->isNotEmpty())
                                                <span class="badge badge-light-success">Ada</span>
                                            @else
                                                <span class="badge badge-light">Belum ada</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('guru.supervisi.show', $supervision->id) }}"
                                                class="btn btn-light btn-sm">
                                                Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end">
                            {{ $supervisions->links() }}
                        </div>
                    @endif
                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>
@endsection
