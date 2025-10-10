<?php

namespace App\Http\Controllers\Pengawas;

use App\Models\Supervision;
use Illuminate\Http\Request;
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
}
