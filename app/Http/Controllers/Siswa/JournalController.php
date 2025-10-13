<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\StudentJournal;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    // Validasi rules untuk setiap tipe journal
    private $validationRules = [
        'bangun_pagi' => [
            'nama_lengkap' => 'required|string|max:255',
            'no_absen' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'bangun_pukul' => 'required|string',
            'aktivitas_setelah_bangun' => 'required|string',
        ],
        'beribadah' => [
            'nama_siswa' => 'required|string|max:255',
            'student_number' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'sholat_wajib' => 'required|array',
            'sholat_sunnah' => 'nullable|array',
            'tadarus_alquran' => 'nullable|string',
        ],
        'olahraga' => [
            'nama_anak' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'student_number' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'kegiatan_olahraga' => 'required|string',
        ],
        'makan_sehat' => [
            'nama_lengkap' => 'required|string|max:255',
            'no_absen' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'karbohidrat' => 'required|string',
            'protein' => 'required|string',
            'serat_vitamin' => 'required|string',
            'minuman_sehat' => 'required|string',
        ],
        'belajar' => [
            'nama_lengkap' => 'required|string|max:255',
            'no_absen' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'kegiatan_belajar' => 'required|array',
            'judul_buku_video' => 'nullable|string',
        ],
        'bermasyarakat' => [
            'nama_anak' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'student_number' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'kegiatan_bermasyarakat' => 'required|string',
        ],
        'tidur_cepat' => [
            'nama_lengkap' => 'required|string|max:255',
            'no_absen' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'tidur_siang' => 'nullable|string',
            'tidur_malam_pukul' => 'required|string',
        ],
    ];

    public function index()
    {
        $journals = StudentJournal::where('user_id', auth()->id())
            ->orderBy('journal_date', 'desc')
            ->paginate(10);

        return view('siswa.pages.journal.index', compact('journals'));
    }

    public function store(Request $request, $type)
    {
        // Validasi tipe journal
        if (!in_array($type, StudentJournal::journalTypes())) {
            abort(404);
        }

        // Validasi data
        $validated = $request->validate($this->validationRules[$type]);

        // Tentukan student_number dari field yang tersedia
        $studentNumber = $validated['no_absen'] ?? $validated['student_number'] ?? null;

        StudentJournal::create([
            'user_id' => auth()->id(),
            'student_number' => $studentNumber,
            'journal_type' => $type,
            'journal_date' => $validated['tanggal'],
            'journal_data' => $validated,
        ]);

        return redirect()->route('siswa.journal.index')
            ->with('success', 'Jurnal berhasil disimpan!');
    }

    public function show(StudentJournal $journal)
    {
        $this->checkOwnership($journal);

        return view('siswa.pages.journal.show', compact('journal'));
    }

    public function edit(StudentJournal $journal)
    {
        $this->checkOwnership($journal);

        return view('siswa.pages.journal.edit', compact('journal'));
    }

    public function update(Request $request, StudentJournal $journal)
    {
        $this->checkOwnership($journal);

        // Validasi berdasarkan tipe journal yang ada
        $validated = $request->validate($this->validationRules[$journal->journal_type]);

        // Update student_number jika ada perubahan
        $studentNumber = $validated['no_absen'] ?? $validated['student_number'] ?? $journal->student_number;

        $journal->update([
            'student_number' => $studentNumber,
            'journal_data' => $validated,
        ]);

        return redirect()->route('siswa.journal.index')
            ->with('success', 'Jurnal berhasil diupdate!');
    }

    public function destroy(StudentJournal $journal)
    {
        $this->checkOwnership($journal);

        $journal->delete();

        return redirect()->route('siswa.journal.index')
            ->with('success', 'Jurnal berhasil dihapus!');
    }

    private function checkOwnership(StudentJournal $journal)
    {
        if ($journal->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
