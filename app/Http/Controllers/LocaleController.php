<?php

namespace App\Http\Controllers;

class LocaleController extends Controller
{
    public function __invoke(string $lang)
    {
        session(['locale' => $lang]);
        $back = url()->previous();
        return redirect(str_starts_with($back, url('/')) ? $back : route('home'));
    }
}
