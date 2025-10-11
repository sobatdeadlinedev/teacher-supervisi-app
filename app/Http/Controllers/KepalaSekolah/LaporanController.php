<?php

namespace App\Http\Controllers\KepalaSekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LaporanSiswaBermasalah;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = LaporanSiswaBermasalah::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kepala-sekolah.pages.laporan.index', compact('laporans'));
    }

    /**
     * Update the specified laporan in storage.
     */
    public function update(Request $request, LaporanSiswaBermasalah $laporan)
    {
        $validated = $request->validate([
            'penanganan' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $laporan->update($validated);

        return redirect()->route('kepala-sekolah.laporan.index')
            ->with('success', 'Laporan berhasil diperbarui');
    }

    /**
     * Download laporan PDF untuk kepala sekolah
     */
    public function downloadPdf(Request $request)
    {
        try {
            $month = $request->input('month', now()->month);
            $year = $request->input('year', now()->year);
            $kelas = $request->input('kelas', 'Semua');

            // Query laporan berdasarkan filter
            $query = LaporanSiswaBermasalah::with('user')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);

            // Filter berdasarkan kelas jika dipilih
            if ($kelas !== 'Semua') {
                $query->where('kelas', $kelas);
            }

            $laporans = $query->orderBy('created_at', 'asc')->get();

            // Ambil daftar kelas unik untuk dropdown
            $kelasOptions = LaporanSiswaBermasalah::distinct('kelas')
                ->orderBy('kelas')
                ->pluck('kelas');

            // Data untuk PDF
            $data = [
                'laporans' => $laporans,
                'kelas' => $kelas,
                'bulan' => $this->getIndonesianMonth($month) . ' ' . $year,
                'sekolah_name' => config('app.school_name', 'Sekolah'),
            ];

            // Generate PDF
            $pdf = Pdf::loadView('kepala-sekolah.pages.laporan.pdf', $data);
            $pdf->setPaper('a4', 'landscape');

            // Nama file
            $bulanName = $this->getIndonesianMonth($month);
            $kelasName = $kelas === 'Semua' ? 'Semua_Kelas' : str_replace(' ', '_', $kelas);
            $filename = "Laporan_Siswa_Bermasalah_{$bulanName}_{$year}_{$kelasName}.pdf";

            return $pdf->download($filename);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengunduh PDF: ' . $e->getMessage());
        }
    }

    /**
     * Helper method untuk mendapatkan nama bulan dalam Bahasa Indonesia
     */
    private function getIndonesianMonth($month)
    {
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $months[$month] ?? 'Tidak Diketahui';
    }
}
