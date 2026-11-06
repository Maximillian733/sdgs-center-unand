<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NewsService;
use App\Support\Msg;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    public function __construct(private NewsService $news) {}

    public function index() { return view('admin.berita.index', ['items' => $this->news->adminList()]); }

    public function create() { return view('admin.berita.form', ['item' => null, 'types' => NewsService::TYPES]); }

    public function edit(int $id)
    {
        $item = $this->news->find($id);
        abort_unless($item, 404);
        return view('admin.berita.form', ['item' => $item, 'types' => NewsService::TYPES]);
    }

    private function rules(): array
    {
        return [
            'title_id' => ['required', 'string', 'max:200'], 'title_en' => ['nullable', 'string', 'max:200'],
            'body_id' => ['required', 'string', 'max:100000'], 'body_en' => ['nullable', 'string', 'max:100000'],
            'event_date' => ['nullable', 'date'], 'type' => ['required', Rule::in(NewsService::TYPES)],
            'is_featured' => ['nullable', 'boolean'], 'sdgs' => ['nullable', 'array'], 'sdgs.*' => ['integer', 'between:1,17'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'attachment' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'action' => ['required', Rule::in(['draft', 'publish'])],
        ];
    }

    private const ATTR = ['title_id' => 'Judul (ID)', 'body_id' => 'Isi berita (ID)', 'type' => 'Jenis', 'event_date' => 'Tanggal kegiatan',
        'cover' => 'Gambar cover', 'attachment' => 'Lampiran PDF', 'sdgs.*' => 'Kategori SDGs'];

    public function store(Request $r)
    {
        $v = $r->validate($this->rules(), Msg::all(), self::ATTR);
        $id = $this->news->save($v, $r->file('cover'), $r->file('attachment'), null, $v['action'], (int) session('admin_id'));
        return redirect()->route('admin.berita.edit', $id)->with('ok', $v['action'] === 'publish' ? 'Berita dipublikasikan.' : 'Draf tersimpan.');
    }

    public function update(Request $r, int $id)
    {
        abort_unless($this->news->find($id), 404);
        $v = $r->validate($this->rules(), Msg::all(), self::ATTR);
        $this->news->save($v, $r->file('cover'), $r->file('attachment'), $id, $v['action'], (int) session('admin_id'));
        return back()->with('ok', $v['action'] === 'publish' ? 'Berita dipublikasikan.' : 'Draf tersimpan.');
    }

    public function unpublish(int $id)
    {
        $this->news->unpublish($id);
        return back()->with('ok', 'Berita dikembalikan menjadi draf.');
    }

    public function destroy(int $id)
    {
        $this->news->delete($id);
        return redirect()->route('admin.berita')->with('ok', 'Berita dihapus.');
    }
}
