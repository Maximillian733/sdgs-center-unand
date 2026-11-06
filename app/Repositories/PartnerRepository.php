<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class PartnerRepository
{
    /** Nama mitra (dipisah koma) -> daftar id; mitra baru dibuat otomatis. */
    public function idsFromNames(string $csv): array
    {
        $ids = [];
        foreach (array_unique(array_filter(array_map('trim', explode(',', $csv)))) as $name) {
            $name = mb_substr($name, 0, 255);
            $row = DB::table('partners')->where('name', $name)->first();
            $ids[] = $row ? $row->id : DB::table('partners')->insertGetId(['name' => $name, 'created_at' => now(), 'updated_at' => now()]);
        }
        return $ids;
    }

    public function sync(int $projectId, array $partnerIds): void
    {
        DB::table('project_partner')->where('project_id', $projectId)->delete();
        foreach ($partnerIds as $pid) {
            DB::table('project_partner')->insert(['project_id' => $projectId, 'partner_id' => $pid]);
        }
    }

    public function namesFor(array $projectIds)
    {
        return DB::table('project_partner')->join('partners', 'partners.id', '=', 'project_partner.partner_id')
            ->whereIn('project_id', $projectIds)->orderBy('partners.name')->get(['project_id', 'partners.name'])->groupBy('project_id');
    }
}
