<?php

namespace App\Repositories\Concerns;

use Illuminate\Support\Facades\DB;

trait HasSdgTags
{
    /** Tempel daftar sdg_id ke tiap baris ($row->sdg_ids). */
    protected function tag($rows, string $pivot, string $fk): void
    {
        $ids = collect($rows)->pluck('id')->all();
        if (! $ids) {
            return;
        }
        $map = DB::table($pivot)->whereIn($fk, $ids)->orderBy('sdg_id')->get()->groupBy($fk);
        foreach ($rows as $r) {
            $r->sdg_ids = ($map[$r->id] ?? collect())->pluck('sdg_id')->all();
        }
    }

    protected function syncSdgs(string $pivot, string $fk, int $id, array $sdgs): void
    {
        DB::table($pivot)->where($fk, $id)->delete();
        $rows = collect($sdgs)->map(fn ($s) => (int) $s)->filter(fn ($s) => $s >= 1 && $s <= 17)->unique()
            ->map(fn ($s) => [$fk => $id, 'sdg_id' => $s])->values()->all();
        if ($rows) {
            DB::table($pivot)->insert($rows);
        }
    }

    protected function like(string $q): string
    {
        return '%'.addcslashes($q, '%_\\').'%';
    }
}
