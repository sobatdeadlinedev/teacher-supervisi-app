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
                                                <h3 class="stepper-title">Percakapan Pra-Observasi</h3>
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
                                                <h3 class="stepper-title">Catatan Hasil Supervisi</h3>
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
                                        <h3 class="mb-5">Percakapan Pra-Observasi Kelas</h3>

                                        <!--begin::Form Group-->
                                        <div class="fv-row mb-6">
                                            <label class="form-label required">Tujuan Pembelajaran</label>
                                            <textarea class="form-control" name="instrumen_penilaian[tujuan_pembelajaran]" rows="3" required></textarea>
                                        </div>

                                        <div class="fv-row mb-6">
                                            <label class="form-label required">Area Pengembangan yang hendak
                                                dicapai</label>
                                            <textarea class="form-control" name="instrumen_penilaian[area_pengembangan]" rows="3" required></textarea>
                                        </div>

                                        <div class="fv-row mb-6">
                                            <label class="form-label required">Strategi yang dipersiapkan</label>
                                            <textarea class="form-control" name="instrumen_penilaian[strategi_persiapan]" rows="3" required></textarea>
                                        </div>
                                        <!--end::Form Group-->
                                    </div>
                                </div>
                                <!--end::Step 1-->

                                <!--begin::Step 2-->
                                <div data-kt-stepper-element="content">
                                    <div class="w-100">
                                        <h3 class="mb-5">Lembar Observasi</h3>

                                        <!--begin::Form Group-->
                                        <div id="observasi-container">
                                            <!-- Template Observasi Item -->
                                            <div class="observasi-item card mb-4" data-index="0">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                                        <h5 class="mb-0">Area Observasi #<span
                                                                class="observasi-number">1</span></h5>
                                                        <button type="button"
                                                            class="btn btn-sm btn-light-danger remove-observasi"
                                                            style="display: none;">
                                                            <i class="ki-outline ki-trash fs-4"></i> Hapus
                                                        </button>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-4">
                                                            <label class="form-label required">Aspek dan Strategi
                                                                Pembelajaran</label>
                                                            <textarea class="form-control" name="lembar_observasi[0][aspek_strategi]" rows="3" required
                                                                placeholder="Contoh: Aspek kognitif/ pemahaman materi dengan memberikan sumber belajar yang beragam"></textarea>
                                                        </div>

                                                        <div class="col-md-3 mb-4">
                                                            <label class="form-label required">Status</label>
                                                            <div class="d-flex gap-4 mt-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="lembar_observasi[0][status]" value="ada"
                                                                        id="status_ada_0" required>
                                                                    <label class="form-check-label" for="status_ada_0">
                                                                        Ada
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="lembar_observasi[0][status]" value="tidak"
                                                                        id="status_tidak_0">
                                                                    <label class="form-check-label" for="status_tidak_0">
                                                                        Tidak
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-9 mb-4">
                                                            <label class="form-label required">Catatan Pengamatan</label>
                                                            <textarea class="form-control" name="lembar_observasi[0][catatan_pengamatan]" rows="3" required
                                                                placeholder="Tuliskan catatan pengamatan detail..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Button Tambah Observasi -->
                                        <div class="mb-6">
                                            <button type="button" class="btn btn-light-primary" id="add-observasi">
                                                <i class="ki-outline ki-plus fs-2"></i> Tambah Area Observasi
                                            </button>
                                        </div>

                                        <!-- Catatan Tambahan -->
                                        <div class="fv-row mb-6">
                                            <label class="form-label">Catatan Tambahan</label>
                                            <textarea class="form-control" name="lembar_observasi[catatan_tambahan]" rows="4"
                                                placeholder="Pembelajaran berjalan dengan lancar dan dilaksanakan sesuai dengan tahapan yang ada di RPP"></textarea>
                                            <div class="form-text">Catatan umum tentang observasi pembelajaran</div>
                                        </div>
                                        <!--end::Form Group-->
                                    </div>
                                </div>
                                <!--end::Step 2-->

                                <!--begin::Step 4-->
                                <div data-kt-stepper-element="content">
                                    <div class="w-100">
                                        <h3 class="mb-5">Catatan Hasil Supervisi</h3>

                                        <!--begin::Catatan Refleksi Guru-->
                                        <div class="card border border-gray-300 mb-6">
                                            <div class="card-header bg-light">
                                                <h4 class="card-title mb-0">Catatan Refleksi Guru</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="fv-row">
                                                    <label class="form-label required">Tuliskan catatan refleksi dari
                                                        guru</label>
                                                    <textarea class="form-control" name="catatan_hasil[refleksi_guru]" rows="5" required
                                                        placeholder="Tuliskan refleksi guru mengenai pembelajaran yang telah dilaksanakan..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Catatan Refleksi Guru-->

                                        <!--begin::Topik Percakapan-->
                                        <div class="card border border-gray-300 mb-6">
                                            <div class="card-header bg-light">
                                                <h4 class="card-title mb-0">Topik Percakapan dan Catatan</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="fv-row">
                                                    <label class="form-label required">Tuliskan topik percakapan dan
                                                        catatan hasil supervisi</label>
                                                    <textarea class="form-control" name="catatan_hasil[topik_percakapan]" rows="5" required
                                                        placeholder="Tuliskan topik percakapan yang dibahas dan catatan penting..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Topik Percakapan-->

                                        <!--begin::Rencana Tindak Lanjut-->
                                        <div class="card border border-gray-300">
                                            <div class="card-header bg-light">
                                                <h4 class="card-title mb-0">Rencana Tindak Lanjut</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="fv-row">
                                                    <label class="form-label required">Tuliskan rencana tindak
                                                        lanjut</label>
                                                    <textarea class="form-control" name="catatan_hasil[rencana_tindak_lanjut]" rows="5" required
                                                        placeholder="Tuliskan rencana tindak lanjut yang akan dilakukan..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Rencana Tindak Lanjut-->
                                    </div>
                                </div>
                                <!--end::Step 4-->

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

        // Counter untuk tracking index observasi
        let observasiCounter = 1;

        // Function untuk update nomor urut observasi
        function updateObservasiNumbers() {
            document.querySelectorAll('.observasi-item').forEach((item, index) => {
                item.querySelector('.observasi-number').textContent = index + 1;

                // Update textarea names
                const aspekStrategi = item.querySelector('[name*="[aspek_strategi]"]');
                const catatanPengamatan = item.querySelector('[name*="[catatan_pengamatan]"]');

                if (aspekStrategi) {
                    aspekStrategi.setAttribute('name', `lembar_observasi[${index}][aspek_strategi]`);
                }
                if (catatanPengamatan) {
                    catatanPengamatan.setAttribute('name', `lembar_observasi[${index}][catatan_pengamatan]`);
                }

                // Update radio buttons - CRITICAL: Pastikan value tetap 'ada' atau 'tidak'
                const radioAda = item.querySelector('input[type="radio"][value="ada"]');
                const radioTidak = item.querySelector('input[type="radio"][value="tidak"]');

                if (radioAda) {
                    const newId = `status_ada_${index}`;
                    radioAda.setAttribute('name', `lembar_observasi[${index}][status]`);
                    radioAda.setAttribute('id', newId);
                    radioAda.setAttribute('value', 'ada'); // Pastikan value tetap 'ada'

                    const label = radioAda.nextElementSibling;
                    if (label && label.tagName === 'LABEL') {
                        label.setAttribute('for', newId);
                    }
                }

                if (radioTidak) {
                    const newId = `status_tidak_${index}`;
                    radioTidak.setAttribute('name', `lembar_observasi[${index}][status]`);
                    radioTidak.setAttribute('id', newId);
                    radioTidak.setAttribute('value', 'tidak'); // Pastikan value tetap 'tidak'

                    const label = radioTidak.nextElementSibling;
                    if (label && label.tagName === 'LABEL') {
                        label.setAttribute('for', newId);
                    }
                }

                // Update data-index
                item.setAttribute('data-index', index);
            });

            // Show/hide remove buttons
            const items = document.querySelectorAll('.observasi-item');
            items.forEach((item, index) => {
                const removeBtn = item.querySelector('.remove-observasi');
                if (items.length > 1) {
                    removeBtn.style.display = 'inline-block';
                } else {
                    removeBtn.style.display = 'none';
                }
            });
        }

        // Tambah area observasi baru
        document.getElementById('add-observasi').addEventListener('click', function() {
            const container = document.getElementById('observasi-container');
            const firstItem = container.querySelector('.observasi-item');
            const newItem = firstItem.cloneNode(true);

            // Clear all inputs in new item
            newItem.querySelectorAll('textarea').forEach(textarea => {
                textarea.value = '';
                textarea.classList.remove('is-invalid');
            });

            // CRITICAL: Clear radio buttons dan pastikan value tetap benar
            newItem.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.checked = false;
                // Pastikan value tidak berubah saat clone
                const originalValue = radio.getAttribute('value');
                if (originalValue === 'ada') {
                    radio.setAttribute('value', 'ada');
                } else if (originalValue === 'tidak') {
                    radio.setAttribute('value', 'tidak');
                }
            });

            // Set new index
            newItem.setAttribute('data-index', observasiCounter);

            container.appendChild(newItem);
            observasiCounter++;

            updateObservasiNumbers();

            // Scroll to new item
            newItem.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        });

        // Remove observasi item
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-observasi')) {
                const item = e.target.closest('.observasi-item');
                const items = document.querySelectorAll('.observasi-item');

                if (items.length > 1) {
                    Swal.fire({
                        title: 'Hapus Area Observasi?',
                        text: "Data yang telah diisi akan hilang!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            item.remove();
                            updateObservasiNumbers();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Area observasi telah dihapus',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            }
        });

        // Validasi step saat ini
        function validateCurrentStep() {
            var currentStepElement = document.querySelector('[data-kt-stepper-element="content"].current');

            if (!currentStepElement) {
                console.log('No current step element found');
                return true;
            }

            var isValid = true;
            var checkedRadioGroups = new Set();

            // Validasi textarea
            var textareas = currentStepElement.querySelectorAll('textarea[required]');
            textareas.forEach(function(textarea) {
                if (!textarea.value || textarea.value.trim() === '') {
                    isValid = false;
                    textarea.classList.add('is-invalid');
                } else {
                    textarea.classList.remove('is-invalid');
                }
            });

            // Validasi radio button groups
            var radioInputs = currentStepElement.querySelectorAll('input[type="radio"][required]');

            radioInputs.forEach(function(input) {
                const radioName = input.getAttribute('name');

                // Skip jika sudah dicek
                if (checkedRadioGroups.has(radioName)) {
                    return;
                }

                checkedRadioGroups.add(radioName);

                const radioGroup = currentStepElement.querySelectorAll(`input[name="${radioName}"]`);
                const isChecked = Array.from(radioGroup).some(radio => radio.checked);

                if (!isChecked) {
                    isValid = false;
                    const radioContainer = input.closest('.col-md-3');
                    if (radioContainer) {
                        radioContainer.classList.add('radio-error');
                    }
                } else {
                    const radioContainer = input.closest('.col-md-3');
                    if (radioContainer) {
                        radioContainer.classList.remove('radio-error');
                    }
                }
            });

            return isValid;
        }

        // Update tombol visibility
        function updateButtons() {
            var allSteps = document.querySelectorAll('[data-kt-stepper-element="content"]');
            var totalSteps = allSteps.length;

            var currentStep = document.querySelector('[data-kt-stepper-element="content"].current');
            var currentIndex = 0;

            allSteps.forEach((step, index) => {
                if (step === currentStep) {
                    currentIndex = index + 1;
                }
            });

            console.log('Current step:', currentIndex, 'Total steps:', totalSteps);

            var prevButton = document.querySelector('[data-kt-stepper-action="previous"]');
            var nextButton = document.querySelector('[data-kt-stepper-action="next"]');
            var submitButton = document.querySelector('[data-kt-stepper-action="submit"]');

            if (currentIndex === 1) {
                prevButton.style.display = 'none';
            } else {
                prevButton.style.display = 'inline-block';
            }

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

        // Custom handler untuk tombol Next
        document.querySelector('[data-kt-stepper-action="next"]').addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            console.log('Next button clicked');

            if (validateCurrentStep()) {
                console.log('Validation passed, moving to next step');

                var allContentSteps = document.querySelectorAll('[data-kt-stepper-element="content"]');
                var allNavSteps = document.querySelectorAll('[data-kt-stepper-element="nav"]');
                var currentContentStep = document.querySelector('[data-kt-stepper-element="content"].current');

                var currentIndex = Array.from(allContentSteps).indexOf(currentContentStep);
                var nextIndex = currentIndex + 1;

                if (nextIndex < allContentSteps.length) {
                    currentContentStep.classList.remove('current');
                    allNavSteps[currentIndex].classList.remove('current');

                    allContentSteps[nextIndex].classList.add('current');
                    allNavSteps[nextIndex].classList.add('current');

                    console.log('Moved from step', currentIndex + 1, 'to step', nextIndex + 1);
                }

                updateButtons();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            } else {
                console.log('Validation failed');
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Mohon lengkapi semua field yang wajib diisi!',
                    confirmButtonText: 'OK'
                });
            }
        });

        // Custom handler untuk tombol Previous
        document.querySelector('[data-kt-stepper-action="previous"]').addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var allContentSteps = document.querySelectorAll('[data-kt-stepper-element="content"]');
            var allNavSteps = document.querySelectorAll('[data-kt-stepper-element="nav"]');
            var currentContentStep = document.querySelector('[data-kt-stepper-element="content"].current');

            var currentIndex = Array.from(allContentSteps).indexOf(currentContentStep);
            var prevIndex = currentIndex - 1;

            if (prevIndex >= 0) {
                currentContentStep.classList.remove('current');
                allNavSteps[currentIndex].classList.remove('current');

                allContentSteps[prevIndex].classList.add('current');
                allNavSteps[prevIndex].classList.add('current');

                console.log('Moved from step', currentIndex + 1, 'to step', prevIndex + 1);
            }

            updateButtons();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Custom handler untuk tombol Submit
        document.querySelector('[data-kt-stepper-action="submit"]').addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            console.log('Submit button clicked');

            if (!validateCurrentStep()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Mohon lengkapi semua field yang wajib diisi!'
                });
                return;
            }

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
                    console.log('Form submitting...');

                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    var form = document.getElementById('kt_stepper_form');
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

        // Debug: Log data sebelum submit untuk troubleshooting
        document.getElementById('kt_stepper_form').addEventListener('submit', function(e) {
            console.log('=== FORM SUBMIT DEBUG ===');

            // Log semua radio button yang tercentang
            const checkedRadios = document.querySelectorAll('input[type="radio"][name*="status"]:checked');
            console.log('Total radio buttons checked:', checkedRadios.length);

            checkedRadios.forEach((radio, index) => {
                console.log(`Radio ${index + 1}:`, {
                    name: radio.name,
                    value: radio.value,
                    id: radio.id
                });
            });

            // Log FormData untuk melihat data yang dikirim
            const formData = new FormData(this);
            console.log('Status values being sent:');
            for (let [key, value] of formData.entries()) {
                if (key.includes('status')) {
                    console.log(key, '=', value, typeof value);
                }
            }
        });

        // Event listener untuk auto-remove invalid class saat user mengetik
        document.addEventListener('input', function(e) {
            if (e.target.tagName === 'TEXTAREA' && e.target.hasAttribute('required')) {
                if (e.target.value.trim()) {
                    e.target.classList.remove('is-invalid');
                }
            }
        });

        // Event listener untuk auto-remove error dari radio button
        document.addEventListener('change', function(e) {
            if (e.target.type === 'radio') {
                const radioContainer = e.target.closest('.col-md-3');
                if (radioContainer) {
                    radioContainer.classList.remove('radio-error');
                }
            }
        });

        // Tambahkan CSS untuk invalid input dan radio error
        var style = document.createElement('style');
        style.textContent = `
    .is-invalid {
        border-color: #f1416c !important;
    }
    .is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(241, 65, 108, 0.25) !important;
    }
    .radio-error {
        border: 2px solid #f1416c;
        border-radius: 0.475rem;
        padding: 10px;
        background-color: rgba(241, 65, 108, 0.05);
    }
    .radio-error label.form-label {
        color: #f1416c;
    }
`;
        document.head.appendChild(style);

        console.log('Stepper initialized:', stepper);
    </script>
@endpush
