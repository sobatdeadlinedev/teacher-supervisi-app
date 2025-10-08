<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use Illuminate\Http\Request;

class JurnalController extends Controller
{
    public function index()
    {
        $jurnals = Jurnal::latest()->get();
        return view('guru.pages.jurnal.index', compact('jurnals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari_tanggal' => 'required|date',
            'kelas' => 'required|string',
            'jam_ke' => 'required|string',
            'materi_pokok' => 'required|string',
            'kegiatan_pembelajaran' => 'required|string',
            'penilaian_pembelajaran' => 'required|string',
            'hadir' => 'required|integer|min:0',
            'sakit' => 'required|integer|min:0',
            'izin' => 'required|integer|min:0',
            'alfa' => 'required|integer|min:0',
        ]);

        $validated['kehadiran_peserta_didik'] = [
            'H' => $validated['hadir'],
            'S' => $validated['sakit'],
            'I' => $validated['izin'],
            'A' => $validated['alfa'],
        ];

        unset($validated['hadir'], $validated['sakit'], $validated['izin'], $validated['alfa']);

        Jurnal::create($validated);

        return redirect()->route('guru.jurnal.index')->with('success', 'Jurnal berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $jurnal = Jurnal::findOrFail($id);

        $validated = $request->validate([
            'hari_tanggal' => 'required|date',
            'kelas' => 'required|string',
            'jam_ke' => 'required|string',
            'materi_pokok' => 'required|string',
            'kegiatan_pembelajaran' => 'required|string',
            'penilaian_pembelajaran' => 'required|string',
            'hadir' => 'required|integer|min:0',
            'sakit' => 'required|integer|min:0',
            'izin' => 'required|integer|min:0',
            'alfa' => 'required|integer|min:0',
        ]);

        $validated['kehadiran_peserta_didik'] = [
            'H' => $validated['hadir'],
            'S' => $validated['sakit'],
            'I' => $validated['izin'],
            'A' => $validated['alfa'],
        ];

        unset($validated['hadir'], $validated['sakit'], $validated['izin'], $validated['alfa']);

        $jurnal->update($validated);

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        $jurnal->delete();

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil dihapus');
    }
}
