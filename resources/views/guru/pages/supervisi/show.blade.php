@extends('guru.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Detail Supervisi</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('guru.dashboard.index') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('guru.supervisi.log') }}" class="text-muted text-hover-primary">Riwayat
                                Supervisi</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Detail</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">

            <!--begin::Info Supervisi-->
            <div class="card mb-5">
                <div class="card-header">
                    <h3 class="card-title">Informasi Supervisi</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-gray-600">Tanggal Supervisi:</label>
                            <p class="text-gray-800">{{ $supervision->schedule_date->format('d F Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-gray-600">Waktu:</label>
                            <p class="text-gray-800">{{ $supervision->schedule_time ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-gray-600">Supervisor:</label>
                            <p class="text-gray-800">{{ $supervision->supervisor->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-gray-600">Status:</label>
                            <p>
                                @if ($supervision->status == 'scheduled')
                                    <span class="badge badge-warning">Dijadwalkan</span>
                                @elseif($supervision->status == 'completed')
                                    <span class="badge badge-success">Selesai</span>
                                @else
                                    <span class="badge badge-danger">Dibatalkan</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-gray-600">Mata Pelajaran:</label>
                            <p class="text-gray-800">{{ $supervision->mata_pelajaran }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-gray-600">Kelas:</label>
                            <p class="text-gray-800">{{ $supervision->kelas }}</p>
                        </div>
                    </div>
                    @if ($supervision->notes)
                        <div class="row">
                            <div class="col-md-12">
                                <label class="fw-bold text-gray-600">Catatan:</label>
                                <p class="text-gray-800">{{ $supervision->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!--end::Info Supervisi-->

            <!--begin::Assessment-->
            @if ($supervision->assessments->isNotEmpty())
                <div class="card mb-5">
                    <div class="card-header">
                        <h3 class="card-title">Penilaian Supervisi</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($supervision->assessments as $assessment)
                            <div class="mb-5">
                                <h5 class="fw-bold text-primary mb-3">
                                    {{ ucwords(str_replace('_', ' ', $assessment->assessment_type)) }}
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        @foreach ($assessment->assessment_data as $key => $value)
                                            <tr>
                                                <td class="fw-bold text-gray-700" style="width: 40%">
                                                    {{ ucwords(str_replace('_', ' ', $key)) }}
                                                </td>
                                                <td class="text-gray-800">
                                                    @if (is_array($value))
                                                        {{ implode(', ', $value) }}
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <div class="separator my-5"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <div class="card mb-5">
                    <div class="card-body text-center py-10">
                        <i class="ki-outline ki-information fs-3x text-muted mb-3"></i>
                        <p class="text-gray-600">Belum ada penilaian dari supervisor</p>
                    </div>
                </div>
            @endif
            <!--end::Assessment-->

            <!--begin::Feedback-->
            @if ($supervision->feedbacks->isNotEmpty())
                <div class="card mb-5">
                    <div class="card-header">
                        <h3 class="card-title">Feedback & Rekomendasi</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($supervision->feedbacks as $feedback)
                            <div class="mb-5">
                                <label class="fw-bold text-gray-700">Feedback:</label>
                                <p class="text-gray-800 bg-light-primary p-4 rounded">{{ $feedback->feedback }}</p>

                                @if ($feedback->rekomendasi)
                                    <label class="fw-bold text-gray-700 mt-3">Rekomendasi:</label>
                                    <p class="text-gray-800 bg-light-info p-4 rounded">{{ $feedback->rekomendasi }}</p>
                                @endif

                                <div class="text-muted fs-7 mt-2">
                                    <i class="ki-outline ki-time fs-6"></i>
                                    {{ $feedback->created_at->format('d F Y, H:i') }}
                                </div>
                            </div>
                            @if (!$loop->last)
                                <div class="separator my-5"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <div class="card mb-5">
                    <div class="card-body text-center py-10">
                        <i class="ki-outline ki-message-text fs-3x text-muted mb-3"></i>
                        <p class="text-gray-600">Belum ada feedback dari supervisor</p>
                    </div>
                </div>
            @endif
            <!--end::Feedback-->

            <div class="d-flex justify-content-end">
                <a href="{{ route('guru.supervisi.log') }}" class="btn btn-light">
                    <i class="ki-outline ki-arrow-left fs-2"></i>Kembali
                </a>
            </div>

        </div>
    </div>
@endsection
