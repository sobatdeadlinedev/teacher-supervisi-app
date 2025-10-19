<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Exception;

class UserManagementController extends Controller
{
    /**
     * Display a list of all users with their roles
     *
     * Retrieves all users with their assigned roles and available roles for assignment.
     * Also loads teacher users for wali kelas (class teacher) assignment.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $users = User::with('roles')->latest()->paginate(15);
            $roles = Role::all();
            $waliKelas = User::role('guru')->orderBy('name')->get();

            Log::info('User Management Index accessed', [
                'total_users' => $users->total(),
                'total_roles' => $roles->count(),
                'user_id' => auth()->id(),
            ]);

            return view('admin.pages.user-management.index', compact('users', 'roles', 'waliKelas'));
        } catch (Exception $e) {
            Log::error('Failed to retrieve users', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal memuat data pengguna. Silakan coba lagi.');
        }
    }

    /**
     * Store a newly created user in storage
     *
     * Creates a new user with hashed password, assigns a role, and optionally
     * assigns a wali kelas (class teacher) if the user is a student.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Log::info('User Create Request initiated', [
            'email' => $request->input('email'),
            'user_id' => auth()->id(),
        ]);

        try {
            $validated = $this->validateUserInput($request);

            // Use transaction to ensure data consistency
            $user = DB::transaction(function () use ($validated) {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                ]);

                // Assign role if provided
                if (!empty($validated['role'])) {
                    $user->assignRole($validated['role']);

                    // Assign wali kelas if user is siswa (student)
                    if ($validated['role'] === 'siswa' && !empty($validated['wali_kelas_id'])) {
                        $user->waliKelas()->attach($validated['wali_kelas_id']);
                    }
                }

                return $user;
            });

            Log::info('User created successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $validated['role'] ?? 'none',
                'created_by' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (Exception $e) {
            Log::error('Failed to create user', [
                'error' => $e->getMessage(),
                'email' => $request->input('email'),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal menambahkan user. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Update the specified user in storage
     *
     * Updates user information, password (if provided), role assignment,
     * and wali kelas relationship for students.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        Log::info('User Update Request initiated', [
            'target_user_id' => $id,
            'user_id' => auth()->id(),
        ]);

        try {
            $user = User::findOrFail($id);

            // Prevent users from modifying others' accounts without proper authorization
            if (!auth()->user()->can('edit users') && $user->id !== auth()->id()) {
                Log::warning('Unauthorized update attempt', [
                    'target_user_id' => $id,
                    'user_id' => auth()->id(),
                ]);

                return redirect()
                    ->back()
                    ->with('error', 'Anda tidak memiliki izin untuk mengubah user ini.');
            }

            $validated = $this->validateUserInput($request, $id);

            // Use transaction to ensure data consistency
            DB::transaction(function () use ($user, $validated) {
                $user->update([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                ]);

                // Update password only if provided
                if (!empty($validated['password'])) {
                    $user->update(['password' => Hash::make($validated['password'])]);
                }

                // Sync roles
                if (!empty($validated['role'])) {
                    $user->syncRoles([$validated['role']]);

                    // Handle wali kelas assignment
                    $this->syncWaliKelas($user, $validated);
                } else {
                    $user->syncRoles([]);
                    $user->waliKelas()->detach();
                }
            });

            Log::info('User updated successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $validated['role'] ?? 'none',
                'updated_by' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User berhasil diperbarui.');
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (Exception $e) {
            Log::error('Failed to update user', [
                'error' => $e->getMessage(),
                'target_user_id' => $id,
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui user. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Remove the specified user from storage
     *
     * Soft delete a user from the system. Prevents users from deleting their own account.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Log::info('User Delete Request initiated', [
            'target_user_id' => $id,
            'user_id' => auth()->id(),
        ]);

        try {
            $user = User::findOrFail($id);

            // Prevent deleting own account
            if ($user->id === auth()->id()) {
                Log::warning('User attempted to delete own account', [
                    'user_id' => auth()->id(),
                ]);

                return redirect()
                    ->route('admin.users.index')
                    ->with('error', 'Tidak dapat menghapus akun sendiri.');
            }

            // Prevent deleting admin/super admin users without proper authorization
            if ($user->hasAnyRole(['admin', 'super_admin']) && !auth()->user()->hasRole('super_admin')) {
                Log::warning('Unauthorized admin deletion attempt', [
                    'target_user_id' => $id,
                    'user_id' => auth()->id(),
                ]);

                return redirect()
                    ->back()
                    ->with('error', 'Anda tidak dapat menghapus pengguna administrator.');
            }

            DB::transaction(function () use ($user) {
                $user->waliKelas()->detach();
                $user->delete();
            });

            Log::info('User deleted successfully', [
                'deleted_user_id' => $id,
                'deleted_by' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User berhasil dihapus.');
        } catch (Exception $e) {
            Log::error('Failed to delete user', [
                'error' => $e->getMessage(),
                'target_user_id' => $id,
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus user. Silakan coba lagi.');
        }
    }

    /**
     * Validate user input data
     *
     * @param \Illuminate\Http\Request $request
     * @param int|null $userId
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateUserInput(Request $request, ?int $userId = null): array
    {
        $emailUnique = $userId ? "unique:users,email,$userId" : 'unique:users,email';

        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|{$emailUnique}",
            'password' => $userId ? 'nullable|min:8' : 'required|min:8',
            'role' => 'nullable|string|exists:roles,name',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'name.max' => 'Nama pengguna tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'role.exists' => 'Role yang dipilih tidak valid.',
            'wali_kelas_id.exists' => 'Wali kelas yang dipilih tidak valid.',
        ]);
    }

    /**
     * Sync wali kelas relationship for students
     *
     * Handles the assignment and removal of wali kelas (class teacher)
     * for student users.
     *
     * @param \App\Models\User $user
     * @param array $validated
     * @return void
     */
    private function syncWaliKelas(User $user, array $validated): void
    {
        if ($validated['role'] === 'siswa') {
            if (!empty($validated['wali_kelas_id'])) {
                $user->waliKelas()->sync([$validated['wali_kelas_id']]);
            } else {
                $user->waliKelas()->detach();
            }
        } else {
            // Remove wali kelas relation if user is not a student
            $user->waliKelas()->detach();
        }
    }
}
