<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\LaporanSiswaBermasalah;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the laporan.
     */
    public function index()
    {
        $laporans = LaporanSiswaBermasalah::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('guru.pages.laporan.index', compact('laporans'));
    }

    /**
     * Store a newly created laporan in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas' => 'required|string|max:50',
            'nama_siswa' => 'required|string|max:100',
            'keadaan_masalah' => 'required|string',
            'penanganan' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        LaporanSiswaBermasalah::create($validated);

        return redirect()->route('guru.laporan.index')
            ->with('success', 'Laporan berhasil ditambahkan');
    }

    /**
     * Update the specified laporan in storage.
     */
    public function update(Request $request, LaporanSiswaBermasalah $laporan)
    {
        // Cek apakah user adalah pemilik laporan
        if ($laporan->user_id !== auth()->id()) {
            return redirect()->route('guru.laporan.index')
                ->with('error', 'Anda tidak memiliki akses ke laporan ini');
        }

        $validated = $request->validate([
            'kelas' => 'required|string|max:50',
            'nama_siswa' => 'required|string|max:100',
            'keadaan_masalah' => 'required|string',
            'penanganan' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $laporan->update($validated);

        return redirect()->route('guru.laporan.index')
            ->with('success', 'Laporan berhasil diperbarui');
    }

    /**
     * Delete the specified laporan from storage.
     */
    public function destroy(LaporanSiswaBermasalah $laporan)
    {
        // Cek apakah user adalah pemilik laporan
        if ($laporan->user_id !== auth()->id()) {
            return redirect()->route('guru.laporan.index')
                ->with('error', 'Anda tidak memiliki akses ke laporan ini');
        }

        $laporan->delete();

        return redirect()->route('guru.laporan.index')
            ->with('success', 'Laporan berhasil dihapus');
    }
}
