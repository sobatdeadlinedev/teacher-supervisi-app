<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\StudentJournal;
use App\Http\Controllers\Controller;

class StudentJournalController extends Controller
{
    public function index()
    {
        // Ambil semua siswa yang punya jurnal, dengan hitungan per tipe
        $students = User::role('siswa')
            ->whereHas('studentJournals')
            ->withCount([
                'studentJournals as total_journals',
                'studentJournals as bangun_pagi_count' => function ($query) {
                    $query->where('journal_type', 'bangun_pagi');
                },
                'studentJournals as beribadah_count' => function ($query) {
                    $query->where('journal_type', 'beribadah');
                },
                'studentJournals as olahraga_count' => function ($query) {
                    $query->where('journal_type', 'olahraga');
                },
                'studentJournals as makan_sehat_count' => function ($query) {
                    $query->where('journal_type', 'makan_sehat');
                },
                'studentJournals as belajar_count' => function ($query) {
                    $query->where('journal_type', 'belajar');
                },
                'studentJournals as bermasyarakat_count' => function ($query) {
                    $query->where('journal_type', 'bermasyarakat');
                },
                'studentJournals as tidur_cepat_count' => function ($query) {
                    $query->where('journal_type', 'tidur_cepat');
                }
            ])
            ->get();

        return view('kepala-sekolah.pages.student-journal.index', compact('students'));
    }

    public function show($userId)
    {
        $student = User::role('siswa')->findOrFail($userId);

        $journals = StudentJournal::where('user_id', $userId)
            ->orderBy('journal_date', 'desc')
            ->paginate(15);

        return view('kepala-sekolah.pages.student-journal.show', compact('student', 'journals'));
    }
}
