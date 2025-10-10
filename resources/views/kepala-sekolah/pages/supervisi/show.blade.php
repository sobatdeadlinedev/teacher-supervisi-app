@extends('kepala-sekolah.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Detail Hasil Supervisi
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('kepala-sekolah.dashboard.index') }}"
                                class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('kepala-sekolah.supervisi.index') }}"
                                class="text-muted text-hover-primary">Supervisi</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Detail</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button onclick="window.print()" class="btn btn-sm btn-primary">
                        <i class="ki-outline ki-printer fs-4"></i>
                        Cetak
                    </button>
                    <a href="{{ route('kepala-sekolah.supervisi.index') }}" class="btn btn-sm btn-light">
                        <i class="ki-outline ki-arrow-left fs-4"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">

            <!--begin::Main Card-->
            <div class="card">
                <div class="card-body p-lg-15">

                    <!--begin::Header-->
                    <div class="text-center mb-10">
                        <h2 class="fw-bold mb-3">LAPORAN HASIL SUPERVISI KINERJA GURU</h2>
                        <div class="separator separator-dashed my-5"></div>
                    </div>
                    <!--end::Header-->

                    <!--begin::Informasi Supervisi-->
                    <div class="mb-10">
                        <h4 class="fw-bold mb-5">I. INFORMASI SUPERVISI</h4>
                        <table class="table table-row-bordered">
                            <tbody>
                                <tr>
                                    <td class="fw-semibold text-gray-700" width="200">Nama Guru</td>
                                    <td width="20">:</td>
                                    <td class="text-gray-800">{{ $supervisi->guru->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-gray-700">Mata Pelajaran</td>
                                    <td>:</td>
                                    <td class="text-gray-800">{{ $supervisi->mata_pelajaran }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-gray-700">Kelas</td>
                                    <td>:</td>
                                    <td class="text-gray-800">{{ $supervisi->kelas }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-gray-700">Tanggal Pelaksanaan</td>
                                    <td>:</td>
                                    <td class="text-gray-800">{{ $supervisi->schedule_date->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-gray-700">Waktu</td>
                                    <td>:</td>
                                    <td class="text-gray-800">{{ $supervisi->schedule_time ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-gray-700">Supervisor</td>
                                    <td>:</td>
                                    <td class="text-gray-800">{{ $supervisi->supervisor->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if ($supervisi->notes)
                            <div class="mt-4">
                                <div class="fw-semibold text-gray-700 mb-2">Catatan Awal:</div>
                                <div class="text-gray-800 fst-italic">{{ $supervisi->notes }}</div>
                            </div>
                        @endif
                    </div>
                    <!--end::Informasi Supervisi-->

                    <div class="separator separator-dashed my-10"></div>

                    <!--begin::Percakapan Pra-Observasi-->
                    @if ($instrumenPenilaian)
                        <div class="mb-10">
                            <h4 class="fw-bold mb-5">II. PERCAKAPAN PRA-OBSERVASI KELAS</h4>
                            @php
                                $praObservasi = $instrumenPenilaian->assessment_data;
                            @endphp

                            <div class="mb-6">
                                <div class="fw-semibold text-gray-800 mb-2">A. Tujuan Pembelajaran</div>
                                <div class="p-4 bg-light border border-gray-300 rounded">
                                    <p class="text-gray-800 mb-0">{{ $praObservasi['tujuan_pembelajaran'] ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="mb-6">
                                <div class="fw-semibold text-gray-800 mb-2">B. Area Pengembangan yang Hendak Dicapai</div>
                                <div class="p-4 bg-light border border-gray-300 rounded">
                                    <p class="text-gray-800 mb-0">{{ $praObservasi['area_pengembangan'] ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="mb-6">
                                <div class="fw-semibold text-gray-800 mb-2">C. Strategi yang Dipersiapkan</div>
                                <div class="p-4 bg-light border border-gray-300 rounded">
                                    <p class="text-gray-800 mb-0">{{ $praObservasi['strategi_persiapan'] ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!--end::Percakapan Pra-Observasi-->

                    <div class="separator separator-dashed my-10"></div>

                    <!--begin::Lembar Observasi-->
                    @if ($lembarObservasi)
                        <div class="mb-10">
                            <h4 class="fw-bold mb-5">III. LEMBAR OBSERVASI PEMBELAJARAN</h4>
                            @php
                                $observasiData = $lembarObservasi->assessment_data;
                                $items = $observasiData['items'] ?? [];
                            @endphp

                            @if (!empty($items))
                                <div class="table-responsive mb-6">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50" class="text-center">No</th>
                                                <th>Aspek dan Strategi Pembelajaran</th>
                                                <th width="120" class="text-center">Status</th>
                                                <th width="350">Catatan Pengamatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $index => $item)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $item['aspek_strategi'] ?? '-' }}</td>
                                                    <td class="text-center">
                                                        @php
                                                            $status = $item['status'] ?? 'tidak';
                                                            $statusText = $status === 'ada' ? '✓ Ada' : '✗ Tidak Ada';
                                                            $statusClass =
                                                                $status === 'ada'
                                                                    ? 'badge-light-success'
                                                                    : 'badge-light-danger';
                                                        @endphp
                                                        <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                                    </td>
                                                    <td>{{ $item['catatan_pengamatan'] ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            @if (isset($observasiData['catatan_tambahan']) && !empty($observasiData['catatan_tambahan']))
                                <div class="mb-6">
                                    <div class="fw-semibold text-gray-800 mb-2">Catatan Tambahan:</div>
                                    <div class="p-4 bg-light border border-gray-300 rounded">
                                        <p class="text-gray-800 mb-0 fst-italic">
                                            {{ $observasiData['catatan_tambahan'] }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    <!--end::Lembar Observasi-->

                    <div class="separator separator-dashed my-10"></div>

                    <!--begin::Catatan Hasil Supervisi-->
                    @if ($catatanHasil)
                        <div class="mb-10">
                            <h4 class="fw-bold mb-5">IV. CATATAN HASIL SUPERVISI</h4>
                            @php
                                $catatanData = $catatanHasil->assessment_data;
                            @endphp

                            <div class="mb-6">
                                <div class="fw-semibold text-gray-800 mb-2">A. Catatan Refleksi Guru</div>
                                <div class="p-4 bg-light border border-gray-300 rounded">
                                    <p class="text-gray-800 mb-0">{{ $catatanData['refleksi_guru'] ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="mb-6">
                                <div class="fw-semibold text-gray-800 mb-2">B. Topik Percakapan dan Catatan</div>
                                <div class="p-4 bg-light border border-gray-300 rounded">
                                    <p class="text-gray-800 mb-0">{{ $catatanData['topik_percakapan'] ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="mb-6">
                                <div class="fw-semibold text-gray-800 mb-2">C. Rencana Tindak Lanjut</div>
                                <div class="p-4 bg-light border border-gray-300 rounded">
                                    <p class="text-gray-800 mb-0">{{ $catatanData['rencana_tindak_lanjut'] ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!--end::Catatan Hasil Supervisi-->

                    <div class="separator separator-dashed my-10"></div>

                    <!--begin::Feedback-->
                    @if ($feedback)
                        <div class="mb-10">
                            <h4 class="fw-bold mb-5">V. UMPAN BALIK DAN REKOMENDASI</h4>

                            <div class="mb-6">
                                <div class="fw-semibold text-gray-800 mb-2">A. Umpan Balik</div>
                                <div class="p-4 bg-light border border-gray-300 rounded">
                                    <p class="text-gray-800 mb-0">{{ $feedback->feedback }}</p>
                                </div>
                            </div>

                            @if ($feedback->rekomendasi)
                                <div class="mb-6">
                                    <div class="fw-semibold text-gray-800 mb-2">B. Rekomendasi Tindak Lanjut</div>
                                    <div class="p-4 bg-light border border-gray-300 rounded">
                                        <p class="text-gray-800 mb-0">{{ $feedback->rekomendasi }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    <!--end::Feedback-->

                    <div class="separator separator-dashed my-10"></div>

                    <!--begin::Signature-->
                    <div class="row mt-15">
                        <div class="col-md-6">
                            <div class="text-center">
                                <p class="mb-1">Guru yang Disupervisi,</p>
                                <div class="my-10"></div>
                                <div class="my-10"></div>
                                <p class="mb-0 fw-bold text-decoration-underline">{{ $supervisi->guru->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center">
                                <p class="mb-1">Supervisor,</p>
                                <div class="my-10"></div>
                                <div class="my-10"></div>
                                <p class="mb-0 fw-bold text-decoration-underline">{{ $supervisi->supervisor->name }}</p>
                                <p class="text-muted mb-0">Kepala Sekolah</p>
                            </div>
                        </div>
                    </div>
                    <!--end::Signature-->

                    <!--begin::Footer-->
                    <div class="mt-10 text-end text-muted">
                        <small>Dokumen dibuat pada: {{ $feedback->created_at->format('d F Y, H:i') }} WIB</small>
                    </div>
                    <!--end::Footer-->

                </div>
            </div>
            <!--end::Main Card-->

        </div>
    </div>
    <!--end::Content-->

    <style>
        @media print {

            .app-toolbar,
            .app-header,
            .app-sidebar,
            .app-footer {
                display: none !important;
            }

            .app-wrapper {
                padding: 0 !important;
            }

            .card {
                box-shadow: none !important;
                border: none !important;
            }

            .btn {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .separator {
                border-color: #000 !important;
            }

            table {
                page-break-inside: avoid;
            }
        }
    </style>
@endsection
