<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Models\User;
use Illuminate\Http\Request;

class JurnalController extends Controller
{
    public function index()
    {
        $gurus = User::whereHas('jurnals')
            ->withCount('jurnals')
            ->with(['jurnals' => function ($query) {
                $query->latest()->take(1);
            }])
            ->get();

        return view('kepala-sekolah.pages.jurnal.index', compact('gurus'));
    }

    public function show($userId)
    {
        $guru = User::findOrFail($userId);
        $jurnals = Jurnal::where('user_id', $userId)->latest()->get();

        return view('kepala-sekolah.pages.jurnal.show', compact('guru', 'jurnals'));
    }
}
