<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
                $request->session()->regenerate();

                $user = Auth::user();

                if ($user->hasRole('admin')) {
                    return redirect()->intended(route('admin.dashboard.index'));
                } elseif ($user->hasRole('guru')) {
                    return redirect()->intended(route('guru.dashboard.index'));
                } elseif ($user->hasRole('kepala_sekolah')) {
                    return redirect()->intended(route('kepala_sekolah.dashboard.index'));
                } elseif ($user->hasRole('pengawas')) {
                    return redirect()->intended(route('pengawas.dashboard.index'));
                }

                return redirect()->intended('/');
            }

            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ])->withInput();
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
