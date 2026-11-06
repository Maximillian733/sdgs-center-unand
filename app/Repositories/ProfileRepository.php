<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ProfileRepository
{
    public function org(): object { return DB::table('org_profile')->first() ?? (object) []; }

    public function updateOrg(array $d): void
    {
        $row = DB::table('org_profile')->first();
        $row ? DB::table('org_profile')->where('id', $row->id)->update($d + ['updated_at' => now()])
             : DB::table('org_profile')->insert($d + ['created_at' => now(), 'updated_at' => now()]);
    }

    public function members()
    {
        return DB::table('board_members')->orderBy('sort_order')->orderBy('id')->get();
    }

    public function member(int $id): ?object { return DB::table('board_members')->find($id); }

    public function createMember(array $d): int
    {
        return DB::table('board_members')->insertGetId($d + ['created_at' => now(), 'updated_at' => now()]);
    }

    public function updateMember(int $id, array $d): void
    {
        DB::table('board_members')->where('id', $id)->update($d + ['updated_at' => now()]);
    }

    public function deleteMember(int $id): void { DB::table('board_members')->where('id', $id)->delete(); }

    public function countMembers(): int { return DB::table('board_members')->count(); }
}
