<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * Menampilkan halaman konfigurasi
     */
    public function index()
    {
        $allConfigs = Config::all();
        $configs = [];

        foreach ($allConfigs as $config) {
            $configs[$config->key] = $config->value;
        }

        return view('admin.pages.config.index', compact('configs'));
    }

    /**
     * Update konfigurasi
     */
    public function update(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'app_name' => 'nullable|string|max:255',
                'app_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'app_bg'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Upload logo
            if ($request->hasFile('app_logo')) {
                $file = $request->file('app_logo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/logo'), $filename);

                $fullUrl = config('app.url') . '/uploads/logo/' . $filename;
                Config::set('app_logo', $fullUrl);
            }

            // Upload background
            if ($request->hasFile('app_bg')) {
                $file = $request->file('app_bg');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/bg'), $filename);

                $fullUrl = config('app.url') . '/uploads/bg/' . $filename;
                Config::set('app_bg', $fullUrl);
            }

            // Update nama aplikasi
            if ($request->filled('app_name')) {
                Config::set('app_name', $request->input('app_name'));
            }

            return redirect()
                ->route('admin.config.index')
                ->with('success', 'Konfigurasi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
