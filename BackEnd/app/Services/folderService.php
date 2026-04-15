<?php

namespace app\Services;

use App\Models\Folder;

class folderService
{
    public function createFolder(string $name, ?int $parentId = null)
    {
        
        return Folder::create([
            'name' => $name,
            'parent_id' => $parentId
        ]);
    }
}
