<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;
use App\Services\SdgService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectPublicController extends Controller
{
    public function __construct(private ProjectService $projects) {}

    public function index(Request $r, SdgService $sdgs)
    {
        $f = $r->only(['type', 'sdg', 'year']);
        return view('portofolio', [
            'items' => $this->projects->paginate($f), 'f' => $f, 'types' => ProjectService::TYPES,
            'years' => $this->projects->years(), 'sdgs' => $sdgs->all()->keyBy('id'),
        ]);
    }

    public function download(int $id)
    {
        $m = $this->projects->report($id);
        abort_unless($m, 404);
        return Storage::disk('local')->download($m->path, $m->original_name, ['Content-Type' => $m->mime]);
    }
}
