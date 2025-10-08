<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Supervision;
use App\Models\User;
use Illuminate\Http\Request;

class SupervisiController extends Controller
{
    /**
     * Halaman daftar pengajuan supervisi
     */
    public function index()
    {
        $supervisions = Supervision::where('guru_id', auth()->id())
            ->with(['supervisor'])
            ->latest()
            ->paginate(10);

        return view('guru.pages.supervisi.index', compact('supervisions'));
    }

    /**
     * Simpan pengajuan supervisi
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_date' => 'required|date|after_or_equal:today',
            'schedule_time' => 'nullable',
            'mata_pelajaran' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Otomatis ambil kepala sekolah sebagai supervisor
        $kepalaSekolah = User::role('kepala_sekolah')->first();

        if (!$kepalaSekolah) {
            return redirect()->back()
                ->with('error', 'Kepala sekolah tidak ditemukan. Hubungi administrator.');
        }

        Supervision::create([
            'guru_id' => auth()->id(),
            'supervisor_id' => $kepalaSekolah->id,
            'schedule_date' => $validated['schedule_date'],
            'schedule_time' => $validated['schedule_time'],
            'mata_pelajaran' => $validated['mata_pelajaran'],
            'kelas' => $validated['kelas'],
            'notes' => $validated['notes'],
            'status' => 'scheduled',
        ]);

        return redirect()->route('guru.supervisi.index')
            ->with('success', 'Pengajuan supervisi berhasil diajukan!');
    }

    /**
     * Update pengajuan supervisi
     */
    public function update(Request $request, Supervision $supervisi)
    {
        if ($supervisi->guru_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if ($supervisi->status !== 'scheduled') {
            return redirect()->back()
                ->with('error', 'Supervisi tidak dapat diubah');
        }

        $validated = $request->validate([
            'schedule_date' => 'required|date|after_or_equal:today',
            'schedule_time' => 'nullable',
            'mata_pelajaran' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $supervisi->update($validated);

        return redirect()->route('guru.supervisi.index')
            ->with('success', 'Pengajuan supervisi berhasil diperbarui!');
    }

    /**
     * Hapus pengajuan supervisi
     */
    public function destroy(Supervision $supervisi)
    {
        if ($supervisi->guru_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if ($supervisi->status !== 'scheduled') {
            return redirect()->back()
                ->with('error', 'Supervisi tidak dapat dihapus');
        }

        $supervisi->delete();

        return redirect()->route('guru.supervisi.index')
            ->with('success', 'Pengajuan supervisi berhasil dihapus!');
    }

    /**
     * Halaman log/riwayat supervisi
     */
    public function log()
    {
        $supervisions = Supervision::where('guru_id', auth()->id())
            ->with(['supervisor', 'assessments', 'feedbacks'])
            ->latest()
            ->paginate(10);

        return view('guru.pages.supervisi.log', compact('supervisions'));
    }

    /**
     * Detail supervisi
     */
    public function show(Supervision $supervisi)
    {
        if ($supervisi->guru_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $supervisi->load(['supervisor', 'assessments', 'feedbacks']);

        return view('guru.pages.supervisi.show', ['supervision' => $supervisi]);
    }
}
