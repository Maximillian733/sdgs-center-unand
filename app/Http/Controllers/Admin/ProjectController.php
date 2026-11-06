<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use App\Support\Msg;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function __construct(private ProjectService $projects) {}

    public function index() { return view('admin.proyek.index', ['items' => $this->projects->adminList()]); }

    public function create() { return view('admin.proyek.form', ['item' => null, 'types' => ProjectService::TYPES]); }

    public function edit(int $id)
    {
        $item = $this->projects->find($id);
        abort_unless($item, 404);
        return view('admin.proyek.form', ['item' => $item, 'types' => ProjectService::TYPES]);
    }

    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'], 'type' => ['required', Rule::in(ProjectService::TYPES)],
            'year' => ['required', 'integer', 'between:1990,2100'], 'description' => ['nullable', 'string', 'max:5000'],
            'partners' => ['nullable', 'string', 'max:500'], 'sdgs' => ['nullable', 'array'], 'sdgs.*' => ['integer', 'between:1,17'],
            'report' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],       // maks. 10 MB, hanya PDF asli
        ];
    }

    private const ATTR = ['title' => 'Judul proyek', 'type' => 'Jenis proyek', 'year' => 'Tahun', 'report' => 'Laporan PDF', 'partners' => 'Mitra'];

    public function store(Request $r)
    {
        $v = $r->validate($this->rules(), Msg::all(), self::ATTR);
        $id = $this->projects->save($v, $r->file('report'), null);
        return redirect()->route('admin.proyek.edit', $id)->with('ok', 'Proyek disimpan.');
    }

    public function update(Request $r, int $id)
    {
        abort_unless($this->projects->find($id), 404);
        $v = $r->validate($this->rules(), Msg::all(), self::ATTR);
        $this->projects->save($v, $r->file('report'), $id);
        return back()->with('ok', 'Proyek diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->projects->delete($id);
        return redirect()->route('admin.proyek')->with('ok', 'Proyek dihapus.');
    }
}
