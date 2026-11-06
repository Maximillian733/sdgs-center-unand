<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// NFR-01: seluruh /admin/* (kecuali login) hanya untuk admin terautentikasi.
class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->session()->has('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        return $next($request);
    }
}
