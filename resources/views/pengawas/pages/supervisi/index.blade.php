@extends('pengawas.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Daftar Supervisi
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('pengawas.dashboard.index') }}"
                                class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Supervisi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
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

            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3>Supervisi Pembelajaran</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end gap-2">
                            <select class="form-select form-select-sm w-150px" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="scheduled">Dijadwalkan</option>
                                <option value="completed">Selesai</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </div>
                    </div>
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
                            <h4 class="fw-semibold text-gray-800 mb-2">Belum Ada Supervisi</h4>
                            <p class="text-gray-600 mb-6">Belum ada pengajuan supervisi dari guru</p>
                        </div>
                        <!--end::Empty state-->
                    @else
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="supervisiTable">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-150px">Guru</th>
                                    <th class="min-w-125px">Tanggal</th>
                                    <th class="min-w-100px">Waktu</th>
                                    <th class="min-w-125px">Mata Pelajaran</th>
                                    <th class="min-w-100px">Kelas</th>
                                    <th class="min-w-100px">Status</th>
                                    <th class="text-end min-w-100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($supervisions as $supervision)
                                    <tr data-status="{{ $supervision->status }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-45px me-3">
                                                    <div class="symbol-label bg-light-primary text-primary fw-bold">
                                                        {{ strtoupper(substr($supervision->guru->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span
                                                        class="text-gray-800 fw-bold">{{ $supervision->guru->name }}</span>
                                                    <span class="text-muted fs-7">{{ $supervision->guru->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $supervision->schedule_date->format('d/m/Y') }}</td>
                                        <td>{{ $supervision->schedule_time ?? '-' }}</td>
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
                                            <a href="{{ route('pengawas.supervisi.show', $supervision->id) }}"
                                                class="btn btn-sm btn-light-primary">
                                                <i class="ki-outline ki-eye fs-4"></i>
                                                Lihat Detail
                                            </a>
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
    </div>
    <!--end::Content-->

    <script>
        // Filter by status
        document.getElementById('filterStatus').addEventListener('change', function() {
            const selectedStatus = this.value;
            const rows = document.querySelectorAll('#supervisiTable tbody tr');

            rows.forEach(row => {
                if (selectedStatus === '' || row.dataset.status === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
