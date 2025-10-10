<?php

namespace App\Http\Controllers\Pengawas;

use App\Models\Supervision;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class SupervisiController extends Controller
{
    public function index()
    {
        $supervisions = Supervision::with(['guru'])
            ->latest()
            ->paginate(10);

        return view('pengawas.pages.supervisi.index', compact('supervisions'));
    }
    public function show(Supervision $supervisi)
    {

        $supervisi->load(['guru', 'assessments', 'feedbacks', 'supervisor']);

        // Kelompokkan assessment berdasarkan tipe
        $instrumenPenilaian = $supervisi->assessments->where('assessment_type', 'instrumen_penilaian')->first();
        $lembarObservasi = $supervisi->assessments->where('assessment_type', 'lembar_observasi')->first();
        $catatanHasil = $supervisi->assessments->where('assessment_type', 'catatan_hasil')->first();
        $feedback = $supervisi->feedbacks->first();

        return view('pengawas.pages.supervisi.show', compact(
            'supervisi',
            'instrumenPenilaian',
            'lembarObservasi',
            'catatanHasil',
            'feedback'
        ));
    }
    public function downloadPdf($id)
    {
        $supervisi = Supervision::with(['guru', 'supervisor'])->findOrFail($id);

        // Ambil data assessment
        $instrumenPenilaian = $supervisi->assessments()
            ->where('assessment_type', 'instrumen_penilaian')
            ->first();

        $lembarObservasi = $supervisi->assessments()
            ->where('assessment_type', 'lembar_observasi')
            ->first();

        $catatanHasil = $supervisi->assessments()
            ->where('assessment_type', 'catatan_hasil')
            ->first();

        $feedback = $supervisi->feedbacks->first();

        $data = [
            'supervisi' => $supervisi,
            'instrumenPenilaian' => $instrumenPenilaian,
            'lembarObservasi' => $lembarObservasi,
            'catatanHasil' => $catatanHasil,
            'feedback' => $feedback,
        ];

        // Generate PDF dengan 4 halaman
        $pdf = Pdf::loadView('pengawas.pages.supervisi.pdf-complete', $data);

        // Set paper size dan orientasi
        $pdf->setPaper('a4', 'portrait');

        // Nama file
        $filename = 'Supervisi_' . str_replace(' ', '_', $supervisi->guru->name) . '_' . date('YmdHis') . '.pdf';

        // Download PDF
        return $pdf->download($filename);
    }

    /**
     * View PDF di browser
     */
    public function viewPdf($id)
    {
        $supervisi = Supervision::with(['guru', 'supervisor'])->findOrFail($id);

        // Ambil data assessment
        $instrumenPenilaian = $supervisi->assessments()
            ->where('assessment_type', 'instrumen_penilaian')
            ->first();

        $lembarObservasi = $supervisi->assessments()
            ->where('assessment_type', 'lembar_observasi')
            ->first();

        $catatanHasil = $supervisi->assessments()
            ->where('assessment_type', 'catatan_hasil')
            ->first();

        $feedback = $supervisi->feedbacks->first();

        $data = [
            'supervisi' => $supervisi,
            'instrumenPenilaian' => $instrumenPenilaian,
            'lembarObservasi' => $lembarObservasi,
            'catatanHasil' => $catatanHasil,
            'feedback' => $feedback,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('pengawas.pages.supervisi.pdf-complete', $data);
        $pdf->setPaper('a4', 'portrait');

        // Stream PDF ke browser
        return $pdf->stream('Supervisi_' . str_replace(' ', '_', $supervisi->guru->name) . '.pdf');
    }
}
