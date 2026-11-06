<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use App\Support\Msg;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private const ATTR = ['position' => 'Jabatan', 'name' => 'Nama', 'photo' => 'Foto', 'vision_id' => 'Visi (ID)', 'mission_id' => 'Misi (ID)',
        'address' => 'Alamat', 'email' => 'Surel', 'phone' => 'Telepon', 'fax' => 'Faks', 'sort_order' => 'Urutan'];

    public function __construct(private ProfileService $profile) {}

    public function edit() { return view('admin.profil', ['org' => $this->profile->org(), 'members' => $this->profile->members()]); }

    public function update(Request $r)
    {
        $v = $r->validate([
            'vision_id' => ['required', 'string', 'max:2000'], 'vision_en' => ['nullable', 'string', 'max:2000'],
            'mission_id' => ['required', 'string', 'max:5000'], 'mission_en' => ['nullable', 'string', 'max:5000'],
            'address' => ['required', 'string', 'max:255'], 'phone' => ['nullable', 'string', 'max:50'],
            'fax' => ['nullable', 'string', 'max:50'], 'email' => ['required', 'email', 'max:255'],
        ], Msg::all(), self::ATTR);
        $this->profile->updateOrg($v);
        return back()->with('ok', 'Profil, visi, dan misi berhasil disimpan.');
    }

    private function memberRules(): array
    {
        return ['position' => ['required', 'string', 'max:120'], 'name' => ['required', 'string', 'max:160'],
            'sort_order' => ['nullable', 'integer', 'between:0,999'], 'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120']];
    }

    public function storeMember(Request $r)
    {
        $v = $r->validate($this->memberRules(), Msg::all(), self::ATTR);
        $this->profile->saveMember(null, $v, $r->file('photo'));
        return back()->with('ok', 'Pengurus ditambahkan.');
    }

    public function updateMember(Request $r, int $id)
    {
        $v = $r->validate($this->memberRules(), Msg::all(), self::ATTR);
        $this->profile->saveMember($id, $v, $r->file('photo'));
        return back()->with('ok', 'Data pengurus diperbarui.');
    }

    public function destroyMember(int $id)
    {
        $this->profile->deleteMember($id);
        return back()->with('ok', 'Pengurus dihapus.');
    }
}
