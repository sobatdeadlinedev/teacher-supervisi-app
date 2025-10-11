@extends('guru.layouts.app')
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
                            <a href="{{ route('guru.dashboard.index') }}" class="text-muted text-hover-primary">Dashboard</a>
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
                    <div class="card-title">
                        <h3>Daftar Laporan</h3>
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end gap-2">
                            <!-- Tombol Download PDF -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#downloadModal">
                                <i class="ki-outline ki-file-down fs-2"></i>Download PDF
                            </button>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#laporanModal" onclick="resetForm()">
                                <i class="ki-outline ki-plus fs-2"></i>Tambah Laporan
                            </button>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
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
                            <p class="text-gray-600 mb-6">Mulai dengan menambahkan laporan siswa bermasalah pertama Anda</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#laporanModal" onclick="resetForm()">
                                <i class="ki-outline ki-plus fs-2"></i>Tambah Laporan Pertama
                            </button>
                        </div>
                        <!--end::Empty state-->
                    @else
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Tanggal</th>
                                    <th class="min-w-125px">Kelas</th>
                                    <th class="min-w-150px">Nama Siswa</th>
                                    <th class="min-w-200px">Keadaan Masalah</th>
                                    <th class="min-w-200px">Penanganan</th>
                                    <th class="min-w-200px">Keterangan</th>
                                    <th class="text-end min-w-70px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($laporans as $laporan)
                                    <tr>
                                        <td>{{ $laporan->created_at?->isoFormat('dddd, D MMMM YYYY') ?? '-' }}</td>
                                        <td>{{ $laporan->kelas }}</td>
                                        <td>{{ $laporan->nama_siswa }}</td>
                                        <td>{{ Str::limit($laporan->keadaan_masalah, 50) }}</td>
                                        <td>{{ Str::limit($laporan->penanganan, 50) ?? '-' }}</td>
                                        <td>{{ Str::limit($laporan->keterangan, 50) ?? '-' }}</td>
                                        <td class="text-end">
                                            <button class="btn btn-light btn-active-light-primary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#laporanModal"
                                                onclick="editLaporan({{ $laporan->toJson() }})">
                                                Edit
                                            </button>
                                            <form action="{{ route('guru.laporan.destroy', $laporan->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-active-light-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                                                    Hapus
                                                </button>
                                            </form>
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
                    <h2 class="fw-bold" id="modalTitle">Tambah Laporan</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="laporanForm" method="POST" action="{{ route('guru.laporan.store') }}">
                    @csrf
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Kelas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="kelas" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_siswa" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Keadaan Masalah <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="keadaan_masalah" rows="3" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Penanganan</label>
                            <textarea class="form-control" name="penanganan" rows="3"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="3"></textarea>
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
    <!--begin::Modal - Download PDF-->
    <div class="modal fade" id="downloadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-500px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Download Laporan PDF</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('guru.laporan.download-pdf') }}" method="GET">
                    <div class="modal-body mx-5 my-7">
                        <div class="mb-4">
                            <label class="form-label">Pilih Bulan</label>
                            <select class="form-select" name="month" required>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->locale('id')->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Pilih Tahun</label>
                            <select class="form-select" name="year" required>
                                @for ($y = now()->year; $y >= now()->year - 5; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="ki-outline ki-file-down"></i>Download
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal - Download PDF-->
    <script>
        function editLaporan(laporan) {
            document.getElementById('modalTitle').textContent = 'Edit Laporan';
            document.getElementById('laporanForm').action = `/guru/laporan/${laporan.id}`;

            document.getElementById('laporanForm').innerHTML = `
                @csrf
                @method('PUT')
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kelas" value="${laporan.kelas}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_siswa" value="${laporan.nama_siswa}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Keadaan Masalah <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="keadaan_masalah" rows="3" required>${laporan.keadaan_masalah}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Penanganan</label>
                        <textarea class="form-control" name="penanganan" rows="3">${laporan.penanganan || ''}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3">${laporan.keterangan || ''}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            `;
        }

        function resetForm() {
            document.getElementById('modalTitle').textContent = 'Tambah Laporan';
            document.getElementById('laporanForm').action = '{{ route('guru.laporan.store') }}';
            document.getElementById('laporanForm').reset();
        }

        // Reset modal saat ditutup
        document.getElementById('laporanModal').addEventListener('hide.bs.modal', function() {
            resetForm();
        });
    </script>
@endsection
