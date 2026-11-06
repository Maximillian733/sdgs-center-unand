<?php

namespace App\Http\Controllers;

use App\Services\GalleryService;

class GalleryPublicController extends Controller
{
    public function index(GalleryService $gallery) { return view('galeri', ['albums' => $gallery->albums()]); }
}
