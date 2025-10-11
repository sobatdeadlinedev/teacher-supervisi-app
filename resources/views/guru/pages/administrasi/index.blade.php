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
                        Administrasi Pembelajaran</h1>
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
                        <li class="breadcrumb-item text-muted">Administrasi Pembelajaran</li>
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
                        <h3>Daftar File Administrasi</h3>
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#administrasiModal">
                                <i class="ki-outline ki-plus fs-2"></i>Upload File</button>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    @if ($files->isEmpty())
                        <!--begin::Empty state-->
                        <div class="text-center py-15">
                            <div class="mb-4">
                                <i class="ki-outline ki-information fs-4x text-muted"></i>
                            </div>
                            <h4 class="fw-semibold text-gray-800 mb-2">Belum Ada File</h4>
                            <p class="text-gray-600 mb-6">Mulai dengan mengunggah file administrasi pembelajaran Anda</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#administrasiModal">
                                <i class="ki-outline ki-plus fs-2"></i>Upload File Pertama
                            </button>
                        </div>
                        <!--end::Empty state-->
                    @else
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Tipe File</th>
                                    <th class="min-w-125px">Mata Pelajaran</th>
                                    <th class="min-w-100px">Kelas</th>
                                    <th class="min-w-100px">Semester</th>
                                    <th class="min-w-150px">Nama File</th>
                                    <th class="min-w-150px">Status</th>
                                    <th class="text-end min-w-100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($files as $file)
                                    <tr>
                                        <td>{{ $file->file_type }}</td>
                                        <td>{{ $file->mata_pelajaran }}</td>
                                        <td>{{ $file->kelas }}</td>
                                        <td>{{ $file->semester }}</td>
                                        <td>{{ Str::limit($file->original_filename, 30) }}</td>
                                        <td>
                                            @if ($file->status === 'waiting_approve')
                                                <span class="badge badge-light-warning">Menunggu Persetujuan</span>
                                            @elseif ($file->status === 'approved')
                                                <span class="badge badge-light-success">Disetujui</span>
                                            @elseif ($file->status === 'revision')
                                                <span class="badge badge-light-danger">Perlu Revisi</span>
                                            @else
                                                <span class="badge badge-light-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if ($file->status === 'waiting_approve' || $file->status === 'revision')
                                                <button class="btn btn-light btn-active-light-primary btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#administrasiModal"
                                                    onclick="editFile({{ $file->toJson() }})">
                                                    Edit
                                                </button>
                                                <form action="{{ route('guru.administrasi.destroy', $file->id) }}"
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
                                                <span class="text-muted text-sm">Tidak dapat diubah</span>
                                            @endif
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

    <!--begin::Modal - Upload File-->
    <div class="modal fade" id="administrasiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-750px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold" id="modalTitle">Upload File</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="administrasiForm" method="POST" action="{{ route('guru.administrasi.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <!-- Feedback Alert (hidden by default) -->
                        <div id="feedbackAlert" class="alert alert-warning mb-4" style="display:none;">
                            <div class="alert-icon"><i class="ki-outline ki-information fs-1"></i></div>
                            <div class="alert-text">
                                <h5>Feedback dari Reviewer</h5>
                                <p id="feedbackText" class="mb-0"></p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Tipe File</label>
                                <select class="form-select form-select-solid" name="file_type" required>
                                    <option value="">Pilih Tipe File</option>
                                    <option value="RPP">RPP</option>
                                    <option value="Silabus">Silabus</option>
                                    <option value="Prota">Prota</option>
                                    <option value="Promes">Promes</option>
                                    <option value="Kontrak Pembelajaran">Kontrak Pembelajaran</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mata Pelajaran</label>
                                <input type="text" class="form-control" name="mata_pelajaran" required>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Kelas</label>
                                <input type="text" class="form-control" name="kelas" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Semester</label>
                                <select class="form-select form-select-solid" name="semester" required>
                                    <option value="">Pilih Semester</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tahun Ajaran</label>
                                <input type="number" class="form-control" name="tahun_ajaran"
                                    value="{{ date('Y') }}" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="2" placeholder="(Opsional)"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">File (PDF, Doc, Excel, PowerPoint)</label>
                            <input type="file" class="form-control" name="file"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" required>
                            <small class="text-muted d-block mt-2">Maksimal ukuran file: 10 MB</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal - Upload File-->

    <script>
        function editFile(file) {
            document.getElementById('modalTitle').textContent = 'Edit File';
            document.getElementById('administrasiForm').action = `/guru/administrasi/${file.id}`;

            const fileRequired = file.status === 'revision' ? 'required' : '';

            document.getElementById('administrasiForm').innerHTML = `
                @csrf
                @method('PUT')
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    ${file.status === 'revision' && file.feedback ? `
                            <div class="alert alert-warning mb-4">
                                <div class="alert-icon"><i class="ki-outline ki-information fs-1"></i></div>
                                <div class="alert-text">
                                    <h5>Feedback dari Reviewer</h5>
                                    <p class="mb-0">${file.feedback}</p>
                                </div>
                            </div>
                        ` : ''}

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Tipe File</label>
                            <select class="form-select form-select-solid" name="file_type" required>
                                <option value="RPP" ${file.file_type === 'RPP' ? 'selected' : ''}>RPP</option>
                                <option value="Silabus" ${file.file_type === 'Silabus' ? 'selected' : ''}>Silabus</option>
                                <option value="Prota" ${file.file_type === 'Prota' ? 'selected' : ''}>Prota</option>
                                <option value="Promes" ${file.file_type === 'Promes' ? 'selected' : ''}>Promes</option>
                                <option value="Kontrak Pembelajaran" ${file.file_type === 'Kontrak Pembelajaran' ? 'selected' : ''}>Kontrak Pembelajaran</option>
                                <option value="Lainnya" ${file.file_type === 'Lainnya' ? 'selected' : ''}>Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mata Pelajaran</label>
                            <input type="text" class="form-control" name="mata_pelajaran" value="${file.mata_pelajaran}" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Kelas</label>
                            <input type="text" class="form-control" name="kelas" value="${file.kelas}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Semester</label>
                            <select class="form-select form-select-solid" name="semester" required>
                                <option value="1" ${file.semester === '1' || file.semester === 1 ? 'selected' : ''}>1</option>
                                <option value="2" ${file.semester === '2' || file.semester === 2 ? 'selected' : ''}>2</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tahun Ajaran</label>
                            <input type="number" class="form-control" name="tahun_ajaran" value="${file.tahun_ajaran}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="2">${file.description || ''}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">File Saat Ini</label>
                        <p class="text-muted">${file.original_filename}</p>
                        <label class="form-label mt-3">Ganti File ${file.status === 'revision' ? '(Wajib)' : '(Opsional)'}</label>
                        <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" ${fileRequired}>
                        <small class="text-muted d-block mt-2">${file.status === 'revision' ? 'File harus diganti untuk memproses revisi' : 'Biarkan kosong jika tidak ingin mengganti file'}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            `;
        }

        // Reset modal untuk upload file baru
        document.getElementById('administrasiModal').addEventListener('hide.bs.modal', function() {
            document.getElementById('modalTitle').textContent = 'Upload File';
            document.getElementById('administrasiForm').action = '{{ route('guru.administrasi.store') }}';
            document.getElementById('administrasiForm').reset();
            document.getElementById('feedbackAlert').style.display = 'none';
        });
    </script>
@endsection
