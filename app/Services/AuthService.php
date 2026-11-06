<?php

namespace App\Services;

use App\Repositories\AdminRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService
{
    private const MAX_FAILS = 5;
    private const LOCK_MINUTES = 15;

    public function __construct(private AdminRepository $admins) {}

    public function login(string $login, string $password, string $ip): void
    {
        $key = 'login:'.$ip;
        if (RateLimiter::tooManyAttempts($key, 10)) {
            $this->fail('Terlalu banyak percobaan. Coba lagi dalam '.max(1, (int) ceil(RateLimiter::availableIn($key) / 60)).' menit.');
        }
        $admin = $this->admins->findByLogin($login);
        if ($admin && $admin->locked_until && Carbon::parse($admin->locked_until)->isFuture()) {
            $this->fail('Akun dikunci sementara. Coba lagi dalam '.max(1, (int) ceil(now()->diffInSeconds(Carbon::parse($admin->locked_until), false) / 60)).' menit.');
        }
        $ok = Hash::check($password, $admin->password_hash ?? Hash::make(Str::random(12))) && $admin;
        if (! $ok) {
            RateLimiter::hit($key, self::LOCK_MINUTES * 60);
            if ($admin) {
                $n = $admin->failed_attempts + 1;
                $this->admins->failure($admin->id, $n, $n >= self::MAX_FAILS ? now()->addMinutes(self::LOCK_MINUTES)->toDateTimeString() : null);
            }
            $this->fail('Username/email atau password salah.');   // pesan umum, tidak menyebut mana yang salah
        }
        RateLimiter::clear($key);
        $this->admins->success($admin->id);
        session()->regenerate();                                    // cegah session fixation
        session(['admin_id' => $admin->id, 'admin_name' => $admin->username]);
    }

    public function logout(): void
    {
        session()->invalidate();
        session()->regenerateToken();
    }

    private function fail(string $msg): never
    {
        throw ValidationException::withMessages(['login' => $msg]);
    }
}
