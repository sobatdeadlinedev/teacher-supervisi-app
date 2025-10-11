<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Wali Kelas Penanganan Siswa Bermasalah</title>
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
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info table {
            border: none;
        }

        .info td {
            padding: 3px 0;
            border: none;
        }

        .info td:first-child {
            width: 100px;
            font-weight: normal;
        }

        .info td:nth-child(2) {
            width: 20px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
            width: 150px;
        }

        table.data-table td:nth-child(3) {
            width: 100px;
            text-align: center;
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
            min-width: 200px;
        }

        .empty-row {
            height: 40px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Wali Kelas</h2>
        <h2>Penanganan Siswa Bermasalah</h2>
    </div>

    <div class="info">
        <table>
            <tr>
                <td>KELAS</td>
                <td>:</td>
                <td><strong>{{ $kelas }}</strong></td>
            </tr>
            <tr>
                <td>BULAN</td>
                <td>:</td>
                <td><strong>{{ $bulan }}</strong></td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA SISWA</th>
                <th>HARI/TANGGAL</th>
                <th>KEADAAN / MASALAH</th>
                <th>PENANGANAN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporans as $index => $laporan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $laporan->nama_siswa }}</td>
                    <td>{{ $laporan->created_at->locale('id')->translatedFormat('l, d/m/Y') }}</td>
                    <td>{{ $laporan->keadaan_masalah }}</td>
                    <td>{{ $laporan->penanganan ?? '-' }}</td>
                </tr>
            @empty
                <tr class="empty-row">
                    <td colspan="5" style="text-align: center; font-style: italic;">
                        Tidak ada laporan untuk bulan ini
                    </td>
                </tr>
            @endforelse

            @if ($laporans->count() > 0 && $laporans->count() < 10)
                @for ($i = $laporans->count(); $i < 10; $i++)
                    <tr class="empty-row">
                        <td>{{ $i + 1 }}</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endfor
            @endif
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <div>Lemito, {{ now()->locale('id')->translatedFormat('F Y') }}</div>
            <div>Wali Kelas</div>
            <div class="signature-line">
                <strong>{{ $wali_kelas }}</strong>
            </div>
        </div>
    </div>
</body>

</html>
