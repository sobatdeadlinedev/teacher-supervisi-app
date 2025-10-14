<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WaliKelasController extends Controller
{
    public function index()
    {
        // Ambil semua siswa dengan relasi wali kelas
        $siswa = User::role('siswa')
            ->with(['waliKelas' => function ($query) {
                $query->select('users.id', 'users.name');
            }])
            ->orderBy('name')
            ->get();

        // Ambil semua wali kelas (guru)
        $waliKelas = User::role('guru')
            ->orderBy('name')
            ->get();

        Log::info('Wali Kelas Index accessed', [
            'total_siswa' => $siswa->count(),
            'total_wali_kelas' => $waliKelas->count()
        ]);

        return view('admin.pages.wali-kelas.index', compact('siswa', 'waliKelas'));
    }

    public function assign(Request $request)
    {
        try {
            $validated = $request->validate([
                'siswa_id' => 'required|exists:users,id',
                'wali_kelas_id' => 'required|exists:users,id'
            ]);

            $siswa = User::findOrFail($validated['siswa_id']);

            // Hapus wali kelas lama jika ada
            $siswa->waliKelas()->detach();

            // Assign wali kelas baru
            $siswa->waliKelas()->attach($validated['wali_kelas_id']);

            Log::info('Wali Kelas assigned', $validated);

            return redirect()->route('admin.wali-kelas.index')
                ->with('success', 'Wali kelas berhasil ditugaskan');
        } catch (\Exception $e) {
            Log::error('Error assigning wali kelas', [
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menugaskan wali kelas: ' . $e->getMessage());
        }
    }

    public function remove($siswaId)
    {
        try {
            $siswa = User::findOrFail($siswaId);
            $siswa->waliKelas()->detach();

            Log::info('Wali Kelas removed', ['siswa_id' => $siswaId]);

            return redirect()->route('admin.wali-kelas.index')
                ->with('success', 'Wali kelas berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error removing wali kelas', [
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menghapus wali kelas: ' . $e->getMessage());
        }
    }

    public function bulkAssign(Request $request)
    {
        try {
            $validated = $request->validate([
                'siswa_ids' => 'required|array',
                'siswa_ids.*' => 'exists:users,id',
                'wali_kelas_id' => 'required|exists:users,id'
            ]);

            DB::beginTransaction();

            foreach ($validated['siswa_ids'] as $siswaId) {
                $siswa = User::findOrFail($siswaId);
                $siswa->waliKelas()->sync([$validated['wali_kelas_id']]);
            }

            DB::commit();

            Log::info('Bulk Wali Kelas assigned', [
                'count' => count($validated['siswa_ids']),
                'wali_kelas_id' => $validated['wali_kelas_id']
            ]);

            return redirect()->route('admin.wali-kelas.index')
                ->with('success', count($validated['siswa_ids']) . ' siswa berhasil ditugaskan ke wali kelas');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error bulk assigning wali kelas', [
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal bulk assign: ' . $e->getMessage());
        }
    }
}
