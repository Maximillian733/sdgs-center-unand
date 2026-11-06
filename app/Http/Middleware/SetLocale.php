<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->session()->get('locale', 'id');
        app()->setLocale(in_array($lang, ['id', 'en'], true) ? $lang : 'id');
        return $next($request);
    }
}
