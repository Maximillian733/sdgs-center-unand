<?php

namespace App\Services;

use App\Repositories\NewsRepository;
use App\Repositories\ProjectRepository;

// UC-03 / FR-03
class SdgFilterService
{
    public function __construct(private NewsRepository $news, private ProjectRepository $projects) {}

    public static function valid($sdg): ?int
    {
        $n = filter_var($sdg, FILTER_VALIDATE_INT);
        return ($n !== false && $n >= 1 && $n <= 17) ? $n : null;
    }

    public function content(int $sdg): array
    {
        return ['sdg' => $sdg, 'news' => $this->news->bySdg($sdg), 'projects' => $this->projects->bySdg($sdg)];
    }
}
