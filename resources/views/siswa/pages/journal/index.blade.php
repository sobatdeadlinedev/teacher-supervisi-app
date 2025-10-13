@extends('siswa.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Jurnal Harian</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('siswa.dashboard.index') }}"
                                class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Jurnal Harian</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3>Daftar Jurnal</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end gap-2">
                            <!-- Dropdown untuk pilih tipe jurnal -->
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="ki-outline ki-plus fs-2"></i>Tambah Jurnal
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" data-journal-type="bangun_pagi"
                                            data-journal-title="Bangun Pagi">Bangun Pagi</a></li>
                                    <li><a class="dropdown-item" data-journal-type="beribadah"
                                            data-journal-title="Beribadah">Beribadah</a></li>
                                    <li><a class="dropdown-item" data-journal-type="olahraga"
                                            data-journal-title="Olahraga">Olahraga</a></li>
                                    <li><a class="dropdown-item" data-journal-type="makan_sehat"
                                            data-journal-title="Makan Sehat">Makan Sehat</a></li>
                                    <li><a class="dropdown-item" data-journal-type="belajar"
                                            data-journal-title="Gemar Belajar">Gemar Belajar</a></li>
                                    <li><a class="dropdown-item" data-journal-type="bermasyarakat"
                                            data-journal-title="Bermasyarakat">Bermasyarakat</a></li>
                                    <li><a class="dropdown-item" data-journal-type="tidur_cepat"
                                            data-journal-title="Tidur Cepat">Tidur Cepat</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    @if ($journals->isEmpty())
                        <div class="text-center py-15">
                            <div class="mb-4">
                                <i class="ki-outline ki-information fs-4x text-muted"></i>
                            </div>
                            <h4 class="fw-semibold text-gray-800 mb-2">Belum Ada Jurnal</h4>
                            <p class="text-gray-600 mb-6">Mulai dengan menambahkan jurnal pertama Anda</p>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="ki-outline ki-plus fs-2"></i>Tambah Jurnal Pertama
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"
                                            onclick="openJournalModal('bangun_pagi', 'Bangun Pagi')">Bangun Pagi</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="openJournalModal('beribadah', 'Beribadah')">Beribadah</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="openJournalModal('olahraga', 'Olahraga')">Olahraga</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="openJournalModal('makan_sehat', 'Makan Sehat')">Makan Sehat</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="openJournalModal('belajar', 'Gemar Belajar')">Gemar Belajar</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="openJournalModal('bermasyarakat', 'Bermasyarakat')">Bermasyarakat</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="openJournalModal('tidur_cepat', 'Tidur Cepat')">Tidur Cepat</a></li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Tanggal</th>
                                    <th class="min-w-150px">Tipe Jurnal</th>
                                    <th class="min-w-200px">Ringkasan</th>
                                    <th class="text-end min-w-100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($journals as $journal)
                                    <tr>
                                        <td>{{ $journal->journal_date->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge badge-light-info">
                                                {{ ucfirst(str_replace('_', ' ', $journal->journal_type)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $data = $journal->journal_data;
                                                $summary = '';

                                                switch ($journal->journal_type) {
                                                    case 'bangun_pagi':
                                                        $summary = 'Bangun pukul ' . ($data['bangun_pukul'] ?? '-');
                                                        break;
                                                    case 'beribadah':
                                                        $summary = implode(', ', $data['sholat_wajib'] ?? []);
                                                        break;
                                                    case 'olahraga':
                                                        $summary = $data['kegiatan_olahraga'] ?? '-';
                                                        break;
                                                    case 'makan_sehat':
                                                        $summary = $data['karbohidrat'] ?? '-';
                                                        break;
                                                    case 'belajar':
                                                        $summary = implode(', ', $data['kegiatan_belajar'] ?? []);
                                                        break;
                                                    case 'bermasyarakat':
                                                        $summary = $data['kegiatan_bermasyarakat'] ?? '-';
                                                        break;
                                                    case 'tidur_cepat':
                                                        $summary =
                                                            'Tidur malam pukul ' . ($data['tidur_malam_pukul'] ?? '-');
                                                        break;
                                                }
                                            @endphp
                                            {{ Str::limit($summary, 50) }}
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-light btn-active-light-primary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#jurnalModal"
                                                onclick="editJournal({{ $journal->toJson() }})">
                                                Edit
                                            </button>
                                            <form action="{{ route('siswa.journal.destroy', $journal->id) }}" method="POST"
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

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $journals->links() }}
                        </div>
                    @endif
                </div>
            </div>
            <!--end::Card-->
        </div>
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
                <form id="jurnalForm" method="POST" novalidate>
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    @csrf
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7" id="modalBody">
                        <!-- Konten akan di-load via JavaScript -->
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
        const journalForms = {
            'bangun_pagi': `
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No Absen</label>
                    <input type="text" class="form-control" name="no_absen" required>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Bangun Pukul</label>
                    <input type="time" class="form-control" name="bangun_pukul" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Aktivitas Setelah Bangun</label>
                <textarea class="form-control" name="aktivitas_setelah_bangun" rows="3" required></textarea>
            </div>
        `,
            'beribadah': `
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nama Siswa</label>
                    <input type="text" class="form-control" name="nama_siswa" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No Siswa</label>
                    <input type="text" class="form-control" name="student_number" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Tanggal</label>
                <input type="date" class="form-control" name="tanggal" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Sholat Wajib (Pilih minimal satu)</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sholat_wajib[]" value="Subuh" id="subuh">
                    <label class="form-check-label" for="subuh">Subuh</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sholat_wajib[]" value="Dzuhur" id="dzuhur">
                    <label class="form-check-label" for="dzuhur">Dzuhur</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sholat_wajib[]" value="Ashar" id="ashar">
                    <label class="form-check-label" for="ashar">Ashar</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sholat_wajib[]" value="Maghrib" id="maghrib">
                    <label class="form-check-label" for="maghrib">Maghrib</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sholat_wajib[]" value="Isya" id="isya">
                    <label class="form-check-label" for="isya">Isya</label>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Tadarus Al-Quran</label>
                <textarea class="form-control" name="tadarus_alquran" rows="2"></textarea>
            </div>
        `,
            'olahraga': `
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nama Anak</label>
                    <input type="text" class="form-control" name="nama_anak" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No Siswa</label>
                    <input type="text" class="form-control" name="student_number" required>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Kelas</label>
                    <input type="text" class="form-control" name="kelas" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Kegiatan Olahraga</label>
                <textarea class="form-control" name="kegiatan_olahraga" rows="3" required></textarea>
            </div>
        `,
            'makan_sehat': `
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No Absen</label>
                    <input type="text" class="form-control" name="no_absen" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Tanggal</label>
                <input type="date" class="form-control" name="tanggal" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Karbohidrat</label>
                <input type="text" class="form-control" name="karbohidrat" placeholder="Contoh: nasi, roti" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Protein</label>
                <input type="text" class="form-control" name="protein" placeholder="Contoh: telur, daging" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Serat & Vitamin</label>
                <input type="text" class="form-control" name="serat_vitamin" placeholder="Contoh: sayur, buah" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Minuman Sehat</label>
                <input type="text" class="form-control" name="minuman_sehat" placeholder="Contoh: air putih, susu" required>
            </div>
        `,
            'belajar': `
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No Absen</label>
                    <input type="text" class="form-control" name="no_absen" required>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Kegiatan Belajar (Pilih minimal satu)</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="kegiatan_belajar[]" value="Membaca Buku" id="membaca">
                    <label class="form-check-label" for="membaca">Membaca Buku</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="kegiatan_belajar[]" value="Menonton Video" id="menonton">
                    <label class="form-check-label" for="menonton">Menonton Video Edukasi</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="kegiatan_belajar[]" value="Mengerjakan Soal" id="soal">
                    <label class="form-check-label" for="soal">Mengerjakan Soal</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="kegiatan_belajar[]" value="Diskusi" id="diskusi">
                    <label class="form-check-label" for="diskusi">Diskusi</label>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Judul Buku/Video (Opsional)</label>
                <textarea class="form-control" name="judul_buku_video" rows="2"></textarea>
            </div>
        `,
            'bermasyarakat': `
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nama Anak</label>
                    <input type="text" class="form-control" name="nama_anak" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No Siswa</label>
                    <input type="text" class="form-control" name="student_number" required>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Kelas</label>
                    <input type="text" class="form-control" name="kelas" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Kegiatan Bermasyarakat</label>
                <textarea class="form-control" name="kegiatan_bermasyarakat" rows="3" required></textarea>
            </div>
        `,
            'tidur_cepat': `
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No Absen</label>
                    <input type="text" class="form-control" name="no_absen" required>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Tidur Siang (Opsional)</label>
                <input type="time" class="form-control" name="tidur_siang">
            </div>
            <div class="mb-4">
                <label class="form-label">Tidur Malam Pukul</label>
                <input type="time" class="form-control" name="tidur_malam_pukul" required>
            </div>
        `
        };

        function openJournalModal(type, title, event) {
            // Prevent default link behavior
            if (event) {
                event.preventDefault();
            }

            // Set judul modal
            document.getElementById('modalTitle').textContent = 'Tambah Jurnal - ' + title;

            // Set action dan method untuk CREATE
            const form = document.getElementById('jurnalForm');
            form.action = `/siswa/journal/${type}`;
            form.method = 'POST';

            // Hapus method PUT jika ada (untuk create baru)
            const methodInput = document.getElementById('formMethod');
            if (methodInput) {
                methodInput.remove();
            }

            // Load form HTML
            document.getElementById('modalBody').innerHTML = journalForms[type];

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('jurnalModal'));
            modal.show();
        }

        function editJournal(journal) {
            const typeTitle = journal.journal_type.replace(/_/g, ' ').split(' ').map(w => w.charAt(0).toUpperCase() + w
                .slice(1)).join(' ');

            // Set judul modal
            document.getElementById('modalTitle').textContent = 'Edit Jurnal - ' + typeTitle;

            // Set action dan method untuk UPDATE
            const form = document.getElementById('jurnalForm');
            form.action = `/siswa/journal/${journal.id}`;
            form.method = 'POST';

            // Tambahkan method spoofing untuk PUT
            let methodInput = document.getElementById('formMethod');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.id = 'formMethod';
                form.insertBefore(methodInput, form.firstChild);
            }
            methodInput.value = 'PUT';

            // Load form HTML berdasarkan tipe
            const data = journal.journal_data;
            const tanggal = journal.journal_date.split('T')[0];
            let formHTML = '';

            // Generate form berdasarkan journal type
            switch (journal.journal_type) {
                case 'bangun_pagi':
                    formHTML = `
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="${data.nama_lengkap || ''}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Absen</label>
                            <input type="text" class="form-control" name="no_absen" value="${data.no_absen || ''}" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" value="${tanggal}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bangun Pukul</label>
                            <input type="time" class="form-control" name="bangun_pukul" value="${data.bangun_pukul || ''}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Aktivitas Setelah Bangun</label>
                        <textarea class="form-control" name="aktivitas_setelah_bangun" rows="3" required>${data.aktivitas_setelah_bangun || ''}</textarea>
                    </div>
                `;
                    break;

                case 'beribadah':
                    const sholatWajib = data.sholat_wajib || [];
                    formHTML = `
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Siswa</label>
                            <input type="text" class="form-control" name="nama_siswa" value="${data.nama_siswa || ''}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Siswa</label>
                            <input type="text" class="form-control" name="student_number" value="${data.student_number || ''}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="${tanggal}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Sholat Wajib (Pilih minimal satu)</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sholat_wajib[]" value="Subuh" id="edit_subuh" ${sholatWajib.includes('Subuh') ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_subuh">Subuh</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sholat_wajib[]" value="Dzuhur" id="edit_dzuhur" ${sholatWajib.includes('Dzuhur') ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_dzuhur">Dzuhur</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sholat_wajib[]" value="Ashar" id="edit_ashar" ${sholatWajib.includes('Ashar') ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_ashar">Ashar</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sholat_wajib[]" value="Maghrib" id="edit_maghrib" ${sholatWajib.includes('Maghrib') ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_maghrib">Maghrib</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sholat_wajib[]" value="Isya" id="edit_isya" ${sholatWajib.includes('Isya') ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_isya">Isya</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Tadarus Al-Quran</label>
                        <textarea class="form-control" name="tadarus_alquran" rows="2">${data.tadarus_alquran || ''}</textarea>
                    </div>
                `;
                    break;

                case 'olahraga':
                    formHTML = `
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Anak</label>
                            <input type="text" class="form-control" name="nama_anak" value="${data.nama_anak || ''}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Siswa</label>
                            <input type="text" class="form-control" name="student_number" value="${data.student_number || ''}" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Kelas</label>
                            <input type="text" class="form-control" name="kelas" value="${data.kelas || ''}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" value="${tanggal}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Kegiatan Olahraga</label>
                        <textarea class="form-control" name="kegiatan_olahraga" rows="3" required>${data.kegiatan_olahraga || ''}</textarea>
                    </div>
                `;
                    break;

                case 'makan_sehat':
                    formHTML = `
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="${data.nama_lengkap || ''}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Absen</label>
                            <input type="text" class="form-control" name="no_absen" value="${data.no_absen || ''}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="${tanggal}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Karbohidrat</label>
                        <input type="text" class="form-control" name="karbohidrat" value="${data.karbohidrat || ''}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Protein</label>
                        <input type="text" class="form-control" name="protein" value="${data.protein || ''}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Serat & Vitamin</label>
                        <input type="text" class="form-control" name="serat_vitamin" value="${data.serat_vitamin || ''}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Minuman Sehat</label>
                        <input type="text" class="form-control" name="minuman_sehat" value="${data.minuman_sehat || ''}" required>
                    </div>
                `;
                    break;

                case 'belajar':
                    const kegiatanBelajar = data.kegiatan_belajar || [];
                    formHTML = `
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="${data.nama_lengkap || ''}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Absen</label>
                            <input type="text" class="form-control" name="no_absen" value="${data.no_absen || ''}" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" value="${tanggal}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Kegiatan Belajar (Pilih minimal satu)</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="kegiatan_belajar[]" value="Membaca Buku" id="edit_membaca" ${kegiatanBelajar.includes('Membaca Buku') ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_membaca">Membaca Buku</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="kegiatan_belajar[]" value="Menonton Video" id="edit_menonton" ${kegiatanBelajar.includes('Menonton Video') ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_menonton">Menonton Video Edukasi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="kegiatan_belajar[]" value="Mengerjakan Soal" id="edit_soal" ${kegiatanBelajar.includes('Mengerjakan Soal') ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_soal">Mengerjakan Soal</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="kegiatan_belajar[]" value="Diskusi" id="edit_diskusi" ${kegiatanBelajar.includes('Diskusi') ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_diskusi">Diskusi</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Judul Buku/Video (Opsional)</label>
                        <textarea class="form-control" name="judul_buku_video" rows="2">${data.judul_buku_video || ''}</textarea>
                    </div>
                `;
                    break;

                case 'bermasyarakat':
                    formHTML = `
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Anak</label>
                            <input type="text" class="form-control" name="nama_anak" value="${data.nama_anak || ''}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Siswa</label>
                            <input type="text" class="form-control" name="student_number" value="${data.student_number || ''}" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Kelas</label>
                            <input type="text" class="form-control" name="kelas" value="${data.kelas || ''}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" value="${tanggal}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Kegiatan Bermasyarakat</label>
                        <textarea class="form-control" name="kegiatan_bermasyarakat" rows="3" required>${data.kegiatan_bermasyarakat || ''}</textarea>
                    </div>
                `;
                    break;

                case 'tidur_cepat':
                    formHTML = `
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="${data.nama_lengkap || ''}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Absen</label>
                            <input type="text" class="form-control" name="no_absen" value="${data.no_absen || ''}" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" value="${tanggal}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Tidur Siang (Opsional)</label>
                        <input type="time" class="form-control" name="tidur_siang" value="${data.tidur_siang || ''}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Tidur Malam Pukul</label>
                        <input type="time" class="form-control" name="tidur_malam_pukul" value="${data.tidur_malam_pukul || ''}" required>
                    </div>
                `;
                    break;
            }

            document.getElementById('modalBody').innerHTML = formHTML;

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('jurnalModal'));
            modal.show();
        }

        // Reset modal saat ditutup
        document.getElementById('jurnalModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('modalTitle').textContent = 'Tambah Jurnal';
            document.getElementById('jurnalForm').reset();
            document.getElementById('modalBody').innerHTML = '';

            // Hapus method PUT jika ada
            const methodInput = document.getElementById('formMethod');
            if (methodInput) {
                methodInput.remove();
            }
        });

        // Event delegation untuk dropdown items
        document.addEventListener('click', function(e) {
            const target = e.target.closest('[data-journal-type]');
            if (target) {
                e.preventDefault();
                const type = target.getAttribute('data-journal-type');
                const title = target.getAttribute('data-journal-title');
                openJournalModal(type, title, e);
            }
        });
    </script>
@endsection
