<?php

namespace App\Http\Controllers;

use App\Services\NewsService;
use App\Services\SdgFilterService;
use App\Services\SdgService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsPublicController extends Controller
{
    public function __construct(private NewsService $news) {}

    public function index(Request $r, SdgService $sdgs)
    {
        $sdg = SdgFilterService::valid($r->query('sdg'));
        return view('berita.index', [
            'items' => $this->news->paginate($sdg, $r->query('type')), 'sdg' => $sdg,
            'type' => $r->query('type'), 'types' => NewsService::TYPES, 'sdgs' => $sdgs->all(),
        ]);
    }

    public function show(string $slug, SdgService $sdgs)
    {
        $item = $this->news->bySlug($slug);
        abort_unless($item, 404);
        return view('berita.show', ['item' => $item, 'sdgs' => $sdgs->all()->keyBy('id'), 'hasAttachment' => (bool) $item->attachment_media_id]);
    }

    public function attachment(string $slug)
    {
        $m = $this->news->attachment($slug);
        abort_unless($m, 404);
        return Storage::disk('local')->download($m->path, $m->original_name, ['Content-Type' => $m->mime]);
    }
}
