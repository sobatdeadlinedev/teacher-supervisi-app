<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class GlobalComposer
{
    public function compose(View $view)
    {
        $view->with([
            'authUser' => auth()->user(),
            // Bisa tambah config lain di sini
            // 'appName' => config('app.name'),
            // 'siteLogo' => config('app.logo'),
        ]);
    }
}
