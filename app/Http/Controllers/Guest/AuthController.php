<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('guest.pages.login.index');
    }
    public function register()
    {
        return view('guest.pages.register.index');
    }
}
