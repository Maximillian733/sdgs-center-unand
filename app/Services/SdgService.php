<?php

namespace App\Services;

use App\Repositories\SdgRepository;

class SdgService
{
    public function __construct(private SdgRepository $sdgs) {}
    public function all() { return $this->sdgs->all(); }
}
