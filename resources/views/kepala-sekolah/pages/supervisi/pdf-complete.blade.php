<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Supervisi - {{ $supervisi->guru->name }}</title>
    <style>
        @page {
            margin: 2cm;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
        }

        .page-break {
            page-break-after: always;
        }

        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
            margin-bottom: 10px;
        }

        .separator {
            border-bottom: 2px dashed #000;
            margin: 15px 0;
        }

        .section-title {
            font-weight: bold;
            font-size: 12pt;
            margin-bottom: 10px;
            margin-top: 15px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 180px;
            font-weight: 600;
        }

        .info-table td:nth-child(2) {
            width: 20px;
        }

        .content-box {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 10px;
        }

        .observation-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .observation-table th,
        .observation-table td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }

        .observation-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .observation-table td:first-child {
            text-align: center;
            width: 40px;
        }

        .subsection-title {
            font-weight: bold;
            margin-bottom: 5px;
            margin-top: 10px;
        }

        .text-content {
            margin-bottom: 10px;
        }

        .signature-section {
            margin-top: 40px;
            width: 100%;
            display: table;
        }

        .signature-box {
            text-align: center;
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .signature-space {
            height: 70px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 2px;
        }

        .signature-title {
            font-size: 10pt;
            margin-top: 0;
        }

        .footer-text {
            text-align: right;
            font-size: 9pt;
            margin-top: 20px;
            font-style: italic;
        }

        .lampiran-title {
            text-align: right;
            font-size: 10pt;
            font-style: italic;
            margin-bottom: 10px;
        }

        ol,
        ul {
            margin: 5px 0;
            padding-left: 25px;
        }

        li {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    {{-- HALAMAN 1: PERCAKAPAN PRA-OBSERVASI --}}
    <div class="page-break">
        <div class="header-title">Lembar Catatan Percakapan Pra-Observasi Kelas</div>

        <table class="info-table">
            <tr>
                <td>Hari/ Tanggal</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($supervisi->schedule_date)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </td>
            </tr>
            <tr>
                <td>Nama Guru</td>
                <td>:</td>
                <td>{{ $supervisi->guru->name }}</td>
            </tr>
            <tr>
                <td>Mata Pelajaran</td>
                <td>:</td>
                <td>{{ $supervisi->mata_pelajaran }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $supervisi->kelas }}</td>
            </tr>
            <tr>
                <td>Waktu Percakapan</td>
                <td>:</td>
                <td>{{ $supervisi->schedule_time ?? '-' }}</td>
            </tr>
        </table>

        @if ($instrumenPenilaian)
            @php
                $praObservasi = $instrumenPenilaian->assessment_data;
            @endphp

            <div class="subsection-title">Tujuan Pembelajaran:</div>
            <div class="content-box">
                {!! nl2br(e($praObservasi['tujuan_pembelajaran'] ?? '-')) !!}
            </div>

            <div class="subsection-title">Area Pengembangan yang hendak dicapai:</div>
            <div class="content-box">
                {!! nl2br(e($praObservasi['area_pengembangan'] ?? '-')) !!}
            </div>

            <div class="subsection-title">Strategi yang dipersiapkan:</div>
            <div class="content-box">
                {!! nl2br(e($praObservasi['strategi_persiapan'] ?? '-')) !!}
            </div>
        @endif

        @if ($catatanHasil)
            @php
                $catatanData = $catatanHasil->assessment_data;
            @endphp

            @if (isset($catatanData['catatan_supervisor']))
                <div class="subsection-title">Catatan khusus Supervisor:</div>
                <div class="text-content" style="font-style: italic;">
                    {{ $catatanData['catatan_supervisor'] }}
                </div>
            @endif
        @endif

        <div class="signature-section">
            <div class="signature-box">
                <div style="margin-bottom: 5px;">Disepakati bersama</div>
                <div class="signature-space"></div>
                <div class="signature-name">{{ $supervisi->supervisor->name }}</div>
                <div class="signature-title">Supervisor</div>
            </div>
            <div class="signature-box">
                <div style="margin-bottom: 5px;">&nbsp;</div>
                <div class="signature-space"></div>
                <div class="signature-name">{{ $supervisi->guru->name }}</div>
                <div class="signature-title">Guru</div>
            </div>
        </div>

        <div class="footer-text">
        </div>
    </div>

    {{-- HALAMAN 2: LEMBAR OBSERVASI --}}
    <div class="page-break">
        <div class="header-title">Lembar Observasi Pembelajaran di Kelas</div>

        <table class="info-table">
            <tr>
                <td>Hari/ Tanggal</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($supervisi->schedule_date)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </td>
            </tr>
            <tr>
                <td>Nama Guru</td>
                <td>:</td>
                <td>{{ $supervisi->guru->name }}</td>
            </tr>
            <tr>
                <td>Mata Pelajaran</td>
                <td>:</td>
                <td>{{ $supervisi->mata_pelajaran }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $supervisi->kelas }}</td>
            </tr>
            <tr>
                <td>Waktu Percakapan</td>
                <td>:</td>
                <td>{{ $supervisi->schedule_time ?? '-' }}</td>
            </tr>
        </table>

        <div class="lampiran-title">Lampiran: Lembar Catatan Observasi</div>

        @if ($lembarObservasi)
            @php
                $observasiData = $lembarObservasi->assessment_data;
                $items = $observasiData['items'] ?? [];
            @endphp

            <div class="subsection-title">Area Observasi:</div>

            @if (!empty($items))
                <table class="observation-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aspek dan Strategi<br>Pengembangan</th>
                            <th style="width: 60px;">Ada</th>
                            <th style="width: 60px;">Tidak</th>
                            <th style="width: 200px;">Catatan Pengamatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $index => $item)
                            @php
                                $status = strtolower($item['status'] ?? 'tidak');
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['aspek_strategi'] ?? '-' }}</td>
                                <td style="text-align: center;">
                                    {{ $status === 'ada' ? '✓' : '' }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $status === 'tidak' ? '✓' : '' }}
                                </td>
                                <td>{{ $item['catatan_pengamatan'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @if (!empty($observasiData['catatan_tambahan']))
                <div class="subsection-title">Catatan Tambahan:</div>
                <div class="content-box">
                    {{ $observasiData['catatan_tambahan'] }}
                </div>
            @endif
        @endif

        <div style="margin-top: 40px;">
            <div class="subsection-title">Dibuat oleh:</div>
            <div style="text-align: center; margin-top: 70px;">
                <div class="signature-name">{{ $supervisi->supervisor->name }}</div>
                <div class="signature-title">Supervisor</div>
            </div>
        </div>
    </div>

    {{-- HALAMAN 3: CATATAN PERCAKAPAN PASCA-OBSERVASI --}}
    <div class="page-break">
        <div class="header-title">Lembar Catatan Percakapan Pasca-Observasi Kelas</div>

        <table class="info-table">
            <tr>
                <td>Hari/ Tanggal</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($supervisi->schedule_date)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </td>
            </tr>
            <tr>
                <td>Nama Guru</td>
                <td>:</td>
                <td>{{ $supervisi->guru->name }}</td>
            </tr>
            <tr>
                <td>Mata Pelajaran</td>
                <td>:</td>
                <td>{{ $supervisi->mata_pelajaran }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $supervisi->kelas }}</td>
            </tr>
            <tr>
                <td>Waktu Percakapan</td>
                <td>:</td>
                <td>{{ $supervisi->schedule_time ?? '-' }}</td>
            </tr>
        </table>

        <div class="lampiran-title">Lampiran: Lembar Catatan Observasi</div>

        @if ($catatanHasil)
            @php
                $catatanData = $catatanHasil->assessment_data;
            @endphp

            <div class="subsection-title">Catatan Refleksi Guru:</div>
            <div class="content-box">
                {!! nl2br(e($catatanData['refleksi_guru'] ?? '-')) !!}
            </div>

            <div class="subsection-title">Topik percakapan dan catatan:</div>
            <div class="content-box">
                {!! nl2br(e($catatanData['topik_percakapan'] ?? '-')) !!}
            </div>

            <div class="subsection-title">Rencana Tindak Lanjut:</div>
            <div class="content-box">
                {!! nl2br(e($catatanData['rencana_tindak_lanjut'] ?? '-')) !!}
            </div>
        @endif

        <div class="signature-section">
            <div class="signature-box">
                <div style="margin-bottom: 5px;">Disepakati bersama</div>
                <div class="signature-space"></div>
                <div class="signature-name">{{ $supervisi->supervisor->name }}</div>
                <div class="signature-title">Supervisor</div>
            </div>
            <div class="signature-box">
                <div style="margin-bottom: 5px;">&nbsp;</div>
                <div class="signature-space"></div>
                <div class="signature-name">{{ $supervisi->guru->name }}</div>
                <div class="signature-title">Guru</div>
            </div>
        </div>

    </div>

    {{-- HALAMAN 4: UMPAN BALIK DAN REKOMENDASI --}}
    <div>
        <div class="header-title">Lembar Umpan Balik dan Rekomendasi</div>

        <table class="info-table">
            <tr>
                <td>Hari/ Tanggal</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($supervisi->schedule_date)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </td>
            </tr>
            <tr>
                <td>Nama Guru</td>
                <td>:</td>
                <td>{{ $supervisi->guru->name }}</td>
            </tr>
            <tr>
                <td>Mata Pelajaran</td>
                <td>:</td>
                <td>{{ $supervisi->mata_pelajaran }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $supervisi->kelas }}</td>
            </tr>
            <tr>
                <td>Waktu Percakapan</td>
                <td>:</td>
                <td>{{ $supervisi->schedule_time ?? '-' }}</td>
            </tr>
        </table>

        @if ($feedback)
            <div class="subsection-title">A. Umpan Balik dari Supervisor:</div>
            <div class="content-box">
                {!! nl2br(e($feedback->feedback ?? '-')) !!}
            </div>

            @if ($feedback->rekomendasi)
                <div class="subsection-title">B. Rekomendasi Tindak Lanjut:</div>
                <div class="content-box">
                    {!! nl2br(e($feedback->rekomendasi)) !!}
                </div>
            @endif

        @endif

        <div class="signature-section">
            <div class="signature-box">
                <div style="margin-bottom: 5px;">Supervisor,</div>
                <div class="signature-space"></div>
                <div class="signature-name">{{ $supervisi->supervisor->name }}</div>
                <div class="signature-title">Kepala Sekolah</div>
            </div>
            <div class="signature-box">
                <div style="margin-bottom: 5px;">Guru yang Disupervisi,</div>
                <div class="signature-space"></div>
                <div class="signature-name">{{ $supervisi->guru->name }}</div>
                <div class="signature-title">Guru {{ $supervisi->mata_pelajaran }}</div>
            </div>
        </div>

        <div class="footer-text">
            Dokumen dibuat pada:
            {{ \Carbon\Carbon::parse($feedback->created_at)->locale('id')->isoFormat('D MMMM Y, HH:mm') }} WIB<br>
        </div>
    </div>
</body>

</html>
