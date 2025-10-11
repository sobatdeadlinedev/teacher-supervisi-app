<?php

namespace App\Http\Controllers\KepalaSekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LaporanSiswaBermasalah;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = LaporanSiswaBermasalah::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kepala-sekolah.pages.laporan.index', compact('laporans'));
    }

    /**
     * Update the specified laporan in storage.
     */
    public function update(Request $request, LaporanSiswaBermasalah $laporan)
    {
        $validated = $request->validate([
            'penanganan' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $laporan->update($validated);

        return redirect()->route('kepala-sekolah.laporan.index')
            ->with('success', 'Laporan berhasil diperbarui');
    }
}
