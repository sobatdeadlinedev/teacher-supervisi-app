@extends('admin.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Manajemen User</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard.index') }}"
                                class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Manajemen User</li>
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

            <!--begin::Alert Validation-->
            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                    <i class="ki-outline ki-information fs-2hx text-danger me-4"></i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-danger">Validasi Error</h4>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <!--end::Alert Validation-->

            <!--begin::Card-->
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3>Daftar User</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#userModal">
                                <i class="ki-outline ki-plus fs-2"></i>Tambah User</button>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    @if ($users->isEmpty())
                        <div class="text-center py-15">
                            <div class="mb-4">
                                <i class="ki-outline ki-user fs-4x text-muted"></i>
                            </div>
                            <h4 class="fw-semibold text-gray-800 mb-2">Belum Ada User</h4>
                            <p class="text-gray-600 mb-6">Mulai dengan menambahkan user pertama Anda</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#userModal">
                                <i class="ki-outline ki-plus fs-2"></i>Tambah User Pertama
                            </button>
                        </div>
                    @else
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nama</th>
                                    <th class="min-w-200px">Email</th>
                                    <th class="min-w-125px">Role</th>
                                    <th class="min-w-125px">Tanggal Dibuat</th>
                                    <th class="text-end min-w-100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                    <div class="symbol-label">
                                                        <div class="symbol-label fs-3 bg-light-primary text-primary">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-800 mb-1">{{ $user->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->roles->first())
                                                <span
                                                    class="badge badge-light-info">{{ $user->roles->first()->name }}</span>
                                            @else
                                                <span class="badge badge-light-secondary">Tidak ada role</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-end">
                                            <button class="btn btn-light btn-active-light-primary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#userModal"
                                                onclick='editUser(@json($user))'>
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-active-light-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                    Hapus
                                                </button>
                                            </form>
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

    <!--begin::Modal - User Form-->
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold" id="modalTitle">Tambah User</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="userForm" method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <div class="mb-4">
                            <label class="form-label required">Nama</label>
                            <input type="text" class="form-control" name="name" id="user_name" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label required">Email</label>
                            <input type="email" class="form-control" name="email" id="user_email" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label required">Password</label>
                            <input type="password" class="form-control" name="password" id="passwordField" required>
                            <div class="form-text">Minimal 8 karakter</div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Role</label>
                            <div class="d-flex flex-column">
                                @foreach ($roles as $role)
                                    @if ($role->name !== 'admin')
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input role-radio" type="radio" name="role"
                                                value="{{ $role->name }}" id="role_{{ $role->id }}"
                                                onchange="toggleWaliKelasField()">
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Wali Kelas Field (Hidden by default) -->
                        <div class="mb-4" id="waliKelasField" style="display: none;">
                            <label class="form-label">Wali Kelas</label>
                            <select class="form-select" name="wali_kelas_id" id="wali_kelas_select">
                                <option value="">-- Pilih Wali Kelas --</option>
                                @foreach ($waliKelas as $wk)
                                    <option value="{{ $wk->id }}">{{ $wk->name }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Pilih guru sebagai wali kelas siswa ini</div>
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
    <!--end::Modal - User Form-->

    <script>
        // Toggle Wali Kelas field based on role selection
        function toggleWaliKelasField() {
            const selectedRole = document.querySelector('input[name="role"]:checked');
            const waliKelasField = document.getElementById('waliKelasField');

            if (selectedRole && selectedRole.value === 'siswa') {
                waliKelasField.style.display = 'block';
            } else {
                waliKelasField.style.display = 'none';
                document.getElementById('wali_kelas_select').value = '';
            }
        }

        function editUser(user) {
            console.log('Edit User:', user);

            document.getElementById('modalTitle').textContent = 'Edit User';
            document.getElementById('userForm').action = `/admin/users/${user.id}`;

            const userRole = user.roles && user.roles.length > 0 ? user.roles[0].name : '';
            const userWaliKelasId = user.wali_kelas && user.wali_kelas.length > 0 ? user.wali_kelas[0].id : null;

            // Build roles radio buttons with checked state
            let rolesHtml = '';
            @foreach ($roles as $role)
                @if ($role->name !== 'admin')
                    const isChecked{{ $role->id }} = userRole === '{{ $role->name }}' ? 'checked' : '';
                    rolesHtml += `
                        <div class="form-check form-check-custom form-check-solid mb-3">
                            <input class="form-check-input role-radio" type="radio" name="role" 
                                   value="{{ $role->name }}" id="role_{{ $role->id }}_edit" 
                                   ${isChecked{{ $role->id }}} onchange="toggleWaliKelasField()">
                            <label class="form-check-label" for="role_{{ $role->id }}_edit">
                                {{ $role->name }}
                            </label>
                        </div>
                    `;
                @endif
            @endforeach

            // Build wali kelas options
            let waliKelasOptions = '<option value="">-- Pilih Wali Kelas --</option>';
            @foreach ($waliKelas as $wk)
                const isSelected{{ $wk->id }} = userWaliKelasId === {{ $wk->id }} ? 'selected' : '';
                waliKelasOptions +=
                    `<option value="{{ $wk->id }}" ${isSelected{{ $wk->id }}}>{{ $wk->name }}</option>`;
            @endforeach

            const showWaliKelas = userRole === 'siswa' ? 'block' : 'none';

            document.getElementById('userForm').innerHTML = `
                @csrf
                @method('PUT')
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="mb-4">
                        <label class="form-label required">Nama</label>
                        <input type="text" class="form-control" name="name" value="${user.name}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label required">Email</label>
                        <input type="email" class="form-control" name="email" value="${user.email}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password">
                        <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Role</label>
                        <div class="d-flex flex-column">
                            ${rolesHtml}
                        </div>
                    </div>
                    <div class="mb-4" id="waliKelasField" style="display: ${showWaliKelas};">
                        <label class="form-label">Wali Kelas</label>
                        <select class="form-select" name="wali_kelas_id" id="wali_kelas_select">
                            ${waliKelasOptions}
                        </select>
                        <div class="form-text">Pilih guru sebagai wali kelas siswa ini</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            `;
        }

        // Reset modal untuk tambah user baru
        document.getElementById('userModal').addEventListener('hide.bs.modal', function() {
            document.getElementById('modalTitle').textContent = 'Tambah User';
            document.getElementById('userForm').action = '{{ route('admin.users.store') }}';

            // Reset form
            const form = document.getElementById('userForm');
            form.innerHTML = `
                @csrf
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="mb-4">
                        <label class="form-label required">Nama</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label required">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label required">Password</label>
                        <input type="password" class="form-control" name="password" required>
                        <div class="form-text">Minimal 8 karakter</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Role</label>
                        <div class="d-flex flex-column">
                            @foreach ($roles as $role)
                                @if ($role->name !== 'admin')
                                <div class="form-check form-check-custom form-check-solid mb-3">
                                    <input class="form-check-input role-radio" type="radio" name="role" 
                                           value="{{ $role->name }}" id="role_{{ $role->id }}"
                                           onchange="toggleWaliKelasField()">
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-4" id="waliKelasField" style="display: none;">
                        <label class="form-label">Wali Kelas</label>
                        <select class="form-select" name="wali_kelas_id" id="wali_kelas_select">
                            <option value="">-- Pilih Wali Kelas --</option>
                            @foreach ($waliKelas as $wk)
                                <option value="{{ $wk->id }}">{{ $wk->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Pilih guru sebagai wali kelas siswa ini</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            `;
        });
    </script>
@endsection
