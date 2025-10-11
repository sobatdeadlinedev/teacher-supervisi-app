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

    public function revision(Request $request, $id)
    {
        $validated = $request->validate([
            'feedback' => 'required|string|min:10|max:1000',
        ], [
            'feedback.required' => 'Catatan revisi harus diisi',
            'feedback.min' => 'Catatan revisi minimal 10 karakter',
            'feedback.max' => 'Catatan revisi maksimal 1000 karakter',
        ]);

        $file = LearningAdministrationFile::findOrFail($id);
        $file->update([
            'status' => 'revision',
            'feedback' => $validated['feedback'],
        ]);

        return redirect()->route('kepala-sekolah.administrasi.index')
            ->with('success', 'File diminta untuk revisi');
    }

    public function preview($id)
    {
        $file = LearningAdministrationFile::findOrFail($id);

        if (!Storage::disk('local')->exists($file->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        $filePath = Storage::disk('local')->path($file->file_path);

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
