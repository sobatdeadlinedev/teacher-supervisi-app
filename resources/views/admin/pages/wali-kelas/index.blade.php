@extends('admin.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Pengaturan Wali Kelas</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard.index') }}"
                                class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Pengaturan Wali Kelas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Alert Success-->
            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                    <i class="ki-outline ki-shield-tick fs-2hx text-success me-4"></i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-success">Berhasil</h4>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            <!--end::Alert Success-->

            <!--begin::Alert Error-->
            @if (session('error'))
                <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                    <i class="ki-outline ki-information fs-2hx text-danger me-4"></i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-danger">Error</h4>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif
            <!--end::Alert Error-->

            <!--begin::Card-->
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3>Mapping Siswa & Wali Kelas</h3>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#bulkAssignModal">
                            <i class="ki-outline ki-plus fs-2"></i>Bulk Assign
                        </button>
                    </div>
                </div>

                <div class="card-body pt-0">
                    @if ($siswa->isEmpty())
                        <div class="text-center py-15">
                            <div class="mb-4">
                                <i class="ki-outline ki-profile-user fs-4x text-muted"></i>
                            </div>
                            <h4 class="fw-semibold text-gray-800 mb-2">Belum Ada Siswa</h4>
                            <p class="text-gray-600 mb-6">Tambahkan siswa terlebih dahulu di menu User Management</p>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                                <i class="ki-outline ki-plus fs-2"></i>Ke User Management
                            </a>
                        </div>
                    @else
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_wali_kelas">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                        </div>
                                    </th>
                                    <th class="min-w-200px">Nama Siswa</th>
                                    <th class="min-w-200px">Email</th>
                                    <th class="min-w-200px">Wali Kelas</th>
                                    <th class="text-end min-w-100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($siswa as $s)
                                    <tr>
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input siswa-checkbox" type="checkbox"
                                                    value="{{ $s->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                    <div class="symbol-label fs-3 bg-light-primary text-primary">
                                                        {{ strtoupper(substr($s->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-800 mb-1">{{ $s->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $s->email }}</td>
                                        <td>
                                            @if ($s->waliKelas->first())
                                                <span class="badge badge-light-success fs-7">
                                                    {{ $s->waliKelas->first()->name }}
                                                </span>
                                            @else
                                                <span class="badge badge-light-warning fs-7">Belum Ada</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-light btn-active-light-primary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#assignModal"
                                                onclick="setSiswaId({{ $s->id }}, '{{ $s->name }}', {{ $s->waliKelas->first() ? $s->waliKelas->first()->id : 'null' }})">
                                                {{ $s->waliKelas->first() ? 'Ubah' : 'Tugaskan' }}
                                            </button>
                                            @if ($s->waliKelas->first())
                                                <form action="{{ route('admin.wali-kelas.remove', $s->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-light btn-active-light-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus wali kelas?')">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Content-->

    <!--begin::Modal - Assign Single-->
    <div class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-550px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Tugaskan Wali Kelas</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.wali-kelas.assign') }}" method="POST">
                    @csrf
                    <input type="hidden" name="siswa_id" id="siswa_id">
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nama Siswa</label>
                            <input type="text" class="form-control" id="siswa_name" readonly>
                        </div>
                        <div class="mb-4">
                            <label class="form-label required fw-bold">Pilih Wali Kelas</label>
                            <select class="form-select" name="wali_kelas_id" id="wali_kelas_select" required>
                                <option value="">-- Pilih Wali Kelas --</option>
                                @foreach ($waliKelas as $wk)
                                    <option value="{{ $wk->id }}">{{ $wk->name }}</option>
                                @endforeach
                            </select>
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
    <!--end::Modal - Assign Single-->

    <!--begin::Modal - Bulk Assign-->
    <div class="modal fade" id="bulkAssignModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-550px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Bulk Assign Wali Kelas</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.wali-kelas.bulk-assign') }}" method="POST" id="bulkAssignForm">
                    @csrf
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Jumlah Siswa Dipilih</label>
                            <div class="alert alert-info d-flex align-items-center p-3">
                                <i class="ki-outline ki-information-5 fs-2x me-3"></i>
                                <span><strong id="selectedCount">0</strong> siswa dipilih</span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label required fw-bold">Pilih Wali Kelas</label>
                            <select class="form-select" name="wali_kelas_id" required>
                                <option value="">-- Pilih Wali Kelas --</option>
                                @foreach ($waliKelas as $wk)
                                    <option value="{{ $wk->id }}">{{ $wk->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Assign Semua</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal - Bulk Assign-->

    <script>
        function setSiswaId(id, name, currentWaliKelasId) {
            document.getElementById('siswa_id').value = id;
            document.getElementById('siswa_name').value = name;

            // Set selected wali kelas if exists
            const select = document.getElementById('wali_kelas_select');
            if (currentWaliKelasId) {
                select.value = currentWaliKelasId;
            } else {
                select.value = '';
            }
        }

        // Check all functionality
        document.getElementById('checkAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.siswa-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateSelectedCount();
        });

        // Update count when individual checkbox changes
        document.querySelectorAll('.siswa-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });

        function updateSelectedCount() {
            const checked = document.querySelectorAll('.siswa-checkbox:checked').length;
            document.getElementById('selectedCount').textContent = checked;
        }

        // Handle bulk assign form submission
        document.getElementById('bulkAssignForm').addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.siswa-checkbox:checked');

            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Pilih minimal 1 siswa terlebih dahulu!');
                return false;
            }

            // Add hidden inputs for selected siswa IDs
            checkedBoxes.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'siswa_ids[]';
                input.value = cb.value;
                this.appendChild(input);
            });
        });

        // Reset modal on close
        document.getElementById('assignModal').addEventListener('hide.bs.modal', function() {
            document.getElementById('siswa_id').value = '';
            document.getElementById('siswa_name').value = '';
            document.getElementById('wali_kelas_select').value = '';
        });
    </script>
@endsection
