<?php

namespace App\Services;

use App\Repositories\GalleryRepository;
use App\Repositories\MediaRepository;
use App\Repositories\NewsRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\ProjectRepository;

class StatsService
{
    public function __construct(private NewsRepository $n, private ProjectRepository $p, private GalleryRepository $g,
                                private MediaRepository $m, private ProfileRepository $pr) {}

    public function summary(): array
    {
        return $this->n->counts() + ['projects' => $this->p->count(), 'albums' => $this->g->count(), 'media' => $this->m->count(), 'members' => $this->pr->countMembers()];
    }
}
