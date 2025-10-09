@extends('kepala-sekolah.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Penilaian Supervisi
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
                        <li class="breadcrumb-item text-muted">Penilaian</li>
                    </ul>
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-gray-600 mb-1">Guru:</label>
                                <div class="text-gray-800 fw-semibold fs-5">{{ $supervisi->guru->name }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-gray-600 mb-1">Mata Pelajaran:</label>
                                <div class="text-gray-800">{{ $supervisi->mata_pelajaran }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-gray-600 mb-1">Tanggal & Waktu:</label>
                                <div class="text-gray-800">
                                    {{ $supervisi->schedule_date->format('d F Y') }}
                                    @if ($supervisi->schedule_time)
                                        - {{ $supervisi->schedule_time }}
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-gray-600 mb-1">Kelas:</label>
                                <div class="text-gray-800">{{ $supervisi->kelas }}</div>
                            </div>
                        </div>
                        @if ($supervisi->notes)
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="fw-bold text-gray-600 mb-1">Catatan:</label>
                                    <div class="text-gray-800">{{ $supervisi->notes }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!--end::Info Card-->

            <!--begin::Stepper-->
            <div class="card">
                <div class="card-body">
                    <!--begin::Stepper-->
                    <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid gap-10"
                        id="kt_stepper">
                        <!--begin::Aside-->
                        <div
                            class="card d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px w-xxl-400px">
                            <!--begin::Wrapper-->
                            <div class="card-body px-6 px-lg-10 px-xxl-15 py-20">
                                <!--begin::Nav-->
                                <div class="stepper-nav">
                                    <!--begin::Step 1-->
                                    <div class="stepper-item current" data-kt-stepper-element="nav">
                                        <div class="stepper-wrapper">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">1</span>
                                            </div>
                                            <div class="stepper-label">
                                                <h3 class="stepper-title">Instrumen Penilaian</h3>
                                                <div class="stepper-desc fw-semibold">Penilaian Kinerja Guru</div>
                                            </div>
                                        </div>
                                        <div class="stepper-line h-40px"></div>
                                    </div>
                                    <!--end::Step 1-->

                                    <!--begin::Step 2-->
                                    <div class="stepper-item" data-kt-stepper-element="nav">
                                        <div class="stepper-wrapper">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">2</span>
                                            </div>
                                            <div class="stepper-label">
                                                <h3 class="stepper-title">Lembar Observasi</h3>
                                                <div class="stepper-desc fw-semibold">Observasi Pembelajaran</div>
                                            </div>
                                        </div>
                                        <div class="stepper-line h-40px"></div>
                                    </div>
                                    <!--end::Step 2-->

                                    <!--begin::Step 3-->
                                    <div class="stepper-item" data-kt-stepper-element="nav">
                                        <div class="stepper-wrapper">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">3</span>
                                            </div>
                                            <div class="stepper-label">
                                                <h3 class="stepper-title">Catatan Hasil</h3>
                                                <div class="stepper-desc fw-semibold">Dokumentasi Hasil</div>
                                            </div>
                                        </div>
                                        <div class="stepper-line h-40px"></div>
                                    </div>
                                    <!--end::Step 3-->

                                    <!--begin::Step 4-->
                                    <div class="stepper-item" data-kt-stepper-element="nav">
                                        <div class="stepper-wrapper">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">4</span>
                                            </div>
                                            <div class="stepper-label">
                                                <h3 class="stepper-title">Feedback</h3>
                                                <div class="stepper-desc fw-semibold">Umpan Balik & Rekomendasi</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Step 4-->
                                </div>
                                <!--end::Nav-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--begin::Aside-->

                        <!--begin::Content-->
                        <div class="card d-flex flex-row-fluid flex-center">
                            <!--begin::Form-->
                            <form class="card-body py-20 w-100 mw-xl-900px px-9"
                                action="{{ route('kepala-sekolah.supervisi.assessment.store', $supervisi->id) }}"
                                method="POST" id="kt_stepper_form">
                                @csrf

                                <!--begin::Step 1-->
                                <div class="current" data-kt-stepper-element="content">
                                    <div class="w-100">
                                        <h3 class="mb-5">Instrumen Penilaian Kinerja Guru</h3>

                                        <!--begin::Form Group-->
                                        <div class="fv-row mb-6">
                                            <label class="form-label required">1. Penguasaan Materi</label>
                                            <select class="form-select" name="instrumen_penilaian[penguasaan_materi]"
                                                required>
                                                <option value="">Pilih Nilai</option>
                                                <option value="4">Sangat Baik (4)</option>
                                                <option value="3">Baik (3)</option>
                                                <option value="2">Cukup (2)</option>
                                                <option value="1">Kurang (1)</option>
                                            </select>
                                        </div>

                                        <div class="fv-row mb-6">
                                            <label class="form-label required">2. Strategi Pembelajaran</label>
                                            <select class="form-select" name="instrumen_penilaian[strategi_pembelajaran]"
                                                required>
                                                <option value="">Pilih Nilai</option>
                                                <option value="4">Sangat Baik (4)</option>
                                                <option value="3">Baik (3)</option>
                                                <option value="2">Cukup (2)</option>
                                                <option value="1">Kurang (1)</option>
                                            </select>
                                        </div>

                                        <div class="fv-row mb-6">
                                            <label class="form-label required">3. Pengelolaan Kelas</label>
                                            <select class="form-select" name="instrumen_penilaian[pengelolaan_kelas]"
                                                required>
                                                <option value="">Pilih Nilai</option>
                                                <option value="4">Sangat Baik (4)</option>
                                                <option value="3">Baik (3)</option>
                                                <option value="2">Cukup (2)</option>
                                                <option value="1">Kurang (1)</option>
                                            </select>
                                        </div>

                                        <div class="fv-row mb-6">
                                            <label class="form-label required">4. Komunikasi dengan Siswa</label>
                                            <select class="form-select" name="instrumen_penilaian[komunikasi]" required>
                                                <option value="">Pilih Nilai</option>
                                                <option value="4">Sangat Baik (4)</option>
                                                <option value="3">Baik (3)</option>
                                                <option value="2">Cukup (2)</option>
                                                <option value="1">Kurang (1)</option>
                                            </select>
                                        </div>

                                        <div class="fv-row mb-6">
                                            <label class="form-label required">5. Penggunaan Media/Alat
                                                Pembelajaran</label>
                                            <select class="form-select" name="instrumen_penilaian[media_pembelajaran]"
                                                required>
                                                <option value="">Pilih Nilai</option>
                                                <option value="4">Sangat Baik (4)</option>
                                                <option value="3">Baik (3)</option>
                                                <option value="2">Cukup (2)</option>
                                                <option value="1">Kurang (1)</option>
                                            </select>
                                        </div>

                                        <div class="fv-row mb-6">
                                            <label class="form-label required">Catatan Tambahan</label>
                                            <textarea class="form-control" name="instrumen_penilaian[catatan]" rows="3" required></textarea>
                                        </div>
                                        <!--end::Form Group-->
                                    </div>
                                </div>
                                <!--end::Step 1-->

                                <!--begin::Step 2-->
                                <div data-kt-stepper-element="content">
                                    <div class="w-100">
                                        <h3 class="mb-5">Lembar Observasi Pembelajaran</h3>

                                        <!--begin::Form Group-->
                                        <div class="fv-row mb-6">
                                            <label class="form-label required">1. Kegiatan Pendahuluan</label>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    name="lembar_observasi[pendahuluan][]" value="apersepsi"
                                                    id="pendahuluan1">
                                                <label class="form-check-label" for="pendahuluan1">
                                                    Melakukan apersepsi dengan baik
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    name="lembar_observasi[pendahuluan][]" value="motivasi"
                                                    id="pendahuluan2">
                                                <label class="form-check-label" for="pendahuluan2">
                                                    Memberikan motivasi kepada siswa
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    name="lembar_observasi[pendahuluan][]" value="tujuan"
                                                    id="pendahuluan3">
                                                <label class="form-check-label" for="pendahuluan3">
                                                    Menyampaikan tujuan pembelajaran
                                                </label>
                                            </div>
                                        </div>

                                        <div class="fv-row mb-6">
                                            <label class="form-label required">2. Kegiatan Inti</label>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    name="lembar_observasi[inti][]" value="materi_sistematis"
                                                    id="inti1">
                                                <label class="form-check-label" for="inti1">
                                                    Menyampaikan materi secara sistematis
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    name="lembar_observasi[inti][]" value="siswa_aktif" id="inti2">
                                                <label class="form-check-label" for="inti2">
                                                    Melibatkan siswa secara aktif
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    name="lembar_observasi[inti][]" value="media_efektif" id="inti3">
                                                <label class="form-check-label" for="inti3">
                                                    Menggunakan media pembelajaran dengan efektif
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    name="lembar_observasi[inti][]" value="waktu_efisien" id="inti4">
                                                <label class="form-check-label" for="inti4">
                                                    Mengelola waktu dengan efisien
                                                </label>
                                            </div>
                                        </div>

                                        <div class="fv-row mb-6">
                                            <label class="form-label required">3. Kegiatan Penutup</label>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    name="lembar_observasi[penutup][]" value="kesimpulan" id="penutup1">
                                                <label class="form-check-label" for="penutup1">
                                                    Membuat kesimpulan bersama siswa
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    name="lembar_observasi[penutup][]" value="evaluasi" id="penutup2">
                                                <label class="form-check-label" for="penutup2">
                                                    Melakukan evaluasi pembelajaran
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    name="lembar_observasi[penutup][]" value="tindak_lanjut"
                                                    id="penutup3">
                                                <label class="form-check-label" for="penutup3">
                                                    Memberikan tindak lanjut
                                                </label>
                                            </div>
                                        </div>

                                        <div class="fv-row mb-6">
                                            <label class="form-label required">Catatan Observasi</label>
                                            <textarea class="form-control" name="lembar_observasi[catatan]" rows="4" required></textarea>
                                        </div>
                                        <!--end::Form Group-->
                                    </div>
                                </div>
                                <!--end::Step 2-->

                                <!--begin::Step 3-->
                                <div data-kt-stepper-element="content">
                                    <div class="w-100">
                                        <h3 class="mb-5">Catatan Hasil Supervisi</h3>

                                        <!--begin::Form Group-->
                                        <div class="fv-row mb-6">
                                            <label class="form-label required">Kekuatan/Keunggulan Pembelajaran</label>
                                            <textarea class="form-control" name="catatan_hasil[kekuatan]" rows="4" required
                                                placeholder="Tuliskan aspek-aspek positif yang terlihat selama pembelajaran..."></textarea>
                                        </div>

                                        <div class="fv-row mb-6">
                                            <label class="form-label required">Kelemahan/Area yang Perlu Diperbaiki</label>
                                            <textarea class="form-control" name="catatan_hasil[kelemahan]" rows="4" required
                                                placeholder="Tuliskan aspek-aspek yang perlu ditingkatkan..."></textarea>
                                        </div>

                                        <div class="fv-row mb-6">
                                            <label class="form-label required">Saran Perbaikan</label>
                                            <textarea class="form-control" name="catatan_hasil[saran]" rows="4" required
                                                placeholder="Tuliskan saran-saran konkret untuk perbaikan pembelajaran..."></textarea>
                                        </div>

                                        <div class="fv-row mb-6">
                                            <label class="form-label required">Kesimpulan Umum</label>
                                            <textarea class="form-control" name="catatan_hasil[kesimpulan]" rows="3" required
                                                placeholder="Tuliskan kesimpulan umum hasil supervisi..."></textarea>
                                        </div>
                                        <!--end::Form Group-->
                                    </div>
                                </div>
                                <!--end::Step 3-->

                                <!--begin::Step 4-->
                                <div data-kt-stepper-element="content">
                                    <div class="w-100">
                                        <h3 class="mb-5">Feedback & Rekomendasi</h3>

                                        <!--begin::Form Group-->
                                        <div class="fv-row mb-6">
                                            <label class="form-label required">Umpan Balik (Feedback)</label>
                                            <textarea class="form-control" name="feedback" rows="6" required
                                                placeholder="Berikan umpan balik secara menyeluruh tentang kinerja guru..."></textarea>
                                            <div class="form-text">Berikan umpan balik yang konstruktif dan motivatif</div>
                                        </div>

                                        <div class="fv-row mb-6">
                                            <label class="form-label">Rekomendasi untuk Tindak Lanjut</label>
                                            <textarea class="form-control" name="rekomendasi" rows="6"
                                                placeholder="Tuliskan rekomendasi tindak lanjut (opsional)..."></textarea>
                                            <div class="form-text">Misalnya: pelatihan yang diperlukan, pembinaan khusus,
                                                dll.</div>
                                        </div>

                                        <!--begin::Summary-->
                                        <div class="alert alert-primary d-flex align-items-center">
                                            <i class="ki-outline ki-information-5 fs-2x me-4"></i>
                                            <div>
                                                <strong>Perhatian:</strong> Setelah submit, status supervisi akan berubah
                                                menjadi "Selesai" dan data tidak dapat diubah lagi.
                                            </div>
                                        </div>
                                        <!--end::Summary-->
                                        <!--end::Form Group-->
                                    </div>
                                </div>
                                <!--end::Step 4-->

                                <!--begin::Actions-->
                                <div class="d-flex flex-stack pt-10">
                                    <div class="me-2">
                                        <button type="button" class="btn btn-lg btn-light-primary me-3"
                                            data-kt-stepper-action="previous">
                                            <i class="ki-outline ki-arrow-left fs-4 me-1"></i>Kembali
                                        </button>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-lg btn-primary"
                                            data-kt-stepper-action="next">
                                            Lanjutkan
                                            <i class="ki-outline ki-arrow-right fs-4 ms-1 me-0"></i>
                                        </button>
                                        <button type="submit" class="btn btn-lg btn-success"
                                            data-kt-stepper-action="submit">
                                            <i class="ki-outline ki-check fs-2"></i>Simpan Penilaian
                                        </button>
                                    </div>
                                </div>
                                <!--end::Actions-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Stepper-->
                </div>
            </div>
            <!--end::Stepper-->
        </div>
    </div>
    <!--end::Content-->
@endsection
@push('scripts')
    <script>
        // Stepper initialization
        var element = document.querySelector("#kt_stepper");
        var stepper = new KTStepper(element);

        // Validasi step saat ini
        function validateCurrentStep() {
            var currentStepElement = document.querySelector('[data-kt-stepper-element="content"].current');

            if (!currentStepElement) return true;

            var inputs = currentStepElement.querySelectorAll('input[required], select[required], textarea[required]');
            var isValid = true;

            inputs.forEach(function(input) {
                // Skip checkbox karena tidak wajib
                if (input.type === 'checkbox') {
                    return;
                }

                if (!input.value || input.value === '') {
                    isValid = false;
                    input.classList.add('is-invalid');

                    // Hapus class invalid saat diisi
                    input.addEventListener('change', function() {
                        if (this.value) {
                            this.classList.remove('is-invalid');
                        }
                    }, {
                        once: true
                    });
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            return isValid;
        }

        // Update tombol visibility
        function updateButtons() {
            var currentIndex = stepper.getCurrentStepIndex();
            var totalSteps = stepper.getTotalStepsNumber();

            var prevButton = document.querySelector('[data-kt-stepper-action="previous"]');
            var nextButton = document.querySelector('[data-kt-stepper-action="next"]');
            var submitButton = document.querySelector('[data-kt-stepper-action="submit"]');

            // Hide/show previous button
            if (currentIndex === 1) {
                prevButton.style.display = 'none';
            } else {
                prevButton.style.display = 'inline-block';
            }

            // Hide/show next and submit buttons
            if (currentIndex === totalSteps) {
                nextButton.style.display = 'none';
                submitButton.style.display = 'inline-block';
            } else {
                nextButton.style.display = 'inline-block';
                submitButton.style.display = 'none';
            }
        }

        // Initial button state
        updateButtons();

        // Handle next step
        stepper.on("kt.stepper.next", function(stepperObj) {
            if (validateCurrentStep()) {
                stepperObj.goNext();
                updateButtons();
                // Scroll ke atas
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Mohon lengkapi semua field yang wajib diisi!',
                    confirmButtonText: 'OK'
                });
            }
        });

        // Handle previous step
        stepper.on("kt.stepper.previous", function(stepperObj) {
            stepperObj.goPrevious();
            updateButtons();
            // Scroll ke atas
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Handle form submit
        stepper.on("kt.stepper.submit", function(stepperObj) {
            console.log('Submit button clicked!'); // Debug log

            // Validasi step terakhir
            if (!validateCurrentStep()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Mohon lengkapi semua field yang wajib diisi!'
                });
                return;
            }

            // Konfirmasi submit
            Swal.fire({
                title: 'Konfirmasi Penilaian',
                text: "Apakah Anda yakin ingin menyimpan penilaian ini? Data tidak dapat diubah setelah disimpan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('Form submitting...'); // Debug log

                    // Tampilkan loading
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit form
                    var form = document.getElementById('kt_stepper_form');
                    console.log('Form element:', form); // Debug log

                    if (form) {
                        form.submit();
                    } else {
                        console.error('Form not found!');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Form tidak ditemukan!'
                        });
                    }
                }
            });
        });

        // Manual submit button handler sebagai backup
        document.querySelector('[data-kt-stepper-action="submit"]').addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Manual submit clicked'); // Debug log
            stepper.goSubmit(); // Trigger stepper submit event
        });

        // Tambahkan CSS untuk invalid input
        var style = document.createElement('style');
        style.textContent = `
    .is-invalid {
        border-color: #f1416c !important;
    }
    .is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(241, 65, 108, 0.25) !important;
    }
`;
        document.head.appendChild(style);

        console.log('Stepper initialized:', stepper); // Debug log
    </script>
@endpush
