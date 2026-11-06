<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GalleryService;
use App\Support\Msg;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    private const ATTR = ['title' => 'Judul kegiatan', 'event_date' => 'Tanggal', 'files' => 'Berkas', 'files.*' => 'Berkas', 'alt_text' => 'Teks alternatif'];

    public function __construct(private GalleryService $gallery) {}

    public function index() { return view('admin.galeri', ['albums' => $this->gallery->albums()]); }

    private function fileRules(): array
    {
        return ['files' => ['nullable', 'array', 'max:20'], 'files.*' => ['file', 'mimes:jpg,jpeg,png,webp,gif,mp4,webm', 'max:102400'],
            'alt_text' => ['nullable', 'string', 'max:255']];
    }

    public function storeAlbum(Request $r)
    {
        $v = $r->validate(['title' => ['required', 'string', 'max:200'], 'event_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:2000']] + $this->fileRules(), Msg::all(), self::ATTR);
        $this->gallery->createAlbum($v, $r->file('files', []));
        return back()->with('ok', 'Album dibuat.');
    }

    public function upload(Request $r, int $id)
    {
        $v = $r->validate(['files' => ['required', 'array', 'max:20']] + $this->fileRules(), Msg::all(), self::ATTR);
        $this->gallery->upload($id, $r->file('files', []), $v['alt_text'] ?? null);
        return back()->with('ok', 'Berkas diunggah.');
    }

    public function destroyMedia(int $id)
    {
        $this->gallery->deleteMedia($id);
        return back()->with('ok', 'Berkas dihapus.');
    }

    public function destroyAlbum(int $id)
    {
        $this->gallery->deleteAlbum($id);
        return back()->with('ok', 'Album dihapus.');
    }
}
