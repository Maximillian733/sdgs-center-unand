<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Satu database, dipisah secara logis: D1 = admins; D2 = konten; D3 = albums + media.
return new class extends Migration
{
    public function up(): void
    {
        // ---- D1 ----
        Schema::create('admins', function (Blueprint $t) {
            $t->id();
            $t->string('username', 50)->unique();
            $t->string('email')->unique();
            $t->string('password_hash');                       // bcrypt, tidak pernah polos
            $t->timestamp('last_login_at')->nullable();
            $t->unsignedTinyInteger('failed_attempts')->default(0);
            $t->timestamp('locked_until')->nullable();
            $t->timestamps();
        });

        // ---- D3 ----
        Schema::create('albums', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->date('event_date')->nullable();
            $t->text('description')->nullable();
            $t->timestamps();
        });
        Schema::create('media', function (Blueprint $t) {
            $t->id();
            $t->string('type', 10);                            // image | pdf | video
            $t->string('path');
            $t->string('original_name');
            $t->string('mime', 100);
            $t->unsignedBigInteger('size');
            $t->string('alt_text')->nullable();
            $t->foreignId('album_id')->nullable()->constrained('albums')->cascadeOnDelete();
            $t->timestamps();
        });

        // ---- D2 ----
        Schema::create('sdgs', function (Blueprint $t) {
            $t->unsignedTinyInteger('id')->primary();          // 1..17
            $t->string('name_id');
            $t->string('name_en');
            $t->string('icon', 20);
            $t->string('color', 7);
        });
        Schema::create('org_profile', function (Blueprint $t) {
            $t->id();
            $t->text('vision_id')->nullable();
            $t->text('vision_en')->nullable();
            $t->text('mission_id')->nullable();                // satu misi per baris
            $t->text('mission_en')->nullable();
            $t->string('address')->nullable();
            $t->string('phone', 50)->nullable();
            $t->string('fax', 50)->nullable();
            $t->string('email')->nullable();
            $t->timestamps();
        });
        Schema::create('board_members', function (Blueprint $t) {
            $t->id();
            $t->string('position');
            $t->string('name');
            $t->foreignId('photo_media_id')->nullable()->constrained('media')->nullOnDelete();
            $t->unsignedSmallInteger('sort_order')->default(0);
            $t->timestamps();
        });
        Schema::create('news', function (Blueprint $t) {
            $t->id();
            $t->string('title_id');
            $t->string('title_en')->nullable();
            $t->string('slug')->unique();
            $t->longText('body_id');
            $t->longText('body_en')->nullable();
            $t->date('event_date')->nullable();
            $t->string('type', 20)->default('berita');         // berita|agenda|workshop|pelatihan|pengumuman
            $t->string('status', 10)->default('draft')->index(); // draft|published
            $t->boolean('is_featured')->default(false);
            $t->foreignId('cover_media_id')->nullable()->constrained('media')->nullOnDelete();
            $t->foreignId('attachment_media_id')->nullable()->constrained('media')->nullOnDelete(); // FT-03
            $t->foreignId('author_id')->nullable()->constrained('admins')->nullOnDelete();
            $t->timestamp('published_at')->nullable();
            $t->timestamps();
        });
        Schema::create('news_sdgs', function (Blueprint $t) {
            $t->foreignId('news_id')->constrained('news')->cascadeOnDelete();
            $t->unsignedTinyInteger('sdg_id');
            $t->foreign('sdg_id')->references('id')->on('sdgs');
            $t->primary(['news_id', 'sdg_id']);
        });
        Schema::create('projects', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('type', 20);                            // studi|pendampingan|advokasi|workshop
            $t->unsignedSmallInteger('year')->index();
            $t->text('description')->nullable();
            $t->foreignId('report_media_id')->nullable()->constrained('media')->nullOnDelete();
            $t->timestamps();
        });
        Schema::create('project_sdgs', function (Blueprint $t) {
            $t->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $t->unsignedTinyInteger('sdg_id');
            $t->foreign('sdg_id')->references('id')->on('sdgs');
            $t->primary(['project_id', 'sdg_id']);
        });
        Schema::create('partners', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();
            $t->foreignId('logo_media_id')->nullable()->constrained('media')->nullOnDelete();
            $t->timestamps();
        });
        Schema::create('project_partner', function (Blueprint $t) {
            $t->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $t->foreignId('partner_id')->constrained('partners')->cascadeOnDelete();
            $t->primary(['project_id', 'partner_id']);
        });
    }

    public function down(): void
    {
        foreach (['project_partner', 'partners', 'project_sdgs', 'projects', 'news_sdgs', 'news', 'board_members',
                  'org_profile', 'sdgs', 'media', 'albums', 'admins'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
