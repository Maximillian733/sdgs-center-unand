<?php

namespace App\Http\Controllers;

use App\Services\SdgFilterService;
use App\Services\SearchService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function content(Request $r, SdgFilterService $filter)
    {
        $sdg = SdgFilterService::valid($r->query('sdg'));
        if (! $sdg) {
            return response()->json(['message' => 'Parameter sdg harus 1 sampai 17.'], 422);
        }
        return response()->json($filter->content($sdg));
    }

    public function search(Request $r, SearchService $search)
    {
        return response()->json($search->search((string) $r->query('q')));
    }
}
