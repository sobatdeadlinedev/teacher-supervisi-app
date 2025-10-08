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
                        Jurnal Mengajar</h1>
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
                        <li class="breadcrumb-item text-muted">Jurnal Mengajar</li>
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
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h3>Daftar Jurnal</h3>
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#jurnalModal">
                                <i class="ki-outline ki-plus fs-2"></i>Tambah Jurnal</button>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    @if ($jurnals->isEmpty())
                        <!--begin::Empty state-->
                        <div class="text-center py-15">
                            <div class="mb-4">
                                <i class="ki-outline ki-information fs-4x text-muted"></i>
                            </div>
                            <h4 class="fw-semibold text-gray-800 mb-2">Belum Ada Jurnal</h4>
                            <p class="text-gray-600 mb-6">Mulai dengan menambahkan jurnal mengajar pertama Anda</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#jurnalModal">
                                <i class="ki-outline ki-plus fs-2"></i>Tambah Jurnal Pertama
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
                                    <th class="min-w-125px">Jam Ke</th>
                                    <th class="min-w-200px">Materi</th>
                                    <th class="min-w-200px">Kegiatan Pembelajaran</th>
                                    <th class="min-w-100px">H/S/I/A</th>
                                    <th class="text-end min-w-70px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($jurnals as $jurnal)
                                    <tr>
                                        <td>{{ $jurnal->hari_tanggal->format('d/m/Y') }}</td>
                                        <td>{{ $jurnal->kelas }}</td>
                                        <td>{{ $jurnal->jam_ke }}</td>
                                        <td>{{ Str::limit($jurnal->materi_pokok, 50) }}</td>
                                        <td>{{ Str::limit($jurnal->kegiatan_pembelajaran, 50) }}</td>
                                        <td>
                                            <span class="badge badge-light-primary">
                                                {{ $jurnal->kehadiran_peserta_didik['H'] }}/{{ $jurnal->kehadiran_peserta_didik['S'] }}/{{ $jurnal->kehadiran_peserta_didik['I'] }}/{{ $jurnal->kehadiran_peserta_didik['A'] }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-light btn-active-light-primary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#jurnalModal"
                                                onclick="editJurnal({{ $jurnal->toJson() }})">
                                                Edit
                                            </button>
                                            <form action="{{ route('guru.jurnal.destroy', $jurnal->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-active-light-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus?')">
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

    <!--begin::Modal - Jurnal Form-->
    <div class="modal fade" id="jurnalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-750px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold" id="modalTitle">Tambah Jurnal</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="jurnalForm" method="POST" action="{{ route('guru.jurnal.store') }}">
                    @csrf
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="hari_tanggal" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kelas</label>
                                <input type="text" class="form-control" name="kelas" required>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Jam Ke</label>
                                <input type="text" class="form-control" name="jam_ke" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Materi Pokok</label>
                            <textarea class="form-control" name="materi_pokok" rows="2" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Kegiatan Pembelajaran</label>
                            <textarea class="form-control" name="kegiatan_pembelajaran" rows="2" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Penilaian Pembelajaran</label>
                            <textarea class="form-control" name="penilaian_pembelajaran" rows="2" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Hadir (H)</label>
                                <input type="number" class="form-control" name="hadir" value="0" min="0"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Sakit (S)</label>
                                <input type="number" class="form-control" name="sakit" value="0" min="0"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Izin (I)</label>
                                <input type="number" class="form-control" name="izin" value="0" min="0"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Alfa (A)</label>
                                <input type="number" class="form-control" name="alfa" value="0" min="0"
                                    required>
                            </div>
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
    <!--end::Modal - Jurnal Form-->

    <script>
        function editJurnal(jurnal) {
            document.getElementById('modalTitle').textContent = 'Edit Jurnal';
            document.getElementById('jurnalForm').action = `/guru/jurnal/${jurnal.id}`;

            // Format tanggal dari YYYY-MM-DD
            const tanggalFormatted = jurnal.hari_tanggal.split('T')[0];

            document.getElementById('jurnalForm').innerHTML = `
                @csrf
                @method('PUT')
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="hari_tanggal" value="${tanggalFormatted}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kelas</label>
                            <input type="text" class="form-control" name="kelas" value="${jurnal.kelas}" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Jam Ke</label>
                            <input type="text" class="form-control" name="jam_ke" value="${jurnal.jam_ke}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Materi Pokok</label>
                        <textarea class="form-control" name="materi_pokok" rows="2" required>${jurnal.materi_pokok}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Kegiatan Pembelajaran</label>
                        <textarea class="form-control" name="kegiatan_pembelajaran" rows="2" required>${jurnal.kegiatan_pembelajaran}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Penilaian Pembelajaran</label>
                        <textarea class="form-control" name="penilaian_pembelajaran" rows="2" required>${jurnal.penilaian_pembelajaran}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Hadir (H)</label>
                            <input type="number" class="form-control" name="hadir" value="${jurnal.kehadiran_peserta_didik.H}" min="0" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sakit (S)</label>
                            <input type="number" class="form-control" name="sakit" value="${jurnal.kehadiran_peserta_didik.S}" min="0" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Izin (I)</label>
                            <input type="number" class="form-control" name="izin" value="${jurnal.kehadiran_peserta_didik.I}" min="0" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Alfa (A)</label>
                            <input type="number" class="form-control" name="alfa" value="${jurnal.kehadiran_peserta_didik.A}" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            `;
        }

        // Reset modal untuk tambah jurnal baru
        document.getElementById('jurnalModal').addEventListener('hide.bs.modal', function() {
            document.getElementById('modalTitle').textContent = 'Tambah Jurnal';
            document.getElementById('jurnalForm').action = '{{ route('guru.jurnal.store') }}';
            document.getElementById('jurnalForm').reset();
        });
    </script>
@endsection
