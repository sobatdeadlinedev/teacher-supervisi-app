<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class ConfigController extends Controller
{
    /**
     * Display the configuration settings page
     *
     * This method retrieves all configuration entries from the database
     * and presents them in key-value format for the admin interface.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $allConfigs = Config::all();
            $configs = $allConfigs->pluck('value', 'key')->toArray();

            return view('admin.pages.config.index', compact('configs'));
        } catch (Exception $e) {
            Log::error('Failed to retrieve configurations', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal memuat konfigurasi. Silakan coba lagi.');
        }
    }

    /**
     * Update application configuration settings
     *
     * Handles updates for application name and image uploads (logo and background).
     * Performs comprehensive validation and error handling with proper logging.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        try {
            $validated = $this->validateConfigInput($request);

            // Process file uploads
            $this->handleLogoUpload($request);
            $this->handleBackgroundUpload($request);

            // Update text configuration
            if ($request->filled('app_name')) {
                Config::updateOrCreate(
                    ['key' => 'app_name'],
                    ['value' => $validated['app_name']]
                );
            }

            Log::info('Configuration updated successfully', [
                'user_id' => auth()->id(),
                'updated_keys' => array_keys(array_filter($validated)),
            ]);

            return redirect()
                ->route('admin.config.index')
                ->with('success', 'Konfigurasi berhasil diperbarui.');
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (Exception $e) {
            Log::error('Configuration update failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui konfigurasi. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Validate configuration input data
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateConfigInput(Request $request): array
    {
        return $request->validate([
            'app_name' => 'nullable|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'app_bg' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'app_logo.image' => 'File logo harus berupa gambar.',
            'app_logo.mimes' => 'Logo harus memiliki format: jpeg, png, jpg, atau webp.',
            'app_logo.max' => 'Ukuran logo tidak boleh lebih dari 2MB.',
            'app_bg.image' => 'File background harus berupa gambar.',
            'app_bg.mimes' => 'Background harus memiliki format: jpeg, png, jpg, atau webp.',
            'app_bg.max' => 'Ukuran background tidak boleh lebih dari 2MB.',
        ]);
    }

    /**
     * Handle logo file upload and configuration update
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     * @throws \Exception
     */
    private function handleLogoUpload(Request $request): void
    {
        if (!$request->hasFile('app_logo')) {
            return;
        }

        try {
            $file = $request->file('app_logo');
            $path = $file->store('uploads/logo', 'public');
            $fullPath = '/storage/' . $path;

            // Remove old logo if exists
            $this->deleteOldFile('app_logo');

            Config::updateOrCreate(
                ['key' => 'app_logo'],
                ['value' => $fullPath]
            );

            Log::info('Logo uploaded successfully', [
                'path' => $fullPath,
                'user_id' => auth()->id(),
            ]);
        } catch (Exception $e) {
            Log::error('Logo upload failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            throw new Exception('Gagal mengunggah logo. ' . $e->getMessage());
        }
    }

    /**
     * Handle background file upload and configuration update
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     * @throws \Exception
     */
    private function handleBackgroundUpload(Request $request): void
    {
        if (!$request->hasFile('app_bg')) {
            return;
        }

        try {
            $file = $request->file('app_bg');
            $path = $file->store('uploads/bg', 'public');
            $fullPath = '/storage/' . $path;

            // Remove old background if exists
            $this->deleteOldFile('app_bg');

            Config::updateOrCreate(
                ['key' => 'app_bg'],
                ['value' => $fullPath]
            );

            Log::info('Background uploaded successfully', [
                'path' => $fullPath,
                'user_id' => auth()->id(),
            ]);
        } catch (Exception $e) {
            Log::error('Background upload failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            throw new Exception('Gagal mengunggah background. ' . $e->getMessage());
        }
    }

    /**
     * Delete old file from storage
     *
     * @param string $configKey The configuration key
     * @return void
     */
    private function deleteOldFile(string $configKey): void
    {
        try {
            $config = Config::where('key', $configKey)->first();

            if ($config && $config->value) {
                $path = str_replace('/storage/', '', $config->value);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                    Log::info('Old file deleted', ['key' => $configKey, 'path' => $path]);
                }
            }
        } catch (Exception $e) {
            Log::warning('Failed to delete old file', [
                'key' => $configKey,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
