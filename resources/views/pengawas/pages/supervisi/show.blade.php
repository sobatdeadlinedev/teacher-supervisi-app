@extends('pengawas.layouts.app')
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
                            <a href="{{ route('pengawas.dashboard.index') }}"
                                class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('pengawas.supervisi.index') }}"
                                class="text-muted text-hover-primary">Supervisi</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Detail</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('pengawas.supervisi.pdf.view', $supervisi->id) }}" class="btn btn-sm btn-info"
                        target="_blank">
                        <i class="ki-outline ki-eye fs-4"></i>
                        Lihat PDF
                    </a>
                    <a href="{{ route('pengawas.supervisi.pdf.download', $supervisi->id) }}" class="btn btn-sm btn-primary">
                        <i class="ki-outline ki-download fs-4"></i>
                        Download PDF
                    </a>
                    <a href="{{ route('pengawas.supervisi.index') }}" class="btn btn-sm btn-light">
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
                        <h2 class="fw-bolder mb-3">LAPORAN HASIL SUPERVISI KINERJA GURU</h2>
                        <div class="separator separator-dashed border-dark my-5"></div>
                    </div>
                    <!--end::Header-->

                    <!--begin::Informasi Supervisi-->
                    <div class="mb-10">
                        <h4 class="fw-bold mb-5 text-dark">I. INFORMASI SUPERVISI</h4>
                        <table class="table table-borderless gs-3">
                            <tbody>
                                <tr>
                                    <td class="fw-semibold text-gray-800 ps-0" width="200">Nama Guru</td>
                                    <td width="20" class="text-gray-800">:</td>
                                    <td class="text-gray-800">{{ $supervisi->guru->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-gray-800 ps-0">Mata Pelajaran</td>
                                    <td class="text-gray-800">:</td>
                                    <td class="text-gray-800">{{ $supervisi->mata_pelajaran }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-gray-800 ps-0">Kelas</td>
                                    <td class="text-gray-800">:</td>
                                    <td class="text-gray-800">{{ $supervisi->kelas }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-gray-800 ps-0">Tanggal Pelaksanaan</td>
                                    <td class="text-gray-800">:</td>
                                    <td class="text-gray-800">{{ $supervisi->schedule_date->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-gray-800 ps-0">Waktu</td>
                                    <td class="text-gray-800">:</td>
                                    <td class="text-gray-800">{{ $supervisi->schedule_time ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-gray-800 ps-0">Supervisor</td>
                                    <td class="text-gray-800">:</td>
                                    <td class="text-gray-800">{{ $supervisi->supervisor->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if ($supervisi->notes)
                            <div class="mt-5">
                                <div class="fw-semibold text-gray-800 mb-2">Catatan Awal:</div>
                                <div class="text-gray-800">{{ $supervisi->notes }}</div>
                            </div>
                        @endif
                    </div>
                    <!--end::Informasi Supervisi-->

                    <div class="separator separator-dashed border-dark my-8"></div>

                    <!--begin::Percakapan Pra-Observasi-->
                    @if ($instrumenPenilaian)
                        <div class="mb-10">
                            <h4 class="fw-bold mb-5 text-dark">II. PERCAKAPAN PRA-OBSERVASI KELAS</h4>
                            @php
                                $praObservasi = $instrumenPenilaian->assessment_data;
                            @endphp

                            <div class="mb-5">
                                <div class="fw-bold text-gray-800 mb-2">A. Tujuan Pembelajaran</div>
                                <div class="text-gray-800">{{ $praObservasi['tujuan_pembelajaran'] ?? '-' }}</div>
                            </div>

                            <div class="mb-5">
                                <div class="fw-bold text-gray-800 mb-2">B. Area Pengembangan yang Hendak Dicapai</div>
                                <div class="text-gray-800">{{ $praObservasi['area_pengembangan'] ?? '-' }}</div>
                            </div>

                            <div class="mb-5">
                                <div class="fw-bold text-gray-800 mb-2">C. Strategi yang Dipersiapkan</div>
                                <div class="text-gray-800">{{ $praObservasi['strategi_persiapan'] ?? '-' }}</div>
                            </div>
                        </div>
                    @endif
                    <!--end::Percakapan Pra-Observasi-->

                    <div class="separator separator-dashed border-dark my-8"></div>

                    <!--begin::Lembar Observasi-->
                    @if ($lembarObservasi)
                        <div class="mb-10">
                            <h4 class="fw-bold mb-5 text-dark">III. LEMBAR OBSERVASI PEMBELAJARAN</h4>
                            @php
                                $observasiData = $lembarObservasi->assessment_data;
                                $items = $observasiData['items'] ?? [];
                            @endphp

                            @if (!empty($items))
                                <div class="table-responsive mb-5">
                                    <table class="table table-bordered border-dark align-middle">
                                        <thead>
                                            <tr class="bg-light">
                                                <th class="text-center fw-bold border-dark" width="50">No</th>
                                                <th class="fw-bold border-dark">Aspek dan<br>Strategi<br>Pembelajaran</th>
                                                <th class="text-center fw-bold border-dark" width="100">Status</th>
                                                <th class="fw-bold border-dark" width="300">Catatan Pengamatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $index => $item)
                                                <tr>
                                                    <td class="text-center border-dark">{{ $index + 1 }}</td>
                                                    <td class="border-dark">{{ $item['aspek_strategi'] ?? '-' }}</td>
                                                    <td class="text-center border-dark">
                                                        @php
                                                            $status = $item['status'] ?? 'tidak';
                                                        @endphp
                                                        @if ($status === 'ada')
                                                            ✓ Ada
                                                        @else
                                                            ✗ Tidak Ada
                                                        @endif
                                                    </td>
                                                    <td class="border-dark">{{ $item['catatan_pengamatan'] ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            @if (isset($observasiData['catatan_tambahan']) && !empty($observasiData['catatan_tambahan']))
                                <div class="mb-5">
                                    <div class="fw-bold text-gray-800 mb-2">Catatan Tambahan:</div>
                                    <div class="text-gray-800">{{ $observasiData['catatan_tambahan'] }}</div>
                                </div>
                            @endif
                        </div>
                    @endif
                    <!--end::Lembar Observasi-->

                    <div class="separator separator-dashed border-dark my-8"></div>

                    <!--begin::Catatan Hasil Supervisi-->
                    @if ($catatanHasil)
                        <div class="mb-10">
                            <h4 class="fw-bold mb-5 text-dark">IV. CATATAN HASIL SUPERVISI</h4>
                            @php
                                $catatanData = $catatanHasil->assessment_data;
                            @endphp

                            <div class="mb-5">
                                <div class="fw-bold text-gray-800 mb-2">A. Catatan Refleksi Guru</div>
                                <div class="text-gray-800">{{ $catatanData['refleksi_guru'] ?? '-' }}</div>
                            </div>

                            <div class="mb-5">
                                <div class="fw-bold text-gray-800 mb-2">B. Topik Percakapan dan Catatan</div>
                                <div class="text-gray-800">{{ $catatanData['topik_percakapan'] ?? '-' }}</div>
                            </div>

                            <div class="mb-5">
                                <div class="fw-bold text-gray-800 mb-2">C. Rencana Tindak Lanjut</div>
                                <div class="text-gray-800">{{ $catatanData['rencana_tindak_lanjut'] ?? '-' }}</div>
                            </div>
                        </div>
                    @endif
                    <!--end::Catatan Hasil Supervisi-->

                    <div class="separator separator-dashed border-dark my-8"></div>

                    <!--begin::Feedback-->
                    @if ($feedback)
                        <div class="mb-10">
                            <h4 class="fw-bold mb-5 text-dark">V. UMPAN BALIK DAN REKOMENDASI</h4>

                            <div class="mb-5">
                                <div class="fw-bold text-gray-800 mb-2">A. Umpan Balik</div>
                                <div class="text-gray-800">{{ $feedback->feedback }}</div>
                            </div>

                            @if ($feedback->rekomendasi)
                                <div class="mb-5">
                                    <div class="fw-bold text-gray-800 mb-2">B. Rekomendasi Tindak Lanjut</div>
                                    <div class="text-gray-800">{{ $feedback->rekomendasi }}</div>
                                </div>
                            @endif
                        </div>
                    @endif
                    <!--end::Feedback-->

                    <div class="separator separator-dashed border-dark my-8"></div>

                    <!--begin::Signature-->
                    <div class="row mt-10">
                        <div class="col-md-6">
                            <div class="text-center">
                                <p class="mb-1 text-gray-800">Guru yang Disupervisi,</p>
                                <div style="height: 80px;"></div>
                                <p class="mb-0 fw-bold text-decoration-underline text-gray-900">
                                    {{ $supervisi->guru->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center">
                                <p class="mb-1 text-gray-800">Supervisor,</p>
                                <div style="height: 80px;"></div>
                                <p class="mb-0 fw-bold text-decoration-underline text-gray-900">
                                    {{ $supervisi->supervisor->name }}</p>
                                <p class="text-gray-700 mb-0">Kepala Sekolah</p>
                            </div>
                        </div>
                    </div>
                    <!--end::Signature-->

                    <!--begin::Footer-->
                    <div class="mt-8 text-end text-gray-700">
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

            .app-content {
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

            .border-dark {
                border-color: #000 !important;
            }

            table {
                page-break-inside: avoid;
            }

            .table-bordered {
                border: 1px solid #000 !important;
            }

            .table-bordered th,
            .table-bordered td {
                border: 1px solid #000 !important;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        .table-borderless td {
            padding: 0.4rem 0;
            vertical-align: top;
        }
    </style>
@endsection
