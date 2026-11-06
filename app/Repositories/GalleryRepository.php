<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

// D3: albums
class GalleryRepository
{
    /** Semua album beserta media-nya. */
    public function albumsWithMedia()
    {
        $albums = DB::table('albums')->orderByDesc('event_date')->orderByDesc('id')->get();
        $media = DB::table('media')->whereNotNull('album_id')->orderBy('id')->get()->groupBy('album_id');
        foreach ($albums as $a) {
            $a->media = $media[$a->id] ?? collect();
        }
        return $albums;
    }

    public function find(int $id): ?object { return DB::table('albums')->find($id); }

    public function create(array $d): int
    {
        return DB::table('albums')->insertGetId($d + ['created_at' => now(), 'updated_at' => now()]);
    }

    public function delete(int $id): void { DB::table('albums')->where('id', $id)->delete(); }

    public function count(): int { return DB::table('albums')->count(); }
}
