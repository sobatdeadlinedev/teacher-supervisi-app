<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Siswa Bermasalah - Kepala Sekolah</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .info {
            margin-bottom: 20px;
        }

        .info table {
            border: none;
            width: 100%;
        }

        .info td {
            padding: 3px 0;
            border: none;
        }

        .info td:first-child {
            width: 120px;
            font-weight: normal;
        }

        .info td:nth-child(2) {
            width: 20px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table.data-table th {
            background-color: #2ecc71;
            color: white;
            padding: 8px;
            border: 1px solid #000;
            font-weight: bold;
            text-align: center;
            font-size: 11px;
        }

        table.data-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
            font-size: 11px;
        }

        table.data-table td:first-child {
            text-align: center;
            width: 30px;
        }

        table.data-table td:nth-child(2) {
            width: 100px;
            text-align: center;
        }

        table.data-table td:nth-child(3) {
            width: 120px;
        }

        table.data-table td:nth-child(4) {
            width: 100px;
            text-align: center;
        }

        .summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
        }

        .summary p {
            margin: 5px 0;
            font-size: 11px;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .footer .signature {
            display: inline-block;
            text-align: center;
            margin-right: 50px;
        }

        .footer .signature-line {
            margin-top: 60px;
            border-top: 1px solid #000;
            padding-top: 5px;
            min-width: 220px;
        }

        .empty-row {
            height: 30px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ config('app.school_name', 'SEKOLAH') }}</h1>
        <h2>Laporan Siswa Bermasalah</h2>
        <p style="font-size: 11px; margin-top: 5px;">Bulan: {{ $bulan }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td>KELAS</td>
                <td>:</td>
                <td><strong>{{ $kelas }}</strong></td>
            </tr>
            <tr>
                <td>PERIODE</td>
                <td>:</td>
                <td><strong>{{ $bulan }}</strong></td>
            </tr>
            <tr>
                <td>TOTAL LAPORAN</td>
                <td>:</td>
                <td><strong>{{ count($laporans) }} Laporan</strong></td>
            </tr>
        </table>
    </div>

    @if ($laporans->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>GURU</th>
                    <th>NAMA SISWA</th>
                    <th>TANGGAL</th>
                    <th>KEADAAN / MASALAH</th>
                    <th>PENANGANAN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporans as $index => $laporan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $laporan->user->name ?? '-' }}</td>
                        <td>{{ $laporan->nama_siswa }}</td>
                        <td>{{ $laporan->created_at->locale('id')->translatedFormat('d/m/Y') }}</td>
                        <td>{{ $laporan->keadaan_masalah }}</td>
                        <td>{{ $laporan->penanganan ?? '-' }}</td>
                    </tr>
                @endforeach

                @if (count($laporans) < 15)
                    @for ($i = count($laporans); $i < 15; $i++)
                        <tr class="empty-row">
                            <td>{{ $i + 1 }}</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endfor
                @endif
            </tbody>
        </table>

        <div class="summary">
            <p><strong>Ringkasan:</strong></p>
            <p>• Total Laporan: <strong>{{ count($laporans) }}</strong></p>
            <p>• Guru Pelapor: <strong>{{ $laporans->unique('user_id')->count() }}</strong></p>
            <p>• Siswa Terlibat: <strong>{{ $laporans->unique('nama_siswa')->count() }}</strong></p>
        </div>
    @else
        <div style="text-align: center; padding: 40px;">
            <p style="font-style: italic; font-size: 12px;">Tidak ada laporan untuk periode ini</p>
        </div>
    @endif

    <div class="footer">
        <div class="signature">
            <div>Lemito, {{ now()->locale('id')->translatedFormat('d F Y') }}</div>
            <div style="font-weight: bold; margin-top: 5px;">Kepala Sekolah</div>
            <div class="signature-line">
                <strong>_______________________</strong>
            </div>
        </div>
    </div>
</body>

</html>
