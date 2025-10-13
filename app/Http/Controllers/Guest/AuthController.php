<?php

namespace App\Http\Controllers\Guest;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login()
    {
        return view('guest.pages.login.index');
    }

    public function loginProcess(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        try {
            // Cek status user dulu (sebelum attempt login)
            $user = User::where('email', $request->email)->first();

            if ($user && isset($user->is_active) && !$user->is_active) {
                return back()->withErrors([
                    'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                ])->withInput($request->only('email'));
            }

            // Attempt login
            if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
                $request->session()->regenerate();

                $user = Auth::user();

                // Redirect berdasarkan role
                if ($user->hasRole('admin')) {
                    return redirect()->route('admin.dashboard.index')
                        ->with('success', 'Selamat datang, ' . $user->name);
                } elseif ($user->hasRole('guru')) {
                    return redirect()->route('guru.administrasi.index')
                        ->with('success', 'Selamat datang, ' . $user->name);
                } elseif ($user->hasRole('kepala_sekolah')) {
                    return redirect()->route('kepala-sekolah.supervisi.index')
                        ->with('success', 'Selamat datang, ' . $user->name);
                } elseif ($user->hasRole('pengawas')) {
                    return redirect()->route('pengawas.supervisi.index')
                        ->with('success', 'Selamat datang, ' . $user->name);
                } elseif ($user->hasRole('siswa')) {
                    return redirect()->route('siswa.dashboard.index')
                        ->with('success', 'Selamat datang, ' . $user->name);
                }

                // Fallback jika tidak ada role yang cocok
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Role Anda tidak memiliki akses ke sistem.',
                ])->withInput($request->only('email'));
            }

            // ⚠️ GENERIC ERROR - Tidak spesifik email atau password
            return back()->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ])->withInput($request->only('email'));
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Login Error: ' . $e->getMessage());

            return back()->withErrors([
                'email' => 'Terjadi kesalahan pada sistem. Silakan coba lagi.',
            ])->withInput($request->only('email'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function register()
    {
        return view('guest.pages.register.index');
    }
}
