<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\Services\SearchService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function profile(ProfileService $profile)
    {
        return view('profil', ['org' => $profile->org(), 'members' => $profile->members()]);
    }

    public function contact(ProfileService $profile) { return view('kontak', ['org' => $profile->org()]); }

    public function search(Request $r, SearchService $search)
    {
        return view('cari', $search->search((string) $r->query('q')));
    }
}
