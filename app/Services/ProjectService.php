<?php

namespace App\Services;

use App\Repositories\PartnerRepository;
use App\Repositories\ProjectRepository;
use Illuminate\Http\UploadedFile;

// UC-05
class ProjectService
{
    public const TYPES = ['studi', 'pendampingan', 'advokasi', 'workshop'];

    public function __construct(private ProjectRepository $projects, private PartnerRepository $partners, private FileService $files) {}

    public function paginate(array $f)
    {
        $f['type'] = in_array($f['type'] ?? null, self::TYPES, true) ? $f['type'] : null;
        $f['sdg'] = SdgFilterService::valid($f['sdg'] ?? null);
        return $this->projects->paginatePublic($f);
    }
    public function years() { return $this->projects->years(); }
    public function adminList() { return $this->projects->adminList(); }
    public function find(int $id) { return $this->projects->find($id); }
    public function report(int $id): ?object
    {
        $p = $this->projects->find($id);
        return $p ? $this->files->find($p->report_media_id) : null;
    }

    public function save(array $v, ?UploadedFile $report, ?int $id): int
    {
        $old = $id ? $this->projects->find($id) : null;
        $data = ['title' => $v['title'], 'type' => $v['type'], 'year' => (int) $v['year'], 'description' => $v['description'] ?? null];
        if ($report) {
            $data['report_media_id'] = $this->files->store($report, 'pdf');
            if ($old) { $this->files->delete($old->report_media_id); }
        }
        return $this->projects->save($id, $data, $v['sdgs'] ?? [], $this->partners->idsFromNames($v['partners'] ?? ''));
    }

    public function delete(int $id): void
    {
        if ($p = $this->projects->find($id)) {
            $this->projects->delete($id);
            $this->files->delete($p->report_media_id);
        }
    }
}
