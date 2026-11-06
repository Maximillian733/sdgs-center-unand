<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Support\Facades\Storage;

// Menyajikan foto/video untuk pratinjau (mendukung Range untuk video). PDF selalu diunduh.
class MediaController extends Controller
{
    public function show(int $id, FileService $files)
    {
        $m = $files->find($id);
        abort_unless($m && Storage::disk('local')->exists($m->path), 404);
        if ($m->type === 'pdf') {
            return Storage::disk('local')->download($m->path, $m->original_name, ['Content-Type' => $m->mime]);
        }
        return response()->file(Storage::disk('local')->path($m->path), [
            'Content-Type' => $m->mime, 'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
