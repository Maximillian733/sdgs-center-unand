<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

// D1
class AdminRepository
{
    public function findByLogin(string $login): ?object
    {
        return DB::table('admins')->where('username', $login)->orWhere('email', $login)->first();
    }

    public function failure(int $id, int $count, ?string $lockedUntil): void
    {
        DB::table('admins')->where('id', $id)->update(['failed_attempts' => $count, 'locked_until' => $lockedUntil]);
    }

    public function success(int $id): void
    {
        DB::table('admins')->where('id', $id)->update(['failed_attempts' => 0, 'locked_until' => null, 'last_login_at' => now()]);
    }
}
