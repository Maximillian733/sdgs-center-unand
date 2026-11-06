<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Support\Msg;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin(Request $r)
    {
        return $r->session()->has('admin_id') ? redirect()->route('admin.dashboard') : view('admin.login');
    }

    public function login(Request $r, AuthService $auth)
    {
        $v = $r->validate(['login' => ['required', 'string', 'max:255'], 'password' => ['required', 'string', 'max:255']], Msg::all(),
            ['login' => 'Username/email', 'password' => 'Password']);
        $auth->login($v['login'], $v['password'], $r->ip());
        return redirect()->route('admin.dashboard');
    }

    public function logout(AuthService $auth)
    {
        $auth->logout();
        return redirect()->route('admin.login')->with('ok', 'Anda telah keluar.');
    }
}
