<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * Show the about/settings page
     */
    public function index()
    {
        // Get all configs and convert to array format key => value
        $allConfigs = Config::all();
        $configs = [];

        foreach ($allConfigs as $config) {
            $configs[$config->key] = $config->value;
        }

        return view('admin.pages.config.index', compact('configs'));
    }

    /**
     * Update configuration settings
     */
    public function update(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'app_name' => 'nullable|string|max:255',
                'app_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'app_bg' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Handle app_logo upload
            if ($request->hasFile('app_logo')) {
                $file = $request->file('app_logo');
                $path = $file->store('uploads/logo', 'public');
                Config::set('app_logo', '/storage/' . $path);
            }

            // Handle app_bg upload
            if ($request->hasFile('app_bg')) {
                $file = $request->file('app_bg');
                $path = $file->store('uploads/bg', 'public');
                Config::set('app_bg', '/storage/' . $path);
            }

            // Update app_name
            if ($request->has('app_name') && $request->input('app_name') !== null) {
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
