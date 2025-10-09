<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\LearningAdministrationFile;
use Illuminate\Http\Request;

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
}
