<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StatsService;

class DashboardController extends Controller
{
    public function index(StatsService $stats) { return view('admin.dashboard', ['s' => $stats->summary()]); }
}
