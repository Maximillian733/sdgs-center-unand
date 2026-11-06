<?php

namespace App\Services;

use App\Repositories\NewsRepository;
use App\Support\Html;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

// UC-04
class NewsService
{
    public const TYPES = ['berita', 'agenda', 'workshop', 'pelatihan', 'pengumuman'];

    public function __construct(private NewsRepository $news, private FileService $files) {}

    // publik
    public function paginate(?int $sdg, ?string $type) { return $this->news->paginatePublic($sdg, in_array($type, self::TYPES, true) ? $type : null); }
    public function featured() { return $this->news->featured(3); }
    public function latest() { return $this->news->latest(6); }
    public function bySlug(string $slug) { return $this->news->findPublishedBySlug($slug); }
    public function attachment(string $slug): ?object
    {
        $n = $this->news->findPublishedBySlug($slug);
        return $n ? $this->files->find($n->attachment_media_id) : null;
    }

    // admin
    public function adminList() { return $this->news->adminList(); }
    public function find(int $id) { return $this->news->find($id); }

    public function save(array $v, ?UploadedFile $cover, ?UploadedFile $att, ?int $id, string $action, int $adminId): int
    {
        $old = $id ? $this->news->find($id) : null;
        $data = [
            'title_id' => $v['title_id'], 'title_en' => $v['title_en'] ?? null,
            'body_id' => Html::clean($v['body_id']), 'body_en' => Html::clean($v['body_en'] ?? null) ?: null,
            'event_date' => $v['event_date'] ?? null, 'type' => $v['type'], 'is_featured' => ! empty($v['is_featured']),
        ];
        if (! $old) {
            $data['slug'] = $this->uniqueSlug($v['title_id']);
            $data['author_id'] = $adminId;
            $data['status'] = 'draft';
        }
        if ($cover) {
            $data['cover_media_id'] = $this->files->store($cover, 'image', $v['title_id']);
            if ($old) { $this->files->delete($old->cover_media_id); }
        }
        if ($att) {
            $data['attachment_media_id'] = $this->files->store($att, 'pdf');
            if ($old) { $this->files->delete($old->attachment_media_id); }
        }
        $id = $this->news->save($id, $data, $v['sdgs'] ?? []);
        if ($action === 'publish') {
            $this->news->setStatus($id, 'published', $old->published_at ?? now()->toDateTimeString());
        } elseif ($old) {
            $this->news->setStatus($id, 'draft', null);
        }
        return $id;
    }

    public function unpublish(int $id): void { $this->news->setStatus($id, 'draft', null); }

    public function delete(int $id): void
    {
        if ($n = $this->news->find($id)) {
            $this->news->delete($id);
            $this->files->delete($n->cover_media_id);
            $this->files->delete($n->attachment_media_id);
        }
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug(Str::limit($title, 80, '')) ?: 'berita';
        $slug = $base; $i = 2;
        while ($this->news->slugExists($slug, null)) { $slug = $base.'-'.$i++; }
        return $slug;
    }
}
