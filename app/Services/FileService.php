<?php

namespace App\Services;

use App\Repositories\MediaRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

// Berkas disimpan di storage/app/private (di luar webroot), nama acak, MIME dicek dari isi berkas.
class FileService
{
    private const KINDS = [
        'image' => ['mimes' => ['image/jpeg', 'image/png', 'image/webp', 'image/gif'], 'max' => 5 * 1024 * 1024],
        'pdf' => ['mimes' => ['application/pdf'], 'max' => 10 * 1024 * 1024],
        'video' => ['mimes' => ['video/mp4', 'video/webm'], 'max' => 100 * 1024 * 1024],
    ];

    public function __construct(private MediaRepository $media) {}

    public function kindOf(UploadedFile $f): ?string
    {
        foreach (self::KINDS as $k => $r) {
            if (in_array($f->getMimeType(), $r['mimes'], true)) { return $k; }
        }
        return null;
    }

    /** $kind: image|pdf|video, atau 'media' (gambar/video otomatis). Mengembalikan media.id */
    public function store(UploadedFile $f, string $kind, ?string $alt = null, ?int $albumId = null): int
    {
        $auto = $kind === 'media';                       // galeri: hanya gambar/video
        $kind = $auto ? ($this->kindOf($f) ?? '') : $kind;
        $rule = self::KINDS[$kind] ?? null;
        if (! $rule || ($auto && $kind === 'pdf') || ! in_array($f->getMimeType(), $rule['mimes'], true) || $f->getSize() > $rule['max']) {
            throw ValidationException::withMessages(['file' => 'Berkas "'.$f->getClientOriginalName().'" ditolak: format tidak didukung atau ukuran terlalu besar.']);
        }
        $path = Storage::disk('local')->putFile('uploads', $f);
        return $this->media->insert([
            'type' => $kind, 'path' => $path, 'original_name' => mb_substr($f->getClientOriginalName(), 0, 255),
            'mime' => $f->getMimeType(), 'size' => $f->getSize(), 'alt_text' => $alt ? mb_substr($alt, 0, 255) : null, 'album_id' => $albumId,
        ]);
    }

    public function delete(?int $id): void
    {
        if ($m = $this->media->find($id)) {
            Storage::disk('local')->delete($m->path);
            $this->media->delete($m->id);
        }
    }

    public function find(?int $id): ?object { return $this->media->find($id); }
}
