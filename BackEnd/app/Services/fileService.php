<?php

namespace App\Services;

use App\Models\File;
use App\Models\FileStorage;

class fileService
{
    public function storePhysicalFile($file)
    {
        $path = $file->store('files');

        return FileStorage::create([
            'path' => $path,
            'hash' => md5_file($file->getRealPath()), // optional
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ]);
    }

    public function createFileRecord(string $name, int $storageId, ?int $folderId = null)
    {
        return File::create([
            'name' => $name,
            'storage_id' => $storageId,
            'folder_id' => $folderId,
        ]);
    }
}
