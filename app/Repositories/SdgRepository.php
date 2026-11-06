<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class SdgRepository
{
    public function all() { return DB::table('sdgs')->orderBy('id')->get(); }
}
