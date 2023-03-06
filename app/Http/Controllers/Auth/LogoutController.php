<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function index()
    {
        Auth::logout();
        return redirect()->route('login')->with("success", "Logout Berhasil, sampai jumpa kembali.");
    }
}
