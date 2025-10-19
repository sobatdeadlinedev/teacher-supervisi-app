<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class WaliKelasController extends Controller
{
    /**
     * Display all students with their assigned wali kelas
     *
     * Retrieves all students with their current wali kelas (class teacher) assignments
     * and loads the list of available teachers for assignment.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $siswa = User::role('siswa')
                ->with(['waliKelas' => function ($query) {
                    $query->select('users.id', 'users.name');
                }])
                ->orderBy('name')
                ->paginate(20);

            $waliKelas = User::role('guru')
                ->orderBy('name')
                ->get();

            Log::info('Wali Kelas Index accessed', [
                'total_siswa' => $siswa->total(),
                'total_wali_kelas' => $waliKelas->count(),
                'user_id' => auth()->id(),
            ]);

            return view('admin.pages.wali-kelas.index', compact('siswa', 'waliKelas'));
        } catch (Exception $e) {
            Log::error('Failed to retrieve wali kelas data', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal memuat data wali kelas. Silakan coba lagi.');
        }
    }

    /**
     * Assign a wali kelas to a single student
     *
     * Replaces the current wali kelas assignment (if any) with a new one.
     * Uses database transaction to ensure consistency.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assign(Request $request)
    {
        Log::info('Wali Kelas Assign Request initiated', [
            'siswa_id' => $request->input('siswa_id'),
            'user_id' => auth()->id(),
        ]);

        try {
            $validated = $this->validateAssignment($request);

            $siswa = User::role('siswa')->findOrFail($validated['siswa_id']);
            $waliKelas = User::role('guru')->findOrFail($validated['wali_kelas_id']);

            DB::transaction(function () use ($siswa, $validated) {
                $siswa->waliKelas()->sync([$validated['wali_kelas_id']]);
            });

            Log::info('Wali Kelas assigned successfully', [
                'siswa_id' => $validated['siswa_id'],
                'wali_kelas_id' => $validated['wali_kelas_id'],
                'assigned_by' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.wali-kelas.index')
                ->with('success', "Wali kelas untuk {$siswa->name} berhasil ditugaskan.");
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (Exception $e) {
            Log::error('Failed to assign wali kelas', [
                'error' => $e->getMessage(),
                'siswa_id' => $request->input('siswa_id'),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal menugaskan wali kelas. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Remove wali kelas assignment from a student
     *
     * Detaches all wali kelas assignments for the specified student.
     *
     * @param int $siswaId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($siswaId)
    {
        Log::info('Wali Kelas Remove Request initiated', [
            'siswa_id' => $siswaId,
            'user_id' => auth()->id(),
        ]);

        try {
            $siswa = User::role('siswa')->findOrFail($siswaId);

            DB::transaction(function () use ($siswa) {
                $siswa->waliKelas()->detach();
            });

            Log::info('Wali Kelas removed successfully', [
                'siswa_id' => $siswaId,
                'removed_by' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.wali-kelas.index')
                ->with('success', "Wali kelas untuk {$siswa->name} berhasil dihapus.");
        } catch (Exception $e) {
            Log::error('Failed to remove wali kelas', [
                'error' => $e->getMessage(),
                'siswa_id' => $siswaId,
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus wali kelas. Silakan coba lagi.');
        }
    }

    /**
     * Assign a wali kelas to multiple students at once
     *
     * Bulk assigns the same wali kelas to multiple students. All operations
     * are performed within a database transaction for consistency.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkAssign(Request $request)
    {
        Log::info('Bulk Wali Kelas Assign Request initiated', [
            'count' => count($request->input('siswa_ids', [])),
            'user_id' => auth()->id(),
        ]);

        try {
            $validated = $this->validateBulkAssignment($request);

            // Verify wali kelas exists and has guru role
            $waliKelas = User::role('guru')->findOrFail($validated['wali_kelas_id']);

            DB::transaction(function () use ($validated) {
                // Verify all students exist and have siswa role
                $siswaIds = $validated['siswa_ids'];
                $siswaCount = User::role('siswa')
                    ->whereIn('id', $siswaIds)
                    ->count();

                if ($siswaCount !== count($siswaIds)) {
                    throw new Exception('Beberapa siswa tidak ditemukan.');
                }

                foreach ($siswaIds as $siswaId) {
                    $siswa = User::find($siswaId);
                    $siswa->waliKelas()->sync([$validated['wali_kelas_id']]);
                }
            });

            Log::info('Bulk Wali Kelas assigned successfully', [
                'count' => count($validated['siswa_ids']),
                'wali_kelas_id' => $validated['wali_kelas_id'],
                'assigned_by' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.wali-kelas.index')
                ->with('success', count($validated['siswa_ids']) . ' siswa berhasil ditugaskan ke wali kelas ' . $waliKelas->name . '.');
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (Exception $e) {
            Log::error('Failed to bulk assign wali kelas', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal melakukan bulk assign. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Validate single assignment request
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateAssignment(Request $request): array
    {
        return $request->validate([
            'siswa_id' => 'required|integer|exists:users,id',
            'wali_kelas_id' => 'required|integer|exists:users,id',
        ], [
            'siswa_id.required' => 'Siswa wajib dipilih.',
            'siswa_id.exists' => 'Siswa yang dipilih tidak ditemukan.',
            'wali_kelas_id.required' => 'Wali kelas wajib dipilih.',
            'wali_kelas_id.exists' => 'Wali kelas yang dipilih tidak ditemukan.',
        ]);
    }

    /**
     * Validate bulk assignment request
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateBulkAssignment(Request $request): array
    {
        return $request->validate([
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'integer|exists:users,id',
            'wali_kelas_id' => 'required|integer|exists:users,id',
        ], [
            'siswa_ids.required' => 'Minimal harus memilih satu siswa.',
            'siswa_ids.array' => 'Format data siswa tidak valid.',
            'siswa_ids.min' => 'Minimal harus memilih satu siswa.',
            'siswa_ids.*.exists' => 'Beberapa siswa yang dipilih tidak ditemukan.',
            'wali_kelas_id.required' => 'Wali kelas wajib dipilih.',
            'wali_kelas_id.exists' => 'Wali kelas yang dipilih tidak ditemukan.',
        ]);
    }
}
