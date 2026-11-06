<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

// D3
class MediaRepository
{
    public function find(?int $id): ?object { return $id ? DB::table('media')->find($id) : null; }

    public function insert(array $row): int
    {
        return DB::table('media')->insertGetId($row + ['created_at' => now(), 'updated_at' => now()]);
    }

    public function delete(int $id): void { DB::table('media')->where('id', $id)->delete(); }

    public function byAlbum(int $albumId) { return DB::table('media')->where('album_id', $albumId)->get(); }

    public function count(): int { return DB::table('media')->count(); }
}
