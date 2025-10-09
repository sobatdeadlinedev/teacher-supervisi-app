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
                    <button onclick="window.print()" class="btn btn-sm btn-light-primary">
                        <i class="ki-outline ki-printer fs-3"></i>
                        Cetak
                    </button>
                    <a href="{{ route('kepala-sekolah.supervisi.index') }}" class="btn btn-sm btn-light">
                        <i class="ki-outline ki-arrow-left fs-3"></i>
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

            <!--begin::Info Card-->
            <div class="card mb-5">
                <div class="card-header">
                    <h3 class="card-title">Informasi Supervisi</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold text-gray-600" width="150">Guru:</td>
                                    <td class="text-gray-800">{{ $supervisi->guru->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-gray-600">Mata Pelajaran:</td>
                                    <td class="text-gray-800">{{ $supervisi->mata_pelajaran }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-gray-600">Kelas:</td>
                                    <td class="text-gray-800">{{ $supervisi->kelas }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold text-gray-600" width="150">Tanggal:</td>
                                    <td class="text-gray-800">{{ $supervisi->schedule_date->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-gray-600">Waktu:</td>
                                    <td class="text-gray-800">{{ $supervisi->schedule_time ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-gray-600">Status:</td>
                                    <td><span class="badge badge-success">Selesai</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @if ($supervisi->notes)
                        <div class="mt-4">
                            <div class="fw-bold text-gray-600 mb-2">Catatan Awal:</div>
                            <div class="text-gray-800">{{ $supervisi->notes }}</div>
                        </div>
                    @endif
                </div>
            </div>
            <!--end::Info Card-->

            <!--begin::Instrumen Penilaian-->
            @if ($instrumenPenilaian)
                <div class="card mb-5">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ki-outline ki-chart-simple text-primary fs-2 me-2"></i>
                            Instrumen Penilaian Kinerja Guru
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                        <th width="50">No</th>
                                        <th>Aspek Penilaian</th>
                                        <th width="150" class="text-center">Nilai</th>
                                        <th width="150" class="text-center">Kategori</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $assessmentData = $instrumenPenilaian->assessment_data;
                                        $aspects = [
                                            'penguasaan_materi' => 'Penguasaan Materi',
                                            'strategi_pembelajaran' => 'Strategi Pembelajaran',
                                            'pengelolaan_kelas' => 'Pengelolaan Kelas',
                                            'komunikasi' => 'Komunikasi dengan Siswa',
                                            'media_pembelajaran' => 'Penggunaan Media/Alat Pembelajaran',
                                        ];
                                        $total = 0;
                                    @endphp
                                    @foreach ($aspects as $key => $label)
                                        @php
                                            $nilai = $assessmentData[$key] ?? 0;
                                            $total += $nilai;
                                            $kategori =
                                                $nilai == 4
                                                    ? 'Sangat Baik'
                                                    : ($nilai == 3
                                                        ? 'Baik'
                                                        : ($nilai == 2
                                                            ? 'Cukup'
                                                            : 'Kurang'));
                                            $badgeClass =
                                                $nilai == 4
                                                    ? 'badge-success'
                                                    : ($nilai == 3
                                                        ? 'badge-primary'
                                                        : ($nilai == 2
                                                            ? 'badge-warning'
                                                            : 'badge-danger'));
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $label }}</td>
                                            <td class="text-center fw-bold">{{ $nilai }}</td>
                                            <td class="text-center">
                                                <span class="badge {{ $badgeClass }}">{{ $kategori }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="fw-bold bg-light">
                                        <td colspan="2" class="text-end">TOTAL NILAI:</td>
                                        <td class="text-center fs-4 text-primary">{{ $total }}</td>
                                        <td class="text-center">
                                            @php
                                                $rataRata = $total / 5;
                                                $kategoriTotal =
                                                    $rataRata >= 3.5
                                                        ? 'Sangat Baik'
                                                        : ($rataRata >= 2.5
                                                            ? 'Baik'
                                                            : ($rataRata >= 1.5
                                                                ? 'Cukup'
                                                                : 'Kurang'));
                                                $badgeTotal =
                                                    $rataRata >= 3.5
                                                        ? 'badge-success'
                                                        : ($rataRata >= 2.5
                                                            ? 'badge-primary'
                                                            : ($rataRata >= 1.5
                                                                ? 'badge-warning'
                                                                : 'badge-danger'));
                                            @endphp
                                            <span class="badge {{ $badgeTotal }}">{{ $kategoriTotal }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @if (isset($assessmentData['catatan']))
                            <div class="mt-5">
                                <div class="fw-bold text-gray-800 mb-2">Catatan Tambahan:</div>
                                <div class="p-4 bg-light rounded">{{ $assessmentData['catatan'] }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <!--end::Instrumen Penilaian-->

            <!--begin::Lembar Observasi-->
            @if ($lembarObservasi)
                <div class="card mb-5">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ki-outline ki-eye text-info fs-2 me-2"></i>
                            Lembar Observasi Pembelajaran
                        </h3>
                    </div>
                    <div class="card-body">
                        @php
                            $observasiData = $lembarObservasi->assessment_data;
                        @endphp

                        <!--Kegiatan Pendahuluan-->
                        <div class="mb-6">
                            <h5 class="fw-bold text-gray-800 mb-3">1. Kegiatan Pendahuluan</h5>
                            @if (isset($observasiData['pendahuluan']))
                                @foreach ($observasiData['pendahuluan'] as $item)
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ki-outline ki-check-circle text-success fs-2 me-2"></i>
                                        <span>
                                            @if ($item == 'apersepsi')
                                                Melakukan apersepsi dengan baik
                                            @elseif($item == 'motivasi')
                                                Memberikan motivasi kepada siswa
                                            @else
                                                Menyampaikan tujuan pembelajaran
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!--Kegiatan Inti-->
                        <div class="mb-6">
                            <h5 class="fw-bold text-gray-800 mb-3">2. Kegiatan Inti</h5>
                            @if (isset($observasiData['inti']))
                                @foreach ($observasiData['inti'] as $item)
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ki-outline ki-check-circle text-success fs-2 me-2"></i>
                                        <span>
                                            @if ($item == 'materi_sistematis')
                                                Menyampaikan materi secara sistematis
                                            @elseif($item == 'siswa_aktif')
                                                Melibatkan siswa secara aktif
                                            @elseif($item == 'media_efektif')
                                                Menggunakan media pembelajaran dengan efektif
                                            @else
                                                Mengelola waktu dengan efisien
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!--Kegiatan Penutup-->
                        <div class="mb-6">
                            <h5 class="fw-bold text-gray-800 mb-3">3. Kegiatan Penutup</h5>
                            @if (isset($observasiData['penutup']))
                                @foreach ($observasiData['penutup'] as $item)
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ki-outline ki-check-circle text-success fs-2 me-2"></i>
                                        <span>
                                            @if ($item == 'kesimpulan')
                                                Membuat kesimpulan bersama siswa
                                            @elseif($item == 'evaluasi')
                                                Melakukan evaluasi pembelajaran
                                            @else
                                                Memberikan tindak lanjut
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        @if (isset($observasiData['catatan']))
                            <div class="mt-5">
                                <div class="fw-bold text-gray-800 mb-2">Catatan Observasi:</div>
                                <div class="p-4 bg-light rounded">{{ $observasiData['catatan'] }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <!--end::Lembar Observasi-->

            <!--begin::Catatan Hasil-->
            @if ($catatanHasil)
                <div class="card mb-5">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ki-outline ki-notepad text-warning fs-2 me-2"></i>
                            Catatan Hasil Supervisi
                        </h3>
                    </div>
                    <div class="card-body">
                        @php
                            $catatanData = $catatanHasil->assessment_data;
                        @endphp

                        <div class="mb-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ki-outline ki-like fs-2 text-success me-2"></i>
                                <h5 class="fw-bold text-gray-800 mb-0">Kekuatan/Keunggulan Pembelajaran</h5>
                            </div>
                            <div class="p-4 bg-light-success rounded">
                                {{ $catatanData['kekuatan'] ?? '-' }}
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ki-outline ki-information fs-2 text-warning me-2"></i>
                                <h5 class="fw-bold text-gray-800 mb-0">Kelemahan/Area yang Perlu Diperbaiki</h5>
                            </div>
                            <div class="p-4 bg-light-warning rounded">
                                {{ $catatanData['kelemahan'] ?? '-' }}
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ki-outline ki-message-text-2 fs-2 text-info me-2"></i>
                                <h5 class="fw-bold text-gray-800 mb-0">Saran Perbaikan</h5>
                            </div>
                            <div class="p-4 bg-light-info rounded">
                                {{ $catatanData['saran'] ?? '-' }}
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ki-outline ki-document fs-2 text-primary me-2"></i>
                                <h5 class="fw-bold text-gray-800 mb-0">Kesimpulan Umum</h5>
                            </div>
                            <div class="p-4 bg-light-primary rounded">
                                {{ $catatanData['kesimpulan'] ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <!--end::Catatan Hasil-->

            <!--begin::Feedback-->
            @if ($feedback)
                <div class="card mb-5">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ki-outline ki-message-text fs-2 text-success me-2"></i>
                            Feedback & Rekomendasi
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-6">
                            <h5 class="fw-bold text-gray-800 mb-3">Umpan Balik</h5>
                            <div class="p-5 bg-light-success rounded border border-success border-dashed">
                                <p class="text-gray-800 mb-0">{{ $feedback->feedback }}</p>
                            </div>
                        </div>

                        @if ($feedback->rekomendasi)
                            <div class="mb-6">
                                <h5 class="fw-bold text-gray-800 mb-3">Rekomendasi Tindak Lanjut</h5>
                                <div class="p-5 bg-light-primary rounded border border-primary border-dashed">
                                    <p class="text-gray-800 mb-0">{{ $feedback->rekomendasi }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="separator my-5"></div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted mb-1">Dinilai oleh:</div>
                                <div class="fw-bold text-gray-800">{{ $supervisi->supervisor->name }}</div>
                            </div>
                            <div class="text-end">
                                <div class="text-muted mb-1">Tanggal Penilaian:</div>
                                <div class="fw-bold text-gray-800">{{ $feedback->created_at->format('d F Y, H:i') }} WIB
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <!--end::Feedback-->

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
                border: 1px solid #ddd !important;
                page-break-inside: avoid;
            }
        }
    </style>
@endsection
