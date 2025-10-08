<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupervisiController extends Controller
{
    public function index()
    {
        return view('guru.pages.supervisi.index');
    }
    public function log()
    {
        return view('guru.pages.supervisi.log');
    }
}
