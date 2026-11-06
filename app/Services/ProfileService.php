<?php

namespace App\Services;

use App\Repositories\ProfileRepository;
use Illuminate\Http\UploadedFile;

// UC-02
class ProfileService
{
    public function __construct(private ProfileRepository $repo, private FileService $files) {}

    public function org(): object { return $this->repo->org(); }
    public function members() { return $this->repo->members(); }
    public function updateOrg(array $d): void { $this->repo->updateOrg($d); }

    public function saveMember(?int $id, array $d, ?UploadedFile $photo): void
    {
        $row = ['position' => $d['position'], 'name' => $d['name'], 'sort_order' => (int) ($d['sort_order'] ?? 0)];
        $old = $id ? $this->repo->member($id) : null;
        if ($photo) {
            $row['photo_media_id'] = $this->files->store($photo, 'image', 'Foto '.$d['name']);
            if ($old) { $this->files->delete($old->photo_media_id); }
        }
        $id ? $this->repo->updateMember($id, $row) : $this->repo->createMember($row);
    }

    public function deleteMember(int $id): void
    {
        if ($m = $this->repo->member($id)) {
            $this->repo->deleteMember($id);
            $this->files->delete($m->photo_media_id);
        }
    }
}
