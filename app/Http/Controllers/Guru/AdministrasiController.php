<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\LearningAdministrationFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdministrasiController extends Controller
{
    public function index()
    {
        $files = LearningAdministrationFile::where('user_id', auth()->id())->latest()->get();
        return view('guru.pages.administrasi.index', compact('files'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'file_type' => 'required|string',
            'mata_pelajaran' => 'required|string',
            'kelas' => 'required|string',
            'semester' => 'required|string',
            'tahun_ajaran' => 'required|integer',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $storedName = time() . '_' . auth()->id() . '_' . $file->hashName();
        $mimeType = $file->getMimeType();
        $fileSize = $file->getSize();

        $path = $file->storeAs('learning_administration_files', $storedName, 'local');

        $validated['user_id'] = auth()->id();
        $validated['original_filename'] = $originalName;
        $validated['stored_filename'] = $storedName;
        $validated['file_path'] = $path;
        $validated['mime_type'] = $mimeType;
        $validated['file_size'] = $fileSize;
        $validated['status'] = 'waiting_approve';

        LearningAdministrationFile::create($validated);

        return redirect()->route('guru.administrasi.index')->with('success', 'File berhasil diupload');
    }

    public function edit($id)
    {
        $file = LearningAdministrationFile::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        if (!in_array($file->status, ['waiting_approve', 'revision'])) {
            return redirect()->route('guru.administrasi.index')->with('error', 'File tidak bisa diedit karena sudah di-approve atau ditolak');
        }

        return view('guru.pages.administrasi.edit', compact('file'));
    }

    public function update(Request $request, $id)
    {
        $file = LearningAdministrationFile::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        if (!in_array($file->status, ['waiting_approve', 'revision'])) {
            return redirect()->route('guru.administrasi.index')->with('error', 'File tidak bisa diupdate karena sudah di-approve atau ditolak');
        }

        $validated = $request->validate([
            'file_type' => 'required|string',
            'mata_pelajaran' => 'required|string',
            'kelas' => 'required|string',
            'semester' => 'required|string',
            'tahun_ajaran' => 'required|integer',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('local')->delete($file->file_path);

            $newFile = $request->file('file');
            $originalName = $newFile->getClientOriginalName();
            $storedName = time() . '_' . auth()->id() . '_' . $newFile->hashName();
            $mimeType = $newFile->getMimeType();
            $fileSize = $newFile->getSize();

            $path = $newFile->storeAs('learning_administration_files', $storedName, 'local');

            $validated['original_filename'] = $originalName;
            $validated['stored_filename'] = $storedName;
            $validated['file_path'] = $path;
            $validated['mime_type'] = $mimeType;
            $validated['file_size'] = $fileSize;
        }

        // Jika file sebelumnya status revisi, ubah status menjadi waiting_approve
        if ($file->status === 'revision') {
            $validated['status'] = 'waiting_approve';
        }

        $file->update($validated);

        $message = $file->status === 'revision' ? 'File revisi berhasil diupload. Menunggu persetujuan.' : 'File berhasil diupdate';

        return redirect()->route('guru.administrasi.index')->with('success', $message);
    }

    public function destroy($id)
    {
        $file = LearningAdministrationFile::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        if (!in_array($file->status, ['waiting_approve', 'revision'])) {
            return redirect()->route('guru.administrasi.index')->with('error', 'File tidak bisa dihapus karena sudah di-approve atau ditolak');
        }

        Storage::disk('local')->delete($file->file_path);
        $file->delete();

        return redirect()->route('guru.administrasi.index')->with('success', 'File berhasil dihapus');
    }
}
