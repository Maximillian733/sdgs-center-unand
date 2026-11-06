<?php

namespace App\Services;

use App\Repositories\NewsRepository;
use App\Repositories\ProjectRepository;

// UC-07 / FR-07
class SearchService
{
    public function __construct(private NewsRepository $news, private ProjectRepository $projects) {}

    public static function clean(?string $q): string
    {
        return mb_substr(trim(strip_tags((string) $q)), 0, 100);
    }

    public function search(string $q): array
    {
        $q = self::clean($q);
        if (mb_strlen($q) < 2) {
            return ['q' => $q, 'news' => collect(), 'projects' => collect()];
        }
        return ['q' => $q, 'news' => $this->news->search($q), 'projects' => $this->projects->search($q)];
    }
}
