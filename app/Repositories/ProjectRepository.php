<?php

namespace App\Repositories;

use App\Repositories\Concerns\HasSdgTags;
use Illuminate\Support\Facades\DB;

// D2: projects, project_sdgs, project_partner
class ProjectRepository
{
    use HasSdgTags;

    public function __construct(private PartnerRepository $partners) {}

    private function decorate($rows)
    {
        $this->tag($rows, 'project_sdgs', 'project_id');
        $names = $rows->count() ? $this->partners->namesFor($rows->pluck('id')->all()) : collect();
        foreach ($rows as $r) {
            $r->partners = ($names[$r->id] ?? collect())->pluck('name')->all();
        }
        return $rows;
    }

    public function paginatePublic(array $f, int $per = 10)
    {
        $q = DB::table('projects')->orderByDesc('year')->orderByDesc('id');
        if (! empty($f['type'])) { $q->where('type', $f['type']); }
        if (! empty($f['year'])) { $q->where('year', (int) $f['year']); }
        if (! empty($f['sdg'])) {
            $q->whereIn('id', fn ($s) => $s->select('project_id')->from('project_sdgs')->where('sdg_id', (int) $f['sdg']));
        }
        $p = $q->paginate($per)->withQueryString();
        $this->decorate($p->getCollection());
        return $p;
    }

    public function years() { return DB::table('projects')->distinct()->orderByDesc('year')->pluck('year'); }

    public function bySdg(int $sdg, int $limit = 12)
    {
        return $this->decorate(DB::table('projects')->whereIn('id', fn ($s) => $s->select('project_id')->from('project_sdgs')->where('sdg_id', $sdg))
            ->orderByDesc('year')->limit($limit)->get());
    }

    public function search(string $q, int $limit = 20)
    {
        $like = $this->like($q);
        return $this->decorate(DB::table('projects')->where(fn ($w) => $w->where('title', 'like', $like)->orWhere('description', 'like', $like)
            ->orWhereIn('id', fn ($s) => $s->select('project_id')->from('project_partner')->join('partners', 'partners.id', '=', 'project_partner.partner_id')->where('partners.name', 'like', $like)))
            ->orderByDesc('year')->limit($limit)->get());
    }

    public function find(int $id): ?object
    {
        $r = DB::table('projects')->find($id);
        if ($r) { $this->decorate(collect([$r])); }
        return $r;
    }

    public function adminList() { return $this->decorate(DB::table('projects')->orderByDesc('year')->orderByDesc('id')->get()); }

    public function save(?int $id, array $d, array $sdgs, array $partnerIds): int
    {
        $d['updated_at'] = now();
        if ($id) {
            DB::table('projects')->where('id', $id)->update($d);
        } else {
            $id = DB::table('projects')->insertGetId($d + ['created_at' => now()]);
        }
        $this->syncSdgs('project_sdgs', 'project_id', $id, $sdgs);
        $this->partners->sync($id, $partnerIds);
        return $id;
    }

    public function delete(int $id): void { DB::table('projects')->where('id', $id)->delete(); }

    public function count(): int { return DB::table('projects')->count(); }
}
