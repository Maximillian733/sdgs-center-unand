<?php

namespace App\Http\Controllers;

use App\Services\NewsService;
use App\Services\SdgFilterService;
use App\Services\SdgService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $r, NewsService $news, SdgService $sdgs, SdgFilterService $filter)
    {
        $sdg = SdgFilterService::valid($r->query('sdg'));
        return view('home', [
            'featured' => $news->featured(), 'latest' => $news->latest(), 'sdgs' => $sdgs->all(),
            'sdg' => $sdg, 'filtered' => $sdg ? $filter->content($sdg) : null,
        ]);
    }
}
