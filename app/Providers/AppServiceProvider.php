<?php

namespace App\Providers;

use App\Services\ProfileService;
use App\Services\SdgService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Paginator::defaultView('pagination::default');
        // FR-08: pilih kolom _id/_en sesuai bahasa; fallback ke Indonesia bila terjemahan kosong.
        View::share('loc', function ($row, string $field) {
            $en = app()->getLocale() === 'en' ? ($row->{$field.'_en'} ?? null) : null;
            return $en ?: ($row->{$field.'_id'} ?? '');
        });
        View::composer('partials.footer', fn ($v) => $v->with('org', app(ProfileService::class)->org()));
        View::composer(['partials.sdg-filter', 'admin.partials.sdg-checks'], fn ($v) => $v->with('sdgList', app(SdgService::class)->all()));
    }
}
