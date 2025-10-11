<?php

namespace App\Http\View\Composers;

use App\Models\Config;
use Illuminate\View\View;

class GlobalComposer
{
    public function compose(View $view)
    {
        // Get all configs from database
        $allConfigs = Config::all();
        $configs = [];

        foreach ($allConfigs as $config) {
            $configs[$config->key] = $config->value;
        }

        $view->with([
            'authUser' => auth()->user(),
            'appName' => $configs['app_name'] ?? config('app.name'),
            'appLogo' => $configs['app_logo'] ?? null,
            'appBg' => $configs['app_bg'] ?? null,
        ]);
    }
}
