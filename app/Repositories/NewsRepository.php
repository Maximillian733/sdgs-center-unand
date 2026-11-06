<?php

namespace App\Repositories;

use App\Repositories\Concerns\HasSdgTags;
use Illuminate\Support\Facades\DB;

// D2: news, news_sdgs
class NewsRepository
{
    use HasSdgTags;

    private function published() { return DB::table('news')->where('status', 'published'); }

    public function paginatePublic(?int $sdg, ?string $type, int $per = 9)
    {
        $q = $this->published()->orderByDesc('published_at')->orderByDesc('id');
        if ($sdg) {
            $q->whereIn('id', fn ($s) => $s->select('news_id')->from('news_sdgs')->where('sdg_id', $sdg));
        }
        if ($type) {
            $q->where('type', $type);
        }
        $p = $q->paginate($per)->withQueryString();
        $this->tag($p->getCollection(), 'news_sdgs', 'news_id');
        return $p;
    }

    public function featured(int $n = 3)
    {
        $rows = $this->published()->where('is_featured', true)->orderByDesc('published_at')->limit($n)->get();
        $this->tag($rows, 'news_sdgs', 'news_id');
        return $rows;
    }

    public function latest(int $n = 6)
    {
        $rows = $this->published()->orderByDesc('published_at')->limit($n)->get();
        $this->tag($rows, 'news_sdgs', 'news_id');
        return $rows;
    }

    public function bySdg(int $sdg, int $limit = 12)
    {
        $rows = $this->published()->whereIn('id', fn ($s) => $s->select('news_id')->from('news_sdgs')->where('sdg_id', $sdg))
            ->orderByDesc('published_at')->limit($limit)->get();
        $this->tag($rows, 'news_sdgs', 'news_id');
        return $rows;
    }

    public function search(string $q, int $limit = 20)
    {
        $like = $this->like($q);
        $rows = $this->published()->where(fn ($w) => $w->where('title_id', 'like', $like)->orWhere('title_en', 'like', $like)
            ->orWhere('body_id', 'like', $like)->orWhere('body_en', 'like', $like))
            ->orderByDesc('published_at')->limit($limit)->get();
        $this->tag($rows, 'news_sdgs', 'news_id');
        return $rows;
    }

    public function findPublishedBySlug(string $slug): ?object
    {
        $r = $this->published()->where('slug', $slug)->first();
        if ($r) { $rows = collect([$r]); $this->tag($rows, 'news_sdgs', 'news_id'); }
        return $r;
    }

    // ---- admin ----
    public function adminList() { return DB::table('news')->orderByDesc('updated_at')->get(); }

    public function find(int $id): ?object
    {
        $r = DB::table('news')->find($id);
        if ($r) { $rows = collect([$r]); $this->tag($rows, 'news_sdgs', 'news_id'); }
        return $r;
    }

    public function slugExists(string $slug, ?int $ignoreId): bool
    {
        return DB::table('news')->where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists();
    }

    public function save(?int $id, array $d, array $sdgs): int
    {
        $d['updated_at'] = now();
        if ($id) {
            DB::table('news')->where('id', $id)->update($d);
        } else {
            $id = DB::table('news')->insertGetId($d + ['created_at' => now()]);
        }
        $this->syncSdgs('news_sdgs', 'news_id', $id, $sdgs);
        return $id;
    }

    public function setStatus(int $id, string $status, ?string $publishedAt = null): void
    {
        DB::table('news')->where('id', $id)->update(['status' => $status, 'published_at' => $publishedAt, 'updated_at' => now()]);
    }

    public function delete(int $id): void { DB::table('news')->where('id', $id)->delete(); }

    public function counts(): array
    {
        return ['published' => $this->published()->count(), 'draft' => DB::table('news')->where('status', 'draft')->count()];
    }
}
