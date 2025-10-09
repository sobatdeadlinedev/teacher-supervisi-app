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
        if ($supervisi->supervisor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

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
        Log::info('Submission Data:', $request->all());

        // Validasi yang diperbaiki
        $validated = $request->validate([
            // Instrumen Penilaian
            'instrumen_penilaian.penguasaan_materi' => 'required|integer|min:1|max:4',
            'instrumen_penilaian.strategi_pembelajaran' => 'required|integer|min:1|max:4',
            'instrumen_penilaian.pengelolaan_kelas' => 'required|integer|min:1|max:4',
            'instrumen_penilaian.komunikasi' => 'required|integer|min:1|max:4',
            'instrumen_penilaian.media_pembelajaran' => 'required|integer|min:1|max:4',
            'instrumen_penilaian.catatan' => 'required|string',

            // Lembar Observasi - checkbox array bisa kosong atau tidak ada
            'lembar_observasi.pendahuluan' => 'nullable|array',
            'lembar_observasi.inti' => 'nullable|array',
            'lembar_observasi.penutup' => 'nullable|array',
            'lembar_observasi.catatan' => 'required|string',

            // Catatan Hasil
            'catatan_hasil.kekuatan' => 'required|string',
            'catatan_hasil.kelemahan' => 'required|string',
            'catatan_hasil.saran' => 'required|string',
            'catatan_hasil.kesimpulan' => 'required|string',

            // Feedback
            'feedback' => 'required|string',
            'rekomendasi' => 'nullable|string',
        ], [
            // Custom error messages
            'instrumen_penilaian.penguasaan_materi.required' => 'Penguasaan materi wajib diisi',
            'instrumen_penilaian.strategi_pembelajaran.required' => 'Strategi pembelajaran wajib diisi',
            'instrumen_penilaian.pengelolaan_kelas.required' => 'Pengelolaan kelas wajib diisi',
            'instrumen_penilaian.komunikasi.required' => 'Komunikasi wajib diisi',
            'instrumen_penilaian.media_pembelajaran.required' => 'Media pembelajaran wajib diisi',
            'instrumen_penilaian.catatan.required' => 'Catatan tambahan wajib diisi',
            'lembar_observasi.catatan.required' => 'Catatan observasi wajib diisi',
            'catatan_hasil.kekuatan.required' => 'Kekuatan pembelajaran wajib diisi',
            'catatan_hasil.kelemahan.required' => 'Kelemahan pembelajaran wajib diisi',
            'catatan_hasil.saran.required' => 'Saran perbaikan wajib diisi',
            'catatan_hasil.kesimpulan.required' => 'Kesimpulan wajib diisi',
            'feedback.required' => 'Feedback wajib diisi',
        ]);

        // Cek authorization
        if ($supervisi->supervisor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if ($supervisi->status === 'completed') {
            return redirect()->back()
                ->with('error', 'Supervisi ini sudah selesai dinilai');
        }

        try {
            DB::beginTransaction();

            // Siapkan data dengan default empty array jika tidak ada checkbox yang dicentang
            $lembarObservasiData = [
                'pendahuluan' => $request->input('lembar_observasi.pendahuluan', []),
                'inti' => $request->input('lembar_observasi.inti', []),
                'penutup' => $request->input('lembar_observasi.penutup', []),
                'catatan' => $request->input('lembar_observasi.catatan'),
            ];

            // 1. Simpan Instrumen Penilaian
            SupervisionAssessment::create([
                'supervision_id' => $supervisi->id,
                'assessment_type' => 'instrumen_penilaian',
                'assessment_data' => $validated['instrumen_penilaian'],
            ]);

            // 2. Simpan Lembar Observasi
            SupervisionAssessment::create([
                'supervision_id' => $supervisi->id,
                'assessment_type' => 'lembar_observasi',
                'assessment_data' => $lembarObservasiData,
            ]);

            // 3. Simpan Catatan Hasil
            SupervisionAssessment::create([
                'supervision_id' => $supervisi->id,
                'assessment_type' => 'catatan_hasil',
                'assessment_data' => $validated['catatan_hasil'],
            ]);

            // 4. Simpan Feedback
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
        if ($supervisi->supervisor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

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
        if ($supervisi->supervisor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

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
