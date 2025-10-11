<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\LearningAdministrationFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdministrasiController extends Controller
{
    public function index()
    {
        $files = LearningAdministrationFile::with('user')->latest()->get();
        return view('kepala-sekolah.pages.administrasi.index', compact('files'));
    }

    public function show($id)
    {
        $file = LearningAdministrationFile::with('user')->findOrFail($id);
        return view('kepala-sekolah.pages.administrasi.show', compact('file'));
    }

    public function approve($id)
    {
        $file = LearningAdministrationFile::findOrFail($id);
        $file->update(['status' => 'approved']);

        return redirect()->route('kepala-sekolah.administrasi.index')->with('success', 'File berhasil di-approve');
    }

    public function reject($id)
    {
        $file = LearningAdministrationFile::findOrFail($id);
        $file->update(['status' => 'rejected']);

        return redirect()->route('kepala-sekolah.administrasi.index')->with('success', 'File berhasil ditolak');
    }

    public function preview($id)
    {
        $file = LearningAdministrationFile::findOrFail($id);

        // Pastikan file exists di storage local
        if (!Storage::disk('local')->exists($file->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        // Ambil file dari storage local
        $filePath = Storage::disk('local')->path($file->file_path);

        // Return response dengan header yang tepat untuk preview di browser
        return response()->file($filePath, [
            'Content-Type' => $file->mime_type,
            'Content-Disposition' => 'inline; filename="' . $file->original_filename . '"'
        ]);
    }

    public function download($id)
    {
        $file = LearningAdministrationFile::findOrFail($id);

        if (!Storage::disk('local')->exists($file->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::disk('local')->download($file->file_path, $file->original_filename);
    }
}
