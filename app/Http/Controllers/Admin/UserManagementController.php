<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->get();
        $roles = Role::all();

        // Ambil semua guru untuk dropdown wali kelas
        $waliKelas = User::role('guru')->orderBy('name')->get();

        Log::info('User Management Index accessed', [
            'total_users' => $users->count(),
            'total_roles' => $roles->count()
        ]);

        return view('admin.pages.user-management.index', compact('users', 'roles', 'waliKelas'));
    }

    public function store(Request $request)
    {
        Log::info('User Store Request', $request->except('password'));

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
                'role' => 'nullable|string|exists:roles,name',
                'wali_kelas_id' => 'nullable|exists:users,id'
            ]);

            Log::info('Validation passed', $validated);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            Log::info('User created', ['user_id' => $user->id]);

            // Assign single role
            if (isset($validated['role'])) {
                $user->assignRole($validated['role']);
                Log::info('Role assigned', ['role' => $validated['role']]);

                // Jika role siswa dan ada wali kelas, assign ke tabel wali_kelas_siswa
                if ($validated['role'] === 'siswa' && isset($validated['wali_kelas_id'])) {
                    $user->waliKelas()->attach($validated['wali_kelas_id']);
                    Log::info('Wali Kelas assigned to siswa', [
                        'siswa_id' => $user->id,
                        'wali_kelas_id' => $validated['wali_kelas_id']
                    ]);
                }
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error storing user', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('User Update Request', [
            'id' => $id,
            'data' => $request->except('password')
        ]);

        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|min:8',
                'role' => 'nullable|string|exists:roles,name',
                'wali_kelas_id' => 'nullable|exists:users,id'
            ]);

            Log::info('Update validation passed', $validated);

            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            if (!empty($validated['password'])) {
                $user->update(['password' => Hash::make($validated['password'])]);
                Log::info('Password updated');
            }

            // Sync single role
            if (isset($validated['role'])) {
                $user->syncRoles([$validated['role']]);
                Log::info('Role synced', ['role' => $validated['role']]);

                // Handle wali kelas untuk siswa
                if ($validated['role'] === 'siswa') {
                    if (isset($validated['wali_kelas_id'])) {
                        // Sync wali kelas (replace yang lama)
                        $user->waliKelas()->sync([$validated['wali_kelas_id']]);
                        Log::info('Wali Kelas synced', [
                            'siswa_id' => $user->id,
                            'wali_kelas_id' => $validated['wali_kelas_id']
                        ]);
                    } else {
                        // Hapus wali kelas jika tidak dipilih
                        $user->waliKelas()->detach();
                    }
                } else {
                    // Jika bukan siswa, hapus relasi wali kelas (jika ada)
                    $user->waliKelas()->detach();
                }
            } else {
                $user->syncRoles([]); // Remove all roles if none selected
                $user->waliKelas()->detach(); // Remove wali kelas relation
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error updating user', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate user: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        Log::info('User Delete Request', ['id' => $id]);

        try {
            $user = User::findOrFail($id);

            // Prevent deleting own account
            if ($user->id === auth()->id()) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Tidak dapat menghapus akun sendiri');
            }

            $user->delete();

            Log::info('User deleted successfully', ['id' => $id]);

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting user', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
