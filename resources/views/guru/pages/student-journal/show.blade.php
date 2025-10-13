@extends('guru.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-5 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Detail Jurnal Siswa</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('guru.dashboard.index') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('guru.student-journal.index') }}" class="text-muted text-hover-primary">Jurnal
                                Harian Siswa</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ $student->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Student Info Card-->
            <div class="card mb-5">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-75px me-5">
                            <div class="symbol-label bg-light-primary">
                                <i class="ki-outline ki-user fs-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="text-gray-900 fw-bold mb-1">{{ $student->name }}</h3>
                            <div class="text-gray-600 fw-semibold fs-6">{{ $student->email }}</div>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('guru.student-journal.index') }}" class="btn btn-light-primary btn-sm">
                                <i class="ki-outline ki-arrow-left fs-3"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Student Info Card-->

            <!--begin::Journal List-->
            @if ($journals->isEmpty())
                <div class="card">
                    <div class="card-body">
                        <div class="text-center py-15">
                            <div class="mb-4">
                                <i class="ki-outline ki-information fs-4x text-muted"></i>
                            </div>
                            <h4 class="fw-semibold text-gray-800 mb-2">Belum Ada Jurnal</h4>
                            <p class="text-gray-600 mb-6">Siswa ini belum mengisi jurnal harian</p>
                        </div>
                    </div>
                </div>
            @else
                @foreach ($journals as $journal)
                    @php
                        $data = $journal->journal_data;
                        $journalTypes = [
                            'bangun_pagi' => ['label' => 'Bangun Pagi', 'class' => 'badge-light-info', 'icon' => 'sun'],
                            'beribadah' => [
                                'label' => 'Beribadah',
                                'class' => 'badge-light-success',
                                'icon' => 'abstract-26',
                            ],
                            'olahraga' => ['label' => 'Olahraga', 'class' => 'badge-light-warning', 'icon' => 'ghost'],
                            'makan_sehat' => [
                                'label' => 'Makan Sehat',
                                'class' => 'badge-light-danger',
                                'icon' => 'heart',
                            ],
                            'belajar' => ['label' => 'Belajar', 'class' => 'badge-light-primary', 'icon' => 'book'],
                            'bermasyarakat' => [
                                'label' => 'Bermasyarakat',
                                'class' => 'badge-light-success',
                                'icon' => 'people',
                            ],
                            'tidur_cepat' => [
                                'label' => 'Tidur Cepat',
                                'class' => 'badge-light-info',
                                'icon' => 'moon',
                            ],
                        ];
                        $type = $journalTypes[$journal->journal_type] ?? [
                            'label' => ucfirst($journal->journal_type),
                            'class' => 'badge-light',
                            'icon' => 'document',
                        ];
                    @endphp

                    <div class="card mb-5">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-50px me-3">
                                        <div
                                            class="symbol-label bg-light-{{ explode('-', $type['class'])[2] ?? 'primary' }}">
                                            <i
                                                class="ki-outline ki-{{ $type['icon'] }} fs-2x text-{{ explode('-', $type['class'])[2] ?? 'primary' }}"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="badge {{ $type['class'] }} fs-6 mb-2">{{ $type['label'] }}</span>
                                        <span
                                            class="text-gray-800 fw-bold fs-5">{{ \Carbon\Carbon::parse($journal->journal_date)->translatedFormat('l, d F Y') }}</span>
                                        <span class="text-gray-600 fs-7">Diinput:
                                            {{ $journal->created_at->translatedFormat('d M Y, H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if ($journal->journal_type === 'bangun_pagi')
                                <div class="row g-5">
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">Nama Lengkap</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['nama_lengkap'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">No Absen</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['no_absen'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">Bangun Pukul</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['bangun_pukul'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="text-gray-600 fw-semibold fs-7">Aktivitas Setelah Bangun</label>
                                        <div class="text-gray-800 fs-6">{{ $data['aktivitas_setelah_bangun'] ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            @elseif ($journal->journal_type === 'beribadah')
                                <div class="row g-5">
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">Nama Siswa</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['nama_siswa'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">No Siswa</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['student_number'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="text-gray-600 fw-semibold fs-7">Sholat Wajib</label>
                                        <div class="d-flex flex-wrap gap-2 mt-2">
                                            @if (isset($data['sholat_wajib']) && is_array($data['sholat_wajib']))
                                                @foreach ($data['sholat_wajib'] as $sholat)
                                                    <span class="badge badge-success">{{ $sholat }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-gray-600">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if (isset($data['tadarus_alquran']) && !empty($data['tadarus_alquran']))
                                        <div class="col-12">
                                            <label class="text-gray-600 fw-semibold fs-7">Tadarus Al-Quran</label>
                                            <div class="text-gray-800 fs-6">{{ $data['tadarus_alquran'] }}</div>
                                        </div>
                                    @endif
                                </div>
                            @elseif ($journal->journal_type === 'olahraga')
                                <div class="row g-5">
                                    <div class="col-md-4">
                                        <label class="text-gray-600 fw-semibold fs-7">Nama Anak</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['nama_anak'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-gray-600 fw-semibold fs-7">No Siswa</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['student_number'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-gray-600 fw-semibold fs-7">Kelas</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['kelas'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="text-gray-600 fw-semibold fs-7">Kegiatan Olahraga</label>
                                        <div class="text-gray-800 fs-6">{{ $data['kegiatan_olahraga'] ?? '-' }}</div>
                                    </div>
                                </div>
                            @elseif ($journal->journal_type === 'makan_sehat')
                                <div class="row g-5">
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">Nama Lengkap</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['nama_lengkap'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">No Absen</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['no_absen'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">Karbohidrat</label>
                                        <div class="text-gray-800 fs-6">{{ $data['karbohidrat'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">Protein</label>
                                        <div class="text-gray-800 fs-6">{{ $data['protein'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">Serat & Vitamin</label>
                                        <div class="text-gray-800 fs-6">{{ $data['serat_vitamin'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">Minuman Sehat</label>
                                        <div class="text-gray-800 fs-6">{{ $data['minuman_sehat'] ?? '-' }}</div>
                                    </div>
                                </div>
                            @elseif ($journal->journal_type === 'belajar')
                                <div class="row g-5">
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">Nama Lengkap</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['nama_lengkap'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">No Absen</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['no_absen'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="text-gray-600 fw-semibold fs-7">Kegiatan Belajar</label>
                                        <div class="d-flex flex-wrap gap-2 mt-2">
                                            @if (isset($data['kegiatan_belajar']) && is_array($data['kegiatan_belajar']))
                                                @foreach ($data['kegiatan_belajar'] as $kegiatan)
                                                    <span class="badge badge-primary">{{ $kegiatan }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-gray-600">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if (isset($data['judul_buku_video']) && !empty($data['judul_buku_video']))
                                        <div class="col-12">
                                            <label class="text-gray-600 fw-semibold fs-7">Judul Buku/Video</label>
                                            <div class="text-gray-800 fs-6">{{ $data['judul_buku_video'] }}</div>
                                        </div>
                                    @endif
                                </div>
                            @elseif ($journal->journal_type === 'bermasyarakat')
                                <div class="row g-5">
                                    <div class="col-md-4">
                                        <label class="text-gray-600 fw-semibold fs-7">Nama Anak</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['nama_anak'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-gray-600 fw-semibold fs-7">No Siswa</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['student_number'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-gray-600 fw-semibold fs-7">Kelas</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['kelas'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="text-gray-600 fw-semibold fs-7">Kegiatan Bermasyarakat</label>
                                        <div class="text-gray-800 fs-6">{{ $data['kegiatan_bermasyarakat'] ?? '-' }}</div>
                                    </div>
                                </div>
                            @elseif ($journal->journal_type === 'tidur_cepat')
                                <div class="row g-5">
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">Nama Lengkap</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['nama_lengkap'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">No Absen</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['no_absen'] ?? '-' }}</div>
                                    </div>
                                    @if (isset($data['tidur_siang']) && !empty($data['tidur_siang']))
                                        <div class="col-md-6">
                                            <label class="text-gray-600 fw-semibold fs-7">Tidur Siang</label>
                                            <div class="text-gray-800 fw-bold fs-6">{{ $data['tidur_siang'] }}</div>
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <label class="text-gray-600 fw-semibold fs-7">Tidur Malam Pukul</label>
                                        <div class="text-gray-800 fw-bold fs-6">{{ $data['tidur_malam_pukul'] ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (isset($journal->photo_path) && !empty($journal->photo_path))
                                <div class="separator my-5"></div>
                                <div>
                                    <label class="text-gray-600 fw-semibold fs-7 mb-3 d-block">Foto Dokumentasi</label>
                                    <a href="{{ Storage::url($journal->photo_path) }}"
                                        data-fslightbox="journal-{{ $journal->id }}">
                                        <img src="{{ Storage::url($journal->photo_path) }}" class="rounded"
                                            style="max-width: 200px; cursor: pointer;" alt="Foto Jurnal">
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!--begin::Pagination-->
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="fs-6 fw-semibold text-gray-700">
                        Menampilkan {{ $journals->firstItem() }} sampai {{ $journals->lastItem() }} dari
                        {{ $journals->total() }} jurnal
                    </div>
                    <div>
                        {{ $journals->links() }}
                    </div>
                </div>
                <!--end::Pagination-->
            @endif
            <!--end::Journal List-->
        </div>
    </div>
    <!--end::Content-->

    @push('scripts')
        <!-- FsLightbox for image gallery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.4.1/index.min.js"></script>
    @endpush
@endsection
