<?php

namespace App\Http\Controllers\Guru;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\LaporanSiswaBermasalah;

class LaporanController extends Controller
{
    /**
     * Display a listing of the laporan.
     */
    public function index()
    {
        $laporans = LaporanSiswaBermasalah::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('guru.pages.laporan.index', compact('laporans'));
    }

    /**
     * Store a newly created laporan in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas' => 'required|string|max:50',
            'nama_siswa' => 'required|string|max:100',
            'keadaan_masalah' => 'required|string',
            'penanganan' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        LaporanSiswaBermasalah::create($validated);

        return redirect()->route('guru.laporan.index')
            ->with('success', 'Laporan berhasil ditambahkan');
    }

    /**
     * Update the specified laporan in storage.
     */
    public function update(Request $request, LaporanSiswaBermasalah $laporan)
    {
        // Cek apakah user adalah pemilik laporan
        if ($laporan->user_id !== auth()->id()) {
            return redirect()->route('guru.laporan.index')
                ->with('error', 'Anda tidak memiliki akses ke laporan ini');
        }

        $validated = $request->validate([
            'kelas' => 'required|string|max:50',
            'nama_siswa' => 'required|string|max:100',
            'keadaan_masalah' => 'required|string',
            'penanganan' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $laporan->update($validated);

        return redirect()->route('guru.laporan.index')
            ->with('success', 'Laporan berhasil diperbarui');
    }

    /**
     * Delete the specified laporan from storage.
     */
    public function destroy(LaporanSiswaBermasalah $laporan)
    {
        // Cek apakah user adalah pemilik laporan
        if ($laporan->user_id !== auth()->id()) {
            return redirect()->route('guru.laporan.index')
                ->with('error', 'Anda tidak memiliki akses ke laporan ini');
        }

        $laporan->delete();

        return redirect()->route('guru.laporan.index')
            ->with('success', 'Laporan berhasil dihapus');
    }

    /**
     * Download laporan per bulan dalam format PDF
     */
    public function downloadPdf(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $kelas = auth()->user()->kelas ?? ''; // Asumsi user punya field kelas

        $laporans = LaporanSiswaBermasalah::where('user_id', auth()->id())
            ->byMonth($month, $year)
            ->orderBy('created_at', 'asc')
            ->get();

        $data = [
            'laporans' => $laporans,
            'kelas' => $kelas,
            'bulan' => $this->getIndonesianMonth($month) . ' ' . $year,
            'wali_kelas' => auth()->user()->name,
        ];

        $pdf = Pdf::loadView('guru.pages.laporan.pdf', $data);
        $pdf->setPaper('a4', 'landscape');

        $filename = 'Laporan_Siswa_Bermasalah_' . $month . '_' . $year . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Helper untuk nama bulan Indonesia
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
            12 => 'Desember'
        ];
        return $months[$month];
    }
}
