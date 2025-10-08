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
                        Pengajuan Supervisi</h1>
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
                        <li class="breadcrumb-item text-muted">Pengajuan Supervisi</li>
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

            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h3>Daftar Pengajuan Supervisi</h3>
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#supervisiModal">
                                <i class="ki-outline ki-plus fs-2"></i>Ajukan Supervisi</button>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    @if ($supervisions->isEmpty())
                        <!--begin::Empty state-->
                        <div class="text-center py-15">
                            <div class="mb-4">
                                <i class="ki-outline ki-information fs-4x text-muted"></i>
                            </div>
                            <h4 class="fw-semibold text-gray-800 mb-2">Belum Ada Pengajuan</h4>
                            <p class="text-gray-600 mb-6">Mulai dengan mengajukan supervisi pertama Anda</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#supervisiModal">
                                <i class="ki-outline ki-plus fs-2"></i>Ajukan Supervisi
                            </button>
                        </div>
                        <!--end::Empty state-->
                    @else
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Tanggal</th>
                                    <th class="min-w-100px">Waktu</th>
                                    <th class="min-w-150px">Supervisor</th>
                                    <th class="min-w-100px">Mata Pelajaran</th>
                                    <th class="min-w-100px">Kelas</th>
                                    <th class="min-w-100px">Status</th>
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
                                        <td class="text-end">
                                            @if ($supervision->status == 'scheduled')
                                                <button class="btn btn-light btn-active-light-primary btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#supervisiModal"
                                                    onclick="editSupervisi({{ $supervision->toJson() }})">
                                                    Edit
                                                </button>
                                                <form action="{{ route('guru.supervisi.destroy', $supervision->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-light btn-active-light-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus?')">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('guru.supervisi.log') }}" class="btn btn-light btn-sm">
                                                    Lihat Detail
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--end::Table-->

                        <!--begin::Pagination-->
                        <div class="d-flex justify-content-end">
                            {{ $supervisions->links() }}
                        </div>
                        <!--end::Pagination-->
                    @endif
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!--begin::Modal - Supervisi Form-->
    <div class="modal fade" id="supervisiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-750px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold" id="modalTitle">Ajukan Supervisi</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="supervisiForm" method="POST" action="{{ route('guru.supervisi.store') }}">
                    @csrf
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <div class="alert alert-info d-flex align-items-center mb-5">
                            <i class="ki-outline ki-information fs-2x me-3"></i>
                            <div>
                                <strong>Info:</strong> Pengajuan supervisi akan ditujukan kepada Kepala Sekolah.
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label required">Tanggal</label>
                                <input type="date" class="form-control" name="schedule_date" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Waktu</label>
                                <input type="time" class="form-control" name="schedule_time">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label required">Mata Pelajaran</label>
                                <input type="text" class="form-control" name="mata_pelajaran" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Kelas</label>
                                <input type="text" class="form-control" name="kelas" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Catatan</label>
                            <textarea class="form-control" name="notes" rows="3"></textarea>
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
    <!--end::Modal - Supervisi Form-->

    <script>
        function editSupervisi(supervision) {
            document.getElementById('modalTitle').textContent = 'Edit Pengajuan Supervisi';
            document.getElementById('supervisiForm').action = `/guru/supervisi/${supervision.id}`;

            const tanggalFormatted = supervision.schedule_date.split('T')[0];

            document.getElementById('supervisiForm').innerHTML = `
                @csrf
                @method('PUT')
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="alert alert-info d-flex align-items-center mb-5">
                        <i class="ki-outline ki-information fs-2x me-3"></i>
                        <div>
                            <strong>Info:</strong> Supervisor tidak dapat diubah (${supervision.supervisor.name}).
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label required">Tanggal</label>
                            <input type="date" class="form-control" name="schedule_date" value="${tanggalFormatted}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Waktu</label>
                            <input type="time" class="form-control" name="schedule_time" value="${supervision.schedule_time || ''}">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label required">Mata Pelajaran</label>
                            <input type="text" class="form-control" name="mata_pelajaran" value="${supervision.mata_pelajaran}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Kelas</label>
                            <input type="text" class="form-control" name="kelas" value="${supervision.kelas}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" name="notes" rows="3">${supervision.notes || ''}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            `;
        }

        // Reset modal untuk tambah baru
        document.getElementById('supervisiModal').addEventListener('hide.bs.modal', function() {
            document.getElementById('modalTitle').textContent = 'Ajukan Supervisi';
            document.getElementById('supervisiForm').action = '{{ route('guru.supervisi.store') }}';
            document.getElementById('supervisiForm').reset();
        });
    </script>
@endsection
