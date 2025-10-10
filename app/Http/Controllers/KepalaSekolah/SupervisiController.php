<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Supervision;
use App\Models\SupervisionAssessment;
use App\Models\SupervisionFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupervisiController extends Controller
{
    /**
     * Halaman daftar supervisi yang perlu dinilai
     */
    public function index()
    {
        $supervisions = Supervision::where('supervisor_id', auth()->id())
            ->with(['guru'])
            ->latest()
            ->paginate(10);

        return view('kepala-sekolah.pages.supervisi.index', compact('supervisions'));
    }

    /**
     * Halaman form penilaian supervisi (step form)
     */
    public function assess(Supervision $supervisi)
    {
        // Cek apakah kepala sekolah yang berwenang
        // if ($supervisi->supervisor_id !== auth()->id()) {
        //     abort(403, 'Unauthorized');
        // }

        // Cek apakah sudah completed
        if ($supervisi->status === 'completed') {
            return redirect()->route('kepala-sekolah.supervisi.show', $supervisi->id)
                ->with('info', 'Supervisi ini sudah selesai dinilai');
        }

        $supervisi->load(['guru', 'assessments', 'feedbacks']);

        return view('kepala-sekolah.pages.supervisi.assess', compact('supervisi'));
    }

    /**
     * Simpan penilaian supervisi (semua step sekaligus)
     */
    public function storeAssessment(Request $request, Supervision $supervisi)
    {
        // Log untuk debugging
        Log::info('=== SUPERVISI SUBMISSION START ===');
        Log::info('All Request Data:', $request->all());
        Log::info('Lembar Observasi Data:', $request->input('lembar_observasi'));
        Log::info('Instrumen Penilaian:', $request->input('instrumen_penilaian'));
        Log::info('Catatan Hasil:', $request->input('catatan_hasil'));

        // Validasi yang lebih fleksibel
        try {
            $validated = $request->validate([
                // Step 1: Instrumen Penilaian (Percakapan Pra-Observasi)
                'instrumen_penilaian.tujuan_pembelajaran' => 'required|string',
                'instrumen_penilaian.area_pengembangan' => 'required|string',
                'instrumen_penilaian.strategi_persiapan' => 'required|string',

                // Step 2: Lembar Observasi (Array dinamis) - Validasi minimal
                'lembar_observasi' => 'required|array|min:1',

                // Step 3: Catatan Hasil Supervisi
                'catatan_hasil.refleksi_guru' => 'required|string',
                'catatan_hasil.topik_percakapan' => 'required|string',
                'catatan_hasil.rencana_tindak_lanjut' => 'required|string',

                // Step 4: Feedback
                'feedback' => 'required|string',
                'rekomendasi' => 'nullable|string',
            ], [
                // Custom error messages
                'instrumen_penilaian.tujuan_pembelajaran.required' => 'Tujuan pembelajaran wajib diisi',
                'instrumen_penilaian.area_pengembangan.required' => 'Area pengembangan wajib diisi',
                'instrumen_penilaian.strategi_persiapan.required' => 'Strategi persiapan wajib diisi',
                'lembar_observasi.required' => 'Lembar observasi wajib diisi',
                'lembar_observasi.min' => 'Minimal harus ada 1 area observasi',
                'catatan_hasil.refleksi_guru.required' => 'Refleksi guru wajib diisi',
                'catatan_hasil.topik_percakapan.required' => 'Topik percakapan wajib diisi',
                'catatan_hasil.rencana_tindak_lanjut.required' => 'Rencana tindak lanjut wajib diisi',
                'feedback.required' => 'Feedback wajib diisi',
            ]);

            Log::info('Validation passed!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', $e->errors());
            throw $e;
        }

        // Cek authorization
        // if ($supervisi->supervisor_id !== auth()->id()) {
        //     abort(403, 'Unauthorized');
        // }

        if ($supervisi->status === 'completed') {
            return redirect()->back()
                ->with('error', 'Supervisi ini sudah selesai dinilai');
        }

        try {
            DB::beginTransaction();

            // 1. Simpan Step 1: Instrumen Penilaian (Percakapan Pra-Observasi)
            SupervisionAssessment::create([
                'supervision_id' => $supervisi->id,
                'assessment_type' => 'instrumen_penilaian',
                'assessment_data' => [
                    'tujuan_pembelajaran' => $validated['instrumen_penilaian']['tujuan_pembelajaran'],
                    'area_pengembangan' => $validated['instrumen_penilaian']['area_pengembangan'],
                    'strategi_persiapan' => $validated['instrumen_penilaian']['strategi_persiapan'],
                ],
            ]);

            // 2. Simpan Step 2: Lembar Observasi (Array dinamis)
            // Pisahkan catatan_tambahan dari items observasi
            $lembarObservasiItems = [];
            $catatanTambahan = $request->input('lembar_observasi.catatan_tambahan', '');

            // Ambil semua item observasi (yang bukan catatan_tambahan)
            foreach ($validated['lembar_observasi'] as $key => $value) {
                // Skip jika key adalah 'catatan_tambahan'
                if ($key === 'catatan_tambahan') {
                    continue;
                }

                // Key adalah index numeric (0, 1, 2, dst)
                if (is_numeric($key)) {
                    $lembarObservasiItems[] = [
                        'aspek_strategi' => $value['aspek_strategi'],
                        'status' => $value['status'],
                        'catatan_pengamatan' => $value['catatan_pengamatan'],
                    ];
                }
            }

            SupervisionAssessment::create([
                'supervision_id' => $supervisi->id,
                'assessment_type' => 'lembar_observasi',
                'assessment_data' => [
                    'items' => $lembarObservasiItems,
                    'catatan_tambahan' => $catatanTambahan,
                ],
            ]);

            Log::info('Lembar observasi saved successfully');

            // 3. Simpan Step 3: Catatan Hasil Supervisi
            SupervisionAssessment::create([
                'supervision_id' => $supervisi->id,
                'assessment_type' => 'catatan_hasil',
                'assessment_data' => [
                    'refleksi_guru' => $validated['catatan_hasil']['refleksi_guru'],
                    'topik_percakapan' => $validated['catatan_hasil']['topik_percakapan'],
                    'rencana_tindak_lanjut' => $validated['catatan_hasil']['rencana_tindak_lanjut'],
                ],
            ]);

            // 4. Simpan Step 4: Feedback
            SupervisionFeedback::create([
                'supervision_id' => $supervisi->id,
                'feedback' => $validated['feedback'],
                'rekomendasi' => $validated['rekomendasi'],
            ]);

            // 5. Update status supervisi menjadi completed
            $supervisi->update([
                'status' => 'completed',
            ]);

            DB::commit();

            return redirect()->route('kepala-sekolah.supervisi.index')
                ->with('success', 'Penilaian supervisi berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Log error untuk debugging
            Log::error('Error saving supervision assessment: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Detail/hasil supervisi yang sudah completed
     */
    public function show(Supervision $supervisi)
    {

        $supervisi->load(['guru', 'assessments', 'feedbacks', 'supervisor']);

        // Kelompokkan assessment berdasarkan tipe
        $instrumenPenilaian = $supervisi->assessments->where('assessment_type', 'instrumen_penilaian')->first();
        $lembarObservasi = $supervisi->assessments->where('assessment_type', 'lembar_observasi')->first();
        $catatanHasil = $supervisi->assessments->where('assessment_type', 'catatan_hasil')->first();
        $feedback = $supervisi->feedbacks->first();

        return view('kepala-sekolah.pages.supervisi.show', compact(
            'supervisi',
            'instrumenPenilaian',
            'lembarObservasi',
            'catatanHasil',
            'feedback'
        ));
    }

    /**
     * Batalkan supervisi
     */
    public function cancel(Supervision $supervisi)
    {

        if ($supervisi->status !== 'scheduled') {
            return redirect()->back()
                ->with('error', 'Supervisi tidak dapat dibatalkan');
        }

        $supervisi->update([
            'status' => 'cancelled',
        ]);

        return redirect()->route('kepala-sekolah.supervisi.index')
            ->with('success', 'Supervisi berhasil dibatalkan');
    }
}
