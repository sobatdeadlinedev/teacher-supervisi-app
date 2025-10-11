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
                        Detail Administrasi</h1>
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
                            <a href="{{ route('kepala-sekolah.administrasi.index') }}"
                                class="text-muted text-hover-primary">Administrasi</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Detail</li>
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
            <div class="row g-5 g-xl-10">
                <!--begin::Col-->
                <div class="col-xl-8">
                    <!--begin::Card-->
                    <div class="card card-flush h-xl-100">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-900">Informasi File</span>
                            </h3>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-6">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 gy-7">
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold text-gray-800">Nama Guru</td>
                                            <td class="text-gray-600">{{ $file->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-gray-800">Jenis File</td>
                                            <td class="text-gray-600">{{ $file->file_type }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-gray-800">Mata Pelajaran</td>
                                            <td class="text-gray-600">{{ $file->mata_pelajaran }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-gray-800">Kelas</td>
                                            <td class="text-gray-600">{{ $file->kelas }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-gray-800">Semester</td>
                                            <td class="text-gray-600">{{ $file->semester }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-gray-800">Tahun Ajaran</td>
                                            <td class="text-gray-600">{{ $file->tahun_ajaran }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-gray-800">Nama File</td>
                                            <td class="text-gray-600">{{ $file->original_filename }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-gray-800">Ukuran File</td>
                                            <td class="text-gray-600">{{ number_format($file->file_size / 1024, 2) }} KB
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-gray-800">Deskripsi</td>
                                            <td class="text-gray-600">{{ $file->description ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-gray-800">Tanggal Upload</td>
                                            <td class="text-gray-600">{{ $file->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-gray-800">Status</td>
                                            <td>
                                                @if ($file->status === 'waiting_approve')
                                                    <span class="badge badge-light-warning">Menunggu Persetujuan</span>
                                                @elseif ($file->status === 'approved')
                                                    <span class="badge badge-light-success">Disetujui</span>
                                                @elseif ($file->status === 'revision')
                                                    <span class="badge badge-light-info">Revision</span>
                                                @else
                                                    <span class="badge badge-light-danger">Ditolak</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($file->feedback)
                                            <tr>
                                                <td class="fw-bold text-gray-800">Feedback</td>
                                                <td class="text-gray-600">{{ $file->feedback }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-xl-4">
                    <!--begin::Card-->
                    <div class="card card-flush h-xl-100">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-900">Aksi</span>
                            </h3>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-6">
                            {{-- Preview & Download Buttons --}}
                            <a href="{{ route('kepala-sekolah.administrasi.preview', $file->id) }}" target="_blank"
                                class="btn btn-primary w-100 mb-3">
                                <i class="ki-outline ki-eye fs-2"></i>
                                Lihat File
                            </a>

                            <a href="{{ route('kepala-sekolah.administrasi.download', $file->id) }}"
                                class="btn btn-info w-100 mb-3">
                                <i class="ki-outline ki-download fs-2"></i>
                                Download File
                            </a>

                            {{-- Separator --}}
                            <div class="separator separator-dashed my-5"></div>

                            {{-- Approval Actions --}}
                            @if ($file->status === 'waiting_approve')
                                <form action="{{ route('kepala-sekolah.administrasi.approve', $file->id) }}" method="POST"
                                    class="mb-3">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100"
                                        onclick="return confirm('Yakin ingin menyetujui file ini?')">
                                        <i class="ki-outline ki-check fs-2"></i>
                                        Setujui
                                    </button>
                                </form>

                                <button type="button" class="btn btn-warning w-100 mb-3" data-bs-toggle="modal"
                                    data-bs-target="#revisionModal">
                                    <i class="ki-outline ki-pencil fs-2"></i>
                                    Minta Revisi
                                </button>

                                <form action="{{ route('kepala-sekolah.administrasi.reject', $file->id) }}" method="POST"
                                    class="mb-3">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100"
                                        onclick="return confirm('Yakin ingin menolak file ini?')">
                                        <i class="ki-outline ki-cross fs-2"></i>
                                        Tolak
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-info d-flex align-items-center p-5 mb-3">
                                    <i class="ki-outline ki-information fs-2hx text-info me-4"></i>
                                    <div class="d-flex flex-column">
                                        <span>File ini sudah diproses</span>
                                    </div>
                                </div>
                            @endif

                            {{-- Separator --}}
                            <div class="separator separator-dashed my-5"></div>

                            {{-- Back Button --}}
                            <a href="{{ route('kepala-sekolah.administrasi.index') }}" class="btn btn-light w-100">
                                <i class="ki-outline ki-left fs-2"></i>
                                Kembali
                            </a>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
            </div>
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!-- Revision Modal -->
    <div class="modal fade" id="revisionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Minta Revisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('kepala-sekolah.administrasi.revision', $file->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Catatan Revisi</label>
                            <textarea class="form-control @error('feedback') is-invalid @enderror" name="feedback" rows="4"
                                placeholder="Tulis catatan revisi untuk guru..."></textarea>
                            @error('feedback')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Kirim Revisi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
