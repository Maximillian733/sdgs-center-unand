<?php

namespace App\Services;

use App\Repositories\GalleryRepository;
use App\Repositories\MediaRepository;

// UC-06
class GalleryService
{
    public function __construct(private GalleryRepository $albums, private MediaRepository $media, private FileService $files) {}

    public function albums() { return $this->albums->albumsWithMedia(); }

    public function createAlbum(array $d, array $uploads): int
    {
        $id = $this->albums->create(['title' => $d['title'], 'event_date' => $d['event_date'] ?? null, 'description' => $d['description'] ?? null]);
        $this->upload($id, $uploads, $d['alt_text'] ?? null);
        return $id;
    }

    public function upload(int $albumId, array $uploads, ?string $alt): void
    {
        $album = $this->albums->find($albumId);
        abort_unless($album, 404);
        foreach ($uploads as $f) {
            $this->files->store($f, 'media', $alt ?: $album->title, $albumId);
        }
    }

    public function deleteMedia(int $id): void { $this->files->delete($id); }

    public function deleteAlbum(int $id): void
    {
        foreach ($this->media->byAlbum($id) as $m) { $this->files->delete($m->id); }
        $this->albums->delete($id);
    }
}
