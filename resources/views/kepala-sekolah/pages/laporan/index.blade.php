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
                        Laporan Siswa Bermasalah</h1>
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
                        <li class="breadcrumb-item text-muted">Laporan Siswa Bermasalah</li>
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
            <!--begin::Alert messages-->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Ada kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <!--end::Alert messages-->

            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <h3>Daftar Laporan</h3>
                        </div>
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end gap-2">
                                <!-- Tombol Download PDF -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#downloadModal">
                                    <i class="ki-outline ki-file-down fs-2"></i>Download PDF
                                </button>
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    @if ($laporans->isEmpty())
                        <!--begin::Empty state-->
                        <div class="text-center py-15">
                            <div class="mb-4">
                                <i class="ki-outline ki-information fs-4x text-muted"></i>
                            </div>
                            <h4 class="fw-semibold text-gray-800 mb-2">Belum Ada Laporan</h4>
                            <p class="text-gray-600 mb-6">Tidak ada laporan siswa bermasalah saat ini</p>
                        </div>
                        <!--end::Empty state-->
                    @else
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-100px">Tanggal</th>
                                    <th class="min-w-120px">Guru</th>
                                    <th class="min-w-80px">Kelas</th>
                                    <th class="min-w-130px">Nama Siswa</th>
                                    <th class="min-w-150px">Keadaan Masalah</th>
                                    <th class="min-w-150px">Penanganan</th>
                                    <th class="min-w-150px">Keterangan</th>
                                    <th class="text-end min-w-70px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($laporans as $laporan)
                                    <tr>
                                        <td>{{ $laporan->created_at?->isoFormat('dddd, D MMMM YYYY') ?? '-' }}</td>
                                        <td>{{ $laporan->user->name }}</td>
                                        <td>{{ $laporan->kelas }}</td>
                                        <td>{{ $laporan->nama_siswa }}</td>
                                        <td>{{ Str::limit($laporan->keadaan_masalah, 50) }}</td>
                                        <td>{{ Str::limit($laporan->penanganan, 50) ?? '-' }}</td>
                                        <td>{{ Str::limit($laporan->keterangan, 50) ?? '-' }}</td>
                                        <td class="text-end">
                                            <button class="btn btn-light btn-active-light-primary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#laporanModal"
                                                onclick="editLaporan({{ $laporan->toJson() }}, '{{ $laporan->user->name }}')">
                                                Edit
                                            </button>
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

    <!--begin::Modal - Laporan Form-->
    <div class="modal fade" id="laporanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-750px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold" id="modalTitle">Edit Laporan</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="laporanForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <div class="mb-4">
                            <label class="form-label">Guru</label>
                            <input type="text" class="form-control" id="guruField" disabled>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Kelas</label>
                            <input type="text" class="form-control" id="kelasField" disabled>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Nama Siswa</label>
                            <input type="text" class="form-control" id="namaSiswaField" disabled>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Keadaan Masalah</label>
                            <textarea class="form-control" id="keadaanMasalahField" rows="3" disabled></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Penanganan</label>
                            <textarea class="form-control" name="penanganan" id="penangananField" rows="3"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="keteranganField" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal - Laporan Form-->

    <script>
        function editLaporan(laporan, guruName) {
            document.getElementById('modalTitle').textContent = 'Edit Laporan';
            document.getElementById('laporanForm').action = `/kepala-sekolah/laporan/${laporan.id}`;

            document.getElementById('guruField').value = guruName;
            document.getElementById('kelasField').value = laporan.kelas;
            document.getElementById('namaSiswaField').value = laporan.nama_siswa;
            document.getElementById('keadaanMasalahField').value = laporan.keadaan_masalah;
            document.getElementById('penangananField').value = laporan.penanganan || '';
            document.getElementById('keteranganField').value = laporan.keterangan || '';
        }

        // Reset modal saat ditutup
        document.getElementById('laporanModal').addEventListener('hide.bs.modal', function() {
            document.getElementById('laporanForm').reset();
        });
    </script>
@endsection
